@extends('layouts.app')

@section('page_title')
    Ledger
@endsection

@section('page_header')
    <h1>
        Ledger
        <small>Ledger List</small>
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
                                <select name="account" class="form-control" id="account">
                                    @foreach($account as $acc)
                                        @if($acc->level==2)
                                        <option value="{{ $acc->id }}">{{ $acc->name}}</option>
                                        @endif
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
                        <a href="{{ url('home') }}" class="btn btn-default">
                          <i class="fa fa-repeat"></i>&nbsp;Cancel
                        </a>&nbsp;
                        <button type="submit" class="btn btn-info" id="btn-submit-ledger">
                          <i class="fa fa-save"></i>&nbsp;Submit
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

    @if(isset($query_select))
    <div class="row">
        <div class="col-lg-12">
            <div class="box" style="box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);border-top:none">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        {{ $query_select->name }}
                    </h3>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Transaction No</th>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>Memo</th>
                                    <th>Debit</th>
                                    <th>Credit</th>
                                    <th>Balance</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $sum_debit_piutang = 0; $sum = 0; ?>
                                @foreach($query_trans as $qt)
                                    <tr>
                                            <td>{{ $qt->source }}</td>
                                            <td>{{ $qt->created_at }}</td>
                                            <td>{{ $qt->description }}</td>
                                            <td>{{ $qt->memo }}</td>
                                            <td>0.00</td>
                                            <td>{{ number_format($qt->amount) }}</td>
                                            <td>{{ number_format($qt->amount) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>

                            </tfoot>
                        </table>
                        <p>Balance : {{ number_format($sum_debit_piutang) }}</p>
                    </div>
                </div>
                <div class="box-footer clearfix">

                </div>
            </div>
        </div>
    </div>
    @endif
@endsection
