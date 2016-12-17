@extends('layouts.app')

@section('page_title')
  Product Units
@endsection

@section('page_header')
  <h1>
    Create Product Unit
    <small>Create product unit</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('unit') }}"><i class="fa fa-dashboard"></i> Product Units</a></li>
    <li class="active"><i></i> Create</li>
  </ol>
@endsection

@section('content')
  {!! Form::model($unit, ['route'=>['unit.update', $unit->id], 'class'=>'form-horizontal','method'=>'put', 'files'=>true]) !!}
  <div class="row">
    <div class="col-md-12">
      <!--BOX Basic Informations-->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Form create product unit</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            {!! Form::label('name', 'Unit Name', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!! Form::text('name',null,['class'=>'form-control', 'placeholder'=>'Name of the unit', 'id'=>'name']) !!}
              @if ($errors->has('name'))
                <span class="help-block">
                  <strong>{{ $errors->first('name') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group">
              {!! Form::label('', '', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              <a href="{{ url('unit') }}" class="btn btn-default">
                <i class="fa fa-repeat"></i>&nbsp;Cancel
              </a>&nbsp;
              <button type="submit" class="btn btn-info" id="btn-submit-unit">
                <i class="fa fa-save"></i>&nbsp;Submit
              </button>
            </div>
          </div>
          
        </div><!-- /.box-body -->
      </div>
      <!--ENDBOX Basic Informations-->
    </div>
  </div>

  {!! Form::close() !!}
@endsection

@section('additional_scripts')
  <script type="text/javascript">
    $('#btn-submit-unit').click(function(){
      $(this).attr('disable', 'disabled');
    })
  </script>
@endsection