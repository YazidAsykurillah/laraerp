<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\StoreSalesInvoicePaymentRequest;
use App\Http\Requests\StoreSalesPaymentCash;
use App\Http\Requests\StoreSalesPaymentTransfer;
//Carbon package
Use Carbon\Carbon;

use App\SalesOrderInvoice;
use App\SalesOrder;
use App\PaymentMethod;
use App\SalesInvoicePayment;
use App\Bank;
use App\BankSalesInvoicePayment;
use DB;

class SalesOrderInvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('sales_order.list_invoice');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $sales_order = SalesOrder::findOrFail($request->sales_order_id);
        return view('sales_order.create_invoice')
            ->with('total_price', $this->count_total_price($sales_order))
            ->with('sales_order', $sales_order);
    }

    protected function count_total_price($sales_order)
    {
        $sum_price = \DB::table('product_sales_order')
                    ->where('sales_order_id', $sales_order->id)
                    ->sum('price');
        return $sum_price;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       if($request->ajax()){
            $sales_order_id = $request->sales_order_id;
            $sales_order_code = SalesOrder::findOrFail($sales_order_id)->code;
            $customer_invoice_term = SalesOrder::findOrFail($sales_order_id)->customer->invoice_term->day_many;


            $current = Carbon::now();
            $due_date = $current->addDays($customer_invoice_term);
            $data = [
                'code'=>'INV-'.$sales_order_code,
                'sales_order_id' =>$request->sales_order_id,
                'bill_price'=>floatval(preg_replace('#[^0-9.]#', '', $request->bill_price)),
                'notes'=>$request->notes,
                'created_by'=>\Auth::user()->id,
                'due_date'=> $due_date
            ];

            $save = SalesOrderInvoice::create($data);
            //get last inserted id of sales_order_invoice
            $sales_order_invoice_id = $save->id;
            if($save){

                //find sales_order model
                $sales_order = SalesOrder::findOrFail($request->sales_order_id);
                //Build sync data to update SalesOrder relation w/ products
                $syncData = [];
                foreach($request->product_id as $key=>$value){
                    $syncData[$value] = [
                        'quantity'=> $request->quantity[$key],
                        'price'=>floatval(preg_replace('#[^0-9.]#', '', $request->price[$key])),
                        'price_per_unit'=>floatval(preg_replace('#[^0-9.]#', '', $request->price_per_unit[$key]))
                    ];
                }
                //First, delete all the relation column for product and sales order on table prouduct_sales_order before syncing
                \DB::table('product_sales_order')->where('sales_order_id','=',$sales_order->id)->delete();
                //Now time to sync the products
                $sales_order->products()->sync($syncData);
            }

            $response = [
                'msg'=>'storeSalesOrderInvoiceOk',
                'sales_order_id'=>$request->sales_order_id
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
        $sales_order_invoice = SalesOrderInvoice::findOrFail($id);
        $sales_order = SalesOrder::findOrFail($sales_order_invoice->sales_order->id);
        return view('sales_order.show_invoice')
            ->with('sales_order_invoice', $sales_order_invoice)
            ->with('sales_order', $sales_order);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sales_order_invoice = SalesOrderInvoice::findOrFail($id);
        $sales_order = SalesOrder::findOrFail($sales_order_invoice->sales_order->id);
        return view('sales_order.edit_invoice')
                ->with('sales_order_invoice',$sales_order_invoice)
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
        $sales_order_invoice = SalesOrderInvoice::findOrFail($request->sales_order_invoice_id);
        $sales_order_invoice->code = $request->code;
        $sales_order_invoice->bill_price = floatval(preg_replace('#[^0-9.]#','',$request->bill_price));
        $sales_order_invoice->notes = $request->notes;
        $sales_order_invoice->save();
        //UPDATE SUCCESS


        //find sales order model
        $sales_order = SalesOrder::findOrFail($request->sales_order_id);
        //build sync data to update PO relative w/products
        $syncData = [];
        foreach ($request->product_id as $key => $value) {
            $syncData[$value] = ['quantity'=>$request->quantity[$key], 'price'=>floatval(preg_replace('#[^0-9.]#','',$request->price[$key]))];
        }
        //first, delete all the relation column between product and sales order on table product sales order before syncing
        \DB::table('product_sales_order')->where('sales_order_id','=',$sales_order->id)->delete();
        //now time to sync the product
        $sales_order->products()->sync($syncData);
        return redirect('sales-order-invoice')
            ->with('successMessage','has been update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = SalesOrderInvoice::findOrFail($request->sales_order_invoice_id);
        $id->delete();
        //\DB::table('sales_order_invoices')->where('id', $id)->delete();
        return redirect('sales-order-invoice')
            ->with('successMessage','Invoice has been deleted');
    }

    //change status invoice to "Completed"
    public function completeSalesInvoice(Request $request)
    {
        $invoice = SalesOrderInvoice::findOrFail($request->sales_order_invoice_id);
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
        $invoice = SalesOrderInvoice::findOrFail($invoice_id);
        $payment_methods = PaymentMethod::lists('name', 'id');
        $banks = Bank::lists('name','id');
        return view('sales_order.create_payment')
            ->with('payment_methods', $payment_methods)
            ->with('invoice', $invoice)
            ->with('banks',$banks);
    }

    public function storePaymentCash(StoreSalesPaymentCash $request)
    {
        $invoice_id = $request->sales_order_invoice_id;
        $amount = floatval(preg_replace('#[^0-9.]#', '', $request->amount));

        $sales_order_invoice = SalesOrderInvoice::findOrFail($invoice_id);
        //get current paid_price of the invoice
        $current_paid_price = $sales_order_invoice->paid_price;
        //build new paid_price to be updated
        $new_paid_price = $current_paid_price+$amount;

        $sales_order_id = $sales_order_invoice->sales_order->id;

        $sales_invoice_payment = new SalesInvoicePayment;
        $sales_invoice_payment->sales_order_invoice_id = $invoice_id;
        $sales_invoice_payment->amount = floatval(preg_replace('#[^0-9.]#', '', $amount));
        $sales_invoice_payment->payment_method_id = $request->payment_method_id;
        $sales_invoice_payment->receiver = \Auth::user()->id;
        $save = $sales_invoice_payment->save();
        if($save){
            //update invoice's paid_price
            $sales_order_invoice->paid_price = $new_paid_price;
            $update_paid_price = $sales_order_invoice->save();

            return redirect('sales-order/'.$sales_order_id)
            ->with('successMessage', 'Payment has been added');
        }
        else{
            return "Failed to save invoice payment, contact the developer";
        }
    }

    public function storePaymentTransfer(StoreSalesPaymentTransfer $request)
    {
        $invoice_id = $request->sales_order_invoice_id;
        $bank_id = $request->bank_id;
        $amount = floatval(preg_replace('#[^0-9.]#','',$request->amount));
        $sales_order_invoice = SalesOrderInvoice::findOrFail($invoice_id);
        $current_paid_price = $sales_order_invoice->paid_price;
        $new_paid_price = $current_paid_price+$amount;
        $sales_order_id = $sales_order_invoice->sales_order->id;

        $sales_invoice_payment = new SalesInvoicePayment;
        $sales_invoice_payment->sales_order_invoice_id = $invoice_id;
        $sales_invoice_payment->amount = floatval(preg_replace('#[^0-9.]#','',$amount));
        $sales_invoice_payment->payment_method_id = $request->payment_method_id;
        $sales_invoice_payment->receiver = \Auth::user()->id;
        $save = $sales_invoice_payment->save();

        $bank_sales_invoice_payment = new BankSalesInvoicePayment;
        $bank_sales_invoice_payment->bank_id = $bank_id;
        $bank_sales_invoice_payment->sales_invoice_payment_id = $sales_invoice_payment->id;
        $bank_sales_invoice_payment->save();
        if($save){
            //update invoice's paid price
            $sales_order_invoice->paid_price = $new_paid_price;
            $update_paid_price = $sales_order_invoice->save();

            return redirect('sales-order/'.$sales_order_id)
                            ->with('successMessage','Payment has been adde');
        }else{
            return "Failde to save invoice payment, contact the developer";
        }
    }

}
