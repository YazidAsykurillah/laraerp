@extends('layouts.app')

@section('page_title')
  {{ $purchase_order_invoice->code }}
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
    <li>Invoice</li>
    <li class="active">{{ $purchase_order_invoice->code }}</li>
  </ol>
@endsection

@section('content')

  <!-- Row Invoice-->
  <div class="row">
    <div class="col-lg-12">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">{{ $purchase_order_invoice->code }}</h3>
          <div class="pull-right">
            <!--Show button create payment only when invoice status is NOT completed yet-->
            @if($purchase_order_invoice->status != "completed")
            <a href="{{ url('purchase-order-invoice/'.$purchase_order_invoice->id.'/payment/create') }}" class="btn btn-default btn-xs" title="Create payment for this invoice">
              <i class='fa fa-money'></i>&nbsp;Input Payment
            </a>
            @endif
          </div>
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
                <td>
                  {{ strtoupper($purchase_order_invoice->status) }}
                  @if($purchase_order_invoice->status =='uncompleted')
                    <p></p>
                    <button id="btn-pay-invoice" class="btn btn-xs btn-primary" title="Click to pay this invoice" data-id="{{ $purchase_order_invoice->id}}" data-text="{{ $purchase_order_invoice->code }}">
                      <i class="fa fa-money"></i>&nbsp;Complete
                    </button>
                  @endif
                </td>
              </tr>
              <tr>
                <td style="width:30%;"><strong>Notes</strong></td>
                <td>{{ $purchase_order_invoice->notes }}</td>
              </tr>
            </table>

          </div>



        </div><!-- /.box-body -->
        <div class="box-footer clearfix">

        </div>

      </div><!-- /.box -->
    </div>
  </div>
  <!-- ENDRow Invoice-->


  <!--Modal pay purchase-order-invoice-->
  <div class="modal fade" id="modal-pay-purchase-order-invoice" tabindex="-1" role="dialog" aria-labelledby="modal-pay-purchase-order-invoiceLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'completePurchaseInvoice', 'method'=>'post']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-pay-purchase-order-invoiceLabel">Confirmation</h4>
        </div>
        <div class="modal-body">
          <b id="purchase-order-invoice-name-to-pay"></b> is going to be completed
          <br/>
          <p class="text text-danger">
            <i class="fa fa-info-circle"></i>&nbsp;This process can not be reverted
          </p>
          <input type="hidden" id="purchase_order_invoice_id" name="purchase_order_invoice_id">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger">Ok</button>
        </div>
      {!! Form::close() !!}
      </div>
    </div>
  </div>
<!--ENDModal pay purchase-order-invoice-->



@endsection


@section('additional_scripts')

  <script type="text/javascript">
    // Delete button handler
    $('#btn-pay-invoice').on('click', function (e) {
      var id = $(this).attr('data-id');
      var code = $(this).attr('data-text');
      $('#purchase_order_invoice_id').val(id);
      $('#purchase-order-invoice-name-to-pay').text(code);
      $('#modal-pay-purchase-order-invoice').modal('show');
    });
  </script>

@endSection
