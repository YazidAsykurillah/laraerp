<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;


use App\SalesOrderInvoice;
use App\SalesOrder;

class SalesOrderInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('sales_order.list_invoice');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $sales_order = SalesOrder::findOrFail($request->sales_order_id);
        return view('sales_order.create_invoice')
            ->with('total_price', $this->count_total_price($sales_order))
            ->with('sales_order', $sales_order);
    }

    protected function count_total_price($sales_order)
    {
        $sum_price = \DB::table('product_sales_order')
                    ->where('sales_order_id', $sales_order->id)
                    ->sum('price');
        return $sum_price;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       if($request->ajax()){

            $data = [
                'sales_order_id' =>$request->sales_order_id,
                'bill_price'=>floatval(preg_replace('#[^0-9.]#', '', $request->bill_price)),
                'notes'=>$request->notes,
                'created_by'=>\Auth::user()->id
            ];

            $save = SalesOrderInvoice::create($data);
            //get last inserted id of sales_order_invoice
            $sales_order_invoice_id = $save->id;
            if($save){
                //update the code for this invoice
                $code = 'SOI-'.$sales_order_invoice_id;
                \DB::table('sales_order_invoices')->where('id', $sales_order_invoice_id)->update(['code'=>$code]);
                //find sales_order model
                $sales_order = SalesOrder::findOrFail($request->sales_order_id);
                //Build sync data to update PO relation w/ products
                $syncData = [];
                foreach($request->product_id as $key=>$value){
                    $syncData[$value] = [
                        'quantity'=> $request->quantity[$key], 
                        'price'=>floatval(preg_replace('#[^0-9.]#', '', $request->price[$key])),
                        'price_per_unit'=>floatval(preg_replace('#[^0-9.]#', '', $request->price_per_unit[$key]))
                    ];
                }
                //First, delete all the relation cloumn between product and sales order on table prouduct_sales_order before syncing
                \DB::table('product_sales_order')->where('sales_order_id','=',$sales_order->id)->delete();
                //Now time to sync the products
                $sales_order->products()->sync($syncData);
            }

            $response = [
                'msg'=>'storeSalesOrderInvoiceOk',
                'sales_order_id'=>$request->sales_order_id
            ];
            return response()->json($response);
        }
        else{

            return "Please activate javascript in your browser";
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
        $sales_order_invoice = SalesOrderInvoice::findOrFail($id);
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
    public function destroy(Request $request)
    {
        $id = $request->sales_order_invoice_id;
        \DB::table('sales_order_invoices')->where('id', $id)->delete();
        return redirect('sales-order-invoice');

    }
}
