@extends('layouts.app')

@section('page_title')
    Family Product
@endsection

@section('page_header')
  <h1>
    Family Product
    <small>Detail Family Product</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('family') }}"><i class="fa fa-dashboard"></i> Family Product</a></li>
    <li class="active"><i></i> {{ $family->code }}</li>
  </ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-lg-12">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Informations</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <table class="table">
            <tr>
              <td><b>Code</b></td>
              <td>{{ $family->code }}</td>
            </tr>
            <tr>
              <td><b>Name</b></td>
              <td>{{ $family->name }}</td>
            </tr>
            <tr>
              <td><b>Created At</b></td>
              <td>{{ $family->created_at }}</td>
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

@endsection