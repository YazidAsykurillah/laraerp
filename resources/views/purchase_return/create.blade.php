@extends('layouts.app')

@section('page_title')
  Purchase Order Return
@endsection

@section('page_header')
  <h1>
    Purchase Order
    <small>Create purchase order return </small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('purchase-order') }}"><i class="fa fa-dashboard"></i> Purchase Order</a></li>
    <li>{{ $purchase_order->code }}</li>
    <li><a href="{{ URL::to('purchase-return') }}"><i class="fa fa-dashboard"></i>Return</a></li>
    <li class="active"><i></i>Create</li>
  </ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-lg-12">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Create Purchase Order Return</h3>
        </div><!-- /.box-header -->
        <div class="box-body table-responsive">
          {!! Form::open(['route'=>'purchase-return.store','role'=>'form','class'=>'form-horizontal','id'=>'form-create-purchase-return']) !!}
          <table class="table table-bordered" id="table-selected-products">
            <thead>
              <tr>
                <th style="width:5%"></th>
                <th style="width:20%">Product Name</th>
                <th style="width:20%">Purchased Qty</th>
                <th style="width:20%">Returned Qty</th>
                <th style="width:35%">Notes</th>
              </tr>
            </thead>
            <tbody>
              @if($purchase_order->products->count() > 0)
                
                @foreach($purchase_order->products as $product)
                <tr id="row_product_{{$product->id}}">
                  <td>{{ Form::checkbox('product_id[]', $product->id, false, ['class'=>'product-id-checkbox']) }}</td>
                  <td>{{ $product->name }}</td>
                  <td class="purchased_qty">{{ $product->pivot->quantity }}</td>
                  <td>{{ Form::text('returned_quantity[]',null, ['class'=>'returned_quantity form-control', 'disabled']) }}</td>
                  <td>{{ Form::text('notes[]',null, ['class'=>'notes form-control', 'disabled']) }}</td>
                </tr>
              
                @endforeach
              @else
                <tr>
                  <td colspan="5">There are no product</td>
                </tr>
              @endif

            </tbody>
            <tfoot>

            </tfoot>
          </table>
          
        </div><!-- /.box-body -->
        <div class="box-footer clearfix">
          <div class="form-group">
              {!! Form::label('', '', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              <a href="{{ url('purchase-order/'.$purchase_order->id) }}" class="btn btn-default">
                <i class="fa fa-repeat"></i>&nbsp;Cancel
              </a>&nbsp;
              <button type="submit" class="btn btn-info" id="btn-submit-purchase-return">
                <i class="fa fa-save"></i>&nbsp;Submit
              </button>
            </div>
          </div>
          {!! Form::hidden('purchase_order_id', $purchase_order->id) !!}
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
    }
    return false;
  });
</script>
<!--ENDBlock Compare Control returned quantity to purchased quantity-->


<script type="text/javascript">
  $('.product-id-checkbox').on('click', function(){
    if($(this).is(':checked') == true){
      $(this).parent().parent().find('.returned_quantity').prop('disabled', false);
      $(this).parent().parent().find('.notes').prop('disabled', false);
    }
    else{
      $(this).parent().parent().find('.returned_quantity').prop('disabled', true);
      $(this).parent().parent().find('.returned_quantity').val('');
      $(this).parent().parent().find('.notes').val('');
      $(this).parent().parent().find('.notes').prop('disabled', true);
    }
  });
</script>

<script type="text/javascript">
  //Block handle form create purchase return submission
    $('#form-create-purchase-return').on('submit', function(event){
      event.preventDefault();
      var data = $(this).serialize();
      $.ajax({
          url: '{!!URL::to('storePurchaseReturn')!!}',
          type : 'POST',
          data : $(this).serialize(),
          beforeSend : function(){
            $('#btn-submit-purchase-return').prop('disabled', true);
            //$('#btn-submit-purchase-return').hide();
          },
          success : function(response){
            if(response == 'storePurchaseReturnOk'){
                window.location.href= '{{ URL::to("purchase-return") }}';
            }
            else{
              $('#btn-submit-purchase-return').prop('disabled', false);
              alertify.error(response);
              console.log(response);
            }
          },
          error:function(data){
            var htmlErrors = '<p>Error : </p>';
            errors = data.responseJSON;
            $.each(errors, function(index, value){
              htmlErrors+= '<p>'+value+'</p>';
            });
            alertify.set('notifier', 'delay',0);
            alertify.error(htmlErrors);
            $('#btn-submit-purchase-return').prop('disabled', false);

        }
      });
    });
  //ENDBlock handle form create purchase order submission
</script>
 
@endsection