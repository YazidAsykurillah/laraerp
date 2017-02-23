@extends('layouts.app')

@section('page_title')
  Purchase Order Return
@endsection

@section('page_header')
  <h1>
    Purchase Order
    <small>Purchase Return Detail </small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('purchase-order') }}"><i class="fa fa-dashboard"></i> Purchase Order</a></li>
    <li><a href="{{ URL::to('purchase-order/'.$purchase_return->purchase_order->id) }}">{{ $purchase_return->purchase_order->code }}</a></li>
    <li><a href="{{ URL::to('purchase-return') }}"><i class="fa fa-dashboard"></i>Return</a></li>
    <li><i></i>{{ $purchase_return->id }}</li>
    <li class="active"><i></i>Detail</li>
  </ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-lg-12">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Purchase Return Detail</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
            <div class="table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>PO Refference</th>
                    <th>Product</th>
                    <th>Purchased Quantity</th>
                    <th>Returned Quantity</th>
                    <th>Notes</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>{{ $purchase_return->purchase_order->code }}</td>
                    <td>{{ $purchase_return->product->name }}</td>
                    <td class="purchased_qty">
                      {{ \DB::table('product_purchase_order')->select('quantity')->where('product_id',$purchase_return->product_id)->where('purchase_order_id', $purchase_return->purchase_order_id)->value('quantity') }}
                    </td>
                    <td>
                      {{ $purchase_return->quantity }}
                    </td>
                    <td>
                      {{ $purchase_return->notes }}
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <br/>
            <div class="row">
              <div class="col-md-3">Status</div>
              <div class="col-md-1">:</div>
              <div class="col-md-3">
                <p>{{ strtoupper($purchase_return->status) }}</p>
                @if($purchase_return->status == 'posted')
                  <button type="button" id="btn-send-purchase-return" class="btn btn-warning btn-xs" data-id="{{ $purchase_return->id}}" title="Change status to Sent">
                    <i class="fa fa-sign-in"></i>&nbsp;Send
                  </button>
                @endif
                @if($purchase_return->status == 'sent')
                  <button type="button" id="btn-complete-purchase-return" class="btn btn-success btn-xs" data-id="{{ $purchase_return->id}}" title="Change status to Completed">
                    <i class="fa fa-check"></i>&nbsp;Complete
                  </button>
                @endif
              </div>
            </div>
        </div><!-- /.box-body -->
        <div class="box-footer clearfix">

        </div>

      </div><!-- /.box -->

    </div>
  </div>

  <!--Modal Send purchase-return-->
  <div class="modal fade" id="modal-send-purchase-return" tabindex="-1" role="dialog" aria-labelledby="modal-send-purchase-returnLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'sendPurchaseReturn', 'method'=>'post', 'id'=>'form-send-purchase-return']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-send-purchase-returnLabel">Send Purchase Return Confirmation</h4>
        </div>
        <div class="modal-body">
          This purchase return status will be changed to "Sent".
          <br/>
          <p class="text text-danger">
            <i class="fa fa-info-circle"></i>&nbsp;The product will be returned to the supplier.
          </p>
          <input type="hidden" id="id_to_be_send" name="id_to_be_send">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger" id="btn-send-purchase-return">Send</button>
        </div>
      {!! Form::close() !!}
      </div>
    </div>
  </div>
<!--ENDModal Send purchase-return-->

<!--Modal complete purchase-return-->
  <div class="modal fade" id="modal-complete-purchase-return" tabindex="-1" role="dialog" aria-labelledby="modal-complete-purchase-returnLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'completePurchaseReturn', 'method'=>'post', 'id'=>'form-complete-purchase-return']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-send-purchase-returnLabel">Complete Purchase Return Confirmation</h4>
        </div>
        <div class="modal-body">
          This return status will be changed to completed
          <br/>
          <p class="text text-danger">
            <i class="fa fa-info-circle"></i>&nbsp;The product will be re-added to the inventory
          </p>
          <input type="hidden" id="id_to_be_completed" name="id_to_be_completed">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger" id="btn-complete-purchase-return">Complete</button>
        </div>
      {!! Form::close() !!}
      </div>
    </div>
  </div>
<!--ENDModal complete purchase-return-->

@endsection


@section('additional_scripts')

<script type="text/javascript">
  //Handler send purchase return
    $('#btn-send-purchase-return').on('click', function (e) {
      var id = $(this).attr('data-id');
      $('#id_to_be_send').val(id);
      $('#modal-send-purchase-return').modal('show');
    });
</script>

<script type="text/javascript">
  //Handler send purchase return
    $('#btn-complete-purchase-return').on('click', function (e) {
      var id = $(this).attr('data-id');
      $('#id_to_be_completed').val(id);
      $('#modal-complete-purchase-return').modal('show');
    });
</script>

@endsection
