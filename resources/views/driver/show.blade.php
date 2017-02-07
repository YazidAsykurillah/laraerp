@extends('layouts.app')

@section('page_title')
  Driver Detail
@endsection

@section('page_header')
  <h1>
    Driver Detail
    <small> {{ $driver->code }}</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('driver') }}"><i class="fa fa-dashboard"></i> Drivers</a></li>
    <li class="active"><i></i> {{ $driver->code }}</li>
  </ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-md-7">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title"><i class="fa fa-bars"></i>&nbsp;General Informations</h3>

        </div><!-- /.box-header -->
        <div class="box-body">
          <div class="table-responsive">
            <table class="table table-hover">
              <tr>
                <td style="width:15%;">Code</td>
                <td>:</td>
                <td>{{ $driver->code }}</td>
              </tr>
              <tr>
                <td style="width:15%;">Name</td>
                <td>:</td>
                <td> {{ $driver->name }}</td>
              </tr>
            </table>
          </div>
        </div>
        <div class="box-footer clearfix">

        </div>
      </div>
    </div>
    <div class="col-md-5">
      <div class="box">
        <div class="box-header">
          <h3 class="box-title"><i class="fa fa-bookmark-o"></i>&nbsp;Primary Contact Information</h3>

        </div><!-- /.box-header -->
        <div class="box-body">
          <div class="table-responsive">
            <table class="table table-hover">
              <tr>
                <td style="width:15%;">Contact Number</td>
                <td>:</td>
                <td>{{ $driver->contact_number }}</td>
              </tr>
            </table>
          </div>
        </div>
        <div class="box-footer clearfix">

        </div>
      </div>
    </div>
  </div>
@endsection()
