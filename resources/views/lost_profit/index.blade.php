@extends('layouts.app')

@section('page_title')
    Lost and Profit
@endsection

@section('page_header')
    <h1>
        Lost&nbsp;&amp;&nbsp;Profit
        <small>Lost&nbsp;&amp;Profit List</small>
    </h1>
@endsection

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{ URL::to('lost-profit') }}"><i class="fa fa-dashboard"></i> Lost&nbsp;&amp;&nbsp;Profit</a></li>
        <li class="active"><i></i>Index</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        {!! Form::open(['url'=>'lost-profit/submit','role'=>'form','class'=>'form-horizontal','id'=>'form-search-neraca']) !!}
        <div class="col-lg-12">
            <div class="box" style="box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);border-top:none">
                <div class="box-header with-border">
                    <h3 class="box-title">Search Period Laba & Rugi</h3>
                    <a data-toggle="collapse" href="#collapse-lost-profit" title="Click to search lost and profit"><i class="fa fa-arrow-down pull-right"></i></a>
                </div>
                <div class="box-body collapse" id="collapse-lost-profit">
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
        <div class="box" style="box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);border-top:none">
            <div class="box-header with-border">
                {!! Form::open(['url'=>'lost-profit.lost_profit_print','role'=>'form','class'=>'form-horizontal','id'=>'form-search-neraca','files'=>true]) !!}
                <center>
                    <h3 class="box-title">CATRA<small>TEXTILE</small></h3>
                    <h4>LABA RUGI</h4>
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
                <center>
                    <table class="table table-striped table-hover" id="table-lost-profit" style="width:80%">
                        <thead>
                            <tr>
                                <th style="width:30%">No.Akun</th>
                                <th style="width:40%">Deskripsi</th>
                                <th style="width:40%">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $sum_pendapatan_operasional = 0;
                                $sum_harga_pokok_penjualan = 0;
                                $sum_beban_operasi = 0;
                            ?>
                            @foreach($chart_account as $pendapatan)
                                <?php $sum = 0; ?>
                                @if($pendapatan->id == 61)
                                <tr>
                                    <td></td>
                                    <td><b>{{ $pendapatan->name}}</b></td>
                                    <td></td>
                                </tr>
                                @foreach(list_parent('61') as $as)
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
                                            @if(list_transaction_pendapatan($sub->id,$year,'y','') == '')
                                            <td>0,00</td>
                                            @else
                                            <td>
                                                {{ number_format(list_transaction_pendapatan($sub->id,$year,'y','')) }}
                                                <?php $sum += list_transaction_pendapatan($sub->id,$year,'y',''); ?>
                                            </td>
                                            @endif
                                        @elseif(isset($month_in))
                                            @if(list_transaction_pendapatan($sub->id,$year_start.'-'.$month_start.'-01 00:00:00','m',$year_end.'-'.$month_end.'-31 23:59:59') == '')
                                            <td>0,00</td>
                                            @else
                                            <td>
                                                {{ number_format(list_transaction_pendapatan($sub->id,$year_start.'-'.$month_start.'-01 00:00:00','m',$year_end.'-'.$month_end.'-31 23:59:59')) }}
                                                <?php $sum += list_transaction_pendapatan($sub->id,$year_start.'-'.$month_start.'-01 00:00:00','m',$year_end.'-'.$month_end.'-31 23:59:59'); ?>
                                            </td>
                                            @endif
                                        @else
                                            @if(list_transaction_pendapatan($sub->id,date('Y'),'y','') == '')
                                            <td>0,00</td>
                                            @else
                                            <td>
                                                {{ number_format(list_transaction_pendapatan($sub->id,date('Y'),'y','')) }}
                                                <?php $sum += list_transaction_pendapatan($sub->id,date('Y'),'y',''); ?>
                                            </td>
                                            @endif
                                        @endif
                                    </tr>
                                    @endforeach
                                @endforeach
                                <tr>
                                    <td></td>
                                    <td style="border-top:1px solid black">Total {{ $pendapatan->name }}</td>
                                    <td style="border-top:1px solid black">{{ number_format($sum)}}<?php $sum_pendapatan_operasional = $sum; ?></td>
                                </tr>
                                @endif
                            @endforeach
                            @foreach($chart_account as $harga_pokok_penjualan)
                                <?php $sum = 0; ?>
                                @if($harga_pokok_penjualan->id == 63)
                                <tr>
                                    <td></td>
                                    <td><b>{{ $harga_pokok_penjualan->name}}</b></td>
                                    <td></td>
                                </tr>
                                @foreach(list_parent('63') as $as)
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
                                            @if(list_transaction_harga_pokok_penjualan($sub->id,$year,'y','') == '')
                                            <td>0,00</td>
                                            @else
                                            <td>
                                                {{ number_format(list_transaction_harga_pokok_penjualan($sub->id,$year,'y','')) }}
                                                <?php $sum += list_transaction_harga_pokok_penjualan($sub->id,$year,'y',''); ?>
                                            </td>
                                            @endif
                                        @elseif(isset($month_in))
                                            @if(list_transaction_harga_pokok_penjualan($sub->id,$year_start.'-'.$month_start.'-01 00:00:00','m',$year_end.'-'.$month_end.'-31 23:59:59') == '')
                                            <td>0,00</td>
                                            @else
                                            <td>
                                                {{ number_format(list_transaction_harga_pokok_penjualan($sub->id,$year_start.'-'.$month_start.'-01 00:00:00','m',$year_end.'-'.$month_end.'-31 23:59:59')) }}
                                                <?php $sum += list_transaction_harga_pokok_penjualan($sub->id,$year_start.'-'.$month_start.'-01 00:00:00','m',$year_end.'-'.$month_end.'-31 23:59:59'); ?>
                                            </td>
                                            @endif
                                        @else
                                            @if(list_transaction_harga_pokok_penjualan($sub->id,date('Y'),'y','') == '')
                                            <td>0,00</td>
                                            @else
                                            <td>
                                                {{ number_format(list_transaction_harga_pokok_penjualan($sub->id,date('Y'),'y','')) }}
                                                <?php $sum += list_transaction_harga_pokok_penjualan($sub->id,date('Y'),'y',''); ?>
                                            </td>
                                            @endif
                                        @endif
                                    </tr>
                                    @endforeach
                                @endforeach
                                <tr>
                                    <td></td>
                                    <td style="border-top:1px solid black">Total {{ $harga_pokok_penjualan->name }}</td>
                                    <td style="border-top:1px solid black">{{ number_format($sum) }}<?php $sum_harga_pokok_penjualan = $sum; ?></td>
                                </tr>
                                @endif
                            @endforeach
                            @foreach($chart_account as $beban_operasi)
                                <?php $sum = 0; ?>
                                @if($beban_operasi->id == 64)
                                <tr>
                                    <td></td>
                                    <td><b>{{ $beban_operasi->name}}</b></td>
                                    <td></td>
                                </tr>
                                @foreach(list_parent('64') as $as)
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
                                            @if(list_transaction_pendapatan($sub->id,$year,'y','') == '')
                                            <td>0,00</td>
                                            @else
                                            <td>
                                                {{ number_format(list_transaction_pendapatan($sub->id,$year,'y','')) }}
                                                <?php $sum += list_transaction_pendapatan($sub->id,$year,'y',''); ?>
                                            </td>
                                            @endif
                                        @elseif(isset($month_in))
                                            @if(list_transaction_pendapatan($sub->id,$year_start.'-'.$month_start.'-01 00:00:00','m',$year_end.'-'.$month_end.'-31 23:59:59') == '')
                                            <td>0,00</td>
                                            @else
                                            <td>
                                                {{ number_format(list_transaction_pendapatan($sub->id,$year_start.'-'.$month_start.'-01 00:00:00','m',$year_end.'-'.$month_end.'-31 23:59:59')) }}
                                                <?php $sum += list_transaction_pendapatan($sub->id,$year_start.'-'.$month_start.'-01 00:00:00','m',$year_end.'-'.$month_end.'-31 23:59:59'); ?>
                                            </td>
                                            @endif
                                        @else
                                            @if(list_transaction_pendapatan($sub->id,date('Y'),'y','') == '')
                                            <td>0,00</td>
                                            @else
                                            <td>
                                                {{ number_format(list_transaction_pendapatan($sub->id,date('Y'),'y','')) }}
                                                <?php $sum += list_transaction_pendapatan($sub->id,date('Y'),'y',''); ?>
                                            </td>
                                            @endif
                                        @endif
                                    </tr>
                                    @endforeach
                                @endforeach
                                <tr>
                                    <td></td>
                                    <td style="border-top:1px solid black">Total {{ $beban_operasi->name }}</td>
                                    <td style="border-top:1px solid black">{{ number_format($sum) }}<?php $sum_beban_operasi = $sum; ?></td>
                                </tr>
                                @endif
                            @endforeach
                                <tr>
                                    <td></td>
                                    <td style="border-top:1px solid black">Total Pendapatan</td>
                                    <td style="border-top:1px solid black;border-bottom:1px solid black">{{ number_format($sum_pendapatan_operasional+$sum_harga_pokok_penjualan+$sum_beban_operasi) }}</td>
                                </tr>

                            <?php
                                $sum_pendapatan_lainnya = 0;
                                $sum_beban_lainnya = 0;
                            ?>
                            @foreach($chart_account as $pendapatan_lainnya)
                                <?php $sum = 0; ?>
                                @if($pendapatan_lainnya->id == 62)
                                <tr>
                                    <td></td>
                                    <td><b>{{ $pendapatan_lainnya->name}}</b></td>
                                    <td></td>
                                </tr>
                                @foreach(list_parent('62') as $as)
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
                                            @if(list_transaction_pendapatan($sub->id,$year,'y','') == '')
                                            <td>0,00</td>
                                            @else
                                            <td>
                                                {{ number_format(list_transaction_pendapatan($sub->id,$year,'y','')) }}
                                                <?php $sum += list_transaction_pendapatan($sub->id,$year,'y',''); ?>
                                            </td>
                                            @endif
                                        @elseif(isset($month_in))
                                            @if(list_transaction_pendapatan($sub->id,$year_start.'-'.$month_start.'-01 00:00:00','m',$year_end.'-'.$month_end.'-31 23:59:59') == '')
                                            <td>0,00</td>
                                            @else
                                            <td>
                                                {{ number_format(list_transaction_pendapatan($sub->id,$year_start.'-'.$month_start.'-01 00:00:00','m',$year_end.'-'.$month_end.'-31 23:59:59')) }}
                                                <?php $sum += list_transaction_pendapatan($sub->id,$year_start.'-'.$month_start.'-01 00:00:00','m',$year_end.'-'.$month_end.'-31 23:59:59'); ?>
                                            </td>
                                            @endif
                                        @else
                                            @if(list_transaction_pendapatan($sub->id,date('Y'),'y','') == '')
                                            <td>0,00</td>
                                            @else
                                            <td>
                                                {{ number_format(list_transaction_pendapatan($sub->id,date('Y'),'y','')) }}
                                                <?php $sum += list_transaction_pendapatan($sub->id,date('Y'),'y',''); ?>
                                            </td>
                                            @endif
                                        @endif
                                    </tr>
                                    @endforeach
                                @endforeach
                                <tr>
                                    <td></td>
                                    <td style="border-top:1px solid black">Total {{ $pendapatan_lainnya->name }}</td>
                                    <td style="border-top:1px solid black">{{ number_format($sum) }}<?php $sum_pendapatan_lainnya = $sum; ?></td>
                                </tr>
                                @endif
                            @endforeach
                            @foreach($chart_account as $beban_lainnya)
                                <?php $sum = 0; ?>
                                @if($beban_lainnya->id == 65)
                                <tr>
                                    <td></td>
                                    <td><b>{{ $beban_lainnya->name}}</b></td>
                                    <td></td>
                                </tr>
                                @foreach(list_parent('65') as $as)
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
                                            @if(list_transaction_pendapatan($sub->id,$year,'y','') == '')
                                            <td>0,00</td>
                                            @else
                                            <td>
                                                {{ number_format(list_transaction_pendapatan($sub->id,$year,'y','')) }}
                                                <?php $sum += list_transaction_pendapatan($sub->id,$year,'y',''); ?>
                                            </td>
                                            @endif
                                        @elseif(isset($month_in))
                                            @if(list_transaction_pendapatan($sub->id,$year_start.'-'.$month_start.'-01 00:00:00','m',$year_end.'-'.$month_end.'-31 23:59:59') == '')
                                            <td>0,00</td>
                                            @else
                                            <td>
                                                {{ number_format(list_transaction_pendapatan($sub->id,$year_start.'-'.$month_start.'-01 00:00:00','m',$year_end.'-'.$month_end.'-31 23:59:59')) }}
                                                <?php $sum += list_transaction_pendapatan($sub->id,$year_start.'-'.$month_start.'-01 00:00:00','m',$year_end.'-'.$month_end.'-31 23:59:59'); ?>
                                            </td>
                                            @endif
                                        @else
                                            @if(list_transaction_pendapatan($sub->id,date('Y'),'y','') == '')
                                            <td>0,00</td>
                                            @else
                                            <td>
                                                {{ number_format(list_transaction_pendapatan($sub->id,date('Y'),'y','')) }}
                                                <?php $sum += list_transaction_pendapatan($sub->id,date('Y'),'y',''); ?>
                                            </td>
                                            @endif
                                        @endif
                                    </tr>
                                    @endforeach
                                @endforeach
                                <tr>
                                    <td></td>
                                    <td style="border-top:1px solid black">Total {{ $beban_lainnya->name }}</td>
                                    <td style="border-top:1px solid black">{{ number_format($sum) }}<?php $sum_beban_lainnya = $sum; ?></td>
                                </tr>
                                @endif
                            @endforeach
                            <tr>
                                <td></td>
                                <td style="border-top:1px solid black">Total Pendapatan Lainnya dan Beban Lainnya</td>
                                <td style="border-top:1px solid black;border-bottom:1px solid black">{{ number_format($sum_pendapatan_lainnya+$sum_beban_lainnya) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </center>
            </div>
        </div>
    </div>
@endsection
