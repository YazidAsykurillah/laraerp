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
use App\Product;

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
                //$return = '';
                $sales_invoice = \DB::table('sales_order_invoices')->whereBetween('created_at',[$start_date.' 00:00:00',$end_date.' 23:59:59'])->get();
                // foreach ($sales_invoice as $key) {
                //     $return = SalesOrderInvoice::findOrfail($key->id)->sales_order->sales_returns;
                //     //$price_per_unit = \DB::table('product_sales_order')->where('product_id',$)
                //     // print_r(count($return) );
                //     // exit();
                // }
                // $data_return = '';
                // foreach ($return as $key) {
                //     $data_return += $key->quantity*\DB::table('product_sales_order')->select('price_per_unit')->where('product_id',$key->product_id)->where('sales_order_id',$key->sales_order_id)->get()[0]->price_per_unit;
                // }
                $return_data = [];
                foreach ($sales_invoice as $key) {

                    array_push($data_invoice,[
                        'no_faktur'=>$key->code,
                        'tgl_faktur'=>$key->created_at,
                        'customer'=>SalesOrderInvoice::findOrfail($key->id)->sales_order->customer->name,
                        'sub_total'=>'',
                        'disc'=>'',
                        'tax'=>'',
                        'bill_price'=>$key->bill_price,
                        'return'=>SalesOrderInvoice::findOrfail($key->id)->sales_order->sales_returns,
                        'net'=>$key->bill_price-0,
                    ]);
                }

                // print_r($data_invoice);
                // exit();
                break;
            case 1:
                $sales_invoice = \DB::table('product_sales_order')->get();
                foreach ($sales_invoice as $key) {
                    // print_r(SalesOrder::findOrfail($key->sales_order_id)->sales_order_invoice()->whereBetween('created_at',[$start_date.' 00:00:00',$end_date.' 23:59:59'])->get()->count());
                    // exit();
                    if(SalesOrder::findOrfail($key->sales_order_id)->sales_order_invoice()->whereBetween('created_at',[$start_date.' 00:00:00',$end_date.' 23:59:59'])->get()->count() > 0)
                    {
                        array_push($data_invoice,[
                            'no_faktur'=>SalesOrder::findOrfail($key->sales_order_id)->sales_order_invoice->code,
                            'tgl_faktur'=>SalesOrder::findOrfail($key->sales_order_id)->sales_order_invoice->created_at,
                            'customer'=>SalesOrder::findOrfail($key->sales_order_id)->customer->name,
                            'item'=>Product::findOrfail($key->product_id)->name,
                            'unit_price'=>$key->price_per_unit,
                            'quantity'=>$key->quantity,
                            'disc'=>'',
                            'disc_amt'=>'',
                            'line_total'=>$key->price,

                        ]);
                    }else{

                    }

                }
                break;
            case 2:
                $sales_invoice = \DB::table('sales_order_invoices')->whereBetween('created_at',[$start_date.' 00:00:00',$end_date.' 23:59:59'])->get();
                // foreach ($sales_invoice as $key) {
                //     $return = SalesOrderInvoice::findOrfail($key->id)->sales_order->sales_returns;
                //     //$price_per_unit = \DB::table('product_sales_order')->where('product_id',$)
                //     // print_r(count($return) );
                //     // exit();
                // }
                // $data_return = '';
                // foreach ($return as $key) {
                //     $data_return += $key->quantity*\DB::table('product_sales_order')->select('price_per_unit')->where('product_id',$key->product_id)->where('sales_order_id',$key->sales_order_id)->get()[0]->price_per_unit;
                // }
                $return_data = [];
                foreach ($sales_invoice as $key) {

                    array_push($data_invoice,[
                        'no_faktur'=>$key->code,
                        'tgl_faktur'=>$key->created_at,
                        'customer'=>SalesOrderInvoice::findOrfail($key->id)->sales_order->customer->name,
                        'sub_total'=>'',
                        'disc'=>'',
                        'tax'=>'',
                        'total'=>SalesOrderInvoice::findOrfail($key->id)->sales_order->sales_returns,
                        'return'=>'',
                        'net'=>$key->bill_price-0,
                    ]);
                }
                break;
            case 3:
                //date between from date sales return
                $sales_return = \DB::table('sales_returns')->whereBetween('created_at',[$start_date.' 00:00:00',$end_date.' 23:59:59'])->get();
                foreach ($sales_return as $key) {
                    array_push($data_invoice,[
                        'no_faktur'=>SalesOrder::findOrfail($key->sales_order_id)->sales_order_invoice->code,
                        'tgl_faktur'=>$key->created_at,
                        'customer'=>SalesOrder::findOrfail($key->sales_order_id)->customer->name,
                        'item'=>Product::findOrfail($key->product_id)->name,
                        'unit_price'=>\DB::table('product_sales_order')->where('product_id',$key->product_id)->where('sales_order_id',$key->sales_order_id)->get()[0]->price_per_unit,
                        'quantity'=>$key->quantity,
                        'disc'=>'',
                        'disc_amt'=>'',
                        'price'=>'',
                    ]);
                }
                break;
            case 4:
                $purchase_invoice = \DB::table('purchase_order_invoices')->whereBetween('created_at',[$start_date.' 00:00:00',$end_date.' 23:59:59'])->get();
                foreach ($purchase_invoice as $key) {
                    array_push($data_invoice,[
                        'no_faktur'=>$key->code,
                        'tgl_faktur'=>$key->created_at,
                        'supplier'=>PurchaseOrderInvoice::findOrfail($key->id)->purchase_order->supplier->name,
                        'sub_total'=>'',
                        'disc'=>'',
                        'tax'=>'',
                        'bill_price'=>$key->bill_price,
                        'return'=>PurchaseOrderInvoice::findOrfail($key->id)->purchase_order->purchase_returns,
                        'net'=>$key->bill_price-0,
                    ]);
                }
                break;
            case 5:
                $purchase_invoice = \DB::table('product_purchase_order')->get();
                foreach ($purchase_invoice as $key) {
                    if(PurchaseOrder::findOrfail($key->purchase_order_id)->purchase_order_invoice()->whereBetween('created_at',[$start_date.' 00:00:00',$end_date.' 23:59:59'])->get()->count() > 0)
                    {
                        array_push($data_invoice,[
                            'no_faktur'=>PurchaseOrder::findOrfail($key->purchase_order_id)->purchase_order_invoice->code,
                            'tgl_faktur'=>PurchaseOrder::findOrfail($key->purchase_order_id)->purchase_order_invoice->created_at,
                            'supplier'=>PurchaseOrder::findOrfail($key->purchase_order_id)->supplier->name,
                            'item'=>Product::findOrfail($key->product_id)->name,
                            'unit_price'=>$key->price/$key->quantity,
                            'quantity'=>$key->quantity,
                            'disc'=>'',
                            'price'=>$key->price,

                        ]);
                    }else{

                    }
                }
                break;
            case 6:
                $purchase_invoice = \DB::table('purchase_order_invoices')->whereBetween('created_at',[$start_date.' 00:00:00',$end_date.' 23:59:59'])->get();
                // foreach ($sales_invoice as $key) {
                //     $return = SalesOrderInvoice::findOrfail($key->id)->sales_order->sales_returns;
                //     //$price_per_unit = \DB::table('product_sales_order')->where('product_id',$)
                //     // print_r(count($return) );
                //     // exit();
                // }
                // $data_return = '';
                // foreach ($return as $key) {
                //     $data_return += $key->quantity*\DB::table('product_sales_order')->select('price_per_unit')->where('product_id',$key->product_id)->where('sales_order_id',$key->sales_order_id)->get()[0]->price_per_unit;
                // }
                $return_data = [];
                foreach ($purchase_invoice as $key) {

                    array_push($data_invoice,[
                        'no_faktur'=>$key->code,
                        'tgl_faktur'=>$key->created_at,
                        'supplier'=>PurchaseOrderInvoice::findOrfail($key->id)->purchase_order->supplier->name,
                        'sub_total'=>'',
                        'disc'=>'',
                        'tax'=>'',
                        'total'=>PurchaseOrderInvoice::findOrfail($key->id)->purchase_order->purchase_returns,
                        'return'=>'',
                        'net'=>$key->bill_price-0,
                    ]);
                }
                break;
            case 7:
                //date between from date purchase return
                $purchase_return = \DB::table('purchase_returns')->whereBetween('created_at',[$start_date.' 00:00:00',$end_date.' 23:59:59'])->get();
                foreach ($purchase_return as $key) {
                    array_push($data_invoice,[
                        'no_faktur'=>PurchaseOrder::findOrfail($key->purchase_order_id)->purchase_order_invoice->code,
                        'tgl_faktur'=>$key->created_at,
                        'supplier'=>PurchaseOrder::findOrfail($key->purchase_order_id)->supplier->name,
                        'item'=>Product::findOrfail($key->product_id)->name,
                        'unit_price'=>(\DB::table('product_purchase_order')->where('product_id',$key->product_id)->where('purchase_order_id',$key->purchase_order_id)->get()[0]->price)/(\DB::table('product_purchase_order')->where('product_id',$key->product_id)->where('purchase_order_id',$key->purchase_order_id)->get()[0]->quantity),
                        'quantity'=>$key->quantity,
                        'disc'=>'',
                        'disc_amt'=>'',
                        'price'=>Product::findOrfail($key->product_id)->price,
                    ]);
                }
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

    // protected function display_table_product_sales_order($pro_id,$sales_order_id)
    // {
    //     $data_pro_sal_ord = \DB::table('product_sales_order')->where('product_id',$pro_id)->where('sales_order_id',$sales_order_id)->get();
    //     $data_nya = [];
    //     foreach ($data_pro_sal_ord as $key) {
    //         array_push($data_nya,[
    //             'price_per_unit'=>$key->price_per_unit,
    //         ]);
    //     }
    //     return $data_nya;
    // }
}
