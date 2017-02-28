@extends('layouts.app')

@section('page_title')
    Sales Order Return
@endsection

@section('page_header')
    <h1>
        Sales Order
        <small>Create sales order return </small>
    </h1>
@endsection

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ url('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{ url('sales-order') }}"><i class="fa fa-dashboard"></i> Sales Order</a></li>
        <li>{{ $sales_order->code }}</li>
        <li><a href="{{ url('sales-return/create?sales_order_id='.$sales_order->id) }}"><i class="fa fa-dashboard"></i> Return</a></li>
        <li class="active"><i></i> Create</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Create Sales Order Return</h3>
                </div><!-- /.box header -->
                <div class="box-body table-responsive">
                    {!! Form::open(['route'=>'sales-order.store','role'=>'form','class'=>'form-horizontal','id'=>'form-create-sales-order-return']) !!}
                    <table class="table table-bordered" id="table-selected-sales">
                        <thead>
                            <tr>
                                <th style="5%"></th>
                                <th style="20%">Product Name</th>
                                <th style="20%">Sales Qty</th>
                                <th style="20%">Returned Qty</th>
                                <th style="35%">Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($sales_order->products->count() > 0)

                                @foreach($sales_order->products as $sales)
                                <tr id="row_sales_{{$sales->id}}">
                                    <td>{{ Form::checkbox('product_id[]',$sales->id,false,['class'=>'sales-id-checkbox']) }}</td>
                                    <td>{{ $sales->name }}</td>
                                    <td class="salesed_qty">{{ $sales->pivot->quantity }}</td>
                                    <td>{{ Form::text('returned_quantity[]',null,['class'=>'returned_quantity form-control','disabled']) }}</td>
                                    <td>{{ Form::text('notes[]',null,['class'=>'notes form-control','disabled']) }}</td>
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
                </div><!-- /.box body -->
                <div class="box-footer clearfix">
                    <div class="form-group">
                        {!! Form::label('','',['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            <a href="{{ url('sales-order/'.$sales_order->id)}}" class="btn btn-default">
                                <i class="fa fa-repeat"></i>&nbsp;Cancel
                            </a>&nbsp;
                            <button type="submit" class="btn btn-info" id="btn-submit-sales-return">
                                <i class="fa fa-save"></i>&nbsp;Submit
                            </button>
                        </div>
                    </div>
                    {!! Form::hidden('sales_order_id', $sales_order->id) !!}
                    {!! Form::close() !!}
                </div><!-- /.box footer -->
            </div>
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
<!-- Block Compare Control returned quantity to sales quantity -->
<script type="text/javascript">
    $('.returned_quantity').on('keyup', function(){
        var salesed_qty = parseInt($(this).parent().parent().find('.salesed_qty').html());
        var the_value = parseInt($(this).val());
        if(the_value > salesed_qty){
            alertify.error('Returned quantity can not be greater than salesed quantity');
        }
        return false;
    });
</script>
<!--ENDBlock Compare control returned quantity to sales quantity-->

<script type="text/javascript">
    $('.sales-id-checkbox').on('click',function(){
        if($(this).is(':checked') == true){
            $(this).parent().parent().find('.returned_quantity').prop('disabled',false);
            $(this).parent().parent().find('.notes').prop('disabled',false);
            $(this).parent().parent().find('.returned_quantity').focus();
        }
        else{
            $(this).parent().parent().find('.returned_quantity').prop('disabled',true);
            $(this).parent().parent().find('.returned_quantity').val('');
            $(this).parent().parent().find('.notes').prop('disabled',true);
            $(this).parent().parent().find('.notes').val('');
        }
    });
</script>

<script type="text/javascript">
    //Block handle form create sales return submission
    $('#form-create-sales-order-return').on('submit', function(event){
        event.preventDefault();
        var data = $(this).serialize();
        $.ajax({
            url: '{!! URL::to('storeSalesReturn') !!}',
            type: 'POST',
            data: $(this).serialize(),
            beforeSend : function(){
                $('#btn-submit-sales-return').prop('disabled',true);
            },
            success : function(response){
                if(response == 'storeSalesReturnOk'){
                    window.location.href = '{{ URL::to("sales-return") }}';
                }
                else{
                    $('btn-submit-sales-return').prop('disabled',false);
                    alertify.error(response);
                    console.log(response);
                }
            },
            error : function(data){
                var htmlErrors = '<p>Error : </p>';
                errors = data.responseJSON;
                $.each(errors, function(index, value){
                    htmlErrors+= '<p>'+value+'</p>';
                });
                alertify.set('notifier', 'delay', 0);
                alertify.error(htmlErrors);
                $('#btn-submit-sales-return').prop('disabled',false);
            }
        });
    });
</script>
@endsection
