@extends('layouts.app')

@section('page_title')
  Supplier Detail
@endsection

@section('page_header')
  <h1>
    Supplier Detail
    <small> {{ $supplier->code }}</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('supplier') }}"><i class="fa fa-dashboard"></i> Suppliers</a></li>
    <li class="active"><i></i> {{ $supplier->code }}</li>
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
                <td>{{ $supplier->code }}</td>
              </tr>
              <tr>
                <td style="width:15%;">Name</td>
                <td>:</td>
                <td> {{ $supplier->name }}</td>
              </tr>
              <tr>
                <td style="width:15%;">Address</td>
                <td>:</td>
                <td> {!! nl2br($supplier->address) !!}</td>
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
                <td style="width:15%;">PIC</td>
                <td>:</td>
                <td>{{ $supplier->pic_name }}</td>
              </tr>
              <tr>
                <td style="width:15%;">Email</td>
                <td>:</td>
                <td> {{ $supplier->primary_email }}</td>
              </tr>
              <tr>
                <td style="width:15%;">Phone Number</td>
                <td>:</td>
                <td> {{ $supplier->primary_phone_number }}</td>
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
