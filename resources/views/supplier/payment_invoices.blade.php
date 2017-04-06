@extends('layouts.app')

@section('page_title')
  Create Purchase Invoice Payment
@endsection

@section('page_header')
  <h1>
    Purchase Order
    <small>Create Invoice Payment</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('supplier') }}"><i class="fa fa-dashboard"></i> Supplier</a></li>
    <li><a href="{{ URL::to('supplier/'.$supplier->id.'/payment-invoices') }}"><i class="fa fa-dashboard"></i>{{ $supplier->code}}</a></li>
    <li class="active">Create Payment</li>
  </ol>
@endsection

@section('content')
    <ul class="nav nav-tabs">
        <li class="active">
            <a data-toggle="tab" href="#section-payment-method-cash"><i class="fa fa-desktop"></i>&nbsp;Cash</a>
        </li>
        <li>
            <a data-toggle="tab" href="#section-payment-method-bank"><i class="fa fa-desktop"></i>&nbsp;Bank Transfer</a>
        </li>
    </ul>
    <div class="tab-content">
        <div id="section-payment-method-cash" class="tab-pane fade in active">
            <div class="row">
                <div class="col-lg-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Form Input Payment</h3>
                        </div>
                        <div class="box-body">
                            {!! Form::open(['url'=>'supplier.store_invoice_payment_cash','role'=>'form','class'=>'form-horizontal','id'=>'store-invoices-payment-supplier','method'=>'post']) !!}
                            <div class="form-group{{ $errors->has('cash_id') ? 'has-error' : '' }}">
                                {!! Form::label('cash_id','Cash',['class'=>'col-sm-2 control-label']) !!}
                                <div class="col-sm-4">
                                    {{ Form::select('cash_id',$cashs,null,['class'=>'form-control','placeholder'=>'Select Cash','id'=>'cash_id']) }}
                                    @if($errors->has('cash_id'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('cash_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('sum_amount') ? 'has-error' : '' }}">
                                {!! Form::label('sum_amount','Total Amount',['class'=>'col-sm-2 control-label']) !!}
                                <div class="col-sm-4">
                                {{ Form::text('sum_amount',null,['class'=>'form-control','placeholder'=>'Payment amount','id'=>'sum-amount-cash','autocomplete'=>'off']) }}
                                @if($errors->has('sum_amount'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('sum_amount') }}</strong>
                                    </span>
                                @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('amount') ? 'has-error' : '' }}">
                                {!! Form::label('select_account','Deposit to Account',['class'=>'col-sm-2 control-label']) !!}
                                <div class="col-sm-4">
                                <select name="cash_account" class="form-control">
                                    <option value="">Select Account</option>
                                @foreach(list_account_cash_bank('51') as $as)
                                    @if($as->level == 1)
                                    <optgroup label="{{ $as->name }}">
                                    @endif
                                    @if($as->level == 2)
                                    <option value="{{ $as->id }}">{{ $as->account_number }}&nbsp;&nbsp;{{ $as->name }}</option>
                                    @endif
                                @endforeach
                                </select>
                                @if($errors->has('amount'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('amount') }}</strong>
                                    </span>
                                @endif
                                </div>
                            </div>
                            <table class="table table-responsive table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Code Invoice</th>
                                        <th>Bill Price</th>
                                        <th>Paid Price</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    @foreach($data_invoice as $d_i)
                                        @if($d_i['status'] != 'completed')
                                            <tr>
                                                <td>
                                                    {{ $no++ }}
                                                    <input type="hidden" name="invoice_id[]" value="{{ $d_i['id']}}">
                                                    <input type="hidden" name="purchase_order_id[]" value="{{ $d_i['purchase_order_id']}}">
                                                    <input type="hidden" name="paid_price[]" value="{{ $d_i['paid_price']}}">
                                                </td>
                                                <td>{{ $d_i['code']}}</td>
                                                <td>{{ number_format($d_i['bill_price']) }}</td>
                                                <td>{{ number_format($d_i['paid_price']) }}</td>
                                                <td><input type="text" name="amount[]" class="amount-invoice"></td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                                <tfoot>

                                </tfoot>
                            </table>

                            <div class="form-group">
                              {!! Form::label('', '', ['class'=>'col-sm-2 control-label']) !!}
                              <div class="col-sm-10">
                                <a href="{{ url('supplier') }}" class="btn btn-default">
                                  <i class="fa fa-repeat"></i>&nbsp;Cancel
                                </a>&nbsp;
                                <button type="submit" class="btn btn-info" id="btn-submit-payment">
                                  <i class="fa fa-save"></i>&nbsp;Submit
                                </button>
                              </div>
                            </div>
                              <input type="hidden" name="payment_method_id" value="2">
                              {!! Form::close() !!}
                        </div>
                        <div class="box-footer clearfix">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="section-payment-method-bank" class="tab-pane fade">
            <div class="row">
                <div class="col-lg-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Form Input Payment</h3>
                        </div>
                        <div class="box-body">
                            {!! Form::open(['url'=>'supplier.store_invoice_payment_bank','role'=>'form','class'=>'form-horizontal','id'=>'store-invoices-payment-supplier','method'=>'post']) !!}
                            <div class="form-group{{ $errors->has('bank_id') ? 'has-error' : '' }}">
                                {!! Form::label('bank_id','Bank',['class'=>'col-sm-2 control-label']) !!}
                                <div class="col-sm-4">
                                    {{ Form::select('bank_id',$banks,null,['class'=>'form-control','placeholder'=>'Select Bank','id'=>'cash_id']) }}
                                    @if($errors->has('bank_id'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('bank_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('sum_amount') ? 'has-error' : '' }}">
                                {!! Form::label('sum_amount','Total Amount',['class'=>'col-sm-2 control-label']) !!}
                                <div class="col-sm-4">
                                {{ Form::text('sum_amount',null,['class'=>'form-control','placeholder'=>'Payment amount','id'=>'sum-amount-bank','autocomplete'=>'off']) }}
                                @if($errors->has('sum_amount'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('sum_amount') }}</strong>
                                    </span>
                                @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('amount') ? 'has-error' : '' }}">
                                {!! Form::label('select_account','Deposit to Account',['class'=>'col-sm-2 control-label']) !!}
                                <div class="col-sm-4">
                                <select name="transfer_account" class="form-control">
                                    <option value="">Select Account</option>
                                @foreach(list_account_cash_bank('51') as $as)
                                    @if($as->level == 1)
                                    <optgroup label="{{ $as->name }}">
                                    @endif
                                    @if($as->level == 2)
                                    <option value="{{ $as->id }}">{{ $as->account_number }}&nbsp;&nbsp;{{ $as->name }}</option>
                                    @endif
                                @endforeach
                                </select>
                                @if($errors->has('amount'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('amount') }}</strong>
                                    </span>
                                @endif
                                </div>
                            </div>
                            <table class="table table-responsive table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Code Invoice</th>
                                        <th>Bill Price</th>
                                        <th>Paid Price</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    @foreach($data_invoice as $d_i)
                                        <tr>
                                            <td>
                                                {{ $no++ }}
                                                <input type="hidden" name="invoice_id[]" value="{{ $d_i['id']}}">
                                                <input type="hidden" name="purchase_order_id[]" value="{{ $d_i['purchase_order_id']}}">
                                                <input type="hidden" name="paid_price[]" value="{{ $d_i['paid_price']}}">
                                            </td>
                                            <td>{{ $d_i['code']}}</td>
                                            <td>{{ number_format($d_i['bill_price']) }}</td>
                                            <td>{{ number_format($d_i['paid_price']) }}</td>
                                            <td>
                                                <input type="text" name="amount[]" class="amount-invoice-bank">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>

                                </tfoot>
                            </table>

                            <div class="form-group">
                              {!! Form::label('', '', ['class'=>'col-sm-2 control-label']) !!}
                              <div class="col-sm-10">
                                <a href="{{ url('supplier') }}" class="btn btn-default">
                                  <i class="fa fa-repeat"></i>&nbsp;Cancel
                                </a>&nbsp;
                                <button type="submit" class="btn btn-info" id="btn-submit-payment">
                                  <i class="fa fa-save"></i>&nbsp;Submit
                                </button>
                              </div>
                            </div>
                              <input type="hidden" name="payment_method_id" value="1">
                              {!! Form::close() !!}
                        </div>
                        <div class="box-footer clearfix">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('additional_scripts')

  {!! Html::script('js/autoNumeric.js') !!}
  <script type="text/javascript">
    $('#sum-amount-cash').autoNumeric('init',{
        aSep:',',
        aDec:'.'
    });

    $('#sum-amount-bank').autoNumeric('init',{
        aSep:',',
        aDec:'.'
    });

    $('.amount-invoice').autoNumeric('init',{
        aSep:',',
        aDec:'.'
    });

    $('.amount-invoice-bank').autoNumeric('init',{
        aSep:',',
        aDec:'.'
    });

    //block handle price value keyup event
    $('.amount-invoice').on('keyup',function(){
        fill_the_bill_price();
    });

    $('.amount-invoice-bank').on('keyup',function(){
        fill_the_bill_price_bank();
    });

    function fill_the_bill_price(){
        var sum = 0;
        $('.amount-invoice').each(function(){
            sum += +$(this).val().replace(/,/g,'');
        });
        $('#sum-amount-cash').val(sum);
        $('#sum-amount-cash').autoNumeric('update',{
            aSep:',',
            aDec:'.'
        });
    }

    function fill_the_bill_price_bank(){
        var sum = 0;
        $('.amount-invoice-bank').each(function(){
            sum += +$(this).val().replace(/,/g,'');
        });
        $('#sum-amount-bank').val(sum);
        $('#sum-amount-bank').autoNumeric('update',{
            aSep:',',
            aDec:'.'
        });
    }
  </script>

@endSection
