@extends('layouts.app')

@section('page_title')
  Purchase Order Return
@endsection

@section('page_header')
  <h1>
    Purchase Order
    <small>Edit purchase order return </small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('purchase-order') }}"><i class="fa fa-dashboard"></i> Purchase Order</a></li>
    <li>{{ $purchase_order->code }}</li>
    <li><a href="{{ URL::to('purchase-return') }}"><i class="fa fa-dashboard"></i>Return</a></li>
    <li><i></i>{{ $purchase_return->id }}</li>
    <li class="active"><i></i>Edit</li>
  </ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-lg-12">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Edit Purchase Order Return</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
            <div class="table-responsive">
              {!! Form::model($purchase_return, ['route'=>['purchase-return.update', $purchase_return->id], 'id'=>'form-edit-purchase-return', 'class'=>'form-horizontal','method'=>'put', 'files'=>true]) !!}
                <table class="table table-bordered">
                  <thead>
                    <tr>
                        <th style="width:20%;background-color:#3c8dbc;color:white">PO Code</th>
                        <th style="width:20%;background-color:#3c8dbc;color:white">Code</th>
                        <th style="width:20%;background-color:#3c8dbc;color:white">Purchased Quantity</th>
                        <th style="width:20%;background-color:#3c8dbc;color:white">Returned Quantity</th>
                        <th style="width:20%;background-color:#3c8dbc;color:white">Notes</th>
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
                        {{ Form::text('quantity',null, ['class'=>'returned_quantity form-control']) }}
                      </td>
                      <td>
                        {{ Form::text('notes',null, ['class'=>'notes form-control']) }}
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
            <br/>
            <div class="row">
              <div class="col-md-3">Supplier Name</div>
              <div class="col-md-1">:</div>
              <div class="col-md-3">
                <p>{{ $purchase_return->purchase_order->supplier->name }}</p>
              </div>
            </div>
            <div class="row">
              <div class="col-md-3">Created At</div>
              <div class="col-md-1">:</div>
              <div class="col-md-3">
                <p>{{ $purchase_return->created_at }}</p>
              </div>
            </div>
        </div><!-- /.box-body -->
        <div class="box-footer clearfix">
          <div class="form-group">
              {!! Form::label('', '', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              <a href="{{ url('purchase-return') }}" class="btn btn-default">
                <i class="fa fa-repeat"></i>&nbsp;Cancel
              </a>&nbsp;
              <button type="submit" class="btn btn-info" id="btn-submit-purchase-return">
                <i class="fa fa-save"></i>&nbsp;Submit
              </button>
            </div>
          </div>
          {!! Form::hidden('purchase_return_id', $purchase_return->id) !!}
          {!! Form::close() !!}
        </div>

      </div><!-- /.box -->

    </div>
  </div>


@endsection


@section('additional_scripts')

{!! Html::script('js/autoNumeric.js') !!}
<script type="text/javascript">
    $('.returned_quantity').autoNumeric('init',{
        aSep:'.',
        aDec:',',
        aPad:false
    });
</script>
<!--Block Compare Control returned quantity to purchased quantity-->
<script type="text/javascript">
  $('.returned_quantity').on('keyup', function(){
    var purchased_qty = parseInt($(this).parent().parent().find('.purchased_qty').html());
    var the_value = parseInt($(this).val());
    if(the_value > purchased_qty){
      alertify.error('Returned quantity can not be greater than purchased quantity');
     $('#btn-submit-purchase-return').prop('disabled', true);
    }
    else{
      $('#btn-submit-purchase-return').prop('disabled', false);
    }
    return false;
  });
</script>
<!--ENDBlock Compare Control returned quantity to purchased quantity-->



<script type="text/javascript">
  //Block handle form edit purchase return submission
    $('#form-edit-purchase-return').on('submit', function(){
      $('#btn-submit-purchase-return').prop('disabled', true);
    });
  //ENDBlock handle form edit purchase order submission
</script>

@endsection
