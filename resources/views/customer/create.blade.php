@extends('layouts.app')

@section('page_title')
  Create Customer
@endsection

@section('page_header')
  <h1>
    Create Customer
    <small>Create new customer</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('customer') }}"><i class="fa fa-dashboard"></i> Customers</a></li>
    <li class="active"><i></i>Create</li>
  </ol>
@endsection

@section('content')
  {!! Form::open(['route'=>'customer.store','role'=>'form','class'=>'form-horizontal','id'=>'form-create-customer','files'=>true]) !!}
  <div class="row">
    <div class="col-lg-8">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Create new customer</h3>
          
        </div><!-- /.box-header -->
        <div class="box-body">
          <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            {!! Form::label('name', 'Name', ['class'=>'col-sm-3 control-label']) !!}
            <div class="col-sm-9">
              {!! Form::text('name',null,['class'=>'form-control', 'placeholder'=>'Name of the customer', 'id'=>'name']) !!}
              @if ($errors->has('name'))
                <span class="help-block">
                  <strong>{{ $errors->first('name') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group{{ $errors->has('phone_number') ? ' has-error' : '' }}">
            {!! Form::label('phone_number', 'Phone Number', ['class'=>'col-sm-3 control-label']) !!}
            <div class="col-sm-9">
              {!! Form::text('phone_number',null,['class'=>'form-control', 'placeholder'=>'Primary phone of the customer', 'id'=>'phone_number']) !!}
              @if ($errors->has('phone_number'))
                <span class="help-block">
                  <strong>{{ $errors->first('phone_number') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
            {!! Form::label('address', 'Address', ['class'=>'col-sm-3 control-label']) !!}
            <div class="col-sm-9">
              {!! Form::textarea('address',null,['class'=>'form-control', 'placeholder'=>'Address of the customer', 'id'=>'address']) !!}
              @if ($errors->has('address'))
                <span class="help-block">
                  <strong>{{ $errors->first('address') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group{{ $errors->has('invoice_term_id') ? ' has-error' : '' }}">
            {!! Form::label('invoice_term_id', 'Unit', ['class'=>'col-sm-3 control-label']) !!}
            <div class="col-sm-9">
              {{ Form::select('invoice_term_id', $invoice_terms, null, ['class'=>'form-control', 'placeholder'=>'Select Term', 'id'=>'invoice_term_id']) }}
              @if ($errors->has('invoice_term_id'))
                <span class="help-block">
                  <strong>{{ $errors->first('invoice_term_id') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group">
              {!! Form::label('', '', ['class'=>'col-sm-3 control-label']) !!}
            <div class="col-sm-9">
              <a href="{{ url('customer') }}" class="btn btn-default">
                <i class="fa fa-repeat"></i>&nbsp;Cancel
              </a>&nbsp;
              <button type="submit" class="btn btn-info" id="btn-submit-customer">
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
    $('#form-create-customer').on('submit', function(){
      $('#btn-submit-customer').prop('disabled', true);
    });
  </script>
  
@endsection