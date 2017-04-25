@extends('layouts.app')

@section('page_title')
    Cash Flow
@endsection

@section('page_header')
    <h1>
        Cash Flow
        <small>Cash Flow Search</small>
    </h1>
@endsection

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{ URL::to('cash-flow') }}"><i class="fa fa-dashboard"></i> Cash Flow</a></li>
        <li class="active"><i></i>Index</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        {!! Form::open(['url'=>'cash-flow/search','role'=>'form','class'=>'form-horizontal','id'=>'form-search-cash-flow']) !!}
        <div class="col-lg-12">
            <div class="box" style="box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);border-top:none">
                <div class="box-header with-border">
                    <h3 class="box-title">Cash Flow Search</h3>
                    <a data-toggle="collapse" href="#collapse-cash-flow" title="Click to search cash flow"><i class="fa fa-arrow-down pull-right"></i></a>
                </div>
                <div class="box-body collapse" id="collapse-cash-flow">
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

    @if(isset($date_start) AND isset($date_end))
    <div class="row">
        <div class="col-lg-12">
            <div class="box" style="box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);border-top:none">
                <div class="box-header with-border">
                    <center>
                        <h3 class="box-title">CATRA<small>TEXTILE</small></h3>
                        <h4>ARUS KAS</h4>
                        <h4>
                            DARI TANGGAL&nbsp;{{ $date_start }}&nbsp;SAMPAI&nbsp;TANGGAL&nbsp;{{ $date_end }}
                        </h4>
                    </center>
                    <div class="form-group pull-right">
                        {!! Form::label('','',['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-3">
                            <input type="hidden" name="sort_date_start" id="sort_date_start" value="{{ $date_start }}">
                            <input type="hidden" name="sort_date_end" id="sort_date_end" value="{{ $date_end }}">
                            <button type="submit" class="btn btn-default" id="btn-submit-neraca-print" title="click to print">
                                <i class="fa fa-print"></i>&nbsp;
                            </button>
                        </div>
                    </div>
                </div>
                <div class="box-body">

                </div>
                <div class="box-footer clearfix">

                </div>
            </div>
        </div>
    </div>
    @endif
@endsection
