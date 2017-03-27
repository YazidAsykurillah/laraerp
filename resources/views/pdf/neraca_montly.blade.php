<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Neraca</title>
    <!-- Bootstrap Core CSS -->
    {!! Html::style('css/bootstrap/bootstrap.css') !!}
    <style>
        *{
            padding: 0;
            margin: 0;
        }
        .container{
            padding: 50px;
        }
        h1,h4{
            text-align: center;
        }
        td{
            font-size: 10pt;
        }
        th{
            text-align: center;
        }
        table tr .parent{
            color: navy;
            padding-left: 20px;
        }
        table tr .sub_child{
            padding-left: 40px;
        }
        table tr .total_child{
            color: navy;
            padding-left: 40px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h1 class="box-title">CATRA<small>TEXTILE</small></h1>
                        <h4>NERACA</h4>
                        <h4 style="line-height:1.7">
                            @if(isset($sort_target_y))
                                Tahun{{ $sort_target_year }}
                            @elseif(isset($sort_target_m))
                                Bulan&nbsp;{{ $month_start }}&nbsp;Tahun&nbsp;{{ $year_start}}&nbsp;sampai&nbsp;Bulan&nbsp;{{ $month_end}}&nbsp;Tahun&nbsp;{{ $year_end}}
                            @endif
                        </h4>
                    </div>
                    <br/>
                    <div class="box-body">
                        <table class="table-responsive table">
                            <thead>
                                <tr>
                                    <th>No.Akun</th>
                                    <th>Deskripsi</th>
                                    <th>BULAN</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td></td>
                                    <td><b>Aktiva-Aktiva</b></td>
                                    <td></td>
                                </tr>
                                @foreach($chart_account as $cash_bank)
                                    @if($cash_bank->id == 51)
                                    <tr>
                                        <td></td>
                                        <td><b>{{ $cash_bank->name}}</b></td>
                                        <td></td>
                                    </tr>
                                    @foreach(list_parent('51') as $as)
                                        @if($as->level == 1)
                                        <tr>
                                            <td style="padding-left:20px;">{{ $as->account_number }}</td>
                                            <td style="padding-left:20px;">{{ $as->name}}</td>
                                            <td></td>
                                        </tr>
                                        @endif
                                        @foreach(list_child('2',$as->id) as $sub)
                                        <tr>
                                            <td style="padding-left:40px;">{{ $sub->account_number}}</td>
                                            <td style="padding-left:40px;">{{ $sub->name}}</td>
                                            @if(isset($sort_target_y))
                                                @if(list_transaction_cash_bank($sub->id,$sort_target_year,'y','') == '')
                                                <td>0,00</td>
                                                @else
                                                <td>{{ number_format(list_transaction_cash_bank($sub->id,$sort_target_year,'y','')) }}</td>
                                                @endif
                                            @elseif(isset($sort_target_m))
                                                @if(list_transaction_cash_bank($sub->id,$year_start.'-'.$month_start.'-01 00:00:00','m',$year_end.'-'.$month_end.'-31 23:59:59') == '')
                                                <td>0,00</td>
                                                @else
                                                <td>{{ number_format(list_transaction_cash_bank($sub->id,$year_start.'-'.$month_start.'-01 00:00:00','m',$year_end.'-'.$month_end.'-31 23:59:59')) }}</td>
                                                @endif
                                            @else
                                                @if(list_transaction_cash_bank($sub->id,date('Y'),'y','') == '')
                                                <td>0,00</td>
                                                @else
                                                <td>{{ number_format(list_transaction_cash_bank($sub->id,date('Y'),'y','')) }}</td>
                                                @endif
                                            @endif
                                        </tr>
                                        @endforeach
                                    @endforeach
                                    @endif
                                @endforeach
                                @foreach($chart_account as $piutang)
                                    @if($piutang->id == 49)
                                    <tr>
                                        <td></td>
                                        <td><b>{{ $piutang->name}}</b></td>
                                        <td></td>
                                    </tr>
                                    @foreach(list_parent('49') as $as)
                                        @if($as->level == 1)
                                        <tr>
                                            <td style="padding-left:20px;">{{ $sub->account_number}}</td>
                                            <td style="padding-left:20px;">{{ $as->name}}</td>
                                            <td></td>
                                        </tr>
                                        @endif
                                        @foreach(list_child('2',$as->id) as $sub)
                                        <tr>
                                            <td style="padding-left:40px;">{{ $sub->account_number}}</td>
                                            <td style="padding-left:40px;">{{ $sub->name}}</td>
                                            @if(isset($sort_target_y))
                                                @if(list_transaction_piutang($sub->id,$sort_target_year,'y','') == '')
                                                <td>0,00</td>
                                                @else
                                                <td>{{ number_format(list_transaction_piutang($sub->id,$sort_target_year,'y','')) }}</td>
                                                @endif
                                            @elseif(isset($sort_target_m))
                                                @if(list_transaction_piutang($sub->id,$year_start.'-'.$month_start.'-01 00:00:00','m',$year_end.'-'.$month_end.'-31 23:59:59') == '')
                                                <td>0,00</td>
                                                @else
                                                <td>{{ number_format(list_transaction_piutang($sub->id,$year_start.'-'.$month_start.'-01 00:00:00','m',$year_end.'-'.$month_end.'-31 23:59:59')) }}</td>
                                                @endif
                                            @else
                                                @if(list_transaction_piutang($sub->id,date('Y'),'y','') == '')
                                                <td>0,00</td>
                                                @else
                                                <td>{{ number_format(list_transaction_piutang($sub->id,date('Y'),'y','')) }}</td>
                                                @endif
                                            @endif
                                        </tr>
                                        @endforeach
                                    @endforeach
                                    @endif
                                @endforeach
                                @foreach($chart_account as $persediaan)
                                    @if($persediaan->id == 52)
                                    <tr>
                                        <td></td>
                                        <td><b>{{ $persediaan->name}}</b></td>
                                        <td></td>
                                    </tr>
                                    @foreach(list_parent('52') as $as)
                                        @if($as->level == 1)
                                        <tr>
                                            <td style="padding-left:20px;">{{ $sub->account_number}}</td>
                                            <td style="padding-left:20px;">{{ $as->name}}</td>
                                            <td></td>
                                        </tr>
                                        @endif
                                        @foreach(list_child('2',$as->id) as $sub)
                                        <tr>
                                            <td style="padding-left:40px;">{{ $sub->account_number}}</td>
                                            <td style="padding-left:40px;">{{ $sub->name}}</td>
                                            @if(isset($sort_target_y))
                                                @if(list_transaction_inventory($sub->id,$sort_target_year,'y','') == '')
                                                <td>0,00</td>
                                                @else
                                                <td>{{ number_format(list_transaction_inventory($sub->id,$sort_target_year,'y','')) }}</td>
                                                @endif
                                            @elseif(isset($sort_target_m))
                                                @if(list_transaction_inventory($sub->id,$year_start.'-'.$month_start.'-01 00:00:00','m',$year_end.'-'.$month_end.'-31 23:59:59') == '')
                                                <td>0,00</td>
                                                @else
                                                <td>{{ number_format(list_transaction_inventory($sub->id,$year_start.'-'.$month_start.'-01 00:00:00','m',$year_end.'-'.$month_end.'-31 23:59:59')) }}</td>
                                                @endif
                                            @else
                                                @if(list_transaction_inventory($sub->id,date('Y'),'y','') == '')
                                                <td>0,00</td>
                                                @else
                                                <td>{{ number_format(list_transaction_inventory($sub->id,date('Y'),'y','')) }}</td>
                                                @endif
                                            @endif
                                        </tr>
                                        @endforeach
                                    @endforeach
                                    @endif
                                @endforeach
                                @foreach($chart_account as $aktiva_lancar_lainnya)
                                    @if($aktiva_lancar_lainnya->id == 50)
                                    <tr>
                                        <td></td>
                                        <td><b>{{ $aktiva_lancar_lainnya->name}}</b></td>
                                        <td></td>
                                    </tr>
                                    @foreach(list_parent('50') as $as)
                                        @if($as->level == 1)
                                        <tr>
                                            <td style="padding-left:20px;">{{ $sub->account_number}}</td>
                                            <td style="padding-left:20px;">{{ $as->name}}</td>
                                            <td></td>
                                        </tr>
                                        @endif
                                        @foreach(list_child('2',$as->id) as $sub)
                                        <tr>
                                            <td style="padding-left:40px;">{{ $sub->account_number}}</td>
                                            <td style="padding-left:40px;">{{ $sub->name}}</td>
                                            @if(list_transaction($sub->id) == '')
                                            <td>0,00</td>
                                            @else
                                            <td>{{ number_format(list_transaction($sub->id)) }}</td>
                                            @endif
                                        </tr>
                                        @endforeach
                                    @endforeach
                                    @endif
                                @endforeach
                                @foreach($chart_account as $nilai_history)
                                    @if($nilai_history->id == 68)
                                    <tr>
                                        <td></td>
                                        <td><b>{{ $nilai_history->name}}</b></td>
                                        <td></td>
                                    </tr>
                                    @foreach(list_parent('68') as $as)
                                        @if($as->level == 1)
                                        <tr>
                                            <td style="padding-left:20px;">{{ $sub->account_number}}</td>
                                            <td style="padding-left:20px;">{{ $as->name}}</td>
                                            <td></td>
                                        </tr>
                                        @endif
                                        @foreach(list_child('2',$as->id) as $sub)
                                        <tr>
                                            <td style="padding-left:40px;">{{ $sub->account_number}}</td>
                                            <td style="padding-left:40px;">{{ $sub->name}}</td>
                                            @if(list_transaction($sub->id) == '')
                                            <td>0,00</td>
                                            @else
                                            <td>{{ number_format(list_transaction($sub->id)) }}</td>
                                            @endif
                                        </tr>
                                        @endforeach
                                    @endforeach
                                    @endif
                                @endforeach
                                @foreach($chart_account as $akumulasi_penyusutan)
                                    @if($akumulasi_penyusutan->id == 55)
                                    <tr>
                                        <td></td>
                                        <td><b>{{ $akumulasi_penyusutan->name}}</b></td>
                                        <td></td>
                                    </tr>
                                    @foreach(list_parent('55') as $as)
                                        @if($as->level == 1)
                                        <tr>
                                            <td style="padding-left:20px;">{{ $sub->account_number}}</td>
                                            <td style="padding-left:20px;">{{ $as->name}}</td>
                                            <td></td>
                                        </tr>
                                        @endif
                                        @foreach(list_child('2',$as->id) as $sub)
                                        <tr>
                                            <td style="padding-left:40px;">{{ $sub->account_number}}</td>
                                            <td style="padding-left:40px;">{{ $sub->name}}</td>
                                            @if(list_transaction($sub->id) == '')
                                            <td>0,00</td>
                                            @else
                                            <td>{{ number_format(list_transaction($sub->id)) }}</td>
                                            @endif
                                        </tr>
                                        @endforeach
                                    @endforeach
                                    @endif
                                @endforeach
                                <tr>
                                    <td></td>
                                    <td><b>Kewajiban dan Ekuitas</b></td>
                                    <td></td>
                                </tr>
                                @foreach($chart_account as $kewajiban)
                                    @if($kewajiban->id == 56)
                                    <tr>
                                        <td></td>
                                        <td><b>{{ $kewajiban->name}}</b></td>
                                        <td></td>
                                    </tr>
                                    @foreach(list_parent('56') as $as)
                                        @if($as->level == 1)
                                        <tr>
                                            <td style="padding-left:20px;">{{ $sub->account_number}}</td>
                                            <td style="padding-left:20px;">{{ $as->name}}</td>
                                            <td></td>
                                        </tr>
                                        @endif
                                        @foreach(list_child('2',$as->id) as $sub)
                                        <tr>
                                            <td style="padding-left:40px;">{{ $sub->account_number}}</td>
                                            <td style="padding-left:40px;">{{ $sub->name}}</td>
                                            @if(isset($sort_target_y))
                                                @if(list_transaction_hutang($sub->id,$sort_target_year,'y','') == '')
                                                <td>0,00</td>
                                                @else
                                                <td>{{ number_format(list_transaction_hutang($sub->id,$sort_target_year,'y','')) }}</td>
                                                @endif
                                            @elseif(isset($sort_target_m))
                                                @if(list_transaction_hutang($sub->id,$year_start.'-'.$month_start.'-01 00:00:00','m',$year_end.'-'.$month_end.'-31 23:59:59') == '')
                                                <td>0,00</td>
                                                @else
                                                <td>{{ number_format(list_transaction_hutang($sub->id,$year_start.'-'.$month_start.'-01 00:00:00','m',$year_end.'-'.$month_end.'-31 23:59:59')) }}</td>
                                                @endif
                                            @else
                                                @if(list_transaction_hutang($sub->id,date('Y'),'y','') == '')
                                                <td>0,00</td>
                                                @else
                                                <td>{{ number_format(list_transaction_hutang($sub->id,date('Y'),'y','')) }}</td>
                                                @endif
                                            @endif
                                        </tr>
                                        @endforeach
                                    @endforeach
                                    @endif
                                @endforeach
                                @foreach($chart_account as $kewajiban_lancar_lainnya)
                                    @if($kewajiban_lancar_lainnya->id == 58)
                                    <tr>
                                        <td></td>
                                        <td><b>{{ $kewajiban_lancar_lainnya->name}}</b></td>
                                        <td></td>
                                    </tr>
                                    @foreach(list_parent('58') as $as)
                                        @if($as->level == 1)
                                        <tr>
                                            <td style="padding-left:20px;">{{ $sub->account_number}}</td>
                                            <td style="padding-left:20px;">{{ $as->name}}</td>
                                            <td></td>
                                        </tr>
                                        @endif
                                        @foreach(list_child('2',$as->id) as $sub)
                                        <tr>
                                            <td style="padding-left:40px;">{{ $sub->account_number}}</td>
                                            <td style="padding-left:40px;">{{ $sub->name}}</td>
                                            @if(list_transaction($sub->id) == '')
                                            <td>0,00</td>
                                            @else
                                            <td>{{ number_format(list_transaction($sub->id)) }}</td>
                                            @endif
                                        </tr>
                                        @endforeach
                                    @endforeach
                                    @endif
                                @endforeach
                                <tr style="display:none">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                @foreach($chart_account as $kewajiban_jangka_panjang)
                                    @if($kewajiban_jangka_panjang->id == 59)
                                    <tr>
                                        <td></td>
                                        <td><b>{{ $kewajiban_jangka_panjang->name}}</b></td>
                                        <td></td>
                                    </tr>
                                    @foreach(list_parent('59') as $as)
                                        @if($as->level == 1)
                                        <tr>
                                            <td style="padding-left:20px;">{{ $sub->account_number}}</td>
                                            <td style="padding-left:20px;">{{ $as->name}}</td>
                                            <td>0,00</td>
                                        </tr>
                                        @endif
                                        @foreach(list_child('2',$as->id) as $sub)
                                        <tr>
                                            <td style="padding-left:40px;">{{ $sub->account_number}}</td>
                                            <td style="padding-left:40px;">{{ $sub->name}}</td>
                                            @if(list_transaction($sub->id) == '')
                                            <td>0,00</td>
                                            @else
                                            <td>{{ number_format(list_transaction($sub->id)) }}</td>
                                            @endif
                                        </tr>
                                        @endforeach
                                    @endforeach
                                    @endif
                                @endforeach
                                @foreach($chart_account as $equitas)
                                    @if($equitas->id == 60)
                                    <tr>
                                        <td></td>
                                        <td><b>{{ $equitas->name}}</b></td>
                                        <td></td>
                                    </tr>
                                    @foreach(list_parent('60') as $as)
                                        @if($as->level == 1)
                                        <tr>
                                            <td style="padding-left:20px;">{{ $sub->account_number}}</td>
                                            <td style="padding-left:20px;">{{ $as->name}}</td>
                                            <td>0,00</td>
                                        </tr>
                                        @endif
                                        @foreach(list_child('2',$as->id) as $sub)
                                        <tr>
                                            <td style="padding-left:40px;">{{ $sub->account_number}}</td>
                                            <td style="padding-left:40px;">{{ $sub->name}}</td>
                                            @if(list_transaction($sub->id) == '')
                                            <td>0,00</td>
                                            @else
                                            <td>{{ number_format(list_transaction($sub->id)) }}</td>
                                            @endif
                                        </tr>
                                        @endforeach
                                    @endforeach
                                    @endif
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</body>
</html>
