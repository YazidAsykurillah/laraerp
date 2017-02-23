<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

// use Modal
use App\SalesOrder;
use App\SalesReturn;
use App\Product;

class SalesReturnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('sales_return.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $sales_order = SalesOrder::findOrFail($request->sales_order_id);
        return view('sales_return.create')
            ->with('sales_order', $sales_order);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // var_dump($request->product_id);
        // exit();
        if($request->ajax()){
            foreach ($request->product_id as $key => $value) {
                $sales_return = new SalesReturn;
                $sales_return->sales_order_id = $request->sales_order_id;
                $sales_return->product_id = $request->product_id[$key];
                $sales_return->quantity = $request->returned_quantity[$key];
                $sales_return->notes = $request->notes[$key];
                $sales_return->created_by = \Auth::user()->id;
                $sales_return->save();
            }
            return response("storeSalesReturnOk");
        }else{
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
        $sales_return = SalesReturn::findOrFail($id);
        return view('sales_return.show')
                ->with('sales_return', $sales_return);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sales_return = SalesReturn::findOrFail($id);
        $sales_order = SalesOrder::findOrFail($sales_return->sales_order->id);
        return view('sales_return.edit')
            ->with('sales_return',$sales_return)
            ->with('sales_order',$sales_order);
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

    public function changeToAccept(request $request)
    {
        //initiate sales return and product models
        $sales_return = SalesReturn::findOrFail($request->id_to_be_accept);
        $product = Product::findOrFail($sales_return->product_id);

        //get product name and sales order code refference
        $product_name = $sales_return->product->name;
        $sales_order_ref = $sales_return->sales_order->code;

        //get the current product stok
        $current_stock = $product->stock;

        //product quantity to be returned
        $qty_to_return = $sales_return->quantity;

        //compare to product quantities to return and current product stock
        //if current product stock is lower than quantities to be returned,  then throw an error
        if($qty_to_return > $current_stock){
            return redirect('sales-return')
                    ->with('errorMessage',"Returned product quantity is higher than product stock, it is must be an error, please fix your sales return");
        }else{
            //update product stock by subtracting curent product stock by product quantity to returned
            $product->stock = $current_stock+$qty_to_return;
            $product->save();

            //change sales return to sent
            $sales_return->status = "accept";
            $sales_return->save();
            return redirect('sales-return')
                    ->with('successMessage',"$product_name on $sales_order_ref has been returned to the supplier");
        }
    }

    public function changeToResent(Request $request)
    {
        $sales_return = SalesReturn::findOrFail($request->id_to_be_resent);
        //get product name and sales order code refference
        $product_id = $sales_return->product_id;
        $quantity = $sales_return->quantity;
        $product_name = $sales_return->product->name;
        $sales_order_ref = $sales_return->sales_order->code;
        $sales_return->status = "resent";
        $sales_return->save();

        //now re add the quantity that returned to the stock
        $product = Product::findOrFail($product_id);
        $current_stock = $product->stock;
        $new_stock = $current_stock-$quantity;
        $product->stock = $new_stock;
        $product->save();
        return redirect('sales-return')
                ->with('successMessage',"$product_name has been added back to inventory from $sales_order_ref");
    }
}
