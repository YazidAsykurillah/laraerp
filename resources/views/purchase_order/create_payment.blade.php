@extends('layouts.app')

@section('page_title')
  Create Purchase Invoice Payment
@endsection

@section('page_header')
  <h1>
    Purchase Order
    <small>Create Invoice Payment</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('purchase-order') }}"><i class="fa fa-dashboard"></i> Purchase Order</a></li>
    <li><a href="{{ URL::to('purchase-order/'.$invoice->purchase_order->id.'') }}"><i class="fa fa-dashboard"></i>{{ $invoice->purchase_order->code }}</a></li>
    <li><a href="{{ URL::to('purchase-order-invoice/'.$invoice->id.'') }}"><i class="fa fa-dashboard"></i>{{ $invoice->code }}</a></li>
    <li class="active">Create Payment</li>
  </ol>
@endsection

@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Create Purchase Invoice Payment</h3>
      </div><!-- /.box-header -->
      <div class="box-body">
        <div class="row">
          <div class="col-md-3"><strong>Payment Method</strong></div>
          <div class="col-md-6">{{ $invoice->payment_method->name }} </div>
        </div>
        <p></p>
        <div></div>
        {!! Form::open(['url'=>'storePurchaseInvoicePayment','role'=>'form','class'=>'form-horizontal','id'=>'form-store-invoice-payment']) !!}
          
          <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
            {!! Form::label('amount', 'Amount', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-6">
              {{ Form::text('amount', null,['class'=>'form-control', 'placeholder'=>'Payment amount', 'id'=>'amount']) }}
              @if ($errors->has('amount'))
                <span class="help-block">
                  <strong>{{ $errors->first('amount') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group">
            {!! Form::label('', '', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              <a href="{{ url('purchase-order-invoice/'.$invoice->id.'') }}" class="btn btn-default">
                <i class="fa fa-repeat"></i>&nbsp;Cancel
              </a>&nbsp;
              <input type="hidden" name="purchase_order_invoice_id" value="{{ $invoice->id }}">
              <button type="submit" class="btn btn-info" id="btn-submit-payment">
                <i class="fa fa-save"></i>&nbsp;Submit
              </button>
            </div>
          </div>
        {!! Form::close() !!}
      </div><!-- /.box-body -->
      <div class="box-footer clearfix"></div>
    </div><!-- /.box -->
  </div>
</div>    

@endsection

@section('additional_scripts')
  <!--Auto numeric plugin-->
  {!! Html::script('js/autoNumeric.js') !!}
  <script type="text/javascript">
    $('#amount').autoNumeric('init',{
        aSep:',',
        aDec:'.'
    });
    $('#form-store-invoice-payment').on('submit', function(event){
      $('#btn-submit-payment').prop('disabled', true);
    });
  </script>
@endSection




