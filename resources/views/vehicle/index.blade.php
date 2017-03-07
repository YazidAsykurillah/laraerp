@extends('layouts.app')

@section('page_title')
    Vehicles
@endsection

@section('page_header')
    <h1>
        Vehicle
        <small>Vehicle List</small>
    </h1>
@endsection

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{ URL::to('vehicle') }}"><i class="fa fa-dashboard"></i> Vehicles</a></li>
        <li class="active"><i></i>Index</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Vehicles</h3>
                    <a href="{{ URL::to('vehicle/create') }}" class="btn btn-primary pull-right" title="Create new vehicle">
                        <i class="fa fa-plus"></i>&nbsp;Add New
                    </a>
                </div>
                <div class="box-body table-responsive">
                    <table class="table table-bordered" id="table-vehicle">
                        <thead>
                            <tr>
                                <th style="width:5%">#</th>
                                <th style="width:20%">Code</th>
                                <th style="width:35%">Category</th>
                                <th style="width:30%">Number of Vehicle</th>
                                <th style="width:10%;text-align:center">Actions</th>
                            </tr>
                        </thead>
                        <thead id="searchid">
                            <tr>
                                <th style="width:5%">#</th>
                                <th style="width:20%">Code</th>
                                <th style="width:35%">Category</th>
                                <th style="width:30%">Number of Vehicle</th>
                                <th style="width:10%;text-align:center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
                <div class="box-footer clearfix">

                </div>
            </div>
        </div>
    </div>

    <!--Modal Delete vehicle-->
    <div class="modal fade" id="modal-delete-vehicle" tabindex="-1" role="dialog" aria-labelledby="modal-delete-vehicleLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
        {!! Form::open(['url'=>'deleteVehicle', 'method'=>'post']) !!}
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="modal-delete-vehicleLabel">Confirmation</h4>
          </div>
          <div class="modal-body">
            You are going to remove vehicle&nbsp;<b id="vehicle-name-to-delete"></b>
            <br/>
            <p class="text text-danger">
              <i class="fa fa-info-circle"></i>&nbsp;This process can not be reverted
            </p>
            <input type="text" id="vehicle_id" name="vehicle_id">
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
        var tableVehicle = $('#table-vehicle').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('datatables.getVehicles') !!}',
            columns: [
                {data: 'rownum', name: 'rownum', searchable: false},
                {data: 'code', name: 'code'},
                {data: 'category', name: 'category'},
                {data: 'number_of_vehicle' , name: 'number_of_vehicle'},
                {data: 'actions', name: 'actions', orderable: false, searchable: false},
            ],
            "order" : [[1, "asc"]]
        });

        //Delete button handler
        tableVehicle.on('click', '.btn-delete-vehicle', function (e) {
          var id = $(this).attr('data-id');
          var name = $(this).attr('data-text');
          $('#vehicle_id').val(id);
          $('#vehicle-name-to-delete').text(name);
          $('#modal-delete-vehicle').modal('show');
        });

          // Setup - add a text input to each header cell
        $('#searchid th').each(function() {
              if ($(this).index() != 0 && $(this).index() != 4) {
                  $(this).html('<input class="form-control" type="text" placeholder="Search" data-id="' + $(this).index() + '" />');
              }

        });
        //Block search input and select
        $('#searchid input').keyup(function() {
          tableVehicle.columns($(this).data('id')).search(this.value).draw();
        });
        //ENDBlock search input and select
    </script>
@endsection