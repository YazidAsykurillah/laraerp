<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Requests\StorePurchaseOrderRequest;
use App\Http\Requests\UpdatePurchaseOrderRequest;

use App\PurchaseOrder;
use App\Supplier;
use App\Product;
use App\PurchaseReturn;

class PurchaseOrderController extends Controller
{

    public function wp_post(Request $request)
    {

        $returned = [];
        $returned['firstname'] = $request->firstname;
        $returned['lastname']=$request->lastname;
        $returned['email']=$request->email;
        $returned['mobile']=$request->mobile;
        $returned['address']=$request->address;
        $returned['countrycode']=$request->countrycode;
        $returned['regioncode']=$request->regioncode;
        $returned['citycode']=$request->citycode;
        $returned['productcode']=$request->productcode;
        $returned['validfrom']=$request->validfrom;
        $returned['paymenttypecode']=$request->paymenttypecode;
        $returned['signature']=$request->signature;
        return $returned;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('purchase_order.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $supplier_options = Supplier::lists('name', 'id');
        return view('purchase_order.create')
            ->with('supplier_options', $supplier_options);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePurchaseOrderRequest $request)
    {   
        if($request->ajax()){

            $max_po_id = \DB::table('purchase_orders')->max('id');
            $next_po_id = $max_po_id+1;
            $code = 'PO-'.$next_po_id;

            $data = [
                'code'=>$code,
                'supplier_id'=>$request->supplier_id,
                'notes'=>$request->notes,
                'creator'=>\Auth::user()->id
            ];

            $save = PurchaseOrder::create($data);
            $purchase_order_id = $save->id;

            $purchase_order = PurchaseOrder::find($purchase_order_id);

            //Build sync data to store the relation w/ products
            $syncData = [];
            foreach($request->product_id as $key=>$value){
                //$syncData[$value] = ['quantity'=> $request->quantity[$key], 'price'=>floatval(preg_replace('#[^0-9.]#', '', $request->price[$key]))];
                $syncData[$value] = ['quantity'=> $request->quantity[$key]];
            }
            //sync the purchase order product relation
            $purchase_order->products()->sync($syncData);

            $response = [
                'msg'=>'storePurchaseOrderOk',
                'purchase_order_id'=>$purchase_order_id
            ];
            return response()->json($response);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    protected function count_total_price($purchase_order)
    {
        $sum_price = \DB::table('product_purchase_order')
                    ->where('purchase_order_id', $purchase_order->id)
                    ->sum('price');
        return $sum_price;
    }
    
    public function show($id)
    {
        $purchase_order = PurchaseOrder::findOrFail($id);
        //invoice related with this purchase order
        $invoice =  $purchase_order->purchase_order_invoice();
        //purchase returns related
        $purchase_returns = $purchase_order->purchase_returns;
        $total_price = $this->count_total_price($purchase_order);
        return view('purchase_order.show')
            ->with('purchase_order', $purchase_order)
            ->with('total_price', $total_price)
            ->with('invoice', $invoice)
            ->with('purchase_returns', $purchase_returns);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $purchase_order = PurchaseOrder::findOrFail($id);
        $supplier_options = Supplier::lists('name', 'id');
        $total_price = $this->count_total_price($purchase_order);
        return view('purchase_order.edit')
            ->with('purchase_order', $purchase_order)
            ->with('total_price', $total_price)
            ->with('supplier_options', $supplier_options);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePurchaseOrderRequest $request)
    {
        if($request->ajax()){
            
            $id = $request->id;
            $purchase_order = PurchaseOrder::findOrFail($id);
            $purchase_order->supplier_id = $request->supplier_id;
            $purchase_order->notes = $request->notes;
            $update = $purchase_order->save();

            //Build sync data to update PO relation w/ products
            $syncData = [];
            foreach($request->product_id as $key=>$value){
                $syncData[$value] = ['quantity'=> $request->quantity[$key]];
            }

            //First, delete all the relation cloumn between product and purchase order on table prouduct_purchase_order before syncing
            \DB::table('product_purchase_order')->where('purchase_order_id','=',$id)->delete();
            //Now time to sync the products
            $purchase_order->products()->sync($syncData);

            $response = [
                'msg'=>'updatePurchaseOrderOk',
                'purchase_order_id'=>$id
            ];
            return response()->json($response);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $purchase_order = PurchaseOrder::findOrFail($request->purchase_order_id);
        $purchase_order->delete();
        //delete all the related data with this purchase order in the database
        //product related
        \DB::table('product_purchase_order')->where('purchase_order_id','=',$request->purchase_order_id)->delete();
        //invoice related
        \DB::table('purchase_order_invoices')->where('purchase_order_id','=',$request->purchase_order_id)->delete();
        //return related
        \DB::table('purchase_returns')->where('purchase_order_id','=',$request->purchase_order_id)->delete();
        return redirect('purchase-order')
            ->with('successMessage', "Purchase Order has been deleted");




    }

    public function printPdf(Request $request){

        $data['purchase_order'] = PurchaseOrder::findOrFail($request->id);
        $data['total_price'] = $this->count_total_price($data['purchase_order']);
        
        $pdf = \PDF::loadView('pdf.purchase_order', $data);
        return $pdf->stream('purchase_order.pdf');
    }


    public function accept(Request $request)
    {

        $purchase_order = PurchaseOrder::findOrFail($request->id_to_be_accepted);
        $purchase_order->status = 'accepted';
        $purchase_order->save();
        
        //update stock quantity to each products based on the accepted purchase order
        //error prevent control incase there are no relational product
        if(count($purchase_order->products) > 0){
            foreach($purchase_order->products as $product){
            
                //$prod_qu []= ['id'=>$product->id, 'stock'=>$product->pivot->quantity];
                $current_stock = \DB::table('products')->where('id', $product->id)->value('stock');
                $added_stock = $current_stock+$product->pivot->quantity;
                $update_stock = \DB::table('products')
                                ->where('id', $product->id)
                                ->update(['stock'=> $added_stock]);
            }    
        }
        

        return redirect('purchase-order');

    }

    public function complete(Request $request)
    {
        $purchase_order = PurchaseOrder::findOrFail($request->id_to_be_completed);
        $purchase_order->status = 'completed';
        $purchase_order->save();
        return redirect('purchase-order');
    }

}
