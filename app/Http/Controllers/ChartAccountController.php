<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\ChartAccount;
use App\SubChartAccount;
use App\Cash;
use App\Bank;

class ChartAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('chart_account.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('chart_account.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $chart_account = new ChartAccount;
        $chart_account->name = $request->name;
        $chart_account->account_number = $request->account_number;
        $chart_account->description = $request->description;
        $chart_account->save();
        return redirect('chart-account')
            ->with('successMessage','Chart Account has been created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $chart_account = ChartAccount::findOrFail($id);
        $sub_chart_account = $chart_account->sub_chart_account;
        if($chart_account->id == 6){
            $cash = Cash::lists('name','id');
            return view('chart_account.show_cash')
                ->with('chart_account',$chart_account)
                ->with('sub_chart_account',$sub_chart_account)
                ->with('cash',$cash);
        }elseif ($chart_account->id == 8) {
            $bank = Bank::lists('name','id');
            return view('chart_account.show_bank')
                ->with('chart_account',$chart_account)
                ->with('sub_chart_account',$sub_chart_account)
                ->with('bank',$bank);
        }


    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $chart_account = ChartAccount::findOrFail($id);
        return view('chart_account.edit')
            ->with('chart_account',$chart_account);
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
        $chart_account = ChartAccount::findOrFail($id);
        $chart_account->name = $request->name;
        $chart_account->account_number = $request->account_number;
        $chart_account->description = $request->description;
        $chart_account->save();
        return redirect('chart-account')
            ->with('successMessage',"$chart_account->name has been updated");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $chart_account = ChartAccount::findOrFail($request->chart_account_id);
        $chart_account->delete();
        return redirect('chart-account')
            ->with('successMessage',"$chart_account->name has been deleted");
    }


    public function store_sub(Request $request)
    {
        $sub_chart_account = New SubChartAccount;
        $sub_chart_account->reference = $request->reference;
        $sub_chart_account->account_number = $request->account_number;
        $sub_chart_account->chart_account_id = $request->chart_account_id;
        $sub_chart_account->save();

        // TODO condition account number

        return redirect('chart-account/'.$request->chart_account_id)
            ->with('successMessage','Sub chart account has been created'.$request->chart_account_id);

    }

    public function update_sub(Request $request)
    {
        $sub_chart_account = SubChartAccount::findOrFail($request->sub_chart_account_id);
        $sub_chart_account->name = $request->name;
        $sub_chart_account->account_number = $request->account_number;
        $sub_chart_account->save();
        return redirect('chart-account/'.$request->chart_account_id)
            ->with('successMessage',"Sub chart account has been updated");
    }

    public function delete_sub(Request $request)
    {
        $sub_chart_account = SubChartAccount::findOrFail($request->sub_chart_account_id);
        $sub_chart_account->delete();
        return redirect('chart-account/'.$request->chart_account_id)
            ->with('successMessage',"Sub chart account has been deleted");
    }
}
