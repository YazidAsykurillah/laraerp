<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\StoreAssetRequest;

use App\Asset;
use App\TransactionChartAccount;
class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('asset.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('asset.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAssetRequest $request)
    {
        $asset = New Asset;
        $asset->code = $request->code;
        $asset->name = $request->name;
        $asset->date_purchase = $request->date_purchase;
        $asset->amount = floatval(preg_replace('#[^0-9.]#','',$request->amount));
        $asset->residual_value = floatval(preg_replace('#[^0-9.]#','',$request->residual_value));
        $asset->periode = $request->periode;
        $asset->notes = $request->notes;
        $asset->save();

        $asset_account = New TransactionChartAccount;
        $asset_account->amount = floatval(preg_replace('#[^0-9.]#','',$request->amount));
        $asset_account->sub_chart_account_id = $request->asset_account;
        $asset_account->created_at = date('Y-m-d h:i:s');
        $asset_account->updated_at = date('Y-m-d h:i:s');
        $asset_account->reference = $request->asset_account;
        $asset_account->source = 'asset';
        $asset_account->type = 'masuk';
        $asset_account->description = $request->name;
        $asset_account->memo = $request->notes;
        $asset_account->save();

        // penyusutan garis lurus
        $biaya_count = (floatval(preg_replace('#[^0-9.]#','',$request->amount))-floatval(preg_replace('#[^0-9.]#','',$request->residual_value)))/($request->periode/12);

        $biaya_penyusutan_account = New TransactionChartAccount;
        $biaya_penyusutan_account->amount = $biaya_count;
        $biaya_penyusutan_account->sub_chart_account_id = $request->biaya_penyusutan_account;
        $biaya_penyusutan_account->created_at = date('Y-m-d h:i:s');
        $biaya_penyusutan_account->updated_at = date('Y-m-d h:i:s');
        $biaya_penyusutan_account->reference = $request->biaya_penyusutan_account;
        $biaya_penyusutan_account->source = $request->date_purchase;
        $biaya_penyusutan_account->type = 'masuk';
        $biaya_penyusutan_account->description = $request->name;
        $biaya_penyusutan_account->memo = 'BIAYA PENYUSUTAN';
        $biaya_penyusutan_account->save();

        $akumulasi_penyusutan_account = New TransactionChartAccount;
        $akumulasi_penyusutan_account->amount = $biaya_count;
        $akumulasi_penyusutan_account->sub_chart_account_id =  $request->akumulasi_penyusutan_account;
        $akumulasi_penyusutan_account->created_at = date('Y-m-d h:i:s');
        $akumulasi_penyusutan_account->updated_at = date('Y-m-d h:i:s');
        $akumulasi_penyusutan_account->reference = $request->akumulasi_penyusutan_account;
        $akumulasi_penyusutan_account->source = $request->date_purchase;
        $akumulasi_penyusutan_account->type = 'masuk';
        $akumulasi_penyusutan_account->description = $request->name;
        $akumulasi_penyusutan_account->memo = 'AKUMULASI PENYUSUTAN';
        $akumulasi_penyusutan_account->save();


        return redirect('asset')
            ->with('successMessage','Asset has been added'.$request->asset_account);
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
