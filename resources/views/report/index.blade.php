@extends('layouts.app')

@section('page_title')
    Report
@endsection

@section('page_header')
    <h1>
        Report
        <small>Report Search</small>
    </h1>
@endsection

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{ URL::to('report') }}"><i class="fa fa-dashboard"></i> Report</a></li>
        <li class="active"><i></i>Index</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        {!! Form::open(['url'=>'report/search','role'=>'form','class'=>'form-horizontal','id'=>'form-search-neraca']) !!}
        <div class="col-lg-12">
            <div class="box" style="box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);border-top:none">
                <div class="box-header with-border">
                    <h3 class="box-title">Search Report</h3>
                    <a data-toggle="collapse" href="#collapse-report" title="Click to search report"><i class="fa fa-arrow-down pull-right"></i></a>
                </div>
                <div class="box-body collapse in" id="collapse-report">
                    <div class="form-group">
                        {!! Form::label('type_report','Report Type',['class'=>'col-sm-2 control-label']) !!}
                            <div class="col-sm-6">
                                {!! Form::select('type_report',['0'=>'Ringkasan Penjualan',
                                                                '1'=>'Detail Penjualan',
                                                                '2'=>'Ringkasan Return Penjualan',
                                                                '3'=>'Detail Return Penjualan',
                                                                '4'=>'Ringkasan Pembelian',
                                                                '5'=>'Detail Pembelian',
                                                                '6'=>'Ringkasan Return Pembelian',
                                                                '7'=>'Detail Return Pembelian',
                                                                '8'=>'Rincian Penjualan per Pelanggan',
                                                                '9'=>'Penjualan per Pelanggan'],
                                                                null,['class'=>'form-control','placeholder'=>'Report of Type','id'=>'type_report']) !!}
                            </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('date_start','Date',['class'=>'col-sm-2 control-label']) !!}
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <span class="input-group-addon">Start</span>
                                {!! Form::date('date_start',\Carbon\Carbon::now(),['class'=>'form-control','placeholder'=>'Report of Type','id'=>'date_start']) !!}
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <span class="input-group-addon">End</span>
                                {!! Form::date('date_end',\Carbon\Carbon::now()->format('Y-m-d'),['class'=>'form-control','placeholder'=>'Report of Type','id'=>'date_end']) !!}
                                </div>
                            </div>
                    </div>
                    <div class="form-group" id="supplier" style="display:none">
                        {!! Form::label('keyword','Keyword',['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-6">
                             <input list='data-supplier' class="form-control" placeholder="Keyword of Supplier" id="text-supplier" autocomplete="off">
                             @if(isset($data_supplier))
                             <datalist id="data-supplier">
                                 @foreach($data_supplier as $key)
                                    <option value="{{ $key['name']}}">
                                 @endforeach
                             </datalist>
                             @endif
                        </div>
                    </div>
                    <div class="form-group" id="customer" style="display:none">
                        {!! Form::label('keyword','Keyword',['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-6">
                             <input list='data-customer' class="form-control" placeholder="Keyword of Customer" id="text-customer" autocomplete="off">
                             @if(isset($data_customer))
                             <datalist id="data-customer">
                                 @foreach($data_customer as $key)
                                    <option value="{{ $key['name']}}">
                                 @endforeach
                             </datalist>
                             @endif
                        </div>
                    </div>
                    <div class="form-group" id="product" style="display:none">
                        {!! Form::label('product','Product',['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-6">
                             {!! Form::text('product',null,['class'=>'form-control', 'placeholder'=>'Product of report', 'id'=>'']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('', '', ['class'=>'col-sm-2 control-label']) !!}
                      <div class="col-sm-6">
                        <a href="{{ url('driver') }}" class="btn btn-default">
                          <i class="fa fa-repeat"></i>&nbsp;Cancel
                        </a>&nbsp;
                        <button type="submit" class="btn btn-info" id="btn-submit-driver">
                          <i class="fa fa-save"></i>&nbsp;Submit
                        </button>
                      </div>
                    </div>
                </div>
                <div class="box-footer clearfix">
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    @if(isset($report_type))
    <div class="row">
        <div class="col-lg-12">
            <div class="box" style="box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);border-top:none">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        @if($report_type == 0)
                            Ringkasan Penjualan
                        @elseif($report_type == 1)
                            Detail Penjualan
                        @elseif($report_type == 2)
                            Ringkasan Return Penjualan
                        @elseif($report_type == 3)
                            Detail Return Penjualan
                        @elseif($report_type == 4)
                            Ringkasan Pembelian
                        @elseif($report_type == 5)
                            Detail Pembelian
                        @elseif($report_type == 6)
                            Ringkasan Return Pembelian
                        @elseif($report_type == 7)
                            Detail Return Pembelian
                        @elseif($report_type == 8)
                            Rincian Penjualan per Pelanggan
                        @elseif($report_type == 9)
                            Penjualan per Pelanggan
                        @endif
                    </h3>
                </div>
                <div class="box-body">
                    <div class="table responsive">
                        @if($report_type == 0)
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th style="width:10%;background-color:#3c8dbc;color:white">Invoice</th>
                                    <th style="width:10%;background-color:#3c8dbc;color:white">Date</th>
                                    <th style="width:20%;background-color:#3c8dbc;color:white">Customer</th>
                                    <th style="width:10%;background-color:#3c8dbc;color:white">Sub Total</th>
                                    <th style="width:10%;background-color:#3c8dbc;color:white">Disc(%)</th>
                                    <th style="width:10%;background-color:#3c8dbc;color:white">Tax(%)</th>
                                    <th style="width:10%;background-color:#3c8dbc;color:white">Nilai Faktur</th>
                                    <th style="width:10%;background-color:#3c8dbc;color:white">Retur</th>
                                    <th style="width:10%;background-color:#3c8dbc;color:white">Net</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $sum_bill_price = 0; ?>
                                @foreach($data_invoice as $d_i)
                                    <tr>
                                        <td>{{ $d_i['no_faktur'] }}</td>
                                        <td>
                                            <?php
                                                $datenya = date_create($d_i['tgl_faktur']);
                                            ?>
                                            {{ date_format($datenya,'d-m-Y') }}
                                        </td>
                                        <td>{{ $d_i['customer'] }}</td>
                                        <td>{{ $d_i['sub_total'] }}</td>
                                        <td>{{ $d_i['disc'] }}</td>
                                        <td>{{ $d_i['tax'] }}</td>
                                        <td>
                                            {{ number_format($d_i['bill_price']) }}
                                        </td>
                                            <?php $x = []; $sum = 0;?>
                                            @foreach($d_i['return'] as $kj)

                                                <?php array_push($x,[
                                                    'price_per_unit'=>\DB::table('product_sales_order')->select('price_per_unit')->where('sales_order_id',$kj->sales_order_id)->where('product_id',$kj->product_id)->get()[0]->price_per_unit,
                                                    'quantity'=>$kj->quantity
                                                ]);
                                                ?>
                                            @endforeach
                                            @foreach($x as $xx)
                                                <?php $sum += $xx['price_per_unit']*$xx['quantity']; ?>
                                            @endforeach
                                            <td>{{ number_format($sum) }}</td>

                                        <td>
                                            {{ number_format($d_i['net']-$sum) }}
                                            <?php $sum_bill_price += $d_i['net']-$sum; ?>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="7" align="right">Total Net</td>
                                    <td style="background-color:red;color:white" colspan="2">{{ number_format($sum_bill_price) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                        @elseif($report_type == 1)
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No.Faktur</th>
                                    <th>Tgl Faktur</th>
                                    <th>Customer</th>
                                    <th>Item</th>
                                    <th>Unit Price</th>
                                    <th>Quantity</th>
                                    <th>Disc(%)</th>
                                    <th>Disc(AMT)</th>
                                    <th>Line Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $sum_bill_price = 0; ?>
                                @foreach($data_invoice as $d_i)
                                    <tr>
                                        <td>{{ $d_i['no_faktur'] }}</td>
                                        <td>{{ $d_i['tgl_faktur'] }}</td>
                                        <td>{{ $d_i['customer'] }}</td>
                                        <td>{{ $d_i['item'] }}</td>
                                        <td>{{ number_format($d_i['unit_price']) }}</td>
                                        <td>{{ $d_i['quantity'] }}</td>
                                        <td>{{ $d_i['disc'] }}</td>
                                        <td>{{ $d_i['disc_amt'] }}</td>
                                        <td>
                                            {{ number_format($d_i['line_total']) }}
                                            <?php $sum_bill_price += $d_i['line_total']; ?>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="6" align="right">Total</td>
                                    <td style="background-color:red;color:white">{{ number_format($sum_bill_price) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                        @elseif($report_type == 2)
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width:10%;background-color:#3c8dbc;color:white">Invoice</th>
                                    <th style="width:10%;background-color:#3c8dbc;color:white">Date</th>
                                    <th style="width:20%;background-color:#3c8dbc;color:white">Customer</th>
                                    <th style="width:10%;background-color:#3c8dbc;color:white">Sub Total</th>
                                    <th style="width:10%;background-color:#3c8dbc;color:white">Disc(%)</th>
                                    <th style="width:10%;background-color:#3c8dbc;color:white">Tax(%)</th>
                                    <th style="width:10%;background-color:#3c8dbc;color:white">Total</th>
                                    <th style="width:10%;background-color:#3c8dbc;color:white">Retur</th>
                                    <th style="width:10%;background-color:#3c8dbc;color:white">Net</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $sum_bill_price = 0; ?>
                                @foreach($data_invoice as $d_i)
                                    <tr>
                                        <td>{{ $d_i['no_faktur'] }}</td>
                                        <td>
                                            <?php
                                                $datenya = date_create($d_i['tgl_faktur']);
                                            ?>
                                            {{ date_format($datenya,'d-m-Y') }}
                                        </td>
                                        <td>{{ $d_i['customer'] }}</td>
                                        <td>{{ $d_i['sub_total'] }}</td>
                                        <td>{{ $d_i['disc'] }}</td>
                                        <td>{{ $d_i['tax'] }}</td>
                                        <?php $x = []; $sum = 0;?>
                                        @foreach($d_i['total'] as $kj)

                                            <?php array_push($x,[
                                                'price_per_unit'=>\DB::table('product_sales_order')->select('price_per_unit')->where('sales_order_id',$kj->sales_order_id)->where('product_id',$kj->product_id)->get()[0]->price_per_unit,
                                                'quantity'=>$kj->quantity
                                            ]);
                                            ?>
                                        @endforeach
                                        @foreach($x as $xx)
                                            <?php $sum += $xx['price_per_unit']*$xx['quantity']; ?>
                                        @endforeach
                                        <td>- {{ number_format($sum) }}</td>
                                        <td>{{ $d_i['return'] }}</td>
                                        <td>
                                            - {{ number_format($sum) }}
                                            <?php $sum_bill_price += $sum-$d_i['return']; ?>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="6" align="right">Total</td>
                                    <td style="background-color:red;color:white">- {{ number_format($sum_bill_price) }}</td>
                                    <td align="right">Net</td>
                                    <td style="background-color:red;color:white">- {{ number_format($sum_bill_price) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                        @elseif($report_type == 3)
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No.Faktur</th>
                                    <th>Tgl Faktur</th>
                                    <th>Customer</th>
                                    <th>Item</th>
                                    <th>Unit Price</th>
                                    <th>Quantity</th>
                                    <th>Disc(%)</th>
                                    <th>Disc(amt)</th>
                                    <th>Line Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $sum_bill_price = 0; ?>
                                @foreach($data_invoice as $d_i)
                                    <tr>
                                        <td>{{ $d_i['no_faktur'] }}</td>
                                        <td>{{ $d_i['tgl_faktur'] }}</td>
                                        <td>{{ $d_i['customer'] }}</td>
                                        <td>{{ $d_i['item'] }}</td>
                                        <td>{{ number_format($d_i['unit_price']) }}</td>
                                        <td>{{ $d_i['quantity'] }}</td>
                                        <td>{{ $d_i['disc'] }}</td>
                                        <td>{{ $d_i['disc_amt'] }}</td>
                                        <td>
                                            {{ number_format($d_i['unit_price']*$d_i['quantity']) }}
                                            <?php $sum_bill_price += $d_i['unit_price']*$d_i['quantity']; ?>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="8" align="right">Total</td>
                                    <td style="background-color:red;color:white">{{ number_format($sum_bill_price) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                        @elseif($report_type == 4)
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width:10%;background-color:#3c8dbc;color:white">Invoice</th>
                                    <th style="width:10%;background-color:#3c8dbc;color:white">Date</th>
                                    <th style="width:20%;background-color:#3c8dbc;color:white">Customer</th>
                                    <th style="width:10%;background-color:#3c8dbc;color:white">Sub Total</th>
                                    <th style="width:10%;background-color:#3c8dbc;color:white">Disc(%)</th>
                                    <th style="width:10%;background-color:#3c8dbc;color:white">Tax(%)</th>
                                    <th style="width:10%;background-color:#3c8dbc;color:white">Nilai Faktur</th>
                                    <th style="width:10%;background-color:#3c8dbc;color:white">Retur</th>
                                    <th style="width:10%;background-color:#3c8dbc;color:white">Net</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $sum_bill_price = 0; ?>
                                @foreach($data_invoice as $d_i)
                                    <tr>
                                        <td>{{ $d_i['no_faktur'] }}</td>
                                        <td>
                                            <?php
                                                $datenya = date_create($d_i['tgl_faktur']);
                                            ?>
                                            {{ date_format($datenya,'d-m-Y') }}
                                        </td>
                                        <td>{{ $d_i['supplier'] }}</td>
                                        <td>{{ $d_i['sub_total'] }}</td>
                                        <td>{{ $d_i['disc'] }}</td>
                                        <td>{{ $d_i['tax'] }}</td>
                                        <td>
                                            {{ number_format($d_i['bill_price']) }}
                                        </td>
                                            <?php $x = []; $sum = 0;?>
                                            @foreach($d_i['return'] as $kj)

                                                <?php array_push($x,[
                                                    'quantity_purchase_order'=>\DB::table('product_purchase_order')->select('quantity')->where('purchase_order_id',$kj->purchase_order_id)->where('product_id',$kj->product_id)->get()[0]->quantity,
                                                    'price'=>\DB::table('product_purchase_order')->select('price')->where('purchase_order_id',$kj->purchase_order_id)->where('product_id',$kj->product_id)->get()[0]->price,
                                                    'quantity'=>$kj->quantity
                                                ]);
                                                ?>
                                            @endforeach
                                            @foreach($x as $xx)
                                                <?php $sum += (($xx['price']/$xx['quantity_purchase_order'])*$xx['quantity']); ?>
                                            @endforeach
                                            <td>{{ number_format($sum) }}</td>

                                        <td>
                                            {{ number_format($d_i['net']-$sum) }}
                                            <?php $sum_bill_price += $d_i['net']-$sum; ?>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="7" align="right">Total Net</td>
                                    <td style="background-color:red;color:white" colspan="2">{{ number_format($sum_bill_price) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                        @elseif($report_type == 5)
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No.Faktur</th>
                                    <th>Tgl Faktur</th>
                                    <th>Supplier</th>
                                    <th>Item</th>
                                    <th>Unit Price</th>
                                    <th>Quantity</th>
                                    <th>Disc(%)</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $sum_bill_price = 0; ?>
                                @foreach($data_invoice as $d_i)
                                    <tr>
                                        <td>{{ $d_i['no_faktur'] }}</td>
                                        <td>{{ $d_i['tgl_faktur'] }}</td>
                                        <td>{{ $d_i['supplier'] }}</td>
                                        <td>{{ $d_i['item'] }}</td>
                                        <td>{{ number_format($d_i['unit_price']) }}</td>
                                        <td>{{ $d_i['quantity'] }}</td>
                                        <td>{{ $d_i['disc'] }}</td>
                                        <td>
                                            {{ number_format($d_i['price']) }}
                                            <?php $sum_bill_price += $d_i['price']; ?>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="6" align="right">Total</td>
                                    <td style="background-color:red;color:white">{{ number_format($sum_bill_price) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                        @elseif($report_type == 6)
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th style="width:10%;background-color:#3c8dbc;color:white">Invoice</th>
                                    <th style="width:10%;background-color:#3c8dbc;color:white">Date</th>
                                    <th style="width:20%;background-color:#3c8dbc;color:white">Supplier</th>
                                    <th style="width:10%;background-color:#3c8dbc;color:white">Sub Total</th>
                                    <th style="width:10%;background-color:#3c8dbc;color:white">Disc(%)</th>
                                    <th style="width:10%;background-color:#3c8dbc;color:white">Tax(%)</th>
                                    <th style="width:10%;background-color:#3c8dbc;color:white">Total</th>
                                    <th style="width:10%;background-color:#3c8dbc;color:white">Retur</th>
                                    <th style="width:10%;background-color:#3c8dbc;color:white">Net</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $sum_bill_price = 0; ?>
                                @foreach($data_invoice as $d_i)
                                    <tr>
                                        <td>{{ $d_i['no_faktur'] }}</td>
                                        <td>
                                            <?php
                                                $datenya = date_create($d_i['tgl_faktur']);
                                            ?>
                                            {{ date_format($datenya,'d-m-Y') }}
                                        </td>
                                        <td>{{ $d_i['supplier'] }}</td>
                                        <td>{{ $d_i['sub_total'] }}</td>
                                        <td>{{ $d_i['disc'] }}</td>
                                        <td>{{ $d_i['tax'] }}</td>
                                        <?php $x = []; $sum = 0;?>
                                        @foreach($d_i['total'] as $kj)
                                            <?php array_push($x,[
                                                'quantity_purchase_order'=>\DB::table('product_purchase_order')->select('quantity')->where('purchase_order_id',$kj->purchase_order_id)->where('product_id',$kj->product_id)->get()[0]->quantity,
                                                'price'=>\DB::table('product_purchase_order')->select('price')->where('purchase_order_id',$kj->purchase_order_id)->where('product_id',$kj->product_id)->get()[0]->price,
                                                'quantity'=>$kj->quantity
                                            ]);
                                            ?>
                                        @endforeach
                                        @foreach($x as $xx)
                                            <?php $sum += (($xx['price']/$xx['quantity_purchase_order'])*$xx['quantity']); ?>
                                        @endforeach
                                        <td>- {{ number_format($sum) }}</td>
                                        <td>{{ $d_i['return'] }}</td>
                                        <td>
                                            - {{ number_format($sum) }}
                                            <?php $sum_bill_price += $sum-$d_i['return']; ?>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="6" align="right">Total</td>
                                    <td style="background-color:red;color:white">- {{ number_format($sum_bill_price) }}</td>
                                    <td align="right">Net</td>
                                    <td style="background-color:red;color:white">- {{ number_format($sum_bill_price) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                        @elseif($report_type == 7)
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No.Faktur</th>
                                    <th>Tgl Faktur</th>
                                    <th>Supplier</th>
                                    <th>Item</th>
                                    <th>Unit Price</th>
                                    <th>Quantity</th>
                                    <th>Disc(%)</th>
                                    <th>Disc(amt)</th>
                                    <th>Line Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $sum_bill_price = 0; ?>
                                @foreach($data_invoice as $d_i)
                                    <tr>
                                        <td>{{ $d_i['no_faktur'] }}</td>
                                        <td>{{ $d_i['tgl_faktur'] }}</td>
                                        <td>{{ $d_i['supplier'] }}</td>
                                        <td>{{ $d_i['item'] }}</td>
                                        <td>{{ number_format($d_i['unit_price']) }}</td>
                                        <td>{{ $d_i['quantity'] }}</td>
                                        <td>{{ $d_i['disc'] }}</td>
                                        <td>{{ $d_i['disc_amt'] }}</td>
                                        <td>
                                            {{ number_format($d_i['unit_price']*$d_i['quantity']) }}
                                            <?php $sum_bill_price += $d_i['unit_price']*$d_i['quantity']; ?>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="8" align="right">Total</td>
                                    <td style="background-color:red;color:white">{{ number_format($sum_bill_price) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                        @elseif($report_type == 8)
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No.Faktur</th>
                                    <th>Tgl Faktur</th>
                                    <th>Keterangan</th>
                                    <th>Nilai Faktur</th>
                                    <th>Retur</th>
                                    <th>Netto</th>
                                    <th>Customer</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $sum_bill_price = 0; ?>
                                @foreach($data_invoice as $d_i)
                                    <tr>
                                        <td>{{ $d_i['no_faktur'] }}</td>
                                        <td>{{ $d_i['tgl_faktur'] }}</td>
                                        <td>{{ $d_i['keterangan'] }}</td>
                                        <td>
                                            {{ number_format($d_i['bill_price']) }}
                                            <?php $sum_bill_price += $d_i['bill_price']; ?>
                                        </td>
                                        <td>{{ $d_i['return'] }}</td>
                                        <td>{{ $d_i['netto'] }}</td>
                                        <td>{{ $d_i['customer'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="6" align="right">Total</td>
                                    <td style="background-color:red;color:white">{{ number_format($sum_bill_price) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                        @elseif($report_type == 9)
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No.Faktur</th>
                                    <th>Tgl Faktur</th>
                                    <th>Keterangan</th>
                                    <th>Nilai Faktur</th>
                                    <th>Customer</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $sum_bill_price = 0; ?>
                                @foreach($data_invoice as $d_i)
                                    <tr>
                                        <td>{{ $d_i['no_faktur'] }}</td>
                                        <td>{{ $d_i['tgl_faktur'] }}</td>
                                        <td>{{ $d_i['keterangan'] }}</td>
                                        <td>
                                            {{ number_format($d_i['bill_price']) }}
                                            <?php $sum_bill_price += $d_i['bill_price']; ?>
                                        </td>
                                        <td>{{ $d_i['customer'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" align="right">Total</td>
                                    <td style="background-color:red;color:white">{{ number_format($sum_bill_price) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                        @endif
                    </div>
                </div>
                <div class="box-footer clearfix">

                </div>
            </div>
        </div>
    </div>
    @else

    @endif
@endsection

@section('additional_scripts')
    <script type="text/javascript">
        $('#type_report').on('click',function(){
            var reportType = $('#type_report').val();
            if(reportType == 8 || reportType == 9){
                $('#supplier').hide();
                $('#customer').show();
                $('#product').hide();
                $('#text-customer').attr('name','keyword');
                $('#text-supplier').attr('name','');
            }else if (reportType == 0) {
                $('#customer').hide();
                $('#supplier').hide();
                $('#product').hide();
                $('#text-supplier').attr('name','');
                $('#text-customer').attr('name','');
            }else if (reportType == 1) {
                $('#customer').hide();
                $('#supplier').hide();
                $('#product').show();
                $('#text-supplier').attr('name','');
                $('#text-customer').attr('name','');
            }else if (reportType == 2) {
                $('#customer').hide();
                $('#supplier').hide();
                $('#product').hide();
                $('#text-supplier').attr('name','');
                $('#text-customer').attr('name','');
            }else if (reportType == 3) {
                $('#customer').hide();
                $('#supplier').hide();
                $('#product').show();
                $('#text-supplier').attr('name','');
                $('#text-customer').attr('name','');
            }else if (reportType == 4) {
                $('#customer').hide();
                $('#supplier').show();
                $('#product').hide();
                $('#text-supplier').attr('name','');
                $('#text-customer').attr('name','');
            }else if (reportType == 5) {
                $('#customer').hide();
                $('#supplier').show();
                $('#product').show();
                $('#text-supplier').attr('name','');
                $('#text-customer').attr('name','');
            }else if (reportType == 6) {
                $('#customer').hide();
                $('#supplier').show();
                $('#product').hide();
                $('#text-supplier').attr('name','');
                $('#text-customer').attr('name','');
            }else if (reportType == 7) {
                $('#customer').hide();
                $('#supplier').show();
                $('#product').show();
                $('#text-supplier').attr('name','');
                $('#text-customer').attr('name','');
            }else{
                $('#customer').hide();
                $('#supplier').show();
                $('#product').hide();
                $('#text-supplier').attr('name','keyword');
                $('#text-customer').attr('name','');
            }
        });
    </script>
@endsection
