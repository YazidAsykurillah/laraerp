<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Requests\StorePurchaseOrderRequest;
use App\Http\Requests\UpdatePurchaseOrderRequest;

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
                $syncData[$value] = ['quantity'=> $request->quantity[$key], 'price'=>floatval(preg_replace('#[^0-9.]#', '', $request->price[$key]))];
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
    protected function count_total_price($purchase_order)
    {
        $sum_price = \DB::table('product_purchase_order')
                    ->where('purchase_order_id', $purchase_order->id)
                    ->sum('price');
        return $sum_price;
    }
    public function show($id)
    {
        $purchase_order = PurchaseOrder::findOrFail($id);
        $total_price = $this->count_total_price($purchase_order);
        return view('purchase_order.show')
            ->with('purchase_order', $purchase_order)
            ->with('total_price', $total_price);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $purchase_order = PurchaseOrder::findOrFail($id);
        $supplier_options = Supplier::lists('name', 'id');
        $total_price = $this->count_total_price($purchase_order);
        return view('purchase_order.edit')
            ->with('purchase_order', $purchase_order)
            ->with('total_price', $total_price)
            ->with('supplier_options', $supplier_options);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePurchaseOrderRequest $request)
    {
        if($request->ajax()){
            
            $id = $request->id;
            $purchase_order = PurchaseOrder::findOrFail($id);
            $purchase_order->supplier_id = $request->supplier_id;
            $purchase_order->notes = $request->notes;
            $update = $purchase_order->save();

            //Build sync data to update PO relation w/ products
            $syncData = [];
            foreach($request->product_id as $key=>$value){
                $syncData[$value] = ['quantity'=> $request->quantity[$key], 'price'=>floatval(preg_replace('#[^0-9.]#', '', $request->price[$key]))];
            }

            //sync the products
            $purchase_order->products()->syncWithoutDetaching($syncData);

            $response = [
                'msg'=>'updatePurchaseOrderOk',
                'purchase_order_id'=>$id
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
    public function destroy($id)
    {
        //
    }
}
