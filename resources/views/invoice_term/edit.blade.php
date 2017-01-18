@extends('layouts.app')

@section('page_title')
  Edit Invoice Term
@endsection

@section('page_header')
  <h1>
    Edit Invoice Term
    <small>Edit the invoice term</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('invoice-term') }}"><i class="fa fa-dashboard"></i> invoice-terms</a></li>
    <li class="active"><i></i>Edit</li>
  </ol>
@endsection

@section('content')
  {!! Form::model($invoice_term,['route'=>['invoice-term.update', $invoice_term], 'class'=>'form-horizontal', 'method'=>'put']) !!}
  <div class="row">
    <div class="col-lg-7">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Create new invoice-term</h3>
          
        </div><!-- /.box-header -->
        <div class="box-body">
          <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            {!! Form::label('name', 'Period', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!! Form::text('name',null,['class'=>'form-control', 'placeholder'=>'Period of the invoice term', 'id'=>'name']) !!}
              @if ($errors->has('name'))
                <span class="help-block">
                  <strong>{{ $errors->first('name') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group{{ $errors->has('day_many') ? ' has-error' : '' }}">
            {!! Form::label('day_many', 'Day Many', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!! Form::text('day_many',null,['class'=>'form-control', 'placeholder'=>'The day many count in defined period', 'id'=>'day_many']) !!}
              @if ($errors->has('day_many'))
                <span class="help-block">
                  <strong>{{ $errors->first('day_many') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group">
              {!! Form::label('', '', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              <a href="{{ url('invoice-term') }}" class="btn btn-default">
                <i class="fa fa-repeat"></i>&nbsp;Cancel
              </a>&nbsp;
              <input type="hidden" name="invoice_term_id" value="{{ $invoice_term->id }}" />
              <button type="submit" class="btn btn-info" id="btn-submit-invoice-term">
                <i class="fa fa-save"></i>&nbsp;Submit
              </button>
            </div>
          </div>
        </div><!-- /.box-body -->
        <div class="box-footer clearfix">
          
        </div>
      </div><!-- /.box -->
    </div>
  </div>
  {!! Form::close() !!}

@endsection


@section('additional_scripts')

  <script type="text/javascript">
    $('#form-create-invoice-term').on('submit', function(){
      $('#btn-submit-invoice-term').prop('disabled', true);
    });
  </script>
  
@endsection