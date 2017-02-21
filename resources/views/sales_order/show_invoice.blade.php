@extends('layouts.app')

@section('page_title')
  Sales Order Invoice Detail
@endsection

@section('page_header')
  <h1>
    Sales Order Invoice Detail
    <small> Invoice Detail </small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('sales-order') }}"><i class="fa fa-dashboard"></i> Sales Order</a></li>
    <li><a href="{{ URL::to('sales-order/'.$sales_order_invoice->sales_order->id.'') }}"><i class="fa fa-dashboard"></i>{{ $sales_order_invoice->sales_order->code }}</a></li>
    <li class="active">{{ $sales_order_invoice->code }}</li>
  </ol>
@endsection

@section('content')

<div class="row">
  <div class="col-lg-12">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">{{ $sales_order_invoice->code }}<small></small></h3>
        <div class="pull-right">
          <!--Show button create payment only when invoice status is NOT completed yet-->
          @if($sales_order_invoice->status != "completed")
          <a href="{{ url('sales-order-invoice/'.$sales_order_invoice->id.'/payment/create') }}" class="btn btn-default btn-xs" title="Create payment for this invoice">
            <i class='fa fa-money'></i>&nbsp;Create Payment
          </a>
          @endif
        </div>
      </div><!-- /.box-header -->
      <div class="box-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="table-selected-products">
            <thead>
              <tr>
                <th style="">Product Name</th>
                <th style="">Quantity</th>
                <th style="">Unit</th>
                <th style="">Price</th>
              </tr>
            </thead>
            <tbody>
              @if($sales_order->products->count() > 0)
                @foreach($sales_order->products as $product)
                <tr>
                  <td>
                    {{ $product->name }}
                  </td>
                  <td>
                    {{ $product->pivot->quantity }}
                  </td>
                  <td>
                    {{ $product->unit->name }}
                  </td>
                  <td>
                    {{ number_format($product->pivot->price) }}
                  </td>
                </tr>
                @endforeach
              @else
                <tr>
                  <td>There are no product</td>
                </tr>
              @endif
            </tbody>
        </table>
        <br/>
        <table class="table">
          <tr>
            <td style="width:30%;"><strong>Bill Price</strong></td>
            <td>{{ number_format($sales_order_invoice->bill_price) }}</td>
          </tr>
          <tr>
            <td style="width:30%;"><strong>Payment Method</strong></td>
            
          </tr>
          <tr>
            <td style="width:30%;"><strong>Paid Price</strong></td>
            <td>{{ number_format($sales_order_invoice->paid_price) }}</td>
          </tr>
          <tr>
            <td style="width:30%;"><strong>Status</strong></td>
            <td>
              {{ strtoupper($sales_order_invoice->status) }}
              @if($sales_order_invoice->status =='uncompleted')
                <p></p>
                <button id="btn-pay-invoice" class="btn btn-xs btn-primary" title="Click to pay this invoice" data-id="{{ $sales_order_invoice->id}}" data-text="{{ $sales_order_invoice->code }}">
                  <i class="fa fa-money"></i>&nbsp;Complete
                </button>
              @endif
            </td>
          </tr>
          <tr>
            <td style="width:30%;"><strong>Notes</strong></td>
            <td>{{ $sales_order_invoice->notes }}</td>
          </tr>
        </table>
      </div><!-- /.box-body -->
      <div class="box-footer clearfix"></div>
    </div><!-- /.box -->
  </div>
</div>
</div>

<!--Modal Complete invoice-->
  <!-- <div class="modal fade" id="modal-complete-invoice" tabindex="-1" role="dialog" aria-labelledby="modal-complete-invoiceLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'completeSalesInvoice', 'method'=>'post']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-complete-invoiceLabel">Complete Invoice confirmation</h4>
        </div>
        <div class="modal-body">
          The invoice's status will be changed to completed&nbsp;
          <br/>
          <p class="text text-danger">
            <i class="fa fa-info-circle"></i>&nbsp;This process can not be reverted
          </p>
          <input type="hidden" id="sales_order_invoice_id" name="sales_order_invoice_id" value="{{ $sales_order_invoice->id }}">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-success">Complete</button>
        </div>
      {!! Form::close() !!}
      </div>
    </div>
  </div> -->
<!--ENDModal Complete invoice-->
@endsection

@section('additional_scripts')
  <script type="text/javascript">
    $('#btn-complete-invoice').on('click', function(){
      $('#modal-complete-invoice').modal('show');
    });
  </script>
@endsection
