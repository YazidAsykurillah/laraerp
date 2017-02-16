<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\StockBalance;

use App\Product;

class StockBalanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('stock_balance.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = Product::get();
        return view('stock_balance.create')->with('dataList',$data);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = array(
            'code' => $request->code,
            'created_by' => \Auth::user()->id
        );
        $save = StockBalance::create($data);

        $stock_balance_id = $save->id;

        $stock_balance = StockBalance::find($stock_balance_id);

        //Build sync data to store the relation w/ products
        $syncData = [];
        foreach($request->product_id as $key=>$value){
            //$syncData[$value] = ['quantity'=> $request->quantity[$key], 'price'=>floatval(preg_replace('#[^0-9.]#', '', $request->price[$key]))];
            $syncData[$value] = [
                                'system_stock'=> $request->system_stock[$key],
                                'real_stock' => $request->real_stock[$key]
                                ];
        }
        //sync the purchase order product relation
        $stock_balance->products()->sync($syncData);
        // print_r($request->real_stock);
        // print_r($request->product_id);
        // print_r($request->system_stock);
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
