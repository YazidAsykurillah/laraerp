@extends('layouts.app')

@section('page_title')
  Purchase Order Invoice
@endsection

@section('page_header')
  <h1>
    Purchase Order Invoice
    <small>Purchase order invoice detail</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('purchase-order/') }}"><i class="fa fa-dashboard"></i> Purchase Orders</a></li>
    <li><a href="{{ URL::to('purchase-order/'.$purchase_order->id.'') }}"><i class="fa fa-dashboard"></i> {{ $purchase_order->code }}</a></li>
    <li><a href="{{ URL::to('purchase-order-invoice') }}"><i class="fa fa-dashboard"></i> Invoice</a></li>
    <li class="active">{{ $purchase_order_invoice->code }}</li>
  </ol>
@endsection

@section('content')
  
  <!-- Row Invoice-->
  <div class="row">
    <div class="col-lg-12">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Purchase Order Invoice Detail</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <!--Panel Invoice-->
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">
                Invoice
              </h3>
            </div>
            <div class="panel-body">
              <div class="table-responsive">
                <table class="table">
                    <tr>
                      <td style="width:30%;">Code</td>
                      <td> {{ $purchase_order_invoice->code }}</td>
                    </tr>
                    <tr>
                      <td style="width:30%;">Bill Price</td>
                      <td> {{ number_format($purchase_order_invoice->bill_price) }}</td>
                    </tr>
                    <tr>
                      <td style="width:30%;">Paid Price</td>
                      <td> {{ number_format($purchase_order_invoice->paid_price) }}</td>
                    </tr>
                    <tr>
                      <td style="width:30%;">Created By</td>
                      <td> {{ $purchase_order_invoice->creator->name }}</td>
                    </tr>
                    <tr>
                      <td style="width:30%;">Status</td>
                      <td> {{ $purchase_order_invoice->status }}</td>
                    </tr>

                </table>

              </div>
            </div>
          </div>
          <!--ENDPanel Invoice-->

          <!--Panel Purchase Order-->
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">
                Purchase Order Detail
              </h3>
            </div>
            <div class="panel-body">
              Code  : {{ $purchase_order->code }}
              <div class="table-responsive">
                <table class="table table-bordered" id="table-selected-products">
                  <thead>
                    <tr>
                      <th style="width:40%">Product Name</th>
                      <th style="width:20%">Quantity</th>
                      <th style="width:20%">Unit</th>
                      <th style="width:20%">Price</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if($purchase_order->products->count() > 0)
                      @foreach($purchase_order->products as $product)
                      <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->pivot->quantity }}</td>
                        <td>{{ $product->unit->name }}</td>
                        <td>{{ number_format($product->pivot->price, 2, ".", ",") }}</td>
                      </tr>
                    <tr>
                      @endforeach
                    @else
                      <td>There are no product</td>
                    </tr>
                    @endif
                  </tbody>
                  <tfoot>
                    <tr>
                      <th colspan="3">Total Price</th>
                      <th>{{ number_format($total_price, 2, ".", ",") }}</th>
                    </tr>
                  </tfoot>
                </table>

              </div>
            </div>
          </div>
          <!--ENDPanel Purchase Order-->

        </div><!-- /.box-body -->
        
      </div><!-- /.box -->
    </div>
  </div>
  <!-- ENDRow Invoice-->


  
  


@endsection


@section('additional_scripts')
  

@endSection

