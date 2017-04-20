<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\StoreCashRequest;
use App\Http\Requests\UpdateCashRequest;

use App\Cash;

class CashController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cash.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cash.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCashRequest $request)
    {
        $data = [
            'code' => $request->code,
            'name' => $request->name,
            'value' => floatval(preg_replace('#[^0-9.]#','',$request->value))
        ];
        $save = Cash::create($data);
        return redirect('cash')
            ->with('successMessage',"Cash has been created.");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cash = Cash::findOrFail($id);
        return view('cash.show')->with('cash',$cash);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cash = Cash::findOrFail($id);
        return view('cash.edit')
            ->with('cash',$cash);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCashRequest $request, $id)
    {
        $cash = Cash::findOrFail($id);
        $cash->code = $request->code;
        $cash->name = $request->name;
        $cash->value = floatval(preg_replace('#[^0-9.]#','',$request->value));
        $cash->save();
        return redirect('cash/'.$id.'/edit')->with('successMessage','Cash has been edited');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $cash = Cash::findOrFail($request->cash_id);
        $cash->delete();
        return redirect('cash')
            ->with('successMessage','cash has been deleted');
    }
}
