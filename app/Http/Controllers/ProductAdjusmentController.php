<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\SubChartAccount;
use App\Product;

class ProductAdjusmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //if(\Auth::user()->can('product-adjustment-module')){
            return view('adjustment.index');
        //}else{
            //return view('403');
        //}
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $adjust_account = SubChartAccount::all();
        $product = Product::all();
        return view('adjustment.create')
            ->with('adjust_account',$adjust_account)
            ->with('product',$product);
    }

    public function callFieldProduct(Request $request)
    {
        if($request->ajax()){
            $results = [];
            $product = \DB::table('products')->where('id',$request->product)->get();
            foreach ($product as $key) {
                array_push($results,[
                    'description'=>$key->description,
                ]);
            }
            return response()->json($results);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
