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
    {!! Form::open(['url'=>'neraca.neraca_montly_print','role'=>'form','class'=>'form-horizontal','id'=>'form-search-neraca','files'=>true]) !!}
    <div class="row">
        <div class="col-lg-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Select Period Neraca</h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <div class="col-sm-offset-1 col-sm-11">
                            <div class="checkbox">
                                <label><input type="checkbox" id="sort_by_year" name="sort_by_year" value=""> Sort by year</label>
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
                            <div class="checkbox">
                                <label><input type="checkbox" id="sort_by_month_start" name="sort_by_month_start" value=""> Sort by month</label>
                                <input type="hidden" name="sort_by_month_year_start" id="sort_by_month_year_start" value="">
                                <input type="hidden" id="sort_by_month_end" name="sort_by_month_end" value="">
                                <input type="hidden" name="sort_by_month_year_end" id="sort_by_month_year_end" value="">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('months','Start',['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-2">
                            <select class="form-control" name="list_months_start" id="list_months_start">
                                <option>Select Month</option>
                                <option value="January">January</option>
                                <option value="February">February</option>
                                <option value="March">March</option>
                                <option value="April">April</option>
                                <option value="May">May</option>
                                <option value="June">June</option>
                                <option value="July">July</option>
                                <option value="August">August</option>
                                <option value="September">September</option>
                                <option value="October">October</option>
                                <option value="November">November</option>
                                <option value="December">December</option>
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
                                <option value="January">January</option>
                                <option value="February">February</option>
                                <option value="March">March</option>
                                <option value="April">April</option>
                                <option value="May">May</option>
                                <option value="June">June</option>
                                <option value="July">July</option>
                                <option value="August">August</option>
                                <option value="September">September</option>
                                <option value="October">October</option>
                                <option value="November">November</option>
                                <option value="December">December</option>
                            </select>
                        </div>
                        <div class="col-sm-2">
                            {!! Form::number('list_years_end','2017',['class'=>'form-control','id'=>'list_years_end']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('','',['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-3">
                            <button type="submit" class="btn btn-info" id="btn-submit-neraca">
                                <i class="fa fa-print"></i>&nbsp;Print
                            </button>
                        </div>
                    </div>
                </div>
                <div class="box-footer">

                </div>
            </box>
        </div>
    </div>
    {!! Form::close() !!}
@endsection

@section('additional_scripts')
    <script type="text/javascript">
        $('#btn-submit-neraca').on('click',function(){
            var sortMonth = document.getElementById('sort_by_month_start');
            if(sortMonth.checked){
                $('#sort_by_month_start').val($('#list_months_start').val());
                $('#sort_by_month_year_start').val($('#list_years_start').val());
                $('#sort_by_month_end').val($('#list_months_end').val());
                $('#sort_by_month_year_end').val($('#list_years_end').val());
                // alert($('#year_selected').val());
            }
        });
    </script>
@endsection
