@extends('layouts.app')

@section('page_title')
    Cashs
@endsection

@section('page_header')
    <h1>
        Add New Cash
        <small>Add New Cash Page</small>
    </h1>
@endsection

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{ URL::to('cash') }}"><i class="fa fa-dashboard"></i> Cash</a></li>
        <li class="active"><i></i>Create</li>
    </ol>
@endsection

@section('content')
    {!! Form::open(['route'=>'cash.store','role'=>'form','class'=>'form-horizontal','id'=>'form-create-cash','files'=>true]) !!}
        <div class="row">
            <div class="col-lg-8">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Create New Cash</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="form-group{{ $errors->has('code') ? 'has-error' : '' }}">
                            {!! Form::label('code','Code',['class'=>'col-sm-3 control-label']) !!}
                            <div class="col-sm-9">
                                {!! Form::text('code',null,['class'=>'form-control','placeholder'=>'Code of the cash','id'=>'code']) !!}
                                @if($errors->has('code'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('code') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('name','Name',['class'=>'col-sm-3 control-label']) !!}
                            <div class="col-sm-9">
                                {!! Form::text('name',null,['class'=>'form-control','placeholder'=>'Name of the cash','id'=>'name']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('value','Value',['class'=>'col-sm-3 control-label']) !!}
                            <div class="col-sm-9">
                                {!! Form::text('value',null,['class'=>'form-control','placeholder'=>'Initial value of the cash','id'=>'value']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('','',['class'=>'col-sm-3 control-label']) !!}
                            <div class="col-sm-9">
                                <a href="{{ url('cash') }}" class="btn btn-default">
                                    <i class="fa fa-repeat"></i>&nbsp;Cancel
                                </a>
                                <button type="submit" class="btn btn-info" id="btn-submit-cash">
                                    <i class="fa fa-save"></i>&nbsp;Submit
                                </button>
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                    <div class="box-footer clearfix">

                    </div> <!-- /.box-footer -->
                </div>
            </div>
        </div>
    {!! Form::close() !!}
@endsection

@section('additional_scripts')
    {!! Html::script('js/autoNumeric.js') !!}
    <script type="text/javascript">
        $('#value').autoNumeric('init',{
            aSep:',',
            aDec:'.'
        });
    </script>
@endsection