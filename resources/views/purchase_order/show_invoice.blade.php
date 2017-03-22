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
                        <th style="width:10%;background-color:#3c8dbc;color:white">Family</th>
                        <th style="width:15%;background-color:#3c8dbc;color:white">Code</th>
                        <th style="width:20%;background-color:#3c8dbc;color:white">Description</th>
                        <th style="width:10%;background-color:#3c8dbc;color:white">Unit</th>
                        <th style="width:10%;background-color:#3c8dbc;color:white">Quantity</th>
                        <th style="width:20%;background-color:#3c8dbc;color:white">Category</th>
                        <th style="width:15%;background-color:#3c8dbc;color:white">Price</th>
                    </tr>
                </thead>
              <tbody>
                  @if(count($row_display))
                      @foreach($row_display as $row)
                          <tr>
                            <td><strong>{{ $row['family'] }}</strong></td>
                            <td><strong>{{ $row['main_product'] }}</strong></td>
                            <td><strong>{{ $row['description'] }}</strong></td>
                            <td><strong>{{ $row['unit'] }}</strong></td>
                            <td><strong>{{ $row['quantity'] }}</strong></td>
                            <td><strong>{{ $row['category'] }}</strong></td>
                            <td></td>
                          </tr>
                          @foreach($row['ordered_products'] as $or)
                          <tr>
                            <td>{{ $or['family'] }}</td>
                            <td>{{ $or['code'] }} </td>
                            <td>{{ $or['description'] }} </td>
                            <td>{{ $or['unit'] }} </td>
                            <td>{{ $or['quantity'] }}</td>
                            <td>{{ $or['category'] }}</td>
                            <td>{{ number_format($or['price']) }}</td>
                          </tr>
                          @endforeach
                      @endforeach
                @else
                <tr id="tr-no-product-selected">
                  <td>There are no product</td>
                @endif
              </tbody>
            </table>
            <br/>
            <table class="table">


              <tr>
                <td style="width:30%;"><strong>Bill Price</strong></td>
                <td id="bill_price">{{ number_format($purchase_order_invoice->bill_price) }}</td>
              </tr>
              <tr>
                <td style="width:30%;"><strong>Paid Price</strong></td>
                <td id="paid_price">{{ number_format($purchase_order_invoice->paid_price) }}</td>
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
              <!-- <tr>
                <td style="width:30%"><strong>Hutang to Account</strong></td>
                <td>
                    <select name="select_account" id="select_account">
                        <option value="">Select Account</option>
                    @foreach(list_account_hutang('56') as $as)
                        @if($as->level == 1)
                        <optgroup label="{{ $as->name }}">
                        @endif
                        @foreach(list_sub_hutang('2',$as->id) as $sub)
                        <option value="{{ $sub->id }}">{{ $sub->account_number }}&nbsp;&nbsp;{{ $sub->name }}</option>
                        @endforeach
                    @endforeach
                    </select>
                    <p></p>
                    <button id="btn-select-account" class="btn btn-xs btn-primary" title="Click to send this piutang">
                      <i class="fa fa-save"></i>&nbsp;Submit
                    </button>
                </td>
              </tr> -->
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

<!--Modal Complete invoice-->
  <div class="modal fade" id="modal-select-account" tabindex="-1" role="dialog" aria-labelledby="modal-select-accountLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'completePurchaseAccount', 'method'=>'post']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-select-accountLabel">Confirmation</h4>
        </div>
        <div class="modal-body">
            <b id="select-account-name-to-send"></b> is going to be selected
            <br/>
          <p class="text text-danger">
            <i class="fa fa-info-circle"></i>&nbsp;This process can not be reverted
          </p>
          <input type="text" id="select_account_id" name="select_account_id">
          <input type="text" id="amount_hutang" name="amount_hutang">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-success">Ok</button>
        </div>
      {!! Form::close() !!}
      </div>
    </div>
  </div>
<!--ENDModal Complete invoice-->

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

    $('#btn-select-account').on('click',function(){
        //$('#select-account-name-to-send').text($('#select_account').text());
        $('#select_account_id').val($('#select_account').val());
        $('#amount_hutang').val($('#bill_price').text().replace(/,/gi,'')-$('#paid_price').text().replace(/,/gi,''));
        $('#modal-select-account').modal('show');
    });
  </script>

@endSection
