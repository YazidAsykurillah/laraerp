@extends('layouts.app')

@section('page_title')
    Sales Order Invoice
@endsection

@section('page_header')
    <h1>
        Sales Order
        <small>Edit Invoice</small>
    </h1>
@endsection

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{ URL::to('sales-order') }}"><i class="fa fa-dashboar"></i> Sales Order</a></li>
        <li><a href="{{ URL::to('sales-order/'.$sales_order_invoice->sales_order->id) }}"><i class="fa fa-dashboard"></i> {{ $sales_order_invoice->sales_order->code }}</a></li>
        <li>Invoice</li>
        <li><a href="{{ URL::to('sales-order-invoice/'.$sales_order_invoice->id.'') }}"><i class="fa fa-dashboard"></i> {{ $sales_order_invoice->code }} </a></li>
        <li class="active">Edit</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Form Edit Invoice</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    {!! Form::model($sales_order_invoice,['route'=>['sales-order-invoice.update',$sales_order_invoice->id],'id'=>'form-edit-sales-order-invoice','class'=>'form-horizontal','method'=>'put','files'=>true]) !!}
                        <div class="table-responsive">
                            <table class="table table-bordered" id="table-selected-products">
                                <thead>
                                    <tr>
                                        <th style="width:40%">Product Name</th>
                                        <th style="width:10%">Quantity</th>
                                        <th style="width:20%">Unit</th>
                                        <th style="width:15%">Price Per Unit</th>
                                        <th style="width:15%">Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($sales_order->products->count() > 0)
                                        @foreach($sales_order->products as $product)
                                            <tr>
                                                <td>
                                                    <input type="hidden" name="product_id[]" value="{{ $product->id}}" />
                                                    {{ $product->name }}
                                                </td>
                                                <td>
                                                    <input type="hidden" name="quantity[]" value="{{ $product->pivot->quantity }}" class="quantity"/>
                                                    {{ $product->pivot->quantity }}
                                                </td>
                                                <td>
                                                    {{ $product->unit->name }}
                                                </td>
                                                <td>
                                                    <input type="text" name="price_per_unit[]" class="price_per_unit form-control" value="{{ $product->pivot->price_per_unit }}" />
                                                </td>
                                                <td>
                                                    <input type="text" name="price[]" class="price form-control" value="{{ $product->pivot->price }}"/>
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

                        <div class="form-group{{ $errors->has('notes') ? ' has-error' : '' }}">
                          {!! Form::label('notes', 'Notes', ['class'=>'col-sm-2 control-label']) !!}
                          <div class="col-sm-6">
                            {!! Form::textarea('notes',null,['class'=>'form-control', 'placeholder'=>'Notes for the invoice', 'id'=>'notes']) !!}
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
                            <a href="{{ url('sales-order-invoice') }}" class="btn btn-default">
                              <i class="fa fa-repeat"></i>&nbsp;Cancel
                            </a>&nbsp;
                            <button type="submit" class="btn btn-info" id="btn-submit-sales-order-invoice">
                              <i class="fa fa-save"></i>&nbsp;Submit
                            </button>
                          </div>
                        </div>
                        {!! Form::hidden('sales_order_invoice_id', $sales_order_invoice->id) !!}
                        {!! Form::hidden('sales_order_id', $sales_order_invoice->sales_order->id) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection


@section('additional_scripts')
    {!! Html::script('js/autoNumeric.js') !!}
    <script type="text/javascript">
        $('.price_per_unit').autoNumeric('init',{
            aSep:',',
            aDec:'.'
        });
        $('.price').autoNumeric('init',{
            aSep:',',
            aDec:'.'
        });
        $('#bill_price').autoNumeric('init',{
            aSep:',',
            aDec:'.'
        });

        //block handle price value on price per unit keyup event
        $('.price_per_unit').on('keyup',function(){
            var quantity = $(this).parent().parent().find('.quantity').val();
            var the_price = 0;
            if($(this).val() == ''){
                the_price = 0;
            }else{
                the_price = parseFloat($(this).val().replace(/,/g,''))*quantity;
            }
            $(this).parent().parent().find('.price').val(the_price).autoNumeric('update',{
                aSep:',',
                aDec:'.'
            });
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
@endsection
