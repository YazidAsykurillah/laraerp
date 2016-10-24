<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Yajra\Datatables\Datatables;

use App\Product;
use App\Supplier;
use App\PurchaseOrder;

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
                $code_html  ='<a href="'.url('product/'.$products->id).'" class="btn btn-link btn-xs" title="Click to see the detail">';
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
    

}
