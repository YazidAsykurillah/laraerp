@extends('layouts.app')

@section('page_title')
  Create Sales Order Invoice
@endsection

@section('page_header')
  <h1>
    Sales Order
    <small>Create Invoice</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('sales-order/') }}"><i class="fa fa-dashboard"></i> Sales Orders</a></li>
    <li><a href="{{ URL::to('sales-order/'.$sales_order->id.'') }}"><i class="fa fa-dashboard"></i> {{ $sales_order->code }}</a></li>
    <li><a href="{{ URL::to('sales-order-invoice') }}"><i class="fa fa-dashboard"></i> Invoices</a></li>
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
          {!! Form::open(['route'=>'sales-order-invoice.store','role'=>'form','class'=>'form-horizontal','id'=>'form-create-sales-order-invoice','files'=>true]) !!}

            <div class="table-responsive">
              <table class="table table-bordered" id="table-selected-products">
                  <thead>
                      <tr>
                        <th style="width:10%;background-color:#3c8dbc;color:white">Family</th>
                        <th style="width:15%;background-color:#3c8dbc;color:white">Code</th>
                        <th style="width:15%;background-color:#3c8dbc;color:white">Description</th>
                        <th style="width:10%;background-color:#3c8dbc;color:white">Unit</th>
                        <th style="width:5%;background-color:#3c8dbc;color:white">Quantity</th>
                        <th style="width:15%;background-color:#3c8dbc;color:white">Category</th>
                        <th style="width:15%;background-color:#3c8dbc;color:white">Price Per Unit</th>
                        <th style="width:15%;background-color:#3c8dbc;color:white">Price</th>
                      </tr>
                  </thead>
                  <tbody>
                  @if(count($row_display))
                      <?php $sum_qty = 0; ?>
                      @foreach($row_display as $row)
                          <tr>
                            <td>{{ $row['family'] }}</td>
                            <td><strong>{{ $row['main_product'] }}</strong></td>
                            <td>{{ $row['description'] }}</td>
                            <td>{{ $row['unit'] }}</td>
                            <td>{{ $sum_qty }}</td>
                            <td>{{ $row['category'] }}</td>
                            <td>
                                <!-- <input type="text" name="price_parent" class="price_parent"> -->
                            </td>
                          </tr>
                          @foreach($row['ordered_products'] as $or)
                          <tr>
                            <td>
                              <input type="hidden" name="product_id[]" value="{{ $or['product_id'] }} " />
                              {{ $or['family'] }}
                            </td>
                            <td>{{ $or['code'] }} </td>
                            <td>{{ $or['description'] }} </td>
                            <td>{{ $or['unit'] }} </td>
                            <td>
                              <input type="hidden" name="quantity[]" value="{{ $or['quantity'] }}" class="quantity">
                              {{ $or['quantity'] }}
                            </td>
                            <td>{{ $or['category'] }}</td>
                            <td>
                              <input type="text" name="price_per_unit[]" class="price_per_unit">
                            </td>
                            <td>
                              <input type="text" name="price[]" class="price">
                            </td>
                          </tr>
                          @endforeach
                      @endforeach
                @else
                <tr id="tr-no-product-selected">
                  <td>There are no product</td>
                @endif

                  </tbody>
              </table>

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
            <div class="form-group{{ $errors->has('notes') ? ' has-error' : '' }}">
              {!! Form::label('notes', 'Notes', ['class'=>'col-sm-2 control-label']) !!}
              <div class="col-sm-6">
                {!! Form::textarea('notes',null,['class'=>'form-control', 'placeholder'=>'Sales order invoice notes', 'id'=>'notes']) !!}
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
                <a href="{{ url('sales-order/'.$sales_order->id) }}" class="btn btn-default">
                  <i class="fa fa-repeat"></i>&nbsp;Cancel
                </a>&nbsp;
                <button type="submit" class="btn btn-info" id="btn-submit-sales-order-invoice">
                  <i class="fa fa-save"></i>&nbsp;Submit
                </button>
              </div>
            </div>
            {!! Form::hidden('sales_order_id', $sales_order->id) !!}
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
    //set autonumeric to price_per_unit classes field
    $('.price_per_unit').autoNumeric('init',{
        aSep:',',
        aDec:'.'
    });
    //set autonumeric to price classes field
    $('.price').autoNumeric('init',{
        aSep:',',
        aDec:'.'
    });

    //Block handle price value on price per unit keyup event
    $('.price_per_unit').on('keyup', function(){

      var quantity = $(this).parent().parent().find('.quantity').val();
      var the_price = 0;
      if($(this).val() == ''){
        the_price = 0;
      }
      else{
        the_price = parseFloat($(this).val().replace(/,/g, ''))*quantity;
      }

      $(this).parent().parent().find('.price').val(the_price).autoNumeric('update',{
          aSep:',',
          aDec:'.'
      });
      fill_the_bill_price();
    });

    function fill_the_bill_price(){

      var sum = 0;
      $(".price").each(function(){
          sum += +$(this).val().replace(/,/g, '');
      });
      $("#bill_price").val(sum);
      $('#bill_price').autoNumeric('update',{
          aSep:',',
          aDec:'.'
      });
    }
  </script>

  <script type="text/javascript">
  //Block handle form create Sales Order submission
    $('#form-create-sales-order-invoice').on('submit', function(event){
      event.preventDefault();
      var data = $(this).serialize();
      $.ajax({
          url: '{!!URL::to('storeSalesOrderInvoice')!!}',
          type : 'POST',
          data : $(this).serialize(),
          beforeSend : function(){
            $('#btn-submit-sales-order-invoice').prop('disabled', true);
            //$('#btn-submit-sales-order-invoice').hide();
          },
          success : function(response){
            if(response.msg == 'storeSalesOrderInvoiceOk'){
                window.location.href= '{{ URL::to('sales-order') }}/'+response.sales_order_id;
            }
            else{
              $('#btn-submit-sales-order-invoice').prop('disabled', false);
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
            $('#btn-submit-sales-order-invoice').prop('disabled', false);
        }
      });
    });
  //ENDBlock handle form create Sales Order submission
  </script>

@endSection
