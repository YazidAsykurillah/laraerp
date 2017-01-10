@extends('layouts.app')

@section('page_title')
  Sales Order Detail
@endsection

@section('page_header')
  <h1>
    Sales Order
    <small>Sales Order Detail</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('sales-order') }}"><i class="fa fa-dashboard"></i> Sales Order</a></li>
    <li class="active">{{ $sales_order->code }}</li>
  </ol>
@endsection

@section('content')
  <!-- Row Products-->
  <div class="row">
    <div class="col-lg-12">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Sales Order Detail</h3>
          <div class="pull-right">
            <a href="{{ url('sales-order/'.$sales_order->id.'/printPdf') }}" class="btn btn-default btn-xs">
              <i class='fa fa-print'></i>&nbsp;Print
            </a>
          </div>
          
        </div><!-- /.box-header -->
        <div class="box-body">
          
          <div class="row">
              <div class="col-md-2"><strong>Code</strong></div>
              <div class="col-md-6"><strong>{{ $sales_order->code }}</strong></div>
          </div>
          <br/>
          
          <div class="table-responsive">
            
            <table class="table table-bordered" id="table-selected-products">
              <thead>

                <tr>
                  <th style="width:40%">Product Name</th>
                  <th style="width:20%">Quantity</th>
                  <th style="width:20%">Unit</th>
                </tr>
              </thead>
              <tbody>
                @if($sales_order->products->count() > 0)
                  @foreach($sales_order->products as $product)
                  <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->pivot->quantity }}</td>
                    <td>{{ $product->unit->name }}</td>
                  </tr>
                <tr>
                  @endforeach
                @else
                  <td colspan="3">There are no product</td>
                </tr>
                @endif
              </tbody>
              <tfoot>

              </tfoot>
            </table>
          </div>

          <div class="row">
            <div class="col-md-3">Customer</div>
            <div class="col-md-1">:</div>
            <div class="col-md-8">
              {{ $sales_order->customer->name }}
            </div>
          </div>
          <br/>
          <div class="row">
            <div class="col-md-3">Created At</div>
            <div class="col-md-1">:</div>
            <div class="col-md-8">
              {{ $sales_order->created_at }}
            </div>
          </div>
          <br/>
          <div class="row">
            <div class="col-md-3">Status</div>
            <div class="col-md-1">:</div>
            <div class="col-md-8">
              {{ strtoupper($sales_order->status) }}
              <br/>
              @if($sales_order->status == 'posted')
                <button id="btn-send" class="btn btn-xs btn-warning" data-id="{{ $sales_order->id }}" data-text="{{ $sales_order->code }}" title="Click to send this Sales Order">
                  <i class="fa fa-sign-in"></i>&nbsp;Send
                </button>
              @endif
              @if($sales_order->status == 'accepted')
                <button id="btn-complete" class="btn btn-xs btn-success" data-id="{{ $sales_order->id }}" data-text="{{ $sales_order->code }}" title="Click to complete this Sales Order">
                  <i class="fa fa-sign-in"></i>&nbsp;Complete
                </button>
              @endif
            </div>
          </div>
          <br/>
          <div class="row">
            <div class="col-md-3">Notes</div>
            <div class="col-md-1">:</div>
            <div class="col-md-8">
              {!! nl2br($sales_order->notes) !!}
            </div>
          </div>
        </div><!-- /.box-body -->
        
      </div><!-- /.box -->
    </div>
  </div>
  <!-- ENDRow Products-->

  <!-- Row Invoice-->
  <div class="row">
    <div class="col-lg-12">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"> Invoice <small>Invoice that related with this sales order</small></h3>
          <div class="pull-right">
            <a href="{{ URL::to('sales-order-invoice/'.$sales_order->id.'/create')}}" class="btn btn-default btn-xs">
                <i class='fa fa-bookmark'></i>&nbsp;Create Invoice
            </a>
          </div>
          
        </div><!-- /.box-header -->
        <div class="box-body">
          @if($invoice->count() > 0)
            <div class="row">
              <div class="col-md-12"> 
                <strong>
                  <a href="{{url('sales-order-invoice/'.$sales_order->sales_order_invoice->id.'')}}" title="Click to view the detail of the invoice" target="_blank">
                    {{ $sales_order->sales_order_invoice->code }}
                  </a>
                </strong>
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
                  <td>{{ number_format($sales_order->sales_order_invoice->bill_price) }}</td>
                </tr>
                <tr>
                  <td style="width:30%;"><strong>Paid Price</strong></td>
                  <td>{{ number_format($sales_order->sales_order_invoice->paid_price) }}</td>
                </tr>
                <tr>
                  <td style="width:30%;"><strong>Status</strong></td>
                  <td>{{ ucwords($sales_order->sales_order_invoice->status) }}</td>
                </tr>
                <tr>
                  <td style="width:30%;"><strong>Notes</strong></td>
                  <td>{{ $sales_order->sales_order_invoice->notes }}</td>
                </tr>
              </table>
            </div>
          @else
            <div class="alert alert-info">
              <p>
                <i class="fa fa-info-circle"></i>&nbsp;
                There is no invoice related with this sales order, you can make it by click the button "Input Invoice".
              </p>
            </div>
          @endif
        </div><!-- /.box-body -->
        <div class="box-footer clearfix">
          
        </div>
      </div><!-- /.box -->
    </div>
  </div>
  <!-- ENDRow Invoice-->

@endsection




