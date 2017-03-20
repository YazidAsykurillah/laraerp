@extends('layouts.app')

@section('page_title')
    Main Product
@endsection

@section('page_header')
    <h1>
        Main Product
        <small>Add New Sub Product</small>
    </h1>
@endsection

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{ URL::to('main-product/create') }}"><i class="fa fa-dashboard"></i> Main Products</a></li>

        <li class="active"><i></i> Create</li>
    </ol>
@endsection

@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="box">
      <div class="box-header with-border">
        <h3 class="box-title">Products</h3>
      </div><!-- /.box-header -->
      <div class="box-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="table-selected-products">
              <thead>
                <tr>
                  <th style="width:15%;background-color:#3c8dbc;color:white">Family</th>
                  <th style="width:15%;background-color:#3c8dbc;color:white">Code</th>
                  <th style="width:20%;background-color:#3c8dbc;color:white">Description</th>
                  <th style="width:15%;background-color:#3c8dbc;color:white">Unit</th>
                  <th style="width:15%;background-color:#3c8dbc;color:white">Quantity</th>
                  <th style="width:20%;background-color:#3c8dbc;color:white">Category</th>
                </tr>
            </thead>
            <tbody>
                @foreach($parent as $parents)
                    <tr>
                        <td>{{ $parents->family->name }}</td>
                        <td>{{ $parents->name }}</td>
                        <td>{{ $parents->id }}</td>
                        <td>{{ $parents->unit_id }}</td>
                        <td>
                            <input type="text" name="quantity[]">
                        </td>
                        <td>{{ $parents->category_id }}</td>
                    </tr>
                @endforeach
            </tbody>
          </table>
        </div>

      </div><!-- /.box-body -->
      <div class="box-footer clearfix">

      </div>
    </div><!-- /.box -->
  </div>
</div>
@endsection
