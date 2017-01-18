<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Http\Requests;
use App\Http\Requests\StoreInvoiceTermRequest;
use App\Http\Requests\UpdateInvoiceTermRequest;

use App\InvoiceTerm;

class InvoiceTermController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('invoice_term.index');
    }

    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('invoice_term.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInvoiceTermRequest $request)
    {
        $invoice_term = new InvoiceTerm;
        $invoice_term->name = $request->name;
        $invoice_term->day_many = $request->day_many;
        $invoice_term->save();
        return redirect('invoice-term')
            ->with('successMessage', "Invoice Term has been created");
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
        $invoice_term = InvoiceTerm::findOrFail($id);
        return view('invoice_term.edit')
            ->with('invoice_term', $invoice_term);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateInvoiceTermRequest $request, $id)
    {
        $invoice_term = InvoiceTerm::findOrFail($id);
        $invoice_term->name = $request->name;
        $invoice_term->day_many = $request->day_many;
        $invoice_term->save();
        return redirect('invoice-term/'.$id.'/edit')
            ->with('successMessage', "Invoice term has been updated");
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
