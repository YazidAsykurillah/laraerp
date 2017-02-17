@extends('layouts.app')

@section('page_title')
    Stock Balance Detail
@endsection

@section('page_header')
    <h1>
        Stock Balance Detail
        <small> {{ $stock_balance->code }} </small>
    </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('stock_balance') }}"><i class="fa fa-dashboard"></i> Stock Balances</a></li>
    <li class="active"><i></i> {{ $stock_balance->code }}</li>
  </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-3">

        </div>
        <div class="col-md-6">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-bars"></i>&nbsp;General Informations</h3>
                </div><!-- /.box header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <tr>
                                <td style="width:20%">Code</td>
                                <td>:</td>
                                <td>{{ $stock_balance->code }}</td>
                            </tr>
                            <tr>
                                <td style="width:20%">Created By</td>
                                <td>:</td>
                                <td>{{ $stock_balance->creator->name }}</td>
                            </tr>
                            <tr>
                                <td style="width:20%">Created At</td>
                                <td>:</td>
                                <td>{{ $stock_balance->created_at }}</td>
                            </tr>
                            <tr>
                                <td style="width:20%">Updated At</td>
                                <td>:</td>
                                <td>{{ $stock_balance->updated_at }}</td>
                            </tr>
                        </table>
                    </div>
                </div><!-- /.box body -->
                <div class="box-footer clearfix">

                </div>
            </div>
        </div>
        <div class="col-md-3">

        </div>

        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title"><i class="fa fa-bookmark-o"></i>&nbsp;Primary Product Information</h3>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th style="width:10%">#</th>
                                    <th>Code</th>
                                    <th>Product Name</th>
                                    <th>System Stock</th>
                                    <th>Real Stock</th>
                                    <th>Information</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $x =1; ?>
                                @foreach($dataList as $view)
                                    <tr>
                                        <td>{{ $x++ }}</td>
                                        <td>{{ $view->code }}</td>
                                        <td>{{ $view->name }}</td>
                                        <td>{{ $view->system_stock }}</td>
                                        <td>@if($view->real_stock<$view->system_stock)
                                                <span style="color:red">
                                            @else
                                                <span style="color:green">
                                            @endif
                                            {{ $view->real_stock }}</span>
                                        </td>
                                        <td>{{ $view->information }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
