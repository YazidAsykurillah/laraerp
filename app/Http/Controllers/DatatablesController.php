<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Yajra\Datatables\Datatables;

use App\Product;
use App\Supplier;
use App\PurchaseOrder;
use App\PurchaseOrderInvoice;

class DatatablesController extends Controller
{



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
            ->editColumn('stock', function($products){
                $minimum_stock = $products->minimum_stock;
                $stock_html = '';
                if($products->stock == '0'){
                    $stock_html = '<text class="text text-danger">0</text>';
                }
                else if($products->stock == $minimum_stock){
                    $stock_html = '<text class="text text-warning">'.$products->stock.'</text>';
                }
                else if($products->stock < $minimum_stock){
                    $stock_html = '<text class="text text-warning">'.$products->stock.'</text>';
                }
                else{
                    $stock_html = '<text class="text text-info">'.$products->stock.'</text>';
                }

                return $stock_html;
                
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


    //Function to get supplier lis
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
        $purchase_orders = PurchaseOrder::with('supplier', 'created_by')->select(
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
                return ucwords($purchase_orders->status);
            })
            ->addColumn('actions', function($purchase_orders){
                $actions_html ='<a href="'.url('purchase-order/'.$purchase_orders->id.'').'" class="btn btn-info btn-xs" title="Click to view the detail">';
                $actions_html .=    '<i class="fa fa-external-link-square"></i>';
                $actions_html .='</a>&nbsp;';
                $actions_html .='<a href="'.url('purchase-order/'.$purchase_orders->id.'/edit').'" class="btn btn-success btn-xs" title="Click to edit">';
                $actions_html .=    '<i class="fa fa-edit"></i>';
                $actions_html .='</a>&nbsp;';
                $actions_html .='<button type="button" class="btn btn-danger btn-xs btn-delete-purchase-order" data-id="'.$purchase_orders->id.'" data-text="'.$purchase_orders->code.'">';
                $actions_html .=    '<i class="fa fa-trash"></i>';
                $actions_html .='</button>';
                
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
        $purchase_order_invoices = PurchaseOrderInvoice::with('purchase_order','creator')->select(
            [
                \DB::raw('@rownum  := @rownum  + 1 AS rownum'),
                'purchase_order_invoices.*',
            ]
        );
        $data_purchase_order_invoices = Datatables::of($purchase_order_invoices)
            ->editColumn('purchase_order_id', function($purchase_order_invoices){
                return $purchase_order_invoices->purchase_order->code;
            })
            ->editColumn('bill_price', function($purchase_order_invoices){
                return number_format($purchase_order_invoices->bill_price);
            })
            ->editColumn('paid_price', function($purchase_order_invoices){
                return number_format($purchase_order_invoices->paid_price);
            })
            ->editColumn('creator', function($purchase_order_invoices){

                return $purchase_order_invoices->creator->name;
            })
            ->addColumn('actions', function($purchase_order_invoices){
                $actions_html ='<a href="'.url('purchase-order-invoice/'.$purchase_order_invoices->id.'').'" class="btn btn-info btn-xs" title="Click to view the detail">';
                $actions_html .=    '<i class="fa fa-external-link-square"></i>';
                $actions_html .='</a>&nbsp;';
                $actions_html .='<a href="'.url('purchase-order-invoice/'.$purchase_order_invoices->id.'/edit').'" class="btn btn-success btn-xs" title="Click to edit">';
                $actions_html .=    '<i class="fa fa-edit"></i>';
                $actions_html .='</a>&nbsp;';
                $actions_html .='<button type="button" class="btn btn-danger btn-xs btn-delete-purchase-order-invoice" data-id="'.$purchase_order_invoices->id.'" data-text="'.$purchase_order_invoices->code.'">';
                $actions_html .=    '<i class="fa fa-trash"></i>';
                $actions_html .='</button>';
                
                return $actions_html;
            });
        return $data_purchase_order_invoices->make(true);
    }
    //ENDFunction get Purchase Order Invoice
    

}
