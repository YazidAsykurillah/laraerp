<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
//form request
use App\Http\Requests\StorePurchaseOrderInvoiceRequest;
use App\Http\Requests\UpdatePurchaseOrderInvoiceRequest;


use App\PurchaseOrderInvoice;
use App\PurchaseOrder;


class PurchaseOrderInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('purchase_order.list_invoice');
    }

    protected function count_total_price($purchase_order)
    {
        $sum_price = \DB::table('product_purchase_order')
                    ->where('purchase_order_id', $purchase_order->id)
                    ->sum('price');
        return $sum_price;
    }

    public function create(Request $request)
    {
        
        $purchase_order = PurchaseOrder::findOrFail($request->purchase_order_id);
        return view('purchase_order.create_invoice')
            ->with('total_price', $this->count_total_price($purchase_order))
            ->with('purchase_order', $purchase_order);

    }

    public function store(StorePurchaseOrderInvoiceRequest $request)
    {
        if($request->ajax()){

            $data = [
                'code'=>$request->code,
                'purchase_order_id' =>$request->purchase_order_id,
                'bill_price'=>floatval(preg_replace('#[^0-9.]#', '', $request->bill_price)),
                'paid_price'=>floatval(preg_replace('#[^0-9.]#', '', $request->paid_price)),
                'created_by'=>\Auth::user()->id
            ];

            $save = PurchaseOrderInvoice::create($data);
            $response = [
                'msg'=>'storePurchaseOrderInvoiceOk',
                'purchase_order_id'=>$request->purchase_order_id
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
        $purchase_order_invoice = PurchaseOrderInvoice::findOrFail($id);
        $purchase_order = PurchaseOrder::where('id','=',$purchase_order_invoice->purchase_order_id)->first();
        $total_price = $this->count_total_price($purchase_order);
        return view('purchase_order.show_invoice')
            ->with('purchase_order_invoice', $purchase_order_invoice)
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
        $purchase_order_invoice = PurchaseOrderInvoice::findOrFail($id);
        return view('purchase_order.edit_invoice')
            ->with('purchase_order_invoice', $purchase_order_invoice);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePurchaseOrderInvoiceRequest $request, $id)
    {
        $purchase_order_invoice = PurchaseOrderInvoice::findOrFail($request->purchase_order_invoice_id);
        $purchase_order_invoice->code = $request->code;
        $purchase_order_invoice->bill_price = floatval(preg_replace('#[^0-9.]#', '', $request->bill_price));
        $purchase_order_invoice->paid_price = floatval(preg_replace('#[^0-9.]#', '', $request->paid_price));
        $purchase_order_invoice->save();
        return redirect('purchase-order-invoice/'.$request->purchase_order_invoice_id)
            ->with('successMessage', "Invoice has been updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $purch_order_inv = PurchaseOrderInvoice::findOrFail($request->purchase_order_invoice_id);
        $delete = $purch_order_inv->delete();
        return redirect('purchase-order-invoice')
        ->with('successMessage', 'Invoice has been deleted');
    }
}
