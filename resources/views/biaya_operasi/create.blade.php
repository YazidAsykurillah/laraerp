@extends('layouts.app')

@section('page_title')
    Biaya Operasi
@endsection

@section('page_header')
    <h1>
        Biaya Operasi
        <small>Create Biaya Operasi</small>
    </h1>
@endsection

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{ URL::to('biaya-operasi') }}"><i class="fa fa-dashboard"></i> Biaya Operasi</a></li>
        <li class="active"><i></i> Create</li>
    </ol>
@endsection

@section('content')
    {!! Form::open(['route'=>'biaya-operasi.store','role'=>'form','class'=>'form-horizontal','id'=>'form-create-biaya-operasi']) !!}
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Create New Biaya Operasi</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            {!! Form::label('expenses_account', 'Expenses Account', ['class'=>'col-sm-2 control-label']) !!}
                            <div class="col-sm-4">
                                <select name="beban_operasi_account" id="beban_operasi_account" class="form-control">
                                  <option value="">Expenses Account</option>
                                  @foreach(list_account_inventory('64') as $as)
                                    @if($as->level ==1)
                                    <optgroup label="{{ $as->name}}">
                                    @endif
                                    @foreach(list_sub_inventory('2',$as->id) as $sub)
                                      <option value="{{ $sub->id}}">{{ $sub->account_number }}&nbsp;&nbsp;{{ $sub->name}}</option>
                                    @endforeach
                                  @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('cash_bank_account', 'Cash/Bank Account', ['class'=>'col-sm-2 control-label']) !!}
                            <div class="col-sm-4">
                                <select name="cash_bank_account" id="cash_bank_account" class="form-control">
                                  <option value="">Cash/Bank Account</option>
                                  @foreach(list_account_inventory('51') as $as)
                                    @if($as->level ==1)
                                    <optgroup label="{{ $as->name}}">
                                    @endif
                                    @foreach(list_sub_inventory('2',$as->id) as $sub)
                                      <option value="{{ $sub->id}}">{{ $sub->account_number }}&nbsp;&nbsp;{{ $sub->name}}</option>
                                    @endforeach
                                  @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
                          {!! Form::label('amount', 'Amount', ['class'=>'col-sm-2 control-label']) !!}
                          <div class="col-sm-4">
                            {!! Form::text('amount',null,['class'=>'form-control', 'placeholder'=>'Amount of the biaya operasi', 'id'=>'amount']) !!}
                            @if ($errors->has('amount'))
                              <span class="help-block">
                                <strong>{{ $errors->first('amount') }}</strong>
                              </span>
                            @endif
                          </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('', '', ['class'=>'col-sm-2 control-label']) !!}
                          <div class="col-sm-4">
                            <a href="{{ url('biaya-operasi') }}" class="btn btn-default">
                              <i class="fa fa-repeat"></i>&nbsp;Cancel
                            </a>&nbsp;
                            <button type="submit" class="btn btn-info" id="btn-submit-bank">
                              <i class="fa fa-save"></i>&nbsp;Submit
                            </button>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {!! Form::close() !!}
@endsection

@section('additional_scripts')
    {!! Html::script('js/autoNumeric.js') !!}
    <script type="text/javascript">
        $('#amount').autoNumeric('init',{
            aSep:',',
            aDec:'.'
        });
    </script>
@endsection
