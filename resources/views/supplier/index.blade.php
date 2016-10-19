@extends('layouts.app')

@section('page_title')
  Supplier
@endsection

@section('page_header')
  <h1>
    Supplier
    <small>Suppliers List</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('supplier') }}"><i class="fa fa-dashboard"></i> Suppliers</a></li>
    <li class="active"><i></i>Index</li>
  </ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-lg-12">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Supplier</h3>
          <a href="{{ URL::to('supplier/create')}}" class="btn btn-primary pull-right" title="Create new supplier">
            <i class="fa fa-plus"></i>&nbsp;Add New
          </a>
        </div><!-- /.box-header -->
        <div class="box-body table-responsive">
          <table class="table table-bordered" id="table-supplier">
            <thead>
              <tr>
                <th style="width:5%;">#</th>
                <th style="width:10%;">Code</th>
                <th>Name</th>
                <th style="width:20%;">PIC</th>
                <th style="width:20%;">Phone Number</th>
                <th style="width:10%;text-align:center;">Actions</th>
              </tr>
            </thead>
            <thead id="searchid">
              <tr>
                <th style="width:5%;">#</th>
                <th style="width:10%;">Code</th>
                <th>Name</th>
                <th style="width:20%;">PIC</th>
                <th style="width:20%;">Phone Number</th>
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

  <!--Modal Delete supplier-->
  <div class="modal fade" id="modal-delete-supplier" tabindex="-1" role="dialog" aria-labelledby="modal-delete-supplierLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'deleteSupplier', 'method'=>'post']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-delete-supplierLabel">Konfirmasi</h4>
        </div>
        <div class="modal-body">
          You are going to remove supplier&nbsp;<b id="supplier-name-to-delete"></b>
          <br/>
          <p class="text text-danger">
            <i class="fa fa-info-circle"></i>&nbsp;This process can not be reverted
          </p>
          <input type="hidden" id="supplier_id" name="supplier_id">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger">Delete</button>
        </div>
      {!! Form::close() !!}
      </div>
    </div>
  </div>
<!--ENDModal Delete supplier-->
@endsection

@section('additional_scripts')
  <script type="text/javascript">
    var tableSupplier =  $('#table-supplier').DataTable({
      processing :true,
      serverSide : true,
      ajax : '{!! route('datatables.getSuppliers') !!}',
      columns :[
        {data: 'rownum', name: 'rownum', searchable:false},
        { data: 'code', name: 'code' },
        { data: 'name', name: 'name' },
        { data: 'pic_name', name: 'pic_name' },
        { data: 'primary_phone_number', name: 'primary_phone_number'},
        { data: 'actions', name: 'actions', orderable:false, searchable:false },
      ],


    });

    // Delete button handler
    tableSupplier.on('click', '.btn-delete-supplier', function (e) { 
      var id = $(this).attr('data-id');
      var name = $(this).attr('data-text');
      $('#supplier_id').val(id);
      $('#supplier-name-to-delete').text(name);
      $('#modal-delete-supplier').modal('show');
    });

      // Setup - add a text input to each header cell
    $('#searchid th').each(function() {
          if ($(this).index() != 0 && $(this).index() != 5) {
              $(this).html('<input class="form-control" type="text" placeholder="Search" data-id="' + $(this).index() + '" />');
          }
          
    });
    //Block search input and select
    $('#searchid input').keyup(function() {
      tableSupplier.columns($(this).data('id')).search(this.value).draw();
    });
    //ENDBlock search input and select
    
  </script>
@endsection
