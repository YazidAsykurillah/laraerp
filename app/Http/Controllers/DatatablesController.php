<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Yajra\Datatables\Datatables;

use App\User;
use App\Role;
use App\Product;
use App\Supplier;
use App\Customer;
use App\Unit;
use App\PurchaseOrder;
use App\PurchaseOrderInvoice;
use App\PurchaseReturn;
use App\SalesOrder;
use App\SalesOrderInvoice;
use App\SalesReturn;
use App\InvoiceTerm;
use App\Driver;
use App\StockBalance;
use App\Bank;
use App\Cash;

class DatatablesController extends Controller
{

    

    //Function get CUSTOMERS datatable
    public function getCustomers(Request $request)
    {
        \DB::statement(\DB::raw('set @rownum=0'));
        $customers = Customer::select([
            \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'id',
            'code',
            'name',
            'phone_number',
            'address',
            'invoice_term_id'
        ]);

        $data_customers = Datatables::of($customers)
            ->editColumn('invoice_term_id', function($customers){
                if(!is_null($customers->invoice_term_id)){
                    return $customers->invoice_term->name;
                }
                return "";
            })
            ->addColumn('actions', function($customers){
                    $actions_html ='<a href="'.url('customer/'.$customers->id.'').'" class="btn btn-info btn-xs" title="Click to view the detail">';
                    $actions_html .=    '<i class="fa fa-external-link-square"></i>';
                    $actions_html .='</a>&nbsp;';
                    $actions_html .='<a href="'.url('customer/'.$customers->id.'/edit').'" class="btn btn-success btn-xs" title="Click to edit this customer">';
                    $actions_html .=    '<i class="fa fa-edit"></i>';
                    $actions_html .='</a>&nbsp;';
                    $actions_html .='<button type="button" class="btn btn-danger btn-xs btn-delete-customer" data-id="'.$customers->id.'" data-text="'.$customers->name.'">';
                    $actions_html .=    '<i class="fa fa-trash"></i>';
                    $actions_html .='</button>';

                    return $actions_html;
            });

        if ($keyword = $request->get('search')['value']) {
            $data_customers->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $data_customers->make(true);
    }
    //ENDFunction get CUSTOMERS datatable


    //Function to get product list
    public function getProducts(Request $request){
        \DB::statement(\DB::raw('set @rownum=0'));
        $products = Product::select([
            \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'id',
            'code',
            'name',
            'category_id',
            'unit_id',
            'stock',
            'minimum_stock'
        ]);
        $datatables = Datatables::of($products)
            ->editColumn('code', function($products){
                $code_html  ='<a href="'.url('product/'.$products->id).'" class="btn btn-link btn-xs" target="_" title="Click to see the detail">';
                $code_html .=   '<i class="fa fa-link">&nbsp;'.$products->code.'</i>';
                $code_html .='</a>&nbsp;';
                return $code_html;
            })
            ->editColumn('category_id', function($products){
                return $products->category->name;
            })
            ->editColumn('unit_id', function($products){
                if($products->unit_id != NULL){
                    return $products->unit->name;
                }
                return 'Undefined unit';

            })
            ->addColumn('actions', function($products){
                    $actions_html  ='<a href="'.url('product/'.$products->id.'/edit').'" class="btn btn-info btn-xs" title="Klik untuk mengedit produk ini">';
                    $actions_html .=    '<i class="fa fa-edit"></i>';
                    $actions_html .='</a>&nbsp;';
                    $actions_html .='<button type="button" class="btn btn-danger btn-xs btn-delete-product" data-id="'.$products->id.'" data-text="'.$products->name.'">';
                    $actions_html .=    '<i class="fa fa-trash"></i>';
                    $actions_html .='</button>';

                    return $actions_html;
            });
        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $datatables->make(true);

    }
    //ENDFunction to get product list

    //Function to get UNITS list
    public function getUnits(Request $request)
    {
        \DB::statement(\DB::raw('set @rownum=0'));
        $units = Unit::select([
            \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'id',
            'name',
            'created_at',
            'updated_at',
        ]);

        $data_units = Datatables::of($units)
            ->addColumn('actions', function($units){
                    $actions_html ='<a href="'.url('unit/'.$units->id.'').'" class="btn btn-default btn-xs" title="Click to view the detail">';
                    $actions_html .=    '<i class="fa fa-eye"></i>';
                    $actions_html .='</a>&nbsp;';
                    $actions_html .='<a href="'.url('unit/'.$units->id.'/edit').'" class="btn btn-success btn-xs" title="Click to edit this unit">';
                    $actions_html .=    '<i class="fa fa-edit"></i>';
                    $actions_html .='</a>&nbsp;';
                    $actions_html .='<button type="button" class="btn btn-danger btn-xs btn-delete-unit" data-id="'.$units->id.'" data-text="'.$units->name.'">';
                    $actions_html .=    '<i class="fa fa-trash"></i>';
                    $actions_html .='</button>';

                    return $actions_html;
            });

        if ($keyword = $request->get('search')['value']) {
            $data_units->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $data_units->make(true);
    }
    //ENDFunction to get UNITS list

    //Function to get supplier list
    public function getSuppliers(Request $request){
        \DB::statement(\DB::raw('set @rownum=0'));
        $suppliers = Supplier::select([
            \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'id',
            'code',
            'name',
            'pic_name',
            'primary_email',
            'primary_phone_number',
        ]);
        $data_suppliers = Datatables::of($suppliers)
            ->addColumn('actions', function($suppliers){
                    $actions_html ='<a href="'.url('supplier/'.$suppliers->id.'').'" class="btn btn-info btn-xs" title="Click to view the detail">';
                    $actions_html .=    '<i class="fa fa-external-link-square"></i>';
                    $actions_html .='</a>&nbsp;';
                    $actions_html .='<a href="'.url('supplier/'.$suppliers->id.'/edit').'" class="btn btn-success btn-xs" title="Click to edit this supplier">';
                    $actions_html .=    '<i class="fa fa-edit"></i>';
                    $actions_html .='</a>&nbsp;';
                    $actions_html .='<button type="button" class="btn btn-danger btn-xs btn-delete-supplier" data-id="'.$suppliers->id.'" data-text="'.$suppliers->name.'">';
                    $actions_html .=    '<i class="fa fa-trash"></i>';
                    $actions_html .='</button>';

                    return $actions_html;
            });

        if ($keyword = $request->get('search')['value']) {
            $data_suppliers->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }


        return $data_suppliers->make(true);

    }
    //ENDFunction to get supplier list


    //Function get Purchase Orders list
    public function getPurchaseOrders(Request $request){
        \DB::statement(\DB::raw('set @rownum=0'));
        $purchase_orders = PurchaseOrder::with('supplier', 'created_by', 'purchase_order_invoice')->select(
            [
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'purchase_orders.*',
            ]
        );

        $data_purchase_orders = Datatables::of($purchase_orders)
            ->editColumn('supplier_id', function($purchase_orders){
                return $purchase_orders->supplier->name;
            })
            ->editColumn('creator', function($purchase_orders){
                return $purchase_orders->created_by->name;
            })
            ->editColumn('status', function($purchase_orders){
                $status_label = '';

                if($purchase_orders->status == 'posted'){
                    $status_label = '<p>POSTED</p>';

                }
                else if($purchase_orders->status =='accepted'){
                    $status_label = '<p>ACCEPTED</p>';

                }
                else{
                    $status_label = '<p>COMPLETED</p>';
                }
                return $status_label;
            })
            ->addColumn('actions', function($purchase_orders){
                $actions_html ='<a href="'.url('purchase-order/'.$purchase_orders->id.'').'" class="btn btn-info btn-xs" title="Click to view the detail">';
                $actions_html .=    '<i class="fa fa-external-link-square"></i>';
                $actions_html .='</a>&nbsp;';
                //only show edit button link if the status is posted
                if($purchase_orders->status =='posted'){
                    $actions_html .='<a href="'.url('purchase-order/'.$purchase_orders->id.'/edit').'" class="btn btn-success btn-xs" title="Click to edit">';
                    $actions_html .=    '<i class="fa fa-edit"></i>';
                    $actions_html .='</a>&nbsp;';
                }
                if(count($purchase_orders->purchase_order_invoice) > 0){
                    $actions_html .='<button type="button" class="btn btn-danger btn-xs btn-delete-purchase-order" title="Click to delete" data-id="'.$purchase_orders->id.'" data-text="'.$purchase_orders->code.'" data-id-payment="'.$purchase_orders->purchase_order_invoice->id.'">';
                    $actions_html .=    '<i class="fa fa-trash"></i>';
                    $actions_html .='</button>';
                }else{
                    $actions_html .='<button type="button" class="btn btn-danger btn-xs btn-delete-purchase-order" title="Click to delete" data-id="'.$purchase_orders->id.'" data-text="'.$purchase_orders->code.'">';
                    $actions_html .=    '<i class="fa fa-trash"></i>';
                    $actions_html .='</button>';
                }
                return $actions_html;
            });

        /*if ($keyword = $request->get('search')['value']) {
            $data_purchase_orders->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }*/

        return $data_purchase_orders->make(true);

    }
    //ENDFunction get Purchase Orders list


    //Function get Purchase Order Invoice
    public function getPurchaseOrderInvoices(Request $request)
    {
        \DB::statement(\DB::raw('set @rownum=0'));
        $purchase_order_invoices = PurchaseOrderInvoice::with('purchase_order','creator', 'payment_method')->select(
            [
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'purchase_order_invoices.*',
            ]
        );
        $data_purchase_order_invoices = Datatables::of($purchase_order_invoices)
            ->editColumn('bill_price', function($purchase_order_invoices){
                return number_format($purchase_order_invoices->bill_price);
            })
            ->editColumn('paid_price', function($purchase_order_invoices){
                return number_format($purchase_order_invoices->paid_price);
            })
            ->editColumn('creator', function($purchase_order_invoices){

                return $purchase_order_invoices->creator->name;
            })
            // ->editColumn('payment_method', function($purchase_order_invoices){
            //     return $purchase_order_invoices->payment_method->code;
            // })
            ->editColumn('status', function($purchase_order_invoices){

                return strtoupper($purchase_order_invoices->status);
            })
            ->addColumn('actions', function($purchase_order_invoices){
                $actions_html ='<a href="'.url('purchase-order-invoice/'.$purchase_order_invoices->id.'').'" class="btn btn-info btn-xs" title="Click to view the detail">';
                $actions_html .=    '<i class="fa fa-external-link-square"></i>';
                $actions_html .='</a>&nbsp;';
                if($purchase_order_invoices->status != "completed"){
                    $actions_html .='<a href="'.url('purchase-order-invoice/'.$purchase_order_invoices->id.'/edit').'" class="btn btn-success btn-xs" title="Click to edit">';
                    $actions_html .=    '<i class="fa fa-edit"></i>';
                    $actions_html .='</a>&nbsp;';
                }

                $actions_html .='<button type="button" class="btn btn-danger btn-xs btn-delete-purchase-order-invoice" data-id="'.$purchase_order_invoices->id.'" data-text="'.$purchase_order_invoices->code.'">';
                $actions_html .=    '<i class="fa fa-trash"></i>';
                $actions_html .='</button>';

                return $actions_html;
            });
        return $data_purchase_order_invoices->make(true);
    }
    //ENDFunction get Purchase Order Invoice


    //Function get Purchase Returns
    public function getPurchaseReturns(Request $request)
    {
        \DB::statement(\DB::raw('set @rownum=0'));
        $purchase_returns = PurchaseReturn::with('purchase_order','creator', 'product')->select(
            [
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'purchase_returns.*',
            ]
        );
        $data_purchase_returns = Datatables::of($purchase_returns)
            ->editColumn('purchase_order_id', function($purchase_returns){
                return $purchase_returns->purchase_order->code;
            })
            ->editColumn('product_id', function($purchase_returns){
                return $purchase_returns->product->name;
            })
            ->editColumn('status', function($purchase_returns){
                $status_label = '';
                $status_action = '';
                if($purchase_returns->status =='posted'){
                    $status_label = '<p>POSTED</p>';
                    $status_action .='<button type="button" class="btn btn-warning btn-xs btn-send-purchase-return" data-id="'.$purchase_returns->id.'" title="Change status to Sent">';
                    $status_action .=    '<i class="fa fa-sign-in"></i>';
                    $status_action .='</button>';
                }
                else if($purchase_returns->status =='sent'){
                    $status_label = '<p>SENT</p>';
                    $status_action .='<button type="button" class="btn btn-success btn-xs btn-complete-purchase-return" data-id="'.$purchase_returns->id.'" title="Change status to Completed">';
                    $status_action .=    '<i class="fa fa-check"></i>';
                    $status_action .='</button>';
                }
                else{
                    $status_label = '<p>COMPLETED</p>';
                }

                return $status_label.$status_action;
            })
            ->addColumn('actions', function($purchase_returns){
                $actions_html ='<a href="'.url('purchase-return/'.$purchase_returns->id.'').'" class="btn btn-default btn-xs" title="Click to view the detail">';
                $actions_html .=    '<i class="fa fa-eye"></i>';
                $actions_html .='</a>&nbsp;';
                //only provide edit and delete button if the purchase return status is posted, otherwise DO NOT show them
                if($purchase_returns->status == 'posted'){
                    $actions_html .='<a href="'.url('purchase-return/'.$purchase_returns->id.'/edit').'" class="btn btn-success btn-xs" title="Click to edit">';
                    $actions_html .=    '<i class="fa fa-edit"></i>';
                    $actions_html .='</a>&nbsp;';
                    $actions_html .='<button type="button" class="btn btn-danger btn-xs btn-delete-purchase-return" data-id="'.$purchase_returns->id.'" data-text="'.$purchase_returns->code.'">';
                    $actions_html .=    '<i class="fa fa-trash"></i>';
                    $actions_html .='</button>';
                }

                return $actions_html;
            });
        return $data_purchase_returns->make(true);
    }


    //Function get Sales Orders list
    public function getSalesOrders(Request $request){
        \DB::statement(\DB::raw('set @rownum=0'));
        $sales_orders = SalesOrder::with('customer', 'created_by','sales_order_invoice')->select(
            [
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'sales_orders.*',
            ]
        );

        $data_sales_orders = Datatables::of($sales_orders)
            ->editColumn('customer_id', function($sales_orders){
                return $sales_orders->customer->name;
            })
            ->editColumn('creator', function($sales_orders){
                return $sales_orders->created_by->name;
            })
            ->editColumn('status', function($sales_orders){

                return strtoupper($sales_orders->status);

                $status_label = '';

                if($sales_orders->status == 'posted'){
                    $status_label = '<p>POSTED</p>';

                }
                else if($sales_orders->status =='accepted'){
                    $status_label = '<p>ACCEPTED</p>';

                }
                else{
                    $status_label = '<p>COMPLETED</p>';
                }

                return $status_label;

            })
            ->addColumn('actions', function($sales_orders){
                $actions_html ='<a href="'.url('sales-order/'.$sales_orders->id.'').'" class="btn btn-info btn-xs" title="Click to view the detail">';
                $actions_html .=    '<i class="fa fa-external-link-square"></i>';
                $actions_html .='</a>&nbsp;';
                //only show edit button link if the status is posted
                if($sales_orders->status =='posted'){
                    $actions_html .='<a href="'.url('sales-order/'.$sales_orders->id.'/edit').'" class="btn btn-success btn-xs" title="Click to edit">';
                    $actions_html .=    '<i class="fa fa-edit"></i>';
                    $actions_html .='</a>&nbsp;';
                }
                if(count($sales_orders->sales_order_invoice) > 0){
                    $actions_html .='<button type="button" class="btn btn-danger btn-xs btn-delete-sales-order" data-id="'.$sales_orders->id.'" data-text="'.$sales_orders->code.'" data-id-payment="'.$sales_orders->sales_order_invoice->id.'">';
                    $actions_html .=    '<i class="fa fa-trash"></i>';
                    $actions_html .='</button>';
                }else{
                    $actions_html .='<button type="button" class="btn btn-danger btn-xs btn-delete-sales-order" data-id="'.$sales_orders->id.'" data-text="'.$sales_orders->code.'">';
                    $actions_html .=    '<i class="fa fa-trash"></i>';
                    $actions_html .='</button>';
                }
                return $actions_html;
            });

        /*if ($keyword = $request->get('search')['value']) {
            $data_sales_orders->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }*/

        return $data_sales_orders->make(true);

    }
    //ENDFunction get Sales Orders list

    //Function get Sales Order Invoice
    public function getSalesOrderInvoices(Request $request)
    {
        \DB::statement(\DB::raw('set @rownum=0'));
        $sales_order_invoices = SalesOrderInvoice::with('sales_order','creator')->select(
            [
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'sales_order_invoices.*',
            ]
        );
        $data_sales_order_invoices = Datatables::of($sales_order_invoices)
            ->editColumn('sales_order_id', function($sales_order_invoices){
                return $sales_order_invoices->sales_order->code;
            })
            ->editColumn('bill_price', function($sales_order_invoices){
                return number_format($sales_order_invoices->bill_price);
            })
            ->editColumn('paid_price', function($sales_order_invoices){
                return number_format($sales_order_invoices->paid_price);
            })
            ->editColumn('created_by', function($sales_order_invoices){

                return $sales_order_invoices->creator->name;
            })
            ->editColumn('status', function($sales_order_invoices){
                return strtoupper($sales_order_invoices->status);
            })
            ->addColumn('actions', function($sales_order_invoices){
                $actions_html ='<a href="'.url('sales-order-invoice/'.$sales_order_invoices->id.'').'" class="btn btn-info btn-xs" title="Click to view the detail">';
                $actions_html .=    '<i class="fa fa-external-link-square"></i>';
                $actions_html .='</a>&nbsp;';
                if($sales_order_invoices->status != 'completed'){
                    $actions_html .='<a href="'.url('sales-order-invoice/'.$sales_order_invoices->id.'/edit').'" class="btn btn-success btn-xs" title="Click to edit">';
                    $actions_html .=    '<i class="fa fa-edit"></i>';
                    $actions_html .='</a>&nbsp;';
                }
                $actions_html .='<button type="button" class="btn btn-danger btn-xs btn-delete-sales-order-invoice" data-id="'.$sales_order_invoices->id.'" data-text="'.$sales_order_invoices->code.'">';
                $actions_html .=    '<i class="fa fa-trash"></i>';
                $actions_html .='</button>';

                return $actions_html;
            });
        return $data_sales_order_invoices->make(true);
    }
    //ENDFunction get Sales Order Invoice

    //Function get sales return
    public function getSalesReturns(Request $request)
    {
        \DB::statement(\DB::raw('set @rownum=0'));
        $sales_returns = SalesReturn::with('sales_order','creator','product')->select(
            [
                \DB::raw('@rownum := @rownum + 1 AS rownum'),
                'sales_returns.*',
            ]
        );
        $data_sales_returns = Datatables::of($sales_returns)
            ->editColumn('sales_order_id', function($sales_returns){
                return $sales_returns->sales_order->code;
            })
            ->editColumn('product_id', function($sales_returns){
                return $sales_returns->product->name;
            })
            ->editColumn('status', function($sales_returns){
                $status_label = '';
                $status_action = '';
                if($sales_returns->status =='posted'){
                    $status_label = '<p>POSTED</p>';
                    $status_action .='<button type="button" class="btn btn-warning btn-xs btn-accept-sales-return" data-id="'.$sales_returns->id.'" title="Change status to Accept">';
                    $status_action .=    '<i class="fa fa-sign-in"></i>';
                    $status_action .='</button>';
                }
                else if($sales_returns->status =='accept'){
                    $status_label = '<p>SENT</p>';
                    $status_action .='<button type="button" class="btn btn-success btn-xs btn-resent-sales-return" data-id="'.$sales_returns->id.'" title="Change status to Resent">';
                    $status_action .=    '<i class="fa fa-check"></i>';
                    $status_action .='</button>';
                }
                else{
                    $status_label = '<p>RESENT</p>';
                }

                return $status_label.$status_action;
            })
            ->addColumn('actions', function($sales_returns){
                $actions_html ='<a href="'.url('sales-return/'.$sales_returns->id.'').'" class="btn btn-default btn-xs" title="Click to view the detail">';
                $actions_html .=    '<i class="fa fa-eye"></i>';
                $actions_html .='</a>&nbsp;';
                //only provide edit and delete button if the purchase return status is posted, otherwise DO NOT show them
                if($sales_returns->status == 'posted'){
                    $actions_html .='<a href="'.url('sales-return/'.$sales_returns->id.'/edit').'" class="btn btn-success btn-xs" title="Click to edit">';
                    $actions_html .=    '<i class="fa fa-edit"></i>';
                    $actions_html .='</a>&nbsp;';
                    $actions_html .='<button type="button" class="btn btn-danger btn-xs btn-delete-sales-return" data-id="'.$sales_returns->id.'" data-text="'.$sales_returns->code.'">';
                    $actions_html .=    '<i class="fa fa-trash"></i>';
                    $actions_html .='</button>';
                }

                return $actions_html;
            });
        return $data_sales_returns->make(true);
    }

    //get invoice terms list
    public function getInvoiceTerms(Request $request)
    {
       \DB::statement(\DB::raw('set @rownum=0'));
        $invoice_terms = InvoiceTerm::select([
            \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'id',
            'name',
            'day_many',
        ]);

        $data_invoice_terms = Datatables::of($invoice_terms)
            ->addColumn('actions', function($invoice_terms){
                    $actions_html ='<a href="'.url('invoice-term/'.$invoice_terms->id.'').'" class="btn btn-info btn-xs" title="Click to view the detail">';
                    $actions_html .=    '<i class="fa fa-external-link-square"></i>';
                    $actions_html .='</a>&nbsp;';
                    $actions_html .='<a href="'.url('invoice-term/'.$invoice_terms->id.'/edit').'" class="btn btn-success btn-xs" title="Click to edit this invoice-term">';
                    $actions_html .=    '<i class="fa fa-edit"></i>';
                    $actions_html .='</a>&nbsp;';
                    $actions_html .='<button type="button" class="btn btn-danger btn-xs btn-delete-invoice-term" data-id="'.$invoice_terms->id.'" data-text="'.$invoice_terms->name.'">';
                    $actions_html .=    '<i class="fa fa-trash"></i>';
                    $actions_html .='</button>';

                    return $actions_html;
            });

        if ($keyword = $request->get('search')['value']) {
            $data_invoice_terms->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $data_invoice_terms->make(true);
    }

    //Function to get driver list
    public function getDrivers(Request $request){
        \DB::statement(\DB::raw('set @rownum=0'));
        //\DB::table('suppliers')->orderBy('code','asc')->get();
        $drivers = Driver::select([
            \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'id',
            'code',
            'name',
            'contact_number',
        ]);

        $data_drivers = Datatables::of($drivers)
            ->addColumn('actions', function($drivers){
                    $actions_html ='<a href="'.url('driver/'.$drivers->id.'').'" class="btn btn-info btn-xs" title="Click to view the detail">';
                    $actions_html .=    '<i class="fa fa-external-link-square"></i>';
                    $actions_html .='</a>&nbsp;';
                    $actions_html .='<a href="'.url('driver/'.$drivers->id.'/edit').'" class="btn btn-success btn-xs" title="Click to edit this driver">';
                    $actions_html .=    '<i class="fa fa-edit"></i>';
                    $actions_html .='</a>&nbsp;';
                    $actions_html .='<button type="button" class="btn btn-danger btn-xs btn-delete-driver" data-id="'.$drivers->id.'" data-text="'.$drivers->name.'">';
                    $actions_html .=    '<i class="fa fa-trash"></i>';
                    $actions_html .='</button>';

                    return $actions_html;
            });

        if ($keyword = $request->get('search')['value']) {
            $data_drivers->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $data_drivers->make(true);

    }
    //ENDFunction to get driver list

    //Function to get driver list
    public function getStockBalances(Request $request){
        \DB::statement(\DB::raw('set @rownum=0'));
        $stock_balance = StockBalance::with('creator')->select(
            [
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'stock_balances.*',
            ]
        );


        $data_stock_balance = Datatables::of($stock_balance)
            ->addColumn('actions', function($stock_balance){
                    $actions_html ='<a href="'.url('stock_balance/'.$stock_balance->id.'').'" class="btn btn-info btn-xs" title="Click to view the detail">';
                    $actions_html .=    '<i class="fa fa-external-link-square"></i>';
                    $actions_html .='</a>&nbsp;';
                    $actions_html .='<a href="'.url('stock_balance/'.$stock_balance->id.'/edit').'" class="btn btn-success btn-xs" title="Click to edit this stock balance">';
                    $actions_html .=    '<i class="fa fa-edit"></i>';
                    $actions_html .='</a>&nbsp;';
                    $actions_html .='<button type="button" class="btn btn-danger btn-xs btn-delete-stock-balance" data-id="'.$stock_balance->id.'" data-text="'.$stock_balance->code.'">';
                    $actions_html .=    '<i class="fa fa-trash"></i>';
                    $actions_html .='</button>';

                    return $actions_html;
            })
            ->editColumn('creator', function($stock_balance){
                    return $stock_balance->creator->name;
            });

        if ($keyword = $request->get('search')['value']) {
            $data_stock_balance->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $data_stock_balance->make(true);

    }
    //ENDFunction to get stock balances list

    //function to get banks datatable
    public function getBanks(Request $request)
    {
        \DB::statement(\DB::raw('set @rownum=0'));
        $banks = Bank::select([
            \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'id',
            'code',
            'name',
            'account_name',
            'account_number',
            'value'
        ]);

        $data_banks = Datatables::of($banks)
            ->addColumn('actions', function($banks){
                    $actions_html ='<a href="'.url('bank/'.$banks->id.'').'" class="btn btn-info btn-xs" title="Click to view the detail">';
                    $actions_html .=    '<i class="fa fa-external-link-square"></i>';
                    $actions_html .='</a>&nbsp;';
                    $actions_html .='<a href="'.url('bank/'.$banks->id.'/edit').'" class="btn btn-success btn-xs" title="Click to edit this bank">';
                    $actions_html .=    '<i class="fa fa-edit"></i>';
                    $actions_html .='</a>&nbsp;';
                    $actions_html .='<button type="button" class="btn btn-danger btn-xs btn-delete-bank" data-id="'.$banks->id.'" data-text="'.$banks->name.'">';
                    $actions_html .=    '<i class="fa fa-trash"></i>';
                    $actions_html .='</button>';

                    return $actions_html;
            });

        if ($keyword = $request->get('search')['value']) {
            $data_banks->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $data_banks->make(true);
    }

    public function getCashs(Request $request)
    {
        \DB::statement(\DB::raw('set @rownum=0'));
        $cashs = Cash::select([
            \DB::raw('@rownum := @rownum + 1 AS rownum'),
            'id',
            'code',
            'name',
            'value',
        ]);

        $data_cashs = Datatables::of($cashs)
            ->addColumn('actions',function($cashs){
                $actions_html ='<a href="'.url('cash/'.$cashs->id.'').'" class="btn btn-info btn-xs" title="Click to view the detail">';
                $actions_html .=    '<i class="fa fa-external-link-square"></i>';
                $actions_html .='</a>&nbsp;';
                $actions_html .='<a href="'.url('cash/'.$cashs->id.'/edit').'" class="btn btn-success btn-xs" title="Click to edit this cash">';
                $actions_html .=    '<i class="fa fa-edit"></i>';
                $actions_html .='</a>&nbsp;';
                $actions_html .='<button type="button" class="btn btn-danger btn-xs btn-delete-cash" data-id="'.$cashs->id.'" data-text="'.$cashs->name.'">';
                $actions_html .=    '<i class="fa fa-trash"></i>';
                $actions_html .='</button>';

                return $actions_html;
            });

            if ($keyword = $request->get('search')['value']) {
                $data_cashs->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
            }

            return $data_cashs->make(true);
    }


    //Build users data
    public function getUsers(Request $request){

        \DB::statement(\DB::raw('set @rownum=0'));
        $users = User::with('roles')->select(
            [
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'users.*',
            ]
        );
        $datatables = Datatables::of($users)
            ->addColumn('role', function($users){
                return $users->roles->first()->name;
            })
            ->addColumn('actions', function($users){
                    $actions_html ='<a href="'.url('user/'.$users->id.'').'" class="btn btn-info btn-xs" title="Click to view the detail">';
                    $actions_html .=    '<i class="fa fa-external-link-square"></i>';
                    $actions_html .='</a>&nbsp;';
                    $actions_html .='<a href="'.url('user/'.$users->id.'/edit').'" class="btn btn-success btn-xs" title="Click to edit this user">';
                    $actions_html .=    '<i class="fa fa-edit"></i>';
                    $actions_html .='</a>&nbsp;';
                    $actions_html .='<button type="button" class="btn btn-danger btn-xs btn-delete-user" data-id="'.$users->id.'" data-text="'.$users->name.'">';
                    $actions_html .=    '<i class="fa fa-trash"></i>';
                    $actions_html .='</button>';

                    return $actions_html;
            });
        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $datatables->make(true);
    }

    //Build roles data
    public function getRoles(Request $request){

        \DB::statement(\DB::raw('set @rownum=0'));
        $roles = Role::select([
            \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
            'id',
            'name',
        ])->where('name','!=', 'Super Admin');
        $datatables = Datatables::of($roles)
            
            ->addColumn('actions', function($roles){
                    $actions_html ='<a href="'.url('role/'.$roles->id.'').'" class="btn btn-info btn-xs" title="Click to view the detail">';
                    $actions_html .=    '<i class="fa fa-external-link-square"></i>';
                    $actions_html .='</a>&nbsp;';
                    $actions_html .='<a href="'.url('role/'.$roles->id.'/edit').'" class="btn btn-success btn-xs" title="Click to edit this role">';
                    $actions_html .=    '<i class="fa fa-edit"></i>';
                    $actions_html .='</a>&nbsp;';
                    $actions_html .='<button type="button" class="btn btn-danger btn-xs btn-delete-role" data-id="'.$roles->id.'" data-text="'.$roles->name.'">';
                    $actions_html .=    '<i class="fa fa-trash"></i>';
                    $actions_html .='</button>';

                    return $actions_html;
            });
        if ($keyword = $request->get('search')['value']) {
            $datatables->filterColumn('rownum', 'whereRaw', '@rownum  + 1 like ?', ["%{$keyword}%"]);
        }

        return $datatables->make(true);
    }



}
