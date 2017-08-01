@extends('layouts.app')

@section('page_title')
    Ledger
@endsection

@section('page_header')
    <h1>
        Ledger
        <small>Ledger Search</small>
    </h1>
@endsection

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{ URL::to('ledger') }}"><i class="fa fa-dashboard"></i> Ledger</a></li>
        <li class="active"><i></i>Index</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        {!! Form::open(['url'=>'ledger/search','role'=>'form','class'=>'form-horizontal','id'=>'form-search-ledger']) !!}
        <div class="col-lg-12">
            <div class="box" style="box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);border-top:none">
                <div class="box-header with-border">
                    <h3 class="box-title">Ledger Search</h3>
                    <a data-toggle="collapse" href="#collapse-ledger" title="Click to search ledger"><i class="fa fa-arrow-down pull-right"></i></a>
                </div>
                <div class="box-body collapse" id="collapse-ledger">
                    <div class="form-group">
                        {!! Form::label('account','Account',['class'=>'col-sm-2 control-label']) !!}
                            <div class="col-sm-6">
                                <select name="account" class="form-control" id="account" style="width:300px">
                                    @foreach($account as $acc)
                                        <option value="{{ $acc->id }}">{{ $acc->account_number }}&nbsp;{{ $acc->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('date_start','Date',['class'=>'col-sm-2 control-label']) !!}
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <span class="input-group-addon">Start</span>
                                {!! Form::date('date_start',\Carbon\Carbon::now(),['class'=>'form-control','placeholder'=>'Report of Type','id'=>'date_start']) !!}
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <span class="input-group-addon">End</span>
                                {!! Form::date('date_end',\Carbon\Carbon::now()->format('Y-m-d'),['class'=>'form-control','placeholder'=>'Report of Type','id'=>'date_end']) !!}
                                </div>
                            </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('', '', ['class'=>'col-sm-2 control-label']) !!}
                      <div class="col-sm-6">
                        <button type="submit" class="btn btn-info" id="btn-submit-ledger">
                          <i class="fa fa-search"></i>&nbsp;Search
                        </button>
                      </div>
                    </div>
                </div>
                <div class="box-footer clearfix">

                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>

    @if(isset($query_select) AND isset($date_start) AND isset($date_end))
    <div class="row">
        <div class="col-lg-12">
            <div class="box" style="box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);border-top:none">
                <div class="box-header with-border">
                    <center>
                          <h2>PT.CATRA TEXTILE RAYA</h2>
                          <h5>Green Sedayu Bizpark DM 5 No.12 Jl.Daan Mogot KM 18 Kalideres - Jakarta Barat</h5>
                          <h5>Telp. 021-22522283, 021-22522334</h5>
                    </center>
                    <hr>
                        <label class="label label-info">LEDGER</label>
                        <label class="label label-info">{{ $query_select->name }}</label>
                        <label class="label label-info">
                        @if(isset($date_start) and isset($date_end))
                          <?php
                            $date_start_f = date_create($date_start);
                            $date_end_f = date_create($date_end);
                          ?>
                          {{ date_format($date_start_f,'d-m-Y') }}&nbsp;s/d&nbsp;{{ date_format($date_end_f,'d-m-Y') }}
                        @endif
                        </label>
                    {!! Form::open(['url'=>'ledger.ledger_print','role'=>'form','class'=>'form-horizontal','id'=>'form-search-ledger','files'=>true]) !!}
                    <div class="form-group pull-right">
                        {!! Form::label('','',['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-3">
                            <input type="hidden" name="sort_target_account" id="sort_target_year" value="{{ $query_select->id }}">
                            <input type="hidden" name="sort_target_date_start" id="sort_target_data_start" value="{{ $date_start }}">
                            <input type="hidden" name="sort_target_date_end" id="sort_target_data_end" value="{{ $date_end }}">
                            <button type="submit" class="btn btn-default" id="btn-submit-neraca-print" title="click to print">
                                <i class="fa fa-print"></i>&nbsp;
                            </button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
                <div class="box-body">
                    <div class="table-responsive" style="max-height:500px">
                      @if(count($query_trans) > 0)
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr style="background-color:#3c8dbc;color:white">
                                    <th>Transaction No</th>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>Memo</th>
                                    <th>Debit</th>
                                    <th>Credit</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $sum_debit = 0; $sum_credit = 0; ?>
                                @foreach($query_trans as $qt)
                                    <tr>
                                            <td>TS{{ $qt->id}}</td>
                                            <td>
                                                <?php $date_qt = date_create($qt->created_at); ?>
                                                {{ date_format($date_qt,'d/m/Y') }}
                                            </td>
                                            @if(is_numeric($qt->description))
                                            <td></td>
                                            @else
                                            <td>{{ $qt->description }}</td>
                                            @endif
                                            <td>{{ $qt->memo }}</td>
                                                @if($qt->type == 'masuk' AND $qt->memo != 'AKUMULASI PENYUSUTAN')
                                                  <td>
                                                    {{ number_format($qt->amount) }}
                                                    <?php $sum_debit += $qt->amount; ?>
                                                  </td>
                                                  <td>0.00</td>
                                                @elseif($qt->type == 'keluar')
                                                  <td>0.00</td>
                                                  <td>
                                                    {{ number_format($qt->amount) }}
                                                    <?php $sum_credit += $qt->amount; ?>
                                                  </td>
                                                @elseif($qt->memo = 'AKUMULASI PENYUSUTAN')
                                                  <td>
                                                    <?php
                                                      $date1 = date_create($qt->source);
                                                      $date_1_1 = date_format($date1,'Y');
                                                      $date2 = date_create($date_end);
                                                      $date_2_2 = date_format($date2,'Y');
                                                      $diff = ($date_2_2-$date_1_1)+1;
                                                     ?>
                                                    {{ number_format($qt->amount*$diff) }}
                                                    <?php $sum_debit += $qt->amount*$diff; ?>
                                                  </td>
                                                  <td>0.00</td>

                                                @endif
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>

                            </tfoot>
                        </table>
                        <p>Balance : {{ number_format($sum_debit-$sum_credit) }}</p>
                        @else
                        <center>
                          <p>Data not available</p>
                        </center>
                        @endif
                    </div>
                </div>
                <div class="box-footer clearfix">

                </div>
            </div>
        </div>
    </div>
    @endif
@endsection

@section('additional_scripts')
    {!! Html::script('js/select2/select2.js') !!}
    {!! Html::script('js/select2/select2.min.js') !!}
    {!! Html::style('css/select2/select2.css') !!}
    <script>
        $("#account").select2();
    </script>
@endsection
