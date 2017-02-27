<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
//form request
use App\Http\Requests\StorePurchaseOrderInvoiceRequest;
use App\Http\Requests\UpdatePurchaseOrderInvoiceRequest;
use App\Http\Requests\StorePurchasePaymentCash;
use App\Http\Requests\StorePurchasePaymentTransfer;


use App\PurchaseOrderInvoice;
use App\PurchaseOrder;
use App\PaymentMethod;
use App\PurchaseInvoicePayment;
use App\Bank;
use App\Cash;
use App\BankPurchaseInvoicePayment;
use App\CashPurchaseInvoicePayment;
use DB;

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
        $payment_methods = PaymentMethod::lists('name', 'id');
        return view('purchase_order.create_invoice')
            ->with('total_price', $this->count_total_price($purchase_order))
            ->with('purchase_order', $purchase_order)
            ->with('payment_methods', $payment_methods);
    }

    public function store(StorePurchaseOrderInvoiceRequest $request)
    {
        if($request->ajax()){

            $data = [
                'code'=>$request->code,
                'purchase_order_id' =>$request->purchase_order_id,
                'bill_price'=>floatval(preg_replace('#[^0-9.]#', '', $request->bill_price)),
                //'payment_method_id'=>$request->payment_method_id,
                // 'paid_price'=>floatval(preg_replace('#[^0-9.]#', '', $request->paid_price)),
                'notes'=>$request->notes,
                'created_by'=>\Auth::user()->id
            ];

            $save = PurchaseOrderInvoice::create($data);
            if($save){
                //find purchase_order model
                $purchase_order = PurchaseOrder::findOrFail($request->purchase_order_id);
                //Build sync data to update PO relation w/ products
                $syncData = [];
                foreach($request->product_id as $key=>$value){
                    $syncData[$value] = ['quantity'=> $request->quantity[$key], 'price'=>floatval(preg_replace('#[^0-9.]#', '', $request->price[$key]))];
                }
                //First, delete all the relation cloumn between product and purchase order on table prouduct_purchase_order before syncing
                \DB::table('product_purchase_order')->where('purchase_order_id','=',$purchase_order->id)->delete();
                //Now time to sync the products
                $purchase_order->products()->sync($syncData);
            }

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
        $purchase_order = PurchaseOrder::findOrFail($purchase_order_invoice->purchase_order->id);
        return view('purchase_order.show_invoice')
            ->with('purchase_order_invoice', $purchase_order_invoice)
            ->with('purchase_order', $purchase_order);
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
        $purchase_order = PurchaseOrder::findOrFail($purchase_order_invoice->purchase_order->id);
        return view('purchase_order.edit_invoice')
            ->with('purchase_order_invoice', $purchase_order_invoice)
            ->with('purchase_order', $purchase_order);
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
        $purchase_order_invoice = PurchaseOrderInvoice::findOrFail($request->purchase_order_invoice_id);
        $purchase_order_invoice->code = $request->code;
        $purchase_order_invoice->bill_price = floatval(preg_replace('#[^0-9.]#', '', $request->bill_price));
        $purchase_order_invoice->notes = $request->notes;
        $purchase_order_invoice->save();

        // //find purchase_order model
        $purchase_order = PurchaseOrder::findOrFail($request->purchase_order_id);
        //Build sync data to update PO relation w/ products
        $syncData = [];
        foreach($request->product_id as $key=>$value){
            $syncData[$value] = ['quantity'=> $request->quantity[$key], 'price'=>floatval(preg_replace('#[^0-9.]#', '', $request->price[$key]))];
        }
        //First, delete all the relation cloumn between product and purchase order on table prouduct_purchase_order before syncing
        \DB::table('product_purchase_order')->where('purchase_order_id','=',$purchase_order->id)->delete();
        //Now time to sync the products
        $purchase_order->products()->sync($syncData);

        return redirect('purchase-order-invoice')
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
        $purch_order_inv->delete();

        if($purch_order_inv->purchase_invoice_payment->count()){
            //delete bank purchase invoice payment
            $bank = $purch_order_inv->purchase_invoice_payment;
            foreach ($bank as $key) {
                \DB::table('bank_purchase_invoice_payment')->where('purchase_invoice_payment_id','=',$key->id)->delete();
            }
            //delete cash purchase invoice payment
            $cash = $purch_order_inv->purchase_invoice_payment;
            foreach ($cash as $key) {
                \DB::table('cash_purchase_invoice_payment')->where('purchase_invoice_payment_id','=',$key->id)->delete();
            }
        }

        //delete purchase invoice payment
        \DB::table('purchase_invoice_payments')->where('purchase_order_invoice_id','=',$request->purchase_order_invoice_id)->delete();

        return redirect('purchase-order-invoice')
        ->with('successMessage', 'Invoice has been deleted');
    }

    public function completePurchaseInvoice(Request $request)
    {
        $invoice = PurchaseOrderInvoice::findOrFail($request->purchase_order_invoice_id);
        //check the bill and the paid price
        $bill_price = $invoice->bill_price;
        $paid_price = $invoice->paid_price;

        if($paid_price < $bill_price)
        {
            return redirect()->back()
                ->with('errorMessage', "Invoice can not be completed, Paid price is less than the Bill price");
        }
        else{
            $invoice->status = 'completed';
            $invoice->save();
             return redirect()->back()
             ->with('successMessage', "Invoice has been completed");
        }

    }


    public function createPayment(Request $request)
    {
        $invoice_id = $request->invoice_id;
        $invoice = PurchaseOrderInvoice::findOrFail($invoice_id);
        $payment_methods = PaymentMethod::lists('name','id');
        $banks = Bank::lists('name', 'id');
        $cashs = Cash::lists('name','id');
        return view('purchase_order.create_payment')
                    ->with('invoice',$invoice)
                    ->with('payment_method',$payment_methods)
                    ->with('banks',$banks)
                    ->with('cashs',$cashs);

    }

    public function storePaymentCash(StorePurchasePaymentCash $request)
    {
        $invoice_id = $request->purchase_order_invoice_id;
        $cash_id = $request->cash_id;
        // $payment_method_id = $request->payment_method_id;
        $amount = floatval(preg_replace('#[^0-9.]#', '', $request->amount));

        $purchase_order_invoice = PurchaseOrderInvoice::findOrFail($invoice_id);
        //get current paid_price of the invoice
        $current_paid_price = $purchase_order_invoice->paid_price;
        //build new paid_price to be updated
        $new_paid_price = $current_paid_price+$amount;

        $purchase_order_id = $purchase_order_invoice->purchase_order->id;

        $purchase_invoice_payment = new PurchaseInvoicePayment;
        $purchase_invoice_payment->purchase_order_invoice_id = $invoice_id;
        $purchase_invoice_payment->amount = floatval(preg_replace('#[^0-9.]#', '', $amount));
        $purchase_invoice_payment->payment_method_id = $request->payment_method_id;
        $purchase_invoice_payment->receiver = \Auth::user()->id;
        $save = $purchase_invoice_payment->save();

        $cash_purchase_invoice_payment = new CashPurchaseInvoicePayment;
        $cash_purchase_invoice_payment->cash_id = $cash_id;
        $cash_purchase_invoice_payment->purchase_invoice_payment_id = $purchase_invoice_payment->id;
        $cash_purchase_invoice_payment->save();

        $cash_value = Cash::findOrFail($cash_id);
        $current_cash_value = $cash_value->value;
        $new_cash_value = $current_cash_value-$amount;
        if($save){
            //update invoice's paid_price
            $purchase_order_invoice->paid_price = $new_paid_price;
            $cash_value->value = $new_cash_value;
            $update_paid_price = $purchase_order_invoice->save();
            $update_cash_value = $cash_value->save();

            return redirect('purchase-order/'.$purchase_order_id)
            ->with('successMessage', 'Payment has been added');
        }
        else{
            return "Failed to save invoice payment, contact the developer";
        }
    }


    public function storePaymentTransfer(StorePurchasePaymentTransfer $request)
    {
        $invoice_id = $request->purchase_order_invoice_id;
        $bank_id = $request->bank_id;
        $amount = floatval(preg_replace('#[^0-9.]#', '', $request->amount));
        $purchase_order_invoice = PurchaseOrderInvoice::findOrFail($invoice_id);
        $current_paid_price = $purchase_order_invoice->paid_price;
        $new_paid_price = $current_paid_price+$amount;
        $purchase_order_id = $purchase_order_invoice->purchase_order->id;

        $purchase_invoice_payment = new PurchaseInvoicePayment;
        $purchase_invoice_payment->purchase_order_invoice_id = $invoice_id;
        $purchase_invoice_payment->amount = floatval(preg_replace('#[^0-9.]#','',$amount));
        $purchase_invoice_payment->payment_method_id = $request->payment_method_id;
        $purchase_invoice_payment->receiver = \Auth::user()->id;
        $save = $purchase_invoice_payment->save();

        $bank_purchase_invoice_payment = new BankPurchaseInvoicePayment;
        $bank_purchase_invoice_payment->bank_id = $bank_id;
        $bank_purchase_invoice_payment->purchase_invoice_payment_id = $purchase_invoice_payment->id;
        $bank_purchase_invoice_payment->save();

        $bank_value = Bank::findOrFail($bank_id);
        $current_bank_value = $bank_value->value;
        $new_bank_value = $current_bank_value-$amount;
        if($save){
            //update invoice's paid_price
            $purchase_order_invoice->paid_price = $new_paid_price;
            $bank_value->value = $new_bank_value;
            $update_paid_price = $purchase_order_invoice->save();
            $update_bank_value = $bank_value->save();

            return redirect('purchase-order/'.$purchase_order_id)
                ->with('successMessage','Payment has been added');
        }else{
            return "Failed to save invoice payment, contact the developer";
        }
    }
}
