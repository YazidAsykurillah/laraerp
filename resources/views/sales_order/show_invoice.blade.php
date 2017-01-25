@extends('layouts.app')

@section('page_title')
  Sales Order Invoice Detail
@endsection

@section('page_header')
  <h1>
    Sales Order 
    <small> Invoice Detail </small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('sales-order') }}"><i class="fa fa-dashboard"></i> Sales Order</a></li>
    <li><a href="{{ URL::to('sales-order/'.$invoice->sales_order->id.'') }}"><i class="fa fa-dashboard"></i>{{ $invoice->sales_order->code }}</a></li>
    <li class="active">{{ $invoice->code }}</li>
  </ol>
@endsection

@section('content')

<div class="row">
  <div class="col-lg-12">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">{{ $invoice->code }}<small></small></h3>
        <div class="pull-right">
          <a href="{{ url('sales-order-invoice/'.$invoice->id.'/payment/create') }}" class="btn btn-default btn-xs" title="Create payment for this invoice">
            <i class='fa fa-money'></i>&nbsp;Create Payment
          </a>
        </div>
      </div><!-- /.box-header -->
      <div class="box-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="table-selected-products">
            <thead>
              <tr>
                <th style="">Product Code</th>
                <th style="">Product Name</th>
                <th style="text-align:center">Quantity</th>
                <th style="">Unit</th>
                <th style="text-align:right">Price / Unit</th>
              </tr>
            </thead>
            <tbody>
              @if($invoice->sales_order->products->count() > 0)
                @foreach($invoice->sales_order->products as $product)
                <tr>
                  <td>{{ $product->code }}</td>
                  <td>{{ $product->name }}</td>
                  <td align="center">{{ $product->pivot->quantity }}</td>
                  <td>{{ $product->unit->name }}</td>
                  <td align="right">{{ number_format($product->pivot->price) }}</td>
                </tr>
                @endforeach
                <tr>
                  <td colspan="5"></td>
                </tr>
                <tr>
                  <td colspan="3"></td>
                  <td><strong>Bill Price</strong></td>
                  <td align="right"><strong>{{ number_format($invoice->bill_price) }}</strong></td>
                </tr>
              @else
                <tr>
                  <td colspan="5">There are no product</td>
                </tr>
              @endif
            </tbody>
            <tfoot>

            </tfoot>
          </table>
        </div>
        <table class="table">
          <tr>
            <td style="width:30%;"><strong>Invoice Date</strong></td>
            <td>{{ $invoice->created_at }}</td>
          </tr>
          <tr>
            <td style="width:30%;"><strong>Customer Invoice Term</strong></td>
            <td>{{ $invoice->sales_order->customer->invoice_term->name }}</td>
          </tr>
          <tr>
            <td style="width:30%;"><strong>Due Date</strong></td>
            <td>{{ $invoice->due_date }}</td>
          </tr>
          <tr>
            <td style="width:30%;"><strong>Paid Price</strong></td>
            <td>{{ number_format($invoice->paid_price) }}</td>
          </tr>
          <tr>
            <td style="width:30%;"><strong>Status</strong></td>
            <td>{{ ucwords($invoice->status) }}</td>
          </tr>
          
          <tr>
            <td style="width:30%;"><strong>Notes</strong></td>
            <td>{{ $invoice->notes }}</td>
          </tr>
        </table>
      </div><!-- /.box-body -->
      <div class="box-footer clearfix"></div>
    </div><!-- /.box -->
  </div>
</div>    

@endsection




