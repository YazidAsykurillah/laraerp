@extends('layouts.app')

@section('page_title')
  Units
@endsection

@section('page_header')
  <h1>
    Product Unit
    <small>List of product units</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('unit') }}"><i class="fa fa-dashboard"></i> Product Units</a></li>
    <li class="active"><i></i>Index</li>
  </ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-lg-12">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Units</h3>
          <a href="{{ URL::to('unit/create')}}" class="btn btn-primary pull-right" title="Create new unit">
            <i class="fa fa-plus"></i>&nbsp;Add New
          </a>
        </div><!-- /.box-header -->
        <div class="box-body table-responsive">
            <table class="display" id="table-unit">
              <thead>
                <tr>
                  <th style="width:5%;background-color:#3c8dbc;color:white">#</th>
                  <th style="width:20%;background-color:#3c8dbc;color:white">Name</th>
                  <th style="width:30%;background-color:#3c8dbc;color:white">Created At</th>
                  <th style="width:30%;background-color:#3c8dbc;color:white">Updated At</th>
                  <th style="width:15%;text-align:center;background-color:#3c8dbc;color:white">Actions</th>
                </tr>
              </thead>
              <!-- <thead id="searchid">
                <tr>
                    <th style="width:5%;background-color:#3c8dbc;color:white">#</th>
                    <th style="width:20%;background-color:#3c8dbc;color:white">Name</th>
                    <th style="width:30%;background-color:#3c8dbc;color:white">Created At</th>
                    <th style="width:30%;background-color:#3c8dbc;color:white">Updated At</th>
                    <th style="width:15%;text-align:center;background-color:#3c8dbc;color:white">Actions</th>
                </tr>
              </thead> -->
              <tbody>

              </tbody>
            </table>
        </div><!-- /.box-body -->
        <div class="box-footer clearfix">

        </div>
      </div><!-- /.box -->

    </div>
  </div>

  <!--Modal Delete unit-->
  <div class="modal fade" id="modal-delete-unit" tabindex="-1" role="dialog" aria-labelledby="modal-delete-unitLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'deleteUnit', 'method'=>'post']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-delete-unitLabel">Confirmation</h4>
        </div>
        <div class="modal-body">
          You are going to remove unit&nbsp;<b id="unit-name-to-delete"></b>
          <br/>
          <p class="text text-danger">
            <i class="fa fa-info-circle"></i>&nbsp;This process can not be reverted
          </p>
          <input type="hidden" id="unit_id" name="unit_id">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger">Delete</button>
        </div>
      {!! Form::close() !!}
      </div>
    </div>
  </div>
<!--ENDModal Delete unit-->
@endsection

@section('additional_scripts')
  <script type="text/javascript">
    var tableUnit =  $('#table-unit').DataTable({
      processing :true,
      serverSide : true,
      ajax : '{!! route('datatables.getUnits') !!}',
      columns :[
        {data: 'rownum', name: 'rownum', searchable:false},
        { data: 'name', name: 'name' },
        { data: 'created_at', name: 'created_at' },
        { data: 'updated_at', name: 'updated_at' },
        { data: 'actions', name: 'actions', orderable:false, searchable:false },
      ],


    });

    // Delete button handler
    tableUnit.on('click', '.btn-delete-unit', function (e) {
      var id = $(this).attr('data-id');
      var name = $(this).attr('data-text');
      $('#unit_id').val(id);
      $('#unit-name-to-delete').text(name);
      $('#modal-delete-unit').modal('show');
    });

      // Setup - add a text input to each header cell
    $('#searchid th').each(function() {
          if ($(this).index() != 0 && $(this).index() != 5) {
              $(this).html('<input class="form-control" type="text" placeholder="Search" data-id="' + $(this).index() + '" />');
          }

    });
    //Block search input and select
    $('#searchid input').keyup(function() {
      tableUnit.columns($(this).data('id')).search(this.value).draw();
    });
    //ENDBlock search input and select

  </script>
@endsection
