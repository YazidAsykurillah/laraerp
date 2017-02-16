@extends('layouts.app')

@section('page_title')
  Stock Balances
@endsection

@section('page_header')
  <h1>
    Stock Balance
    <small>Stocks Balance List</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('stock_balance') }}"><i class="fa fa-dashboard"></i> Stocks Balance</a></li>
    <li class="active"><i></i>Index</li>
  </ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-lg-12">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Stocks Balance</h3>
          <a href="{{ URL::to('stock_balance/create')}}" class="btn btn-primary pull-right" title="Create new stocks balance">
            <i class="fa fa-plus"></i>&nbsp;Add New
          </a>
        </div><!-- /.box-header -->
        <div class="box-body table-responsive">
          <table class="table table-bordered" id="table-stock-balance">
            <thead>
              <tr>
                <th style="width:5%;">#</th>
                <th style="width:10%;">Code</th>
                <th style="width:20%;">Created By</th>
                <th style="width:20%;">Created At</th>
                <th style="width:20%;">Updated At</th>
                <th style="width:10%;text-align:center;">Actions</th>
              </tr>
            </thead>
            <thead id="searchid">
              <tr>
                <th style="width:5%;">#</th>
                <th style="width:10%;">Code</th>
                <th style="width:20%;">Created By</th>
                <th style="width:20%;">Created At</th>
                <th style="width:20%;">Updated At</th>
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
  <!-- <div class="modal fade" id="modal-delete-driver" tabindex="-1" role="dialog" aria-labelledby="modal-delete-driverLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'deleteDriver', 'method'=>'post']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-delete-driverLabel">Confirmation</h4>
        </div>
        <div class="modal-body">
          You are going to remove supplier&nbsp;<b id="driver-name-to-delete"></b>
          <br/>
          <p class="text text-danger">
            <i class="fa fa-info-circle"></i>&nbsp;This process can not be reverted
          </p>
          <input type="hidden" id="driver_id" name="driver_id">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger">Delete</button>
        </div>
      {!! Form::close() !!}
      </div>
    </div>
  </div> -->
<!--ENDModal Delete supplier-->
@endsection

@section('additional_scripts')
  <script type="text/javascript">
    var tableStockBalance =  $('#table-stock-balance').DataTable({
      processing :true,
      serverSide : true,
      ajax : '{!! route('datatables.getStockBalances') !!}',
      columns :[
        {data: 'rownum', name: 'rownum', searchable:false},
        { data: 'code', name: 'code' },
        { data: 'creator', name: 'creator.name' },
        { data: 'created_at', name: 'created_at' },
        { data: 'updated_at', name: 'updated_at' },
        { data: 'actions', name: 'actions', orderable:false, searchable:false },
      ],


    });

    //Delete button handler
    // tableDriver.on('click', '.btn-delete-driver', function (e) {
    //   var id = $(this).attr('data-id');
    //   var name = $(this).attr('data-text');
    //   $('#driver_id').val(id);
    //   $('#driver-name-to-delete').text(name);
    //   $('#modal-delete-driver').modal('show');
    // });
    //
    // Setup - add a text input to each header cell
    $('#searchid th').each(function() {
          if ($(this).index() != 0 && $(this).index() != 5) {
              $(this).html('<input class="form-control" type="text" placeholder="Search" data-id="' + $(this).index() + '" />');
          }

    });
    //Block search input and select
    $('#searchid input').keyup(function() {
      tableStockBalance.columns($(this).data('id')).search(this.value).draw();
    });
    //ENDBlock search input and select

  </script>
@endsection
