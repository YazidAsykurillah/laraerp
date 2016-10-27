<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Requests\StorePurchaseOrderRequest;

use App\PurchaseOrder;
use App\Supplier;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('purchase_order.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $supplier_options = Supplier::lists('name', 'id');
        return view('purchase_order.create')
            ->with('supplier_options', $supplier_options);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePurchaseOrderRequest $request)
    {
        if($request->ajax()){

            $max_po_id = \DB::table('purchase_orders')->max('id');
            $next_po_id = $max_po_id+1;
            $code = 'PO-'.$next_po_id;

            $data = [
                'code'=>$code,
                'supplier_id'=>$request->supplier_id,
                'notes'=>$request->notes,
                'creator'=>\Auth::user()->id
            ];

            $save = PurchaseOrder::create($data);
            $purchase_order_id = $save->id;

            $purchase_order = PurchaseOrder::find($purchase_order_id);

            //Build sync data to store the relation w/ products
            $syncData = [];
            foreach($request->product_id as $key=>$value){
                   $syncData[$value] = ['quantity'=> $request->quantity[$key], 'price'=>$request->price[$key]];
            }
            //sync the products
            $purchase_order->products()->sync($syncData);

            $response = [
                'msg'=>'storePurchaseOrderOk',
                'purchase_order_id'=>$purchase_order_id
            ];
            return response()->json($response);
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
}
