<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\StoreSalesOrderRequest;
use App\Http\Requests\UpdateSalesOrderRequest;

use App\SalesOrder;
use App\Customer;

class SalesOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('sales_order.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customer_options = Customer::lists('name', 'id');
        return view('sales_order.create')
            ->with('customer_options', $customer_options);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSalesOrderRequest $request)
    {
        if($request->ajax()){
            $data = [
                'customer_id'=>$request->customer_id,
                'notes'=>$request->notes,
                'creator'=>\Auth::user()->id
            ];

            $save = SalesOrder::create($data);
            $sales_order_id = $save->id;

            //update the code for this sales order
            $code = \DB::table('sales_orders')->where('id', $sales_order_id)->update(['code'=>'SO-'.$sales_order_id]);
            $sales_order = SalesOrder::find($sales_order_id);

            //Build sync data to store the relation w/ products
            $syncData = [];
            foreach($request->product_id as $key=>$value){
                //$syncData[$value] = ['quantity'=> $request->quantity[$key], 'price'=>floatval(preg_replace('#[^0-9.]#', '', $request->price[$key]))];
                $syncData[$value] = ['quantity'=> $request->quantity[$key]];
            }
            //sync the sales order product relation
            $sales_order->products()->sync($syncData);

            $response = [
                'msg'=>'storeSalesOrderOk',
                'sales_order_id'=>$sales_order_id
            ];
            return response()->json($response);
        }
        else{
            die("Seriously, we only need an ajax call");
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
        $sales_order = SalesOrder::findOrFail($id);
        //invoice related with this purchase order
        $invoice =  $sales_order->sales_order_invoice();

        return view('sales_order.show')
            ->with('sales_order', $sales_order)
            ->with('invoice', $invoice);
    }

    protected function count_total_price($sales_order)
    {
        $sum_price = \DB::table('product_sales_order')
                    ->where('sales_order_id', $sales_order->id)
                    ->sum('price');
        return $sum_price;
    }
    public function edit($id)
    {
        $sales_order = SalesOrder::findOrFail($id);
        if($sales_order->status == 'posted'){
            $customer_options = Customer::lists('name', 'id');
            $total_price = $this->count_total_price($sales_order);
            return view('sales_order.edit')
                ->with('sales_order', $sales_order)
                ->with('total_price', $total_price)
                ->with('customer_options', $customer_options);
        }
        else{

            return response('404');
        }
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSalesOrderRequest $request)
    {
        if($request->ajax()){

            $id = $request->id;
            $sales_order = SalesOrder::findOrFail($id);
            $sales_order->customer_id = $request->customer_id;
            $sales_order->notes = $request->notes;
            $update = $sales_order->save();

            //Build sync data to update PO relation w/ products
            $syncData = [];
            foreach($request->product_id as $key=>$value){
                $syncData[$value] = ['quantity'=> $request->quantity[$key]];
            }

            //First, delete all the relation cloumn between product and purchase order on table prouduct_sales_order before syncing
            \DB::table('product_sales_order')->where('sales_order_id','=',$id)->delete();
            //Now time to sync the products
            $sales_order->products()->sync($syncData);

            $response = [
                'msg'=>'updateSalesOrderOk',
                'sales_order_id'=>$id
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
        $sales_order = SalesOrder::findOrFail($request->sales_order_id);
        $sales_order->delete();
        //delete related data with this sales order in the database
        //product related
        \DB::table('product_sales_order')->where('sales_order_id','=',$request->sales_order_id)->delete();
        return redirect('sales-order')
            ->with('successMessage', "Sales order has been deleted");
    }

    
    public function updateStatus(Request $request)
    {
        $sales_order = SalesOrder::findOrFail($request->sales_order_id);
        $sales_order->status = $request->status;
        $updateStatus = $sales_order->save();
        switch ($request->status) {
            case 'processing':
                $this->update_product_stock_from_process($sales_order);
                break;
            case 'cancelled':
                $this->update_product_stock_from_cancelled($sales_order);
            default:
                # code...
                break;
        }
        return back()->with('successMessage', "Status has been changed");
    }

    protected function update_product_stock_from_process($sales_order)
    {
        if(count($sales_order->products)){
            foreach($sales_order->products as $product){
                //echo $product->id;
                $current_stock = \DB::table('products')->where('id', $product->id)->value('stock');
                $stock_to_sale = $product->pivot->quantity;
                $new_stock = $current_stock-$stock_to_sale;
                $update_product_stock = \DB::table('products')->where('id', $product->id)->update(['stock'=>$new_stock]);
            }
        }
        return TRUE;
    }

    protected function update_product_stock_from_cancelled($sales_order)
    {
        if(count($sales_order->products)){
            foreach($sales_order->products as $product){
                //echo $product->id;
                $current_stock = \DB::table('products')->where('id', $product->id)->value('stock');
                $stock_to_sale = $product->pivot->quantity;
                $new_stock = $current_stock+$stock_to_sale;
                $update_product_stock = \DB::table('products')->where('id', $product->id)->update(['stock'=>$new_stock]);
            }
        }
        return TRUE;
    }
    
}
