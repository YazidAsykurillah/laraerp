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
        <div class="box-body table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>Purchase Order Referense</th>
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
        </div><!-- /.box-body -->
        <div class="box-footer clearfix">
          <div class="row">
            <div class="col-md-3">{{ ucwords($purchase_return->status) }}</div>
          </div>
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