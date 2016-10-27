@extends('layouts.app')

@section('page_title')
  Purchase Order Detail
@endsection

@section('page_header')
  <h1>
    Purchase Order Detail
    <small></small>
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
          <h3 class="box-title">{{ $purchase_order->code }}</h3>
          
        </div><!-- /.box-header -->
        <div class="box-body">
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
                    <td>{{ $product->pivot->price }}</td>
                  </tr>
                  @endforeach
                @else
                <tr>
                  <td>There are no product</td>
                </tr>
                @endif
              </tbody>
              <tfoot>
                <tr>
                  <th colspan="3">Total Price</th>
                  <th>{{ $total_price }}</th>
                </tr>
              </tfoot>
            </table>

          </div>
          <div class="row">
            <div class="col-md-3">Notes</div>
            <div class="col-md-3">
              {!! nl2br($purchase_order->notes) !!}
            </div>
            
          </div>
        </div><!-- /.box-body -->
        <div class="box-footer clearfix">
          <div class="row">
            <div class="col-md-3">
              <i class="fa fa-calendar" title="Date created"></i>&nbsp;{{ $purchase_order->created_at }}
            </div>
            <div class="col-md-3">
              <i class="fa fa-user" title="Date created"></i>&nbsp;{{ $purchase_order->created_by->name }}
            </div>
            <div class="col-md-3">
              <i class="fa fa-comment-o" title="Date created"></i>&nbsp;{{ $purchase_order->status }}
            </div>
          </div>
        </div>
      </div><!-- /.box -->
    </div>
  </div>
  <!-- ENDRow Products-->
  


@endsection


@section('additional_scripts')
  
@endSection

