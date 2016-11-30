@extends('layouts.app')

@section('page_title')
  Create Purchase Order Invoice
@endsection

@section('page_header')
  <h1>
    Purchase Order
    <small>Create Invoice</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('purchase-order/') }}"><i class="fa fa-dashboard"></i> Purchase Orders</a></li>
    <li><a href="{{ URL::to('purchase-order/'.$purchase_order->id.'') }}"><i class="fa fa-dashboard"></i> {{ $purchase_order->code }}</a></li>
    <li><a href="{{ URL::to('purchase-order-invoice') }}"><i class="fa fa-dashboard"></i> Invoices</a></li>
    <li class="active">Create</li>
  </ol>
@endsection

@section('content')
  
  <!-- Row Invoice-->
  <div class="row">
    <div class="col-lg-12">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Form Invoice</h3>    
        </div><!-- /.box-header -->
        <div class="box-body">
          {!! Form::open(['route'=>'purchase-order-invoice.store','role'=>'form','class'=>'form-horizontal','id'=>'form-create-purchase-order-invoice','files'=>true]) !!}

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
                      <input type="hidden"  name="product_id[]"  value="{{ $product->id }}" />
                      {{ $product->name }}
                    </td>
                    <td>
                      <input type="hidden"  name="quantity[]" value="{{ $product->pivot->quantity }}" />
                      {{ $product->pivot->quantity }}
                    </td>
                    <td>
                      {{ $product->unit->name }}
                    </td>
                    <td>
                      <input type="text"  name="price[]" class="price form-control" />
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

          </div>

          
            <div class="form-group{{ $errors->has('code') ? ' has-error' : '' }}">
              {!! Form::label('code', 'Code', ['class'=>'col-sm-2 control-label']) !!}
              <div class="col-sm-6">
                {!! Form::text('code',null,['class'=>'form-control', 'placeholder'=>'Code of the invoice', 'id'=>'code']) !!}
                @if ($errors->has('code'))
                  <span class="help-block">
                    <strong>{{ $errors->first('code') }}</strong>
                  </span>
                @endif
              </div>
            </div>
            <div class="form-group{{ $errors->has('bill_price') ? ' has-error' : '' }}">
              {!! Form::label('bill_price', 'Bill Price', ['class'=>'col-sm-2 control-label']) !!}
              <div class="col-sm-6">
                {!! Form::text('bill_price',$total_price,['class'=>'form-control', 'placeholder'=>'Bill price of the invoice', 'id'=>'bill_price']) !!}
                @if ($errors->has('bill_price'))
                  <span class="help-block">
                    <strong>{{ $errors->first('bill_price') }}</strong>
                  </span>
                @endif
              </div>
            </div>
            <div class="form-group{{ $errors->has('paid_price') ? ' has-error' : '' }}">
              {!! Form::label('paid_price', 'Paid Price', ['class'=>'col-sm-2 control-label']) !!}
              <div class="col-sm-6">
                {!! Form::text('paid_price',null,['class'=>'form-control', 'placeholder'=>'Paid price for the invoice', 'id'=>'paid_price']) !!}
                @if ($errors->has('paid_price'))
                  <span class="help-block">
                    <strong>{{ $errors->first('paid_price') }}</strong>
                  </span>
                @endif
              </div>
            </div>
            <div class="form-group{{ $errors->has('notes') ? ' has-error' : '' }}">
              {!! Form::label('notes', 'Notes', ['class'=>'col-sm-2 control-label']) !!}
              <div class="col-sm-6">
                {!! Form::textarea('notes',null,['class'=>'form-control', 'placeholder'=>'Paid price for the invoice', 'id'=>'notes']) !!}
                @if ($errors->has('notes'))
                  <span class="help-block">
                    <strong>{{ $errors->first('notes') }}</strong>
                  </span>
                @endif
              </div>
            </div>
            <div class="form-group">
                {!! Form::label('', '', ['class'=>'col-sm-2 control-label']) !!}
              <div class="col-sm-6">
                <a href="{{ url('purchase-order/'.$purchase_order->id) }}" class="btn btn-default">
                  <i class="fa fa-repeat"></i>&nbsp;Cancel
                </a>&nbsp;
                <button type="submit" class="btn btn-info" id="btn-submit-purchase-order-invoice">
                  <i class="fa fa-save"></i>&nbsp;Submit
                </button>
              </div>
            </div>
            {!! Form::hidden('purchase_order_id', $purchase_order->id) !!}
          {!! Form::close() !!}
        </div><!-- /.box-body -->
        
      </div><!-- /.box -->
    </div>
  </div>
  <!-- ENDRow Invoice-->


  
  


@endsection


@section('additional_scripts')
  
  {!! Html::script('js/autoNumeric.js') !!}
  <script type="text/javascript">
    $('#bill_price').autoNumeric('init',{
        aSep:',',
        aDec:'.'
    });
    $('#paid_price').autoNumeric('init',{
        aSep:',',
        aDec:'.'
    });
    //set autonumeric to price classes field
    $('.price').autoNumeric('init',{
        aSep:',',
        aDec:'.'
    });

  </script>

  <script type="text/javascript">
  //Block handle form create purchase order submission
    $('#form-create-purchase-order-invoice').on('submit', function(event){
      event.preventDefault();
      var data = $(this).serialize();
      $.ajax({
          url: '{!!URL::to('storePurchaseOrderInvoice')!!}',
          type : 'POST',
          data : $(this).serialize(),
          beforeSend : function(){
            $('#btn-submit-purchase-order-invoice').prop('disabled', true);
            //$('#btn-submit-purchase-order-invoice').hide();
          },
          success : function(response){
            if(response.msg == 'storePurchaseOrderInvoiceOk'){
                window.location.href= '{{ URL::to('purchase-order') }}/'+response.purchase_order_id;
            }
            else{
              $('#btn-submit-purchase-order-invoice').prop('disabled', false);
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
            $('#btn-submit-purchase-order-invoice').prop('disabled', false);
        }
      });
    });
  //ENDBlock handle form create purchase order submission
  </script>

@endSection

