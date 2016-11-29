@extends('layouts.app')

@section('page_title')
  Purchase Order Detail
@endsection

@section('page_header')
  <h1>
    Purchase Order
    <small>Purchase Order Detail</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('purchase-order') }}"><i class="fa fa-dashboard"></i> Purchase Order</a></li>
    <li class="active">{{ $purchase_order->code }}</li>
  </ol>
@endsection

@section('content')
  <!-- Row Products-->
  <div class="row">
    <div class="col-lg-12">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Purchase Order Detail</h3>
          <div class="pull-right">
            <a href="{{ url('purchase-order/'.$purchase_order->id.'/printPdf') }}" class="btn btn-default btn-xs">
              <i class='fa fa-print'></i>&nbsp;Print
            </a>&nbsp;
            @if($purchase_order->status == 'posted' || $purchase_order->status =='completed')
            
            @endif
            @if(count($purchase_order->purchase_order_invoice) == 0)
              <a href="{{ URL::to('purchase-order-invoice/'.$purchase_order->id.'/create')}}" class="btn btn-default btn-xs">
                <i class='fa fa-bookmark'></i>&nbsp;Input Invoice
              </a>
            @endif

            
          </div>
          
        </div><!-- /.box-header -->
        <div class="box-body">
          
          <div class="row">
              <div class="col-md-2"><strong>Code</strong></div>
              <div class="col-md-6"><strong>{{ $purchase_order->code }}</strong></div>
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
                @if($purchase_order->products->count() > 0)
                  @foreach($purchase_order->products as $product)
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
            <div class="col-md-3">Supplier</div>
            <div class="col-md-9">
              {{ $purchase_order->supplier->name }}
            </div>
          </div>
          <br/>
          <div class="row">
            <div class="col-md-3">Notes</div>
            <div class="col-md-9">
              {!! nl2br($purchase_order->notes) !!}
            </div>
          </div>
        </div><!-- /.box-body -->
        <div class="box-footer clearfix">
          <div class="row">
            <div class="col-md-4">
              <i class="fa fa-calendar" title="Date created"></i>&nbsp;{{ $purchase_order->created_at }}
            </div>
            <div class="col-md-4">
              <i class="fa fa-user" title="Purchase order creator"></i>&nbsp;{{ $purchase_order->created_by->name }}
            </div>
            <div class="col-md-4">
              
              {{ $purchase_order->status }}
            </div>
          </div>
        </div>
      </div><!-- /.box -->
    </div>
  </div>
  <!-- ENDRow Products-->

  <!-- Row Invoice-->
  <div class="row">
    <div class="col-lg-12">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title"> Related Invoice </h3>
          
        </div><!-- /.box-header -->
        <div class="box-body">
          
        </div><!-- /.box-body -->
        <div class="box-footer clearfix">
          
        </div>
      </div><!-- /.box -->
    </div>
  </div>
  <!-- ENDRow Invoice-->
  


@endsection


@section('additional_scripts')
  
@endSection

