@extends('layouts.app')

@section('page_title')
  Create Sales Order
@endsection

@section('page_header')
  <h1>
    Sales Order
    <small>Create Sales Order</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('sales-order') }}"><i class="fa fa-dashboard"></i> Sales Order</a></li>
    <li class="active"><i></i>Create</li>
  </ol>
@endsection

@section('content')
  <!-- Row Products-->
  {!! Form::open(['route'=>'sales-order.store','role'=>'form','class'=>'form-horizontal','id'=>'form-create-sales-order']) !!}
  <div class="row">
    <div class="col-lg-12">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Products</h3>
          <a href="#" id="btn-display-product-datatables" class="btn btn-primary pull-right" title="Select products to be added">
            <i class="fa fa-list"></i>&nbsp;Select Products
          </a>
        </div><!-- /.box-header -->
        <div class="box-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="table-selected-products">
              <tr>
                <th style="width:40%">Product Name</th>
                <th style="width:20%">Quantity</th>
                <th style="width:20%">Unit</th>
              </tr>
              <tr id="tr-no-product-selected">
                <td colspan="4">No product selected</td>
              </tr>
            </table>
          </div>

        </div><!-- /.box-body -->
        <div class="box-footer clearfix">

        </div>
      </div><!-- /.box -->
    </div>
  </div>
  <!-- ENDRow Products-->
  <!-- Row customer and Notes-->
  <div class="row">
    <div class="col-md-6">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Customer and Notes</h3>
        </div><!-- /.box-header -->
        <div class="box-body">

            <div class="form-group{{ $errors->has('customer_id') ? ' has-error' : '' }}">
              {!! Form::label('customer_id', 'customer', ['class'=>'col-sm-2 control-label']) !!}
              <div class="col-sm-6">
                {{ Form::select('customer_id', $customer_options, null, ['class'=>'form-control', 'placeholder'=>'Select customer', 'id'=>'customer_id']) }}
                @if ($errors->has('customer_id'))
                  <span class="help-block">
                    <strong>{{ $errors->first('customer_id') }}</strong>
                  </span>
                @endif
              </div>
            </div>

            <div class="form-group{{ $errors->has('notes') ? ' has-error' : '' }}">
              {!! Form::label('notes', 'Notes', ['class'=>'col-sm-2 control-label']) !!}
              <div class="col-sm-6">
                {{ Form::textarea('notes', null,['class'=>'form-control', 'placeholder'=>'Notes of Sales Order', 'id'=>'notes']) }}
                @if ($errors->has('notes'))
                  <span class="help-block">
                    <strong>{{ $errors->first('notes') }}</strong>
                  </span>
                @endif
              </div>
            </div>

            <div class="form-group">
                {!! Form::label('', '', ['class'=>'col-sm-2 control-label']) !!}
              <div class="col-sm-10">
                <a href="{{ url('sales-order') }}" class="btn btn-default">
                  <i class="fa fa-repeat"></i>&nbsp;Cancel
                </a>&nbsp;
                <button type="submit" class="btn btn-info" id="btn-submit-product">
                  <i class="fa fa-save"></i>&nbsp;Submit
                </button>
              </div>
            </div>

        </div><!-- /.box-body -->
        <div class="box-footer clearfix">

        </div>
      </div><!-- /.box -->

    </div>
    <div class="col-md-6">
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Drivers and Transport</h3>
            </div>
            <div class="box-body">
                <div class="form-group{{ $errors->has('driver_id') ? 'has-error' : '' }}">
                    {!! Form::label('driver_id','Driver',['class'=>'col-sm-2 control-label']) !!}
                    <div class="col-sm-6">
                        {{ Form::select('driver_id',$driver_options,null,['class'=>'form-control','placeholder'=>'Select driver','id'=>'driver_id']) }}
                        @if($errors->has('driver_id'))
                        <span class="help-block">
                            <strong>{{ $errors->first('driver_id') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('driver_id') ? 'has-error' : '' }}">
                    {!! Form::label('vehicle_id','Vehicle',['class'=>'col-sm-2 control-label']) !!}
                    <div class="col-sm-6">
                        {{ Form::select('vehicle_id',$vehicle_options,null,['class'=>'form-control','placeholder'=>'Select vehicle','id'=>'vehicle_id']) }}
                        @if($errors->has('vehicle_id'))
                        <span class="help-block">
                            <strong>{{ $errors->first('vehicle_id') }}</strong>
                        </span>
                        @endif
                    </div>
                    </div>
            </div>
        </div>
  </div>
  <!-- ENDRow customer and Notes-->
  {!! Form::close() !!}

  <!--Modal Display product datatables-->
  <div class="modal fade" id="modal-display-products" tabindex="-1" role="dialog" aria-labelledby="modal-display-productsLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-display-productsLabel">Products list</h4>
        </div>
        <div class="modal-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="table-product">
              <thead>
                <tr>
                  <th style="width:5%;">#</th>
                  <th style="width:10%;">Code</th>
                  <th>Product Name</th>
                  <th>Stock</th>
                  <th>Minimum Stock</th>
                </tr>
              </thead>
              <thead id="searchid">
                <tr>
                  <th style="width:5%;"></th>
                  <th>Code</th>
                  <th>Product Name</th>
                  <th>Stock</th>
                  <th>Minimum Stock</th>
                </tr>
              </thead>
              <tbody>

              </tbody>
            </table>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-info" id="btn-set-product">Set selected products</button>
        </div>

      </div>
    </div>
  </div>
<!--ENDModal Display product datatables-->
@endsection


@section('additional_scripts')
  <!--Auto numeric plugin-->
  {!! Html::script('js/autoNumeric.js') !!}

  <script type="text/javascript">
    $('#btn-display-product-datatables').on('click', function(event){
      event.preventDefault();
      $('#modal-display-products').modal('show');
    });
  </script>

  <script type="text/javascript">

    var selected = [];

    var tableProduct =  $('#table-product').DataTable({
      processing :true,
      serverSide : true,
      pageLength:10,
      ajax : '{!! route('datatables.getProducts') !!}',
      columns :[
        {data: 'rownum', name: 'rownum', searchable:false},
        { data: 'code', name: 'code' },
        { data: 'name', name: 'name' },
        { data: 'stock', name: 'stock' },
        { data: 'minimum_stock', name: 'minimum_stock' },

      ],
      rowCallback: function(row, data){
        if($.inArray(data.id, selected) !== -1){
          $(row).addClass('selected');
        }
      }

    });

    tableProduct.on('click', 'tr', function(){
        //var id = this.id;
        var id = tableProduct.row(this).data().id;
        var product_name = tableProduct.row(this).data().name;
        var stock = tableProduct.row(this).data().stock;
        var minimum_stock = tableProduct.row(this).data().minimum_stock;
        if(stock < minimum_stock){ //product out of the stock, prevent this product to be added on the selected product
          alertify.error(product_name+" is out of the stock");
          return false;
        }
        else{
          var index = $.inArray(id, selected);
          if ( index === -1 ) {
              selected.push(id);
              $('#table-selected-products').append(
                '<tr id="tr_product_'+id+'">'+
                  '<td>'+
                    '<input type="hidden" name="product_id[]" value="'+id+'" />'+
                    tableProduct.row(this).data().name+
                  '</td>'+
                  '<td>'+
                    '<input type="text" name="quantity[]" class="quantity form-control" style="" value="" />'+
                  '</td>'+
                  '<td>'+
                    tableProduct.row(this).data().unit_id+
                  '</td>'+
                '</tr>'
              );
          } else {
              selected.splice( index, 1 );
              $('#tr_product_'+id).remove();
          }

          $(this).toggleClass('selected');
        }


    } );

    $('#btn-set-product').on('click', function(){
      if(selected.length !== 0){
        $('#tr-no-product-selected').hide();
      }
      else{
        $('#tr-no-product-selected').show();
      }
      $('#modal-display-products').modal('hide');
    });

      // Setup - add a text input to each header cell
    $('#searchid th').each(function() {
      if ($(this).index() != 0 && $(this).index() != 5) {
          $(this).html('<input class="form-control" type="text" placeholder="Search" data-id="' + $(this).index() + '" />');
      }

    });
    //Block search input and select
    $('#searchid input').keyup(function() {
      tableProduct.columns($(this).data('id')).search(this.value).draw();
    });
    $('#searchid select').change(function () {
      if($(this).val() == ""){
        tableProduct.columns($(this).data('id')).search('').draw();
      }
      else{
        tableProduct.columns($(this).data('id')).search(this.value).draw();
      }
    });
    //ENDBlock search input and select

  </script>

  <script type="text/javascript">
  //Block handle form create Sales Order submission
    $('#form-create-sales-order').on('submit', function(event){
      event.preventDefault();
      var data = $(this).serialize();
      $.ajax({
          url: '{!!URL::to('storeSalesOrder')!!}',
          type : 'POST',
          data : $(this).serialize(),
          beforeSend : function(){
            $('#btn-submit-product').prop('disabled', true);
            //$('#btn-submit-product').hide();
          },
          success : function(response){
            if(response.msg == 'storeSalesOrderOk'){
                window.location.href= '{{ URL::to('sales-order') }}/'+response.sales_order_id;
            }
            else{
              $('#btn-submit-product').prop('disabled', false);
              console.log(response);
            }
          },
          error:function(data){
            var htmlErrors = '<p>Error : </p>';
            errors = data.responseJSON;
            $.each(errors, function(index, value){
              htmlErrors+= '<p>'+value+'</p>';
            });
            alertify.set('notifier', 'delay',0);
            alertify.error(htmlErrors);
            $('#btn-submit-product').prop('disabled', false);
        }
      });
    });
  //ENDBlock handle form create Sales Order submission
  </script>
@endSection
