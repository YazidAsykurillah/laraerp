<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

//Form requests
use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;

use App\Supplier;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('supplier.index');
    }

    
    public function create()
    {
        return view('supplier.create');
    }

    
    public function store(StoreSupplierRequest $request)
    {
        $supplier = new Supplier;
        $supplier->code = $request->code;
        $supplier->name = $request->name;
        $supplier->address = $request->address;
        $supplier->pic_name = $request->pic_name;
        $supplier->primary_email = $request->primary_email;
        $supplier->primary_phone_number = $request->primary_phone_number;
        $supplier->save();
        return redirect('supplier');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $supplier = Supplier::findOrFail($id);
        return view('supplier.show')
            ->with('supplier', $supplier);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);
        return view('supplier.edit')
            ->with('supplier', $supplier);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSupplierRequest $request, $id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->code = $request->code;
        $supplier->name = $request->name;
        $supplier->address = $request->address;
        $supplier->pic_name = $request->pic_name;
        $supplier->primary_email = $request->primary_email;
        $supplier->primary_phone_number = $request->primary_phone_number;
        $supplier->save();
        return redirect('supplier')
            ->with('successMessage', "$supplier->name has been updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $supplier = Supplier::findOrFail($request->supplier_id);
        $supplier->delete();
        return redirect('supplier')
            ->with('successMessage', "$supplier->name has been deleted");
    }
}
