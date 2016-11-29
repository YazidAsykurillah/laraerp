@extends('layouts.app')

@section('page_title')
  Purchase Order Invoice Detail
@endsection

@section('page_header')
  <h1>
    Purchase Order
    <small>Invoice Detail</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('purchase-order') }}"><i class="fa fa-dashboard"></i> Purchase Order </a></li>
    <li><a href="{{ URL::to('purchase-order/'.$purchase_order_invoice->purchase_order->id) }}"><i class="fa fa-dashboard"></i> {{ $purchase_order_invoice->purchase_order->code }} </a></li>
    <li></i>Invoice</li>
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

          <div class="row">
            <div class="col-md-3"><strong>Purchase Order Reference</strong></div>
            <div class="col-md-1">:</div>
            <div class="col-md-6">
              <a href="{{ url('purchase-order/'.$purchase_order->id.'')}}" target="_blank">
                {{ $purchase_order_invoice->purchase_order->code }}
              </a>
            </div>
          </div>
          <br/>
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
                <td>{{ number_format($purchase_order_invoice->bill_price) }}</td>
              </tr>
              <tr>
                <td style="width:30%;"><strong>Paid Price</strong></td>
                <td>{{ number_format($purchase_order_invoice->paid_price) }}</td>
              </tr>
              <tr>
                <td style="width:30%;"><strong>Status</strong></td>
                <td>{{ $purchase_order_invoice->status }}</td>
              </tr>
              <tr>
                <td style="width:30%;"><strong>Notes</strong></td>
                <td>{{ $purchase_order_invoice->notes }}</td>
              </tr>
            </table>

          </div>


          
        </div><!-- /.box-body -->
        
      </div><!-- /.box -->
    </div>
  </div>
  <!-- ENDRow Invoice-->


  
  


@endsection


@section('additional_scripts')
  
  
@endSection

