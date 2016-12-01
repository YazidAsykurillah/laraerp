<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

//form requests
use App\Http\Requests\StorePurchaseReturnRequest;

use App\PurchaseOrder;
use App\PurchaseReturn;
use App\Product;

class PurchaseReturnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('purchase_return.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $purchase_order = PurchaseOrder::findOrFail($request->purchase_order_id);
        return view('purchase_return.create')
            ->with('purchase_order', $purchase_order);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function compare_stock_and_quantity(){
        $error = array();
        $error[]= 'returned_quantity is higher than stock';
        $error[]= 'returned_quantity is higher than stock again';
        return $error;
        
    }
    public function store(StorePurchaseReturnRequest $request)
    {
        if($request->ajax()){
            
            /*foreach($request->product_id as $key=>$value){  
                $current_stock =  \DB::table('products')->where('id', $request->product_id[$key])->first()->stock;
                $returned_quantity = $request->returned_quantity[$key];
                if($current_stock < $returned_quantity){
                    echo "Over limit";
                    break;
                }
            }*/
            foreach($request->product_id as $key=>$value){
                $purchase_return = new PurchaseReturn;
                $purchase_return->purchase_order_id = $request->purchase_order_id;
                $purchase_return->product_id = $request->product_id[$key];
                $purchase_return->quantity = preg_replace('#[^0-9]#', '', $request->returned_quantity[$key]);
                $purchase_return->notes = $request->notes[$key];
                $purchase_return->created_by = \Auth::user()->id;
                $purchase_return->save();
            }
            
            return response("storePurchaseReturnOk");
        }
        else{
            return "Please enable javascript";
        }
        


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function changeToSent(Request $request){

        //initiate Purchase return and Product models
        $purchase_return = PurchaseReturn::findOrFail($request->id_to_be_send);
        $product = Product::findOrFail($purchase_return->product_id);

        //get product name and purchase order code refference
        $product_name = $purchase_return->product->name;
        $purchase_order_ref = $purchase_return->purchase_order->code;
        //get the current product stok
        $current_stock = $product->stock;
        //product quantity to be returned
        $qty_to_return = $purchase_return->quantity;
        
        //compare to product quantities to return and current product stock
        //if current product stock is lower than quantities to be returned, then throw an errror
        if($qty_to_return > $current_stock){
            return redirect('purchase-return')
                ->with('errorMessage', "Returned product quantity is higher than product stock, it is must be an error, please fix your purchase return");
        }
        else{
            //update product stock by subtracting curent product stock by product quantity to returned
            $product->stock = $current_stock-$qty_to_return;
            $product->save();

            //change purchase return to sent
            $purchase_return->status = 'sent';
            $purchase_return->save();
            return redirect('purchase-return')
                ->with('successMessage', "$product_name on $purchase_order_ref has been returned to the supplier");    
        }
        
    }

    public function changeToCompleted(Request $request){

        $purchase_return = PurchaseReturn::findOrFail($request->id_to_be_completed);
        //get product name and purchase order code refference
        $product_name = $purchase_return->product->name;
        $purchase_order_ref = $purchase_return->purchase_order->code;
        $purchase_return->status = 'completed';
        $purchase_return->save();
        return redirect('purchase-return')
            ->with('successMessage', "$product_name has been added back to inventory from $purchase_order_ref");
    }

}
