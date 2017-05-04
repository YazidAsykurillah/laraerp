@extends('layouts.app')

@section('page_title')
  Product Units
@endsection

@section('page_header')
  <h1>
    Show Product Unit
    <small>Show product unit</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('unit') }}"><i class="fa fa-dashboard"></i> Product Units</a></li>
    <li class="active"><i></i>{{ $unit->name }}</li>
  </ol>
@endsection

@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="box" style="box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);border-top:none">
      <div class="box-header with-border">
        <h3 class="box-title">Informations</h3>
      </div><!-- /.box-header -->
      <div class="box-body">
        <table class="table">
          <tr>
            <td><b>Name</b></td>
            <td>{{ $unit->name }}</td>
          </tr>
          <tr>
            <td><b>Created At</b></td>
            <td>{{ $unit->created_at }}</td>
          </tr>
        </table>
      </div><!-- /.box-body -->
      <div class="box-footer clearfix">

      </div>
    </div><!-- /.box -->
  </div>
</div>
@endsection

@section('additional_scripts')
  <script type="text/javascript">
    $('#btn-submit-unit').click(function(){
      $(this).attr('disable', 'disabled');
    })
  </script>
@endsection
