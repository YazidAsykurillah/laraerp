<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;


//Form requests
use App\Http\Requests\StoreStockBalance;

// Use Modal
use App\StockBalance;
use App\Product;
use DB;

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
    public function store(StoreStockBalance $request)
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
                                'real_stock' => $request->real_stock[$key],
                                'information' => $request->information[$key]
                                ];
        }
        //sync the purchase order product relation
        $stock_balance->products()->sync($syncData);
        return redirect('stock_balance')
            ->with('successMessage','Stock balance has been created');
        // print_r($request->real_stock);
        // print_r($request->product_id);~
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
        $data = \DB::table('product_stock_balance')
        ->join('products','product_stock_balance.product_id','=','products.id')
        ->select('product_stock_balance.*','products.name','products.description')
        ->where('product_stock_balance.stock_balance_id','=',$id)
        ->get();
        //$data->product_stock_balance()->get();
        $stock_balance = StockBalance::findOrFail($id);
        return view('stock_balance.show')
            ->with('dataList',$data)
            ->with('stock_balance',$stock_balance);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = \DB::table('product_stock_balance')
        ->join('products','product_stock_balance.product_id','=','products.id')
        ->select('product_stock_balance.*','products.name','products.description')
        ->where('product_stock_balance.stock_balance_id','=',$id)
        ->get();
        $stock_balance = StockBalance::findOrFail($id);
        return view('stock_balance.edit')
            ->with('dataList',$data)
            ->with('stock_balance',$stock_balance);
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
        // $data = \DB::table('stock_balance')
        // ->join('product_stock_balance','product_stock_balance.stock_balance_id','=','stock_balance.id')
        // ->where('stock_balance.id','=',$id)
        // ->update('');
        $stock_balance = StockBalance::findOrFail($id);
        $stock_balance->code = $request->code;
        $stock_balance->created_by = $request->created_by;
        $stock_balance->save();
        \DB::table('product_stock_balance')->where('stock_balance_id','=',$request->id)->delete();
        $syncData = [];
        foreach($request->product_id as $key=>$value){
            //$syncData[$value] = ['quantity'=> $request->quantity[$key], 'price'=>floatval(preg_replace('#[^0-9.]#', '', $request->price[$key]))];
            $syncData[$value] = [
                                'stock_balance_id' => $request->stock_balance_id[$key],
                                'product_id' => $request->product_id[$key],
                                'system_stock' => $request->system_stock[$key],
                                'real_stock' => $request->real_stock[$key],
                                'information' => $request->information[$key]
                                ];
        }
        //sync the purchase order product relation
        \DB::table('product_stock_balance')->insert($syncData);
        return redirect('stock_balance')
            ->with('successMessage',"$stock_balance->code has been updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $stock_balance = StockBalance::findOrFail($request->stock_balance_id);
        $stock_balance->delete();
        \DB::table('product_stock_balance')->where('stock_balance_id','=',$request->stock_balance_id)->delete();
        return redirect('stock_balance')
            ->with('successMessage',"$stock_balance->code has been deleted");
    }
}
