<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\ChartAccount;

use App\Helpers\Helper;

class NeracaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $chart_account = \DB::table('chart_accounts')->get();
        $sub_chart_account = \DB::table('sub_chart_accounts')->get();
        return view('neraca.index')
            ->with('chart_account',$chart_account);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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

    public function neraca_sort_submit(Request $request)
    {
        $sort_by_year = $request->sort_by_year;
        if($sort_by_year == 'y'){
            true;
            $year = $request->years;
            $year_in = 'y';
            if(true){
                $chart_account = \DB::table('chart_accounts')->get();
                return view('neraca.index')
                    ->with('chart_account',$chart_account)
                    ->with('year',$year)
                    ->with('year_in',$year_in);
            }// }else{
            //     $chart_account = \DB::table('chart_accounts')->get();
            //     return view('neraca.index')
            //         ->with('chart_account',$chart_account);
            // }
        }elseif ($sort_by_year == 'm') {
            true;
            $month_start = $request->list_months_start;
            $year_start = $request->list_years_start;
            $month_end = $request->list_months_end;
            $year_end = $request->list_years_end;
            $month_in = 'm';
            if(true){
                $chart_account = \DB::table('chart_accounts')->get();
                return view('neraca.index')
                    ->with('chart_account',$chart_account)
                    ->with('month_start',$month_start)
                    ->with('year_start',$year_start)
                    ->with('month_end',$month_end)
                    ->with('year_end',$year_end)
                    ->with('month_in',$month_in);
            }
        }else{
            $chart_account = \DB::table('chart_accounts')->get();
            return view('neraca.index')
                ->with('chart_account',$chart_account);
        }

    }

    public function neraca_print(Request $request)
    {
        $data['sort_by_month_start'] = $request->sort_by_month_start;
        $data['sort_by_month_year_start'] = $request->sort_by_month_year_start;
        $data['sort_by_month_end'] = $request->sort_by_month_end;
        $data['sort_by_month_year_end'] = $request->sort_by_month_year_end;
        $data['sort_year_start'] = $request->years;
        $data['chart_account'] = ChartAccount::all();

        $pdf = \PDF::loadView('pdf.neraca_montly',$data);
        return $pdf->stream('neraca_montly.pdf');
    }
}
