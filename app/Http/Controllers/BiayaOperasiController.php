<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\TransactionChartAccount;

class BiayaOperasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('biaya_operasi.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('biaya_operasi.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // now save beban operasi account
        $trans_chart_account = New TransactionChartAccount;
        $trans_chart_account->amount = $request->amount;
        $trans_chart_account->sub_chart_account_id = $request->beban_operasi_account;
        $trans_chart_account->created_at = date('Y-m-d h:i:s');
        $trans_chart_account->updated_at = date('Y-m-d h:i:s');
        $trans_chart_account->reference = $request->beban_operasi_account;
        $trans_chart_account->source = 'biaya_operasi';
        $trans_chart_account->type = 'masuk';
        $trans_chart_account->save();

        $id_first_row = $trans_chart_account->id;
        // now save cash/bank account
        $trans_chart_account_cb = New TransactionChartAccount;
        $trans_chart_account_cb->amount = $request->amount;
        $trans_chart_account_cb->sub_chart_account_id = $request->cash_bank_account;
        $trans_chart_account_cb->created_at = date('Y-m-d h:i:s');
        $trans_chart_account_cb->updated_at = date('Y-m-d h:i:s');
        $trans_chart_account_cb->reference = $id_first_row;
        $trans_chart_account_cb->source = 'biaya_operasi';
        $trans_chart_account_cb->type = 'keluar';
        $trans_chart_account_cb->save();

        return redirect('biaya-operasi')
            ->with('successMessage','Biaya operasi has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $trans_chart_account = TransactionChartAccount::findOrFail($id);
        return view('biaya_operasi.show')
            ->with('trans_chart_account',$trans_chart_account);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $trans_chart_account = TransactionChartAccount::findOrFail($id);
        $cash_bank_account = TransactionChartAccount::select('sub_chart_account_id')->where('reference',$id)->get();
        $sub = '';
        foreach ($cash_bank_account as $key) {
            $sub = $key->sub_chart_account_id;
        }
        return view('biaya_operasi.edit')
            ->with('trans_chart_account',$trans_chart_account)
            ->with('cash_bank_account',$sub);
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
        // now save beban operasi account
        $trans_chart_account = TransactionChartAccount::findOrFail($id);
        $trans_chart_account->amount = floatval(preg_replace('#[^0-9.]#','',$request->amount));
        $trans_chart_account->sub_chart_account_id = $request->beban_operasi_account;
        $trans_chart_account->created_at = date('Y-m-d h:i:s');
        $trans_chart_account->updated_at = date('Y-m-d h:i:s');
        $trans_chart_account->reference = $request->beban_operasi_account;
        $trans_chart_account->source = 'biaya_operasi';
        $trans_chart_account->type = 'masuk';
        $trans_chart_account->save();
        // now save cash/bank account
        \DB::table('transaction_chart_accounts')->where('reference',$id)->update([
                'amount'=>floatval(preg_replace('#[^0-9.]#','',$request->amount)),
                'sub_chart_account_id'=>$request->cash_bank_account,
                'created_at'=>date('Y-m-d h:i:s'),
                'updated_at'=>date('Y-m-d h:i:s'),
                'reference'=>$id,
                'source'=>'biaya_operasi',
                'type'=>'keluar'
        ]);

        return redirect('biaya-operasi')
            ->with('successMessage','biaya operasi has been updated'.$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $trans_chart_account = TransactionChartAccount::findOrFail($request->trans_id);
        $trans_chart_account->delete();

        return redirect('biaya-operasi')
            ->with('successMessage','biaya operasi has been deleted');
    }
}
