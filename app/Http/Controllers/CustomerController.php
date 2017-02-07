<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;

use App\Customer;
use App\InvoiceTerm;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('customer.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $invoice_terms = InvoiceTerm::lists('name', 'id');
        return view('customer.create')
        ->with('invoice_terms', $invoice_terms);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCustomerRequest $request)
    {
        $customer = new Customer;
        $customer->name = preg_replace('/\s+/',' ',$request->name);
        $customer->phone_number = preg_replace('/\s+/','',$request->phone_number);
        $customer->address = preg_replace('/\s+/',' ',$request->address);
        $customer->invoice_term_id = preg_replace('/\s+/',' ',$request->invoice_term_id);
        $customer->save();
        //now update customer's code
        $customer_id = $customer->id;
        $customer_code = \DB::table('customers')->where('id',$customer_id)->update(['code'=>'CST-'.$customer_id]);
        return redirect('customer')
            ->with('successMessage', "Customer has been added");


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
        $invoice_terms = InvoiceTerm::lists('name', 'id');
        $customer = Customer::findOrFail($id);
        return view('customer.edit')
        ->with('invoice_terms', $invoice_terms)
        ->with('customer', $customer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCustomerRequest $request, $id)
    {
        $customer = Customer::findOrFail($id);
        $customer->name = preg_replace('/\s+/',' ',$request->name);
        $customer->phone_number = preg_replace('/\s+/','',$request->phone_number);
        $customer->address = preg_replace('/\s+/',' ',$request->address);
        $customer->invoice_term_id = preg_replace('/\s+/',' ',$request->invoice_term_id);
        $customer->save();
        return redirect('customer/'.$id.'/edit')
            ->with('successMessage', 'Customer has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $customer = Customer::findOrFail($request->customer_id);
        $customer->delete();
        return redirect('customer')
            ->with('successMessage', 'Customer has been succesfuly deleted');
    }
}
