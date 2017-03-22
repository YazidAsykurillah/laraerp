@extends('layouts.app')

@section('page_title')
  Purchase Order Invoice
@endsection

@section('page_header')
  <h1>
    Purchase Order
    <small>Edit Invoice</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('purchase-order') }}"><i class="fa fa-dashboard"></i> Purchase Order </a></li>
    <li><a href="{{ URL::to('purchase-order/'.$purchase_order_invoice->purchase_order->id) }}"><i class="fa fa-dashboard"></i> {{ $purchase_order_invoice->purchase_order->code }} </a></li>
    <li>Invoice</li>
    <li><a href="{{ URL::to('purchase-order-invoice/'.$purchase_order_invoice->id.'') }}"><i class="fa fa-dashboard"></i> {{ $purchase_order_invoice->code }}</a></li>
    <li class="active">Edit</li>
  </ol>
@endsection

@section('content')

  <!-- Row Invoice-->
  <div class="row">
    <div class="col-lg-12">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Form Edit Invoice</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          {!! Form::model($purchase_order_invoice, ['route'=>['purchase-order-invoice.update', $purchase_order_invoice->id], 'id'=>'form-edit-purchase-order-invoice', 'class'=>'form-horizontal','method'=>'put', 'files'=>true]) !!}
          <div class="table-responsive">
            <table class="table table-bordered" id="table-selected-products">
                <thead>
                    <tr>
                        <th style="width:20%;background-color:#3c8dbc;color:white">Family</th>
                        <th style="width:15%;background-color:#3c8dbc;color:white">Code</th>
                        <th style="width:15%;background-color:#3c8dbc;color:white">Description</th>
                        <th style="width:10%;background-color:#3c8dbc;color:white">Unit</th>
                        <th style="width:5%;background-color:#3c8dbc;color:white">Quantity</th>
                        <th style="width:20%;background-color:#3c8dbc;color:white">Category</th>
                        <th style="width:15%;background-color:#3c8dbc;color:white">Price</th>
                    </tr>
                </thead>
              <tbody>
                  @if(count($row_display))
                      @foreach($row_display as $row)
                          <tr>
                            <td>
                                <strong>
                                {{ $row['family'] }}<br>
                                </strong>
                                <input type="hidden" name="parent_product_id[]" value="{{ $row['main_product_id'] }} " />
                                <select name="inventory_account[]" id="inventory_account" class="col-md-12">
                                    <option value="">Inventory Account</option>
                                @foreach(list_account_hutang('52') as $as)
                                    @if($as->level == 1)
                                    <optgroup label="{{ $as->name }}">
                                    @endif
                                    @foreach(list_sub_hutang('2',$as->id) as $sub)
                                    <option value="{{ $sub->id }}">{{ $sub->account_number }}&nbsp;&nbsp;{{ $sub->name }}</option>
                                    @endforeach
                                @endforeach
                                </select>
                            </td>
                            <td><strong>{{ $row['main_product'] }}</strong></td>
                            <td><strong>{{ $row['description'] }}</strong></td>
                            <td><strong>{{ $row['unit'] }}</strong></td>
                            <td><strong>{{ $row['quantity'] }}</strong></td>
                            <td><strong>{{ $row['category'] }}</strong></td>
                            <td>
                                <input type="text" name="price_parent[]" class="price_parent">
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
                                  <input type="hidden" name="quantity[]" value="{{ $or['quantity'] }}">
                                  {{ $or['quantity'] }}
                              </td>
                              <td>{{ $or['category'] }}</td>
                              <td>
                                <input type="text" name="price[]" value="{{ number_format($or['price']) }}" class="price">
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
                {!! Form::text('bill_price',null,['class'=>'form-control', 'placeholder'=>'Bill price of the invoice', 'id'=>'bill_price']) !!}
                @if ($errors->has('bill_price'))
                  <span class="help-block">
                    <strong>{{ $errors->first('bill_price') }}</strong>
                  </span>
                @endif
              </div>
            </div>

            <div class="form-group{{ $errors->has('select_account') ? ' has-error' : '' }}">
              {!! Form::label('select_account', 'Accounts Payable', ['class'=>'col-sm-2 control-label']) !!}
              <div class="col-sm-6">
                  <select name="select_account" id="select_account" class="form-control">
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
                <a href="{{ url('purchase-order-invoice') }}" class="btn btn-default">
                  <i class="fa fa-repeat"></i>&nbsp;Cancel
                </a>&nbsp;
                <button type="submit" class="btn btn-info" id="btn-submit-purchase-order-invoice">
                  <i class="fa fa-save"></i>&nbsp;Submit
                </button>
              </div>
            </div>
            {!! Form::hidden('purchase_order_invoice_id', $purchase_order_invoice->id) !!}
            {!! Form::hidden('purchase_order_id', $purchase_order_invoice->purchase_order->id) !!}
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

    //set autonumeric to price classes field
    $('.price_parent').autoNumeric('init',{
        aSep:',',
        aDec:'.'
    });

    $('.price').on('keyup',function(){
        fill_the_bill_price();
    });

    function fill_the_bill_price(){
        var sum = 0;
        $('.price').each(function(){
            sum += +$(this).val().replace(/,/g,'');
        });
        $('#bill_price').val(sum);
        $('#bill_price').autoNumeric('update',{
            aSep:',',
            aDec:'.'
        });
    }
  </script>

  <script type="text/javascript">
  //Block handle form create purchase order submission
    $('#form-edit-purchase-order-invoice').on('submit', function(event){
      $('#btn-submit-purchase-order-invoice').attr('disable','disabled');
    });
  //ENDBlock handle form create purchase order submission
  </script>

@endSection
