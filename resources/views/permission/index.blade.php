@extends('layouts.app')

@section('page_title')
  Permission
@endsection

@section('page_header')
  <h1>
    Permission
    <small>Permission List</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="#"><i class="fa fa-dashboard"></i> Permission </a></li>
    <li class="active"><i></i>Index</li>
  </ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Permission List</h3>
        </div><!-- /.box-header -->
        <div class="box-body table-responsive">
          <table class="table table-bordered" id="table-permission">
            <thead>
              <tr>
                <th style="width:5%;">#</th>
                <th style="width:20%;">Permission Slug</th>
                <th style="">Description</th>
                <th style="width:5%;"></th>
              </tr>
            </thead>
            
            <tbody>

            </tbody>
          </table>
        </div><!-- /.box-body -->
        <div class="box-footer clearfix"></div>
      </div><!-- /.box -->
    </div>
</div>

@endsection

@section('additional_scripts')
  <script type="text/javascript">
  var tablePermission =  $('#table-permission').DataTable({
      processing :true,
      serverSide : true,
      ajax : '{!! route('datatables.getPermissions') !!}',
      columns :[
        {data: 'rownum', name: 'rownum', searchable:false, orderable:false},
        {data: 'slug', name: 'slug' },
        {data: 'description', name: 'description'},
        {data: 'actions', name: 'actions', searchable:false, orderable:false},
      ],
    });
  </script>
@endsection