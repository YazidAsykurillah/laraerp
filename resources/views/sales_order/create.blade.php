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
    <li><a href="{{ URL::to('sales-order') }}"><i class="fa fa-files-o"></i> Sales Order</a></li>
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
          <h3 class="box-title">Products Added</h3>
          <a href="#" id="btn-display-product-datatables" class="btn btn-primary pull-right" title="Select products to be added">
            <i class="fa fa-list"></i>&nbsp;Select Products
          </a>
        </div><!-- /.box-header -->
        <div class="box-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="table-selected-products">
                <tr>
                  <th style="width:15%;background-color:#3c8dbc;color:white">Family</th>
                  <th style="width:15%;background-color:#3c8dbc;color:white">Code</th>
                  <th style="width:20%;background-color:#3c8dbc;color:white">Description</th>
                  <th style="width:15%;background-color:#3c8dbc;color:white">Unit</th>
                  <th style="width:15%;background-color:#3c8dbc;color:white">Quantity</th>
                  <th style="width:20%;background-color:#3c8dbc;color:white">Category</th>
                </tr>
                <tr id="tr-no-product-selected">
                  <td colspan="6">No product selected</td>
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

            <div class="form-group{{ $errors->has('do_number') ? ' has-error' : '' }}">
              {!! Form::label('do_number', 'D.O Number', ['class'=>'col-sm-3 control-label']) !!}
              <div class="col-sm-6">
                  @if(count($sales_order) == 0)
                    <input type="text" class="form-control" placeholder="D.O Number" id="do_number" autocomplete="off" value="SO-01" name="do_number">
                  @else
                    <input type="text" class="form-control" placeholder="D.O Number" id="do_number" autocomplete="off" value="SO-{{$sales_order->id+1}}" name="do_number">
                  @endif
                  @if($errors->has('do_number'))
                      <span class="help-block">
                          <strong>{{ $errors->first('do_number') }}</strong>
                      </span>
                  @endif
              </div>
            </div>

            <div class="form-group{{ $errors->has('customer_id') ? ' has-error' : '' }}">
              {!! Form::label('customer_id', 'Customer Name', ['class'=>'col-sm-3 control-label']) !!}
              <div class="col-sm-6">
                {{ Form::select('customer_id', $customer_options, null, ['class'=>'form-control', 'placeholder'=>'Select Customer', 'id'=>'customer_id']) }}
                @if ($errors->has('customer_id'))
                  <span class="help-block">
                    <strong>{{ $errors->first('customer_id') }}</strong>
                  </span>
                @endif
              </div>
            </div>

            <div class="form-group{{ $errors->has('notes') ? ' has-error' : '' }}">
              {!! Form::label('notes', 'Notes', ['class'=>'col-sm-3 control-label']) !!}
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
                {!! Form::label('', '', ['class'=>'col-sm-3 control-label']) !!}
              <div class="col-sm-9">
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
                <h3 class="box-title">Driver and Vehicle</h3>
            </div>
            <div class="box-body">
                <div class="form-group{{ $errors->has('driver_id') ? 'has-error' : '' }}">
                    {!! Form::label('driver_id','Driver Name',['class'=>'col-sm-3 control-label']) !!}
                    <div class="col-sm-6">
                        {{ Form::select('driver_id',$driver_options,null,['class'=>'form-control','placeholder'=>'Select Driver','id'=>'driver_id']) }}
                        @if($errors->has('driver_id'))
                        <span class="help-block">
                            <strong>{{ $errors->first('driver_id') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('driver_id') ? 'has-error' : '' }}">
                    {!! Form::label('vehicle_id','Vehicle Number',['class'=>'col-sm-3 control-label']) !!}
                    <div class="col-sm-6">
                        {{ Form::select('vehicle_id',$vehicle_options,null,['class'=>'form-control','placeholder'=>'Select Vehicle','id'=>'vehicle_id']) }}
                        @if($errors->has('vehicle_id'))
                        <span class="help-block">
                            <strong>{{ $errors->first('vehicle_id') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('ship_date') ? ' has-error' : '' }}">
                  {!! Form::label('ship_date', 'Ship Date', ['class'=>'col-sm-3 control-label']) !!}
                  <div class="col-sm-6">
                      {{ Form::text('ship_date',null,['class'=>'form-control','placeholder'=>'Ship Date','id'=>'ship_date','autocomplete'=>'off']) }}
                      @if($errors->has('ship_date'))
                          <span class="help-block">
                              <strong>{{ $errors->first('ship_date') }}</strong>
                          </span>
                      @endif
                  </div>
                </div>
            </div>
            <div class="box-footer clearfix">

            </div>
        </div>
  </div>
  <!-- ENDRow customer and Notes-->
  {!! Form::close() !!}

  <!--Modal Display product datatables-->
  <div class="modal fade" id="modal-display-products" tabindex="-1" role="dialog" aria-labelledby="modal-display-productsLabel">
    <div class="modal-dialog modal-lg" role="document" style="width:80%">
      <div class="modal-content">

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-display-productsLabel">Products list</h4>
        </div>
        <div class="modal-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="table-product" style="width:100%">
              <thead>
                  <tr>
                      <th style="width:5%;background-color:#3c8dbc;color:white">#</th>
                      <th style="width:10%;background-color:#3c8dbc;color:white">Family</th>
                      <th style="width:20%;background-color:#3c8dbc;color:white">Code</th>
                      <!-- <th style="width:15%;background-color:#3c8dbc;color:white">Image</th> -->
                      <th style="width:20%;background-color:#3c8dbc;color:white">Description</th>
                      <th style="width:15%;background-color:#3c8dbc;color:white">Unit</th>
                      <th style="width:15%;background-color:#3c8dbc;color:white">Category</th>
                  </tr>
                </thead>
                <thead id="searchid">
                  <tr>
                      <th style="width:5%;"></th>
                      <th style="width:10%;">Family</th>
                      <th style="width:20%;">Code</th>
                      <!-- <th style="width:15%;">Image</th> -->
                      <th style="width:20%;">Description</th>
                      <th style="width:15%;">Unit</th>
                      <th style="width:15%;">Category</th>
                  </tr>
                </thead>
              <tbody>

              </tbody>
              <tfoot>

              </tfoot>
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
  <!-- <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> -->
  {!! Html::style('css/datepicker/jquery-ui.css') !!}
  {!! Html::script('js/jquery-ui.js') !!}
  <script>
      $( function() {
        $( "#ship_date" ).datepicker({
            dateFormat: 'yy-mm-dd'
        });
      } );
  </script>
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
          { data: 'family_id', name: 'family_id', searchable:false},
          { data: 'name', name: 'name'},
        //   { data: 'image', name: 'image', searchable:false},
          { data: 'description', name: 'description', searchable:false},
          { data: 'unit_id', name: 'unit_id' , searchable:false, searchable:false},
          { data: 'category_id', name: 'category_id' , searchable:false},
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
        var index = $.inArray(id, selected);
        if ( index === -1 ) {
            selected.push(id);
            $('#table-selected-products').append(
              '<tr id="tr_product_'+id+'">'+
                '<td>'+
                    '<input type="hidden" name="product_id[]" value="'+id+'" />'+
                    tableProduct.row(this).data().family_id+
                '</td>'+
                '<td>'+
                    tableProduct.row(this).data().name+

                '</td>'+
                '<td>'+
                    tableProduct.row(this).data().description+
                '</td>'+
                '<td>'+
                    tableProduct.row(this).data().unit_id+
                '</td>'+
                '<td>'+
                    '<input type="text" name="quantity[]" class="quantity form-control" style="" value="" />'+
                '</td>'+
                '<td>'+
                    tableProduct.row(this).data().category_id+
                '</td>'+
              '</tr>'
            );
            // var token = $("meta[name='csrf-token']").attr('content');
            // //alert(token);
            // //panggil controller tampilan sub product
            // $.ajax({
            //     url: '{!!URL::to('callSubProduct')!!}',
            //     type : 'POST',
            //     data : 'id='+id+'&_token='+token,
            //     beforeSend: function(){
            //
            //     } ,
            //     success: function(response){
            //         $.each(response,function(index,value){
            //             $('#table-selected-products').append(
            //               '<tr class="tr_product_'+id+'">'+
            //                 '<td>'+
            //                     '<input type="text" name="product_id[]" value="'+value.id+'" />'+
            //                     value.family+
            //                 '</td>'+
            //                 '<td>'+
            //                     value.name+
            //                 '</td>'+
            //                 '<td>'+
            //                     value.description+
            //                 '</td>'+
            //                 '<td>'+
            //                     value.unit+
            //                 '</td>'+
            //                 '<td>'+
            //                     '<input type="text" name="quantity[]" class="quantity form-control" style="" value="" />'+
            //                 '</td>'+
            //                 '<td>'+
            //                     value.category+
            //                 '</td>'+
            //               '</tr>'
            //             );
            //         });
            //     },
            // })

        } else {
            selected.splice( index, 1 );
            $('#tr_product_'+id).remove();
        }

        $(this).toggleClass('selected');

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
      if ($(this).index() != 0 && $(this).index() != 8) {
          $(this).html('<input class="form-control" type="text" placeholder="Search" data-id="' + $(this).index() + '" />');
      }

    });
    //Block search input and select
    $('#searchid input').keyup(function() {
      tableProduct.columns($(this).data('id')).search(this.value).draw();
    });
    // $('#searchid select').change(function () {
    //   if($(this).val() == ""){
    //     tableProduct.columns($(this).data('id')).search('').draw();
    //   }
    //   else{
    //     tableProduct.columns($(this).data('id')).search(this.value).draw();
    //   }
    // });
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
