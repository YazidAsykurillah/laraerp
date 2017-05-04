@extends('layouts.app')

@section('page_title')
  Adjustment Products
@endsection

@section('page_header')
  <h1>
    Banks
    <small>Adjustment of The Products </small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('product-adjustment') }}"><i class="fa fa-dashboard"></i> Adjustment Products</a></li>
    <li class="active"><i></i>Create</li>
  </ol>
@endsection

@section('content')
  {!! Form::open(['route'=>'product-adjustment.store','role'=>'form','class'=>'form-horizontal','id'=>'form-product-adjustment']) !!}
  <div class="row">
    <div class="col-lg-12">
      <div class="box" style="box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);border-top:none">
        <div class="box-header with-border">
          <h3 class="box-title">Create New Adjustment Products</h3>

        </div><!-- /.box-header -->
        <div class="box-body">
          <div class="form-group{{ $errors->has('adjust_no') ? ' has-error' : '' }}">
            {!! Form::label('adjust_no', 'Adjust No', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-4">
              {!! Form::text('adjust_no',null,['class'=>'form-control', 'placeholder'=>'Adjust no of the products', 'id'=>'adjust_no']) !!}
              @if ($errors->has('adjust_no'))
                <span class="help-block">
                  <strong>{{ $errors->first('adjust_no') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group{{ $errors->has('in_out') ? ' has-error' : '' }}">
            {!! Form::label('in_out', 'IN/OUT', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-4">
              {!! Form::select('in_out',['in'=>'IN','out'=>'OUT'],null,['class'=>'form-control', 'placeholder'=>'IN/OUT of the products', 'id'=>'in-out']) !!}
              @if ($errors->has('in_out'))
                <span class="help-block">
                  <strong>{{ $errors->first('in_out') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group{{ $errors->has('adjust_account') ? ' has-error' : '' }}">
            {!! Form::label('adjust_account', 'Adjust Account', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-4">
              <select name="adjust_account" id="adjust-account" class="form-control">
                  <option value="">Select Adjust Account</option>
                  @foreach($adjust_account as $ac)
                    <option value="{{$ac->id}}">{{ $ac->account_number.' '.$ac->name }}</option>
                  @endforeach
              </select>
              @if ($errors->has('adjust_account'))
                <span class="help-block">
                  <strong>{{ $errors->first('adjust_account') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group{{ $errors->has('notes') ? ' has-error' : '' }}">
            {!! Form::label('notes', 'Notes', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-4">
              {!! Form::textarea('notes',null,['class'=>'form-control', 'placeholder'=>'Initial notes of the bank', 'id'=>'notes' , 'style'=>'height:100px']) !!}
              @if ($errors->has('notes'))
                <span class="help-block">
                  <strong>{{ $errors->first('notes') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="table-responsive">
              <table class="table table-hover table-striped">
                  <thead>
                      <tr style="background-color:#3c8dbc;color:white">
                          <th style="width:20%">Code</th>
                          <th style="width:20%">Description</th>
                          <th style="width:10%">Unit</th>
                          <th>Unit Cost</th>
                          <th>Qty</th>
                          <th>Total</th>
                      </tr>
                  </thead>
                  <tbody id="select-table">
                      <tr>
                          <td>
                              <select name="select_product" class="form-control" id="select-product">
                                  <option>Select Product</option>
                                  @foreach($product as $p)
                                    <option value="{{$p->id}}">{{$p->name}}</option>
                                  @endforeach
                              </select>
                          </td>
                          <td>
                              <input type="text" name="select_description" class="form-control" id="select-description">
                          </td>
                          <td>
                              <input type="text" name="select_unit" class="form-control" id="select-unit">
                          </td>
                          <td>
                              <input type="text" name="select_unit" class="form-control" id="select-unit-cost">
                          </td>
                          <td>
                              <input type="text" name="select_unit" class="form-control" id="select-qty">
                          </td>
                          <td>
                              <input type="text" name="select_unit" class="form-control" id="select-total">
                          </td>
                      </tr>
                  </tbody>
              </table>
              <button class="btn btn-default" type="button" id="add-line">+</button>
          </div>
          <div class="form-group">
              {!! Form::label('', '', ['class'=>'col-sm-3 control-label']) !!}
            <div class="col-sm-9">
              <a href="{{ url('product-adjustment') }}" class="btn btn-default">
                <i class="fa fa-repeat"></i>&nbsp;Cancel
              </a>&nbsp;
              <button type="submit" class="btn btn-info" id="btn-submit-bank">
                <i class="fa fa-save"></i>&nbsp;Submit
              </button>
            </div>
          </div>
        </div><!-- /.box-body -->
        <div class="box-footer clearfix">

        </div>
      </div><!-- /.box -->

    </div>

  </div>
  {!! Form::close() !!}
@endsection

@section('additional_scripts')
{!! Html::script('js/autoNumeric.js') !!}
    <script type="text/javascript">
        $('#value').autoNumeric('init',{
            aSep:',',
            aDec:'.'
        });
    </script>

    <script type="text/javascript">
        $('#add-line').on('click', function(){
            $('#');
        })
        $(document).ready(function(){
            $('#select-product').change(function(){
                var product = $('#select-product').val();
                var token = $("meta[name='csrf-token']").attr('content');
                $.ajax({
                    url:"{!!URL::to('callFieldProduct')!!}",
                    type:'POST',
                    data:"product="+product+'&_token='+token,
                    beforeSend: function(){

                    } ,
                    success:function(response){
                        console.log(response);
                        $.each(response,function(index,value){
                            $('#select-description').val(value.description);
                        });
                    }
                });
            });
        });
    </script>
@endsection
