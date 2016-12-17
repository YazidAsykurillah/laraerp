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
            </a>
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
            <div class="col-md-1">:</div>
            <div class="col-md-8">
              {{ $purchase_order->supplier->name }}
            </div>
          </div>
          <br/>
          <div class="row">
            <div class="col-md-3">Created At</div>
            <div class="col-md-1">:</div>
            <div class="col-md-8">
              {{ $purchase_order->created_at }}
            </div>
          </div>
          <br/>
          <div class="row">
            <div class="col-md-3">Status</div>
            <div class="col-md-1">:</div>
            <div class="col-md-8">
              {{ strtoupper($purchase_order->status) }}
              <br/>
              @if($purchase_order->status == 'posted')
                <button id="btn-accept" class="btn btn-xs btn-warning" data-id="{{ $purchase_order->id }}" data-text="{{ $purchase_order->code }}" title="Click to accept this purchase order">
                  <i class="fa fa-sign-in"></i>&nbsp;Accept
                </button>
              @endif
              @if($purchase_order->status == 'accepted')
                <button id="btn-complete" class="btn btn-xs btn-success" data-id="{{ $purchase_order->id }}" data-text="{{ $purchase_order->code }}" title="Click to complete this purchase order">
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
              {!! nl2br($purchase_order->notes) !!}
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
          <h3 class="box-title"> Related Invoice </h3>
          <div class="pull-right">
            @if($purchase_order->status == 'posted' || $purchase_order->status =='completed')
            
            @endif
            @if($purchase_order->status=='accepted' && count($purchase_order->purchase_order_invoice) == 0)
              <a href="{{ URL::to('purchase-order-invoice/'.$purchase_order->id.'/create')}}" class="btn btn-default btn-xs">
                <i class='fa fa-bookmark'></i>&nbsp;Input Invoice
              </a>
            @endif
            
          </div>
          
        </div><!-- /.box-header -->
        <div class="box-body">
          @if($invoice->count() > 0)
            <div class="row">
              <div class="col-md-12"> 
                <strong>{{ $purchase_order->purchase_order_invoice->code }}</strong>
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
                  <td>{{ number_format($purchase_order->purchase_order_invoice->bill_price) }}</td>
                </tr>
                <tr>
                  <td style="width:30%;"><strong>Paid Price</strong></td>
                  <td>{{ number_format($purchase_order->purchase_order_invoice->paid_price) }}</td>
                </tr>
                <tr>
                  <td style="width:30%;"><strong>Status</strong></td>
                  <td>{{ ucwords($purchase_order->purchase_order_invoice->status) }}</td>
                </tr>
                <tr>
                  <td style="width:30%;"><strong>Notes</strong></td>
                  <td>{{ $purchase_order->purchase_order_invoice->notes }}</td>
                </tr>
              </table>
            </div>
          @else
            <div class="alert alert-info">
              <p>
                <i class="fa fa-info-circle"></i>&nbsp;
                There is no invoice related with this purchase order, you can make it by click the button "Input Invoice".
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
  
  <!-- Row Return-->
  <div class="row">
    <div class="col-lg-12">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Related Return</h3>
          <div class="pull-right">
            <a href="{{ url('purchase-return/create/?purchase_order_id='.$purchase_order->id.'') }}" class="btn btn-default btn-xs">
              <i class='fa fa-reply'></i>&nbsp;Create Return
            </a>
          </div>
          
        </div><!-- /.box-header -->
        <div class="box-body">
          
          <div class="table-responsive">
            
            <table class="table">
              <thead>
                <tr>
                  <th>Product</th>
                  <th>Returned Quantity</th>
                  <th>Notes</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
              @if($purchase_returns->count() > 0)

                @foreach($purchase_returns as $purchase_return)
                <tr>
                  <td> {{ $purchase_return->product->name }}</td>
                  <td> {{ $purchase_return->quantity }}</td>
                  <td> {{ $purchase_return->notes }}</td>
                  <td> {{ ucwords($purchase_return->status) }}</td>
                </tr>
                @endforeach
              @else
              <tr>
                <td colspan="4">
                  <p class="alert alert-info"><i class="fa fa-info-circle"></i>&nbsp;There is no related return to this purchase order</p>
                </td>
              </tr>
              @endif
              </tbody>
            </table>
          </div>
        </div><!-- /.box-body -->
        <div class="box-footer clearfix">
          
        </div>
      </div><!-- /.box -->
    </div>
  </div>
  <!-- ENDRow Return-->

  <!--Modal Accept purchase-order-->
  <div class="modal fade" id="modal-accept-purchase-order" tabindex="-1" role="dialog" aria-labelledby="modal-accept-purchase-orderLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'acceptPurchaseOrder', 'method'=>'post']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-accept-purchase-orderLabel">Accept Purchase Order Confirmation</h4>
        </div>
        <div class="modal-body">
          <b id="purchase-order-name-to-accept"></b> status will be changed to Accepted
          <br/>
          <p class="text text-danger">
            <i class="fa fa-info-circle"></i>&nbsp;This process can not be reverted
          </p>
          <input type="hidden" id="id_to_be_accepted" name="id_to_be_accepted">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger">Accept</button>
        </div>
      {!! Form::close() !!}
      </div>
    </div>
  </div>
<!--ENDModal Accept purchase-order-->

<!--Modal complete purchase-order-->
  <div class="modal fade" id="modal-complete-purchase-order" tabindex="-1" role="dialog" aria-labelledby="modal-complete-purchase-orderLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'completePurchaseOrder', 'method'=>'post']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-complete-purchase-orderLabel">Complete Purchase Order Confirmation</h4>
        </div>
        <div class="modal-body">
          <b id="purchase-order-name-to-complete"></b> will be changed to completed
          <br/>
          <p class="text text-danger">
            <i class="fa fa-info-circle"></i>&nbsp;This process can not be reverted
          </p>
          <input type="hidden" id="id_to_be_completed" name="id_to_be_completed">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger">complete</button>
        </div>
      {!! Form::close() !!}
      </div>
    </div>
  </div>
<!--ENDModal Complete purchase-order-->

@endsection


@section('additional_scripts')

<script type="text/javascript">
  //Accept
  $('#btn-accept').on('click', function(event){
    event.preventDefault();
    var id = $(this).attr('data-id');
      var code = $(this).attr('data-text');
      $('#id_to_be_accepted').val(id);
      $('#purchase-order-name-to-accept').text(code);
      $('#modal-accept-purchase-order').modal('show');
  });

  //Complete
  $('#btn-complete').on('click', function(event){
    event.preventDefault();
    var id = $(this).attr('data-id');
      var code = $(this).attr('data-text');
      $('#id_to_be_completed').val(id);
      $('#purchase-order-name-to-complete').text(code);
      $('#modal-complete-purchase-order').modal('show');
  });
</script>
  
@endSection
