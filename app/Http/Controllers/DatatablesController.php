<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Yajra\Datatables\Datatables;

use App\Product;

class DatatablesController extends Controller
{
    protected function get_number($products){
        
    }
    public function getProducts(){
    	$products = Product::all();
    	return Datatables::of($products)
    		->addColumn('#', function($products){
              return '#';
    		})
    		->editColumn('code', function($products){
    			$code_html  ='<a href="'.url('product/'.$products->id).'" class="btn btn-link btn-xs" title="Click to see the detail">';
    			$code_html .=	'<i class="fa fa-link">&nbsp;'.$products->code.'</i>';
    			$code_html .='</a>&nbsp;';
    			return $code_html;
    		})
    		->editColumn('category_id', function($products){
            	return $products->category->name;
        	})
            ->editColumn('unit_id', function($products){
                return $products->unit->name;
            })
    		->addColumn('actions', function($products){
    			$actions_html  ='<a href="'.url('product/'.$products->id.'/edit').'" class="btn btn-info btn-xs" title="Klik untuk mengedit produk ini">';
    			$actions_html .=	'<i class="fa fa-edit"></i>';
    			$actions_html .='</a>&nbsp;';
    			$actions_html .='<button type="button" class="btn btn-danger btn-xs btn-delete-product" data-id="'.$products->id.'" data-text="'.$products->name.'">';
    			$actions_html .=	'<i class="fa fa-trash"></i>';
    			$actions_html .='</button>';
    			return $actions_html;
    		})
    		->make(true);
    }
}
