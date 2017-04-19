@extends('layouts.app')

@section('page_title')
    Sales Order Return
@endsection

@section('page_header')
    <h1>
        Sales Order
        <small>Edit sales order return</small>
    </h1>
@endsection

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{ URL::to('sales-order') }}"><i class="fa fa-dashboard"></i> Sales Order</a></li>
        <li>{{ $sales_order->code }}</li>
        <li><a href="{{ URL::to('sales-return')}}"><i class="fa fa-dashboard"></i> Return</a></li>
        <li><i></i>{{ $sales_return->id }}</li>
        <li class="active"><i></i>Edit</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="box" style="box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);border-top:none">
                <div class="box-header with-border">
                    <h3 class="box-title">Edit Sales Order Return</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                    {!! Form::model($sales_return,['route'=>['sales-return.update',$sales_return->id],'id'=>'form-edit-sales-return','class'=>'form-horizontal','method'=>'put','files'=>true]) !!}
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr style="background-color:#3c8dbc;color:white">
                                <th style="width:20%;">PO Code</th>
                                <th style="width:20%;">Code</th>
                                <th style="width:20%;">Salesed Quantity</th>
                                <th style="width:20%;">Returned Quantity</th>
                                <th style="width:20%;">Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $sales_return->sales_order->code }}</td>
                                <td>{{ $sales_return->product->name }}</td>
                                <td class="salesed_qty">
                                    {{ \DB::table('product_sales_order')->select('quantity')->where('product_id',$sales_return->product_id)->where('sales_order_id',$sales_return->sales_order_id)->value('quantity') }}
                                </td>
                                <td>
                                    {{ Form::text('quantity',null,['class'=>'returned_quantity form-control']) }}
                                </td>
                                <td>
                                    {{ Form::text('notes',null,['class'=>'notes form-control']) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-md-3"><strong>Status</strong></div>
                        <div class="col-md-1">:</div>
                        <div class="col-md-3">
                            <p>{{ strtoupper($sales_return->status) }}</p>
                        </div>
                    </div><!-- /.row -->
                    <div class="row">
                      <div class="col-md-3"><strong>Customer Name</strong></div>
                      <div class="col-md-1">:</div>
                      <div class="col-md-3">
                        <p>{{ $sales_return->sales_order->customer->name }}</p>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-3"><strong>Created At</strong></div>
                      <div class="col-md-1">:</div>
                      <div class="col-md-3">
                        <p>{{ $sales_return->created_at }}</p>
                      </div>
                    </div>
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">
                    <div class="form-group">
                        {!! Form::label('','',['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            <a href="{{ url('sales-return') }}" class="btn btn-default">
                                <i class="fa fa-repeat"></i>&nbsp;Cancel
                            </a>
                            <button type="submit" class="btn btn-info" id="btn-submit-sales-return">
                                <i class="fa fa-save"></i>&nbsp;Submit
                            </button>
                        </div>
                    </div>
                    {!! Form::hidden('sales_return_id',$sales_return->id) !!}
                    {!! Form::close() !!}
                </div><!-- /.box-footer -->
            </div>
        </div>
    </div>
@endsection
