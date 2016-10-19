@extends('layouts.app')

@section('page_title')
  Purchase Order
@endsection

@section('page_header')
  <h1>
    Purchase Order
    <small>Purchase Order List</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('purchase-order') }}"><i class="fa fa-dashboard"></i> Purchase Order</a></li>
    <li class="active"><i></i>Index</li>
  </ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-lg-12">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Purchase Order</h3>
          <a href="{{ URL::to('purchase-order/create')}}" class="btn btn-primary pull-right" title="Create new purchase-order">
            <i class="fa fa-plus"></i>&nbsp;Add New
          </a>
        </div><!-- /.box-header -->
        <div class="box-body table-responsive">
          <table class="table table-bordered" id="table-purchase-order">
            <thead>
              <tr>
                <th style="width:5%;">#</th>
                <th style="width:10%;">Code</th>
                <th>Supplier</th>
                <th>Creator</th>
                <th style="width:20%;">Date Created</th>
                <th style="width:20%;">Status</th>
                <th style="width:10%;text-align:center;">Actions</th>
              </tr>
            </thead>
            <thead id="searchid">
              <tr>
                <th style="width:5%;">#</th>
                <th style="width:10%;">Code</th>
                <th>Supplier</th>
                <th>Creator</th>
                <th style="width:20%;">Date Created</th>
                <th style="width:20%;">Status</th>
                <th style="width:10%;text-align:center;">Actions</th>
              </tr>
            </thead>
            <tbody>
              
            </tbody>
          </table>
        </div><!-- /.box-body -->
        <div class="box-footer clearfix">
          
        </div>
      </div><!-- /.box -->
    
    </div>
  </div>

  <!--Modal Delete purchase-order-->
  <div class="modal fade" id="modal-delete-purchase-order" tabindex="-1" role="dialog" aria-labelledby="modal-delete-purchase-orderLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'deletePurchaseOrder', 'method'=>'post']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-delete-purchase-orderLabel">Confirmation</h4>
        </div>
        <div class="modal-body">
          You are going to remove purchase-order&nbsp;<b id="purchase-order-name-to-delete"></b>
          <br/>
          <p class="text text-danger">
            <i class="fa fa-info-circle"></i>&nbsp;This process can not be reverted
          </p>
          <input type="hidden" id="purchase_order_id" name="purchase_order_id">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger">Delete</button>
        </div>
      {!! Form::close() !!}
      </div>
    </div>
  </div>
<!--ENDModal Delete purchase-order-->
@endsection


@section('additional_scripts')
  <script type="text/javascript">
    var tablePurchaseOrder =  $('#table-purchase-order').DataTable({
      processing :true,
      serverSide : true,
      ajax : '{!! route('datatables.getPurchaseOrders') !!}',
      columns :[
        {data: 'rownum', name: 'rownum', searchable:false},
        { data: 'code', name: 'code' },
        { data: 'supplier_id', name: 'supplier_id' },
        { data: 'creator', name: 'creator.name' },
        { data: 'created_at', name: 'created_at' },
        { data: 'status', name: 'status' },
        { data: 'actions', name: 'actions', orderable:false, searchable:false },
      ],


    });

    // Delete button handler
    tablePurchaseOrder.on('click', '.btn-delete-purchase-order', function (e) { 
      var id = $(this).attr('data-id');
      var code = $(this).attr('data-text');
      $('#purchase_order_id').val(id);
      $('#purchase-order-name-to-delete').text(code);
      $('#modal-delete-purchase-order').modal('show');
    });

      // Setup - add a text input to each header cell
    $('#searchid th').each(function() {
          if ($(this).index() != 0 && $(this).index() != 5) {
              $(this).html('<input class="form-control" type="text" placeholder="Search" data-id="' + $(this).index() + '" />');
          }
          
    });
    //Block search input and select
    $('#searchid input').keyup(function() {
      tablePurchaseOrder.columns($(this).data('id')).search(this.value).draw();
    });
    //ENDBlock search input and select
    
  </script>
@endsection