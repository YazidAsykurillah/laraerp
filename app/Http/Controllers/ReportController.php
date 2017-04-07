<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Supplier;
use App\Customer;
use App\SalesOrder;
use App\SalesOrderInvoice;
use App\PurchaseOrder;
use App\PurchaseOrderInvoice;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $supplier = Supplier::get();
        $customer = Customer::get();
        $data_supplier = [];
        $data_customer = [];
        foreach ($supplier as $key) {
            array_push($data_supplier,[
                'id'=>$key->id,
                'name'=>$key->name
            ]);
        }
        foreach ($customer as $key) {
            array_push($data_customer,[
                'id'=>$key->id,
                'name'=>$key->name
            ]);
        }
        return view('report.index')
            ->with('data_supplier',$data_supplier)
            ->with('data_customer',$data_customer);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

    public function report_search(Request $request)
    {
        $supplier = Supplier::get();
        $customer = Customer::get();
        $data_supplier = [];
        $data_customer = [];
        foreach ($supplier as $key) {
            array_push($data_supplier,[
                'id'=>$key->id,
                'name'=>$key->name
            ]);
        }
        foreach ($customer as $key) {
            array_push($data_customer,[
                'id'=>$key->id,
                'name'=>$key->name
            ]);
        }
        $report_type = $request->type_report;
        $start_date = $request->date_start;
        $end_date = $request->date_end;
        $keyword = $request->keyword;
        $product = $request->product;
        $data_invoice = [];
        switch($report_type){
            case 0:
                $sales_invoice = \DB::table('sales_order_invoices')->whereBetween('created_at',[$start_date.' 00:00:00',$end_date.' 23:59:59'])->get();
                foreach ($sales_invoice as $key) {
                    array_push($data_invoice,[
                        'no_faktur'=>$key->code,
                        'tgl_faktur'=>$key->created_at,
                        'keterangan'=>$key->notes,
                        'bill_price'=>$key->bill_price,
                        'customer'=>SalesOrderInvoice::findOrfail($key->id)->sales_order->customer->name
                    ]);
                }
                break;
            case 1:
                $sales_invoice = \DB::table('sales_order_invoices')->whereBetween('created_at',[$start_date.' 00:00:00',$end_date.' 23:59:59'])->get();
                foreach ($sales_invoice as $key) {
                    array_push($data_invoice,[
                        'no_faktur'=>$key->code,
                        'tgl_faktur'=>$key->created_at,
                        'keterangan'=>$key->notes,
                        'bill_price'=>$key->bill_price,
                        'return'=>'',
                        'netto'=>'',
                        'customer'=>SalesOrderInvoice::findOrfail($key->id)->sales_order->customer->name
                    ]);
                }
                break;
            case 2:

                break;
            case 3:

                break;
            case 4:
                $purchase_invoice = \DB::table('purchase_order_invoices')->whereBetween('created_at',[$start_date.' 00:00:00',$end_date.' 23:59:59'])->get();
                foreach ($purchase_invoice as $key) {
                    array_push($data_invoice,[
                        'no_faktur'=>$key->code,
                        'tgl_faktur'=>$key->created_at,
                        'keterangan'=>$key->notes,
                        'bill_price'=>$key->bill_price,
                        'supplier'=>PurchaseOrderInvoice::findOrfail($key->id)->purchase_order->supplier->name
                    ]);
                }
                break;
            case 5:
                $purchase_invoice = \DB::table('purchase_order_invoices')->whereBetween('created_at',[$start_date.' 00:00:00',$end_date.' 23:59:59'])->get();
                foreach ($purchase_invoice as $key) {
                    array_push($data_invoice,[
                        'no_faktur'=>$key->code,
                        'tgl_faktur'=>$key->created_at,
                        'keterangan'=>$key->notes,
                        'bill_price'=>$key->bill_price,
                        'return'=>'',
                        'netto'=>'',
                        'supplier'=>PurchaseOrderInvoice::findOrfail($key->id)->purchase_order->supplier->name
                    ]);
                }
                break;
            case 6:

                break;
            case 7:

                break;
            // search rincian penjualan per pelanggan
            case 8:
                $customer_id = \DB::table('customers')->select('id')->where('name',$keyword)->get();
                $sales = \DB::table('sales_orders')->where('customer_id',$customer_id[0]->id)->get();
                $sales_join = \DB::table('sales_orders')
                                ->join('sales_order_invoices','sales_orders.id','=','sales_order_invoices.sales_order_id')
                                ->select('sales_order_invoices.code','sales_order_invoices.created_at','sales_order_invoices.notes','sales_order_invoices.bill_price')
                                ->where('sales_orders.customer_id','=',$customer_id[0]->id)
                                ->whereBetween('sales_order_invoices.created_at',[$start_date.' 00:00:00',$end_date.' 23:59:59'])->get();
                // print_r($sales_join);
                // exit();
                foreach ($sales_join as $key) {
                    array_push($data_invoice,[
                            'no_faktur'=>$key->code,
                            'tgl_faktur'=>$key->created_at,
                            'keterangan'=>$key->notes,
                            'bill_price'=>$key->bill_price,
                            'return'=>'',
                            'netto'=>'',
                            'customer'=>$keyword,
                        ]);
                }
                // print_r($data_invoice);
                // exit();
                break;
            case 9:
                $customer_id = \DB::table('customers')->select('id')->where('name',$keyword)->get();
                $sales = \DB::table('sales_orders')->where('customer_id',$customer_id[0]->id)->get();
                $sales_join = \DB::table('sales_orders')
                                ->join('sales_order_invoices','sales_orders.id','=','sales_order_invoices.sales_order_id')
                                ->select('sales_order_invoices.code','sales_order_invoices.created_at','sales_order_invoices.notes','sales_order_invoices.bill_price')
                                ->where('sales_orders.customer_id','=',$customer_id[0]->id)
                                ->whereBetween('sales_order_invoices.created_at',[$start_date.' 00:00:00',$end_date.' 23:59:59'])->get();
                // print_r($sales_join);
                // exit();
                foreach ($sales_join as $key) {
                    array_push($data_invoice,[
                            'no_faktur'=>$key->code,
                            'tgl_faktur'=>$key->created_at,
                            'keterangan'=>$key->notes,
                            'bill_price'=>$key->bill_price,
                            'customer'=>$keyword,
                        ]);
                }
                break;
        }

        // print_r($data_invoice);
        // exit();
        return view('report.index')
            ->with('report_type',$report_type)
            ->with('start_date',$start_date)
            ->with('end_date',$end_date)
            ->with('keyword',$keyword)
            ->with('product',$product)
            ->with('data_supplier',$data_supplier)
            ->with('data_customer',$data_customer)
            ->with('data_invoice',$data_invoice);
    }
}
