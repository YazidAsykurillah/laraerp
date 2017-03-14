@extends('layouts.app')

@section('page_title')
  Stock Balance
@endsection

@section('page_header')
  <h1>
    Add New Stock Balance
    <small>Add New Stock Balance Page</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('stock_balance') }}"><i class="fa fa-dashboard"></i> stock balance</a></li>
    <li class="active"><i></i> Create</li>
  </ol>
@endsection

@section('content')
  {!! Form::open(['route'=>'stock_balance.store','role'=>'form','class'=>'form-horizontal','id'=>'form-create-stock-balance','files'=>true]) !!}
  <div class="row">
    <div class="col-md-12">
      <!--BOX Basic Informations-->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Basic Informations</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <div class="form-group{{ $errors->has('code') ? ' has-error' : '' }}">
            {!! Form::label('code', 'Code', ['class'=>'col-sm-4 control-label']) !!}
            <div class="col-sm-4">
              {!! Form::text('code',null,['class'=>'form-control', 'placeholder'=>'Code of the stock balance', 'id'=>'code']) !!}
              @if ($errors->has('code'))
                <span class="help-block">
                  <strong>{{ $errors->first('code') }}</strong>
                </span>
              @endif
            </div>
          </div>

        </div><!-- /.box-body -->
      </div>
      <!--ENDBOX Basic Informations-->
    </div>

  </div>


  <div class="row">
    <div class="col-lg-12">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Product</h3>
          <!-- <a href="{{ URL::to('stock_balance/create')}}" class="btn btn-primary pull-right" title="Create new stocks balance">
            <i class="fa fa-plus"></i>&nbsp;Add New
          </a> -->
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive">
          <table class="table table-bordered" id="table-product">
            <thead>
              <tr>
                  <th style="width:5%;">#</th>
                  <th style="width:20%;">Product Name</th>
                  <th style="width:30%;">Description</th>
                  <th style="width:10%;">System Stock</th>
                  <th style="width:10%;">Real Stock</th>
                  <th style="width:25%;">Information</th>
              </tr>
            </thead>
            <!-- <thead id="searchid">
              <tr>
                  <th style="width:5%;"></th>
                  <th style="width:10%;">Code</th>
                  <th style="width:40%;">Product Name</th>
                  <th style="width:20%;">System Stock</th>
                  <th style="width:20%;">Real Stock</th>
                  <th style="width:10%;text-align:center;"></th>
              </tr>
            </thead> -->
            <tbody>
                <?php $no = 1; ?>
                @foreach($dataList as $view)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $view->name }}</td>
                        <td>{{ $view->description }}<input type="hidden" value="{{ $view->id }}"name="product_id[]"></td>
                        <td>{{ $view->stock }}<input type="hidden" value="{{ $view->stock }}" name="system_stock[]"></td>
                        <td>
                            <input type="text" value="{{ $view->stock }}" name="real_stock[]" class="col-lg-12">
                            @if ($errors->has('real_stock[]'))
                              <span class="help-block">
                                <strong>{{ $errors->first('real_stock[]') }}</strong>
                              </span>
                            @endif
                        </td>
                        <td>
                            <input type="text" name="information[]" class="col-lg-12" value="">
                            @if ($errors->has('information[]'))
                              <span class="help-block" style="color:red;font-size:8pt">
                                <strong>{{ $errors->first('information[]') }}</strong>
                              </span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
          </table>
        </div><!-- /.box-body -->
        <div class="box-footer clearfix">

        </div>
      </div><!-- /.box -->

    </div>
  </div>

  <!--ROW Submission-->
  <div class="row">
    <div class="col-md-12">
      <!--BOX submission buttons-->
      <div class="box">
        <div class="box-body">
          <div class="form-group">
              {!! Form::label('', '', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              <a href="{{ url('stock_balance') }}" class="btn btn-default">
                <i class="fa fa-repeat"></i>&nbsp;Cancel
              </a>&nbsp;
              <button type="submit" class="btn btn-info" id="btn-submit-stock-balance">
                <i class="fa fa-save"></i>&nbsp;Submit
              </button>
            </div>
          </div>
        </div>
      </div>
      <!--ENDBOX submission buttons-->
    </div>
  </div>
  <!--ENDROW Submission-->
  {!! Form::close() !!}


@endsection

@section('additional_scripts')
  <script type="text/javascript">
    $('#btn-submit-driver').click(function(){
      $(this).attr('disable', 'disabled');
    });

    // Delete button handler
    tableProduct.on('click', '.btn-delete-product', function (e) {
      var id = $(this).attr('data-id');
      var name = $(this).attr('data-text');
      $('#product_id').val(id);
      $('#product-name-to-delete').text(name);
      $('#modal-delete-product').modal('show');
    });



    //Delete product process
    // $('#form-delete-product').on('submit', function(){
    //   $('#btn-confirm-delete-product').prop('disabled', true);
    // });
  </script>
@endsection
