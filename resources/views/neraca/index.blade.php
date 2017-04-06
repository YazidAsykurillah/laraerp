@extends('layouts.app')

@section('page_title')
    Neraca
@endsection

@section('page_header')
    <h1>
        Neraca
        <small>Neraca List</small>
    </h1>
@endsection

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{ URL::to('neraca') }}"><i class="fa fa-dashboard"></i> Neraca</a></li>
        <li class="active"><i></i>Index</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        {!! Form::open(['url'=>'neraca/submit','role'=>'form','class'=>'form-horizontal','id'=>'form-search-neraca']) !!}
        <div class="col-lg-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Search Period Neraca</h3>
                    <a data-toggle="collapse" href="#collapse-neraca" title="Click to search neraca"><i class="fa fa-arrow-down pull-right"></i></a>
                </div>
                <div class="box-body collapse" id="collapse-neraca">
                    <div class="form-group">
                        <div class="col-sm-offset-1 col-sm-11">
                            <div class="radio">
                                <label><input type="radio" id="sort_by_year" name="sort_by_year" value="y"> Sort by year</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('years','Years',['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-2">
                            {!! Form::number('years','2017',['class'=>'form-control','id'=>'years']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-1 col-sm-11">
                            <div class="radio">
                                <label><input type="radio" id="sort_by_month_start" name="sort_by_year" value="m"> Sort by month</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('months','Start',['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-2">
                            <select class="form-control" name="list_months_start" id="list_months_start">
                                <option>Select Month</option>
                                <option value="01">January</option>
                                <option value="02">February</option>
                                <option value="03">March</option>
                                <option value="04">April</option>
                                <option value="05">May</option>
                                <option value="06">June</option>
                                <option value="07">July</option>
                                <option value="08">August</option>
                                <option value="09">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                            </select>
                        </div>
                        <div class="col-sm-2">
                            {!! Form::number('list_years_start','2017',['class'=>'form-control','id'=>'list_years_start']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('months','End',['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-2">
                            <select class="form-control" name="list_months_end" id="list_months_end">
                                <option>Select Month</option>
                                <option value="01">January</option>
                                <option value="02">February</option>
                                <option value="03">March</option>
                                <option value="04">April</option>
                                <option value="05">May</option>
                                <option value="06">June</option>
                                <option value="07">July</option>
                                <option value="08">August</option>
                                <option value="09">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                            </select>
                        </div>
                        <div class="col-sm-2">
                            {!! Form::number('list_years_end','2017',['class'=>'form-control','id'=>'list_years_end']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('','',['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-3">
                            <button type="submit" href="#" class="btn btn-info" id="btn-submit-neraca">
                                <i class="fa fa-print"></i>&nbsp;Submit
                            </button>
                        </div>
                    </div>
                </div>
                <div class="box-footer">

                </div>
            </box>
        </div>
        {!! Form::close() !!}
    </div>

    <div class="col-lg-12">
        <div class="box">
            <div class="box-header with-border">
                {!! Form::open(['url'=>'neraca.neraca_print','role'=>'form','class'=>'form-horizontal','id'=>'form-search-neraca','files'=>true]) !!}
                <center>
                    <h3 class="box-title">CATRA<small>TEXTILE</small></h3>
                    <h4>NERACA</h4>
                    <h4 id="sort_target">
                        @if(isset($year_in))
                            Tahun&nbsp;{{ $year }}
                        @elseif(isset($month_in))
                            Bulan&nbsp;{{ $conv_month_start }}&nbsp;Tahun&nbsp;{{ $year_start }}&nbsp;sampai&nbsp;Bulan&nbsp;{{ $conv_month_end }}&nbsp;Tahun&nbsp;{{ $year_end}}
                        @else
                            {{ date('Y') }}
                        @endif
                    </h4>
                </center>
                @if(isset($year_in))
                <div class="form-group pull-right">
                    {!! Form::label('','',['class'=>'col-sm-2 control-label']) !!}
                    <div class="col-sm-3">
                        <input type="hidden" name="sort_target_year" id="sort_target_year" value="{{ $year }}">
                        <input type="hidden" name="sort_target" id="sort_target" value="y">
                        <button type="submit" class="btn btn-default" id="btn-submit-neraca-print" title="click to print">
                            <i class="fa fa-print"></i>&nbsp;
                        </button>
                    </div>
                </div>
                @elseif(isset($month_in))
                <div class="form-group pull-right">
                    {!! Form::label('','',['class'=>'col-sm-2 control-label']) !!}
                    <div class="col-sm-3">
                        <input type="hidden" name="sort_target" id="sort_target" value="m">
                        <input type="hidden" name="sort_target_months_start" id="sort_by_month_year_start" value="{{ $month_start }}">
                        <input type="hidden" name="sort_target_years_start" id="sort_by_month_end" value="{{ $year_start }}">
                        <input type="hidden" name="sort_target_months_end" id="sort_by_month_year_end" value="{{ $month_end }}">
                        <input type="hidden" name="sort_target_years_end" id="sort_by_month_year_end" value="{{ $year_end }}">
                        <button type="submit" class="btn btn-default" id="btn-submit-neraca-print" title="click to print">
                            <i class="fa fa-print"></i>&nbsp;
                        </button>
                    </div>
                </div>
                @endif
                {!! Form::close() !!}
            </div>
            <div class="box-body table-responsive">
                <table class="table table-striped" id="table-neraca">
                    <thead>
                        <tr>
                            <th style="width:30%">No.Akun</th>
                            <th style="width:40%">Deskripsi</th>
                            <th style="width:30%">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td><b>Aktiva-Aktiva</b></td>
                            <td></td>
                        </tr>
                        <?php
                        $sum_cash_bank = 0;
                        $sum_piutang = 0;
                        $sum_inventory = 0;
                        $sum_aktiva_lancar_lainnya = 0;
                        $sum_nilai_history = 0;
                        $sum_akumulasi_penyusutan = 0;
                        ?>
                        @foreach($chart_account as $cash_bank)
                            <?php $sum=0;?>
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
                                    @if(isset($year_in))
                                        @if(list_transaction_cash_bank($sub->id,$year,'y','') == '')
                                        <td>0,00</td>
                                        @else
                                        <td>
                                            {{ number_format(list_transaction_cash_bank($sub->id,$year,'y','')) }}
                                            <?php $sum += list_transaction_cash_bank($sub->id,$year,'y','');?>
                                        </td>
                                        @endif
                                    @elseif(isset($month_in))
                                        @if(list_transaction_cash_bank($sub->id,$year_start.'-'.$month_start.'-01 00:00:00','m',$year_end.'-'.$month_end.'-31 23:59:59') == '')
                                        <td>0,00</td>
                                        @else
                                        <td>
                                            {{ number_format(list_transaction_cash_bank($sub->id,$year_start.'-'.$month_start.'-01 00:00:00','m',$year_end.'-'.$month_end.'-31 23:59:59')) }}
                                            <?php $sum += list_transaction_cash_bank($sub->id,$year_start.'-'.$month_start.'-01 00:00:00','m',$year_end.'-'.$month_end.'-31 23:59:59');?>
                                        </td>
                                        @endif
                                    @else
                                        @if(list_transaction_cash_bank($sub->id,date('Y'),'y','') == '')
                                        <td>0,00</td>
                                        @else
                                        <td>
                                            {{ number_format(list_transaction_cash_bank($sub->id,date('Y'),'y','')) }}
                                            <?php $sum += list_transaction_cash_bank($sub->id,date('Y'),'y','');?>
                                        </td>
                                        @endif
                                    @endif
                                </tr>
                                @endforeach
                            @endforeach
                            <tr>
                                <td></td>
                                <td style="border-top:1px solid black">Total {{ $cash_bank->name }}</td>
                                <td style="border-top:1px solid black">{{ number_format($sum) }}<?php $sum_cash_bank = $sum; ?></td>
                            </tr>
                            @endif
                        @endforeach
                        @foreach($chart_account as $piutang)
                            <?php $sum =0;?>
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
                                    @if(isset($year_in))
                                        @if(list_transaction_piutang($sub->id,$year,'y','') == '')
                                        <td>0,00</td>
                                        @else
                                        <td>
                                            {{ number_format(list_transaction_piutang($sub->id,$year,'y','')) }}
                                            <?php $sum += list_transaction_piutang($sub->id,$year,'y','');?>
                                        </td>
                                        @endif
                                    @elseif(isset($month_in))
                                        @if(list_transaction_piutang($sub->id,$year_start.'-'.$month_start.'-01 00:00:00','m',$year_end.'-'.$month_end.'-31 23:59:59') == '')
                                        <td>0,00</td>
                                        @else
                                        <td>
                                            {{ number_format(list_transaction_piutang($sub->id,$year_start.'-'.$month_start.'-01 00:00:00','m',$year_end.'-'.$month_end.'-31 23:59:59')) }}
                                            <?php $sum += list_transaction_piutang($sub->id,$year_start.'-'.$month_start.'-01 00:00:00','m',$year_end.'-'.$month_end.'-31 23:59:59'); ?>
                                        </td>
                                        @endif
                                    @else
                                        @if(list_transaction_piutang($sub->id,date('Y'),'y','') == '')
                                        <td>0,00</td>
                                        @else
                                        <td>
                                            {{ number_format(list_transaction_piutang($sub->id,date('Y'),'y','')) }}
                                            <?php $sum += list_transaction_piutang($sub->id,date('Y'),'y',''); ?>
                                        </td>
                                        @endif
                                    @endif
                                </tr>
                                @endforeach
                            @endforeach
                            <tr>
                                <td></td>
                                <td style="border-top:1px solid black">Total {{ $piutang->name }}</td>
                                <td style="border-top:1px solid black">{{ number_format($sum) }}<?php $sum_piutang = $sum; ?></td>
                            </tr>
                            @endif
                        @endforeach
                        @foreach($chart_account as $persediaan)
                            <?php $sum = 0; ?>
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
                                    @if(isset($year_in))
                                        @if(list_transaction_inventory($sub->id,$year,'y','') == '')
                                        <td>0,00</td>
                                        @else
                                        <td>
                                            {{ number_format(list_transaction_inventory($sub->id,$year,'y','')) }}
                                            <?php $sum+= list_transaction_inventory($sub->id,$year,'y',''); ?>
                                        </td>
                                        @endif
                                    @elseif(isset($month_in))
                                        @if(list_transaction_inventory($sub->id,$year_start.'-'.$month_start.'-01 00:00:00','m',$year_end.'-'.$month_end.'-31 23:59:59') == '')
                                        <td>0,00</td>
                                        @else
                                        <td>
                                            {{ number_format(list_transaction_inventory($sub->id,$year_start.'-'.$month_start.'-01 00:00:00','m',$year_end.'-'.$month_end.'-31 23:59:59')) }}
                                            <?php $sum += list_transaction_inventory($sub->id,$year_start.'-'.$month_start.'-01 00:00:00','m',$year_end.'-'.$month_end.'-31 23:59:59'); ?>
                                        </td>
                                        @endif
                                    @else
                                        @if(list_transaction_inventory($sub->id,date('Y'),'y','') == '')
                                        <td>0,00</td>
                                        @else
                                        <td>
                                            {{ number_format(list_transaction_inventory($sub->id,date('Y'),'y','')) }}
                                            <?php $sum += list_transaction_inventory($sub->id,date('Y'),'y',''); ?>
                                        </td>
                                        @endif
                                    @endif
                                </tr>
                                @endforeach
                            @endforeach
                            <tr>
                                <td></td>
                                <td style="border-top:1px solid black">Total {{ $persediaan->name }}</td>
                                <td style="border-top:1px solid black">{{ number_format($sum) }} <?php $sum_inventory = $sum; ?></td>
                            </tr>
                            @endif
                        @endforeach
                        @foreach($chart_account as $aktiva_lancar_lainnya)
                            <?php $sum = 0; ?>
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
                            <tr>
                                <td></td>
                                <td style="border-top:1px solid black">Total {{ $aktiva_lancar_lainnya->name }}<?php $sum_aktiva_lancar_lainnya = $sum; ?></td>
                                <td style="border-top:1px solid black">0,00</td>
                            </tr>
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
                                    <td>
                                        {{ number_format(list_transaction($sub->id)) }}
                                        <?php $sum += list_transaction($sub->id); ?>
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                            @endforeach
                            <tr>
                                <td></td>
                                <td style="border-top:1px solid black">Total {{ $nilai_history->name }}</td>
                                <td style="border-top:1px solid black">{{ number_format($sum) }} <?php $sum_nilai_history = $sum; ?></td>
                            </tr>
                            @endif
                        @endforeach
                        @foreach($chart_account as $akumulasi_penyusutan)
                        <?php $sum = 0; ?>
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
                                    <td>
                                        {{ number_format(list_transaction($sub->id)) }}
                                        <?php $sum += list_transaction($sub->id); ?>
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                            @endforeach
                            <tr>
                                <td></td>
                                <td style="border-top:1px solid black">Total {{ $akumulasi_penyusutan->name }}</td>
                                <td style="border-top:1px solid black">{{ number_format($sum) }}<?php $sum_akumulasi_penyusutan = $sum; ?></td>
                            </tr>
                            @endif
                        @endforeach
                        <tr>
                            <td></td>
                            <td style="border-top:1px solid black">Total Aktiva-Aktiva</td>
                            <td style="border-top:1px solid black">{{ number_format($sum_cash_bank+$sum_piutang+$sum_inventory+$sum_aktiva_lancar_lainnya+$sum_nilai_history+$sum_akumulasi_penyusutan) }}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><b>Kewajiban dan Ekuitas</b></td>
                            <td></td>
                        </tr>
                        <?php
                        $sum_kewajiban = 0;
                        $sum_kewajiban_lancar_lainnya = 0;
                        $sum_kewajiban_jangka_panjang = 0;
                        $sum_equitas = 0;
                        ?>
                        @foreach($chart_account as $kewajiban)
                            <?php $sum = 0; ?>
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
                                    @if(isset($year_in))
                                        @if(list_transaction_hutang($sub->id,$year,'y','') == '')
                                        <td>0,00</td>
                                        @else
                                        <td>
                                            {{ number_format(list_transaction_hutang($sub->id,$year,'y','')) }}
                                            <?php $sum += list_transaction_hutang($sub->id,$year,'y',''); ?>
                                        </td>
                                        @endif
                                    @elseif(isset($month_in))
                                        @if(list_transaction_hutang($sub->id,$year_start.'-'.$month_start.'-01 00:00:00','m',$year_end.'-'.$month_end.'-31 23:59:59') == '')
                                        <td>0,00</td>
                                        @else
                                        <td>
                                            {{ number_format(list_transaction_hutang($sub->id,$year_start.'-'.$month_start.'-01 00:00:00','m',$year_end.'-'.$month_end.'-31 23:59:59')) }}
                                            <?php $sum += list_transaction_hutang($sub->id,$year_start.'-'.$month_start.'-01 00:00:00','m',$year_end.'-'.$month_end.'-31 23:59:59'); ?>
                                        </td>
                                        @endif
                                    @else
                                        @if(list_transaction_hutang($sub->id,date('Y'),'y','') == '')
                                        <td>0,00</td>
                                        @else
                                        <td>
                                            {{ number_format(list_transaction_hutang($sub->id,date('Y'),'y','')) }}
                                            <?php $sum += list_transaction_hutang($sub->id,date('Y'),'y',''); ?>
                                        </td>
                                        @endif
                                    @endif
                                </tr>
                                @endforeach
                            @endforeach
                            <tr>
                                <td></td>
                                <td style="border-top:1px solid black">Total {{ $kewajiban->name }}</td>
                                <td style="border-top:1px solid black">{{ number_format($sum) }}<?php $sum_kewajiban = $sum; ?></td>
                            </tr>
                            @endif
                        @endforeach
                        @foreach($chart_account as $kewajiban_lancar_lainnya)
                            <?php $sum = 0; ?>
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
                                    <td>
                                        {{ number_format(list_transaction($sub->id)) }}
                                        <?php $sum += list_transaction($sub->id); ?>
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                            @endforeach
                            <tr>
                                <td></td>
                                <td style="border-top:1px solid black">Total {{ $kewajiban_lancar_lainnya->name }}</td>
                                <td style="border-top:1px solid black">{{ number_format($sum) }}<?php $sum_kewajiban_lancar_lainnya = $sum; ?></td>
                            </tr>
                            @endif
                        @endforeach
                        @foreach($chart_account as $kewajiban_jangka_panjang)
                            <?php $sum = 0; ?>
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
                                    <td>
                                        {{ number_format(list_transaction($sub->id)) }}
                                        <?php $sum += list_transaction($sub->id); ?>
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                            @endforeach
                            <tr>
                                <td></td>
                                <td style="border-top:1px solid black">Total {{ $kewajiban_jangka_panjang->name }}</td>
                                <td style="border-top:1px solid black">{{ number_format($sum) }}<?php $sum_kewajiban_jangka_panjang = $sum; ?></td>
                            </tr>
                            @endif
                        @endforeach
                        @foreach($chart_account as $equitas)
                            <?php $sum = 0; ?>
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
                                    <td>
                                        {{ number_format(list_transaction($sub->id)) }}
                                        <?php $sum += list_transaction($sub->id); ?>
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                            @endforeach
                            <tr>
                                <td></td>
                                <td style="border-top:1px solid black">Total {{ $equitas->name }}</td>
                                <td style="border-top:1px solid black">{{ number_format($sum) }}<?php $sum_equitas = $sum; ?></td>
                            </tr>
                            @endif
                        @endforeach
                        <tr>
                            <td></td>
                            <td style="border-top:1px solid black">Total Kewajiban dan Equitas</td>
                            <td style="border-top:1px solid black">{{ number_format($sum_kewajiban+$sum_kewajiban_lancar_lainnya+$sum_kewajiban_jangka_panjang+$sum_equitas) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('additional_scripts')
    <script type="text/javascript">
        // $('#btn-submit-neraca').on('click',function(){
        //     var sortYear = document.getElementById('sort_by_year');
        //     if(sortYear.checked){
        //         var year = $('#years').val();
        //         $('#sort_target').text(year);
        //     }
        // });

        $('#btn-submit-neraca-print').on('click',function(){
            var sort_target = $('#sort_target').text();
            $('#cont_sort_target').val(sort_target);
        });

        // $(document).ready(function(){
        //   $('#table-neraca').DataTable({
        //
        //   });
        // });
    </script>
@endsection
