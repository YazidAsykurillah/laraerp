@extends('layouts.app')

@section('page_title')
  Products Available
@endsection

@section('page_header')
  <h1>
    Products Available
    <small>Product Lists</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('product-available') }}"><i class="fa fa-dashboard"></i> Products Available</a></li>
    <li class="active"><i></i>Index</li>
  </ol>
@endsection

@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="box" style="box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
      <div class="box-header with-border">
        <h3 class="box-title">Products Available</h3>
      </div><!-- /.box-header -->
      <div class="box-body table-responsive">
        <table class="display" id="table-product">
          <thead>
            <tr>
                <th style="width:5%;background-color:#3c8dbc;color:white">#</th>
                <th style="width:20%;background-color:#3c8dbc;color:white">Code</th>
                <th style="width:10%;background-color:#3c8dbc;color:white">Sub Code</th>
                <th style="width:20%;background-color:#3c8dbc;color:white">Description</th>
                <th style="width:10%;background-color:#3c8dbc;color:white">Stock</th>
                <th style="width:10%;background-color:#3c8dbc;color:white">Unit</th>
                <th style="width:10%;background-color:#3c8dbc;color:white">Family</th>
                <th style="width:15%;background-color:#3c8dbc;color:white">Category</th>
            </tr>
          </thead>
          <!-- <thead id="searchid">
            <tr>
              <th style="width:5%;"></th>
              <th>Code</th>
              <th>Product Name</th>
              <th>Category</th>
              <th style="width:10%;">Unit</th>
              <th style="width:10%;"></th>
              <th></th>
            </tr>
          </thead> -->
          <tbody>
              <?php $no = 1; ?>
              @foreach($data_main_products as $dmp)
                <tr>
                    <td>{{ $no++}}</td>
                    <td>{{ $dmp['name']}}</td>
                    <td>
                        @if($dmp['image'] != NULL)
                        <a class="thumbnail">
                            {!! Html::image('img/products/thumb_'.$dmp['image'].'', $dmp['image']) !!}
                        </a>
                        @else
                        <a class="thumbnail">
                            {!! Html::image('files/default/noimageavailable.jpeg', 'No Image') !!}
                        </a>
                        @endif
                    </td>
                    <td>{{ $dmp['description']}}</td>
                    <td>{{ $dmp['sum']}}</td>
                    <td>{{ $dmp['unit']}}</td>
                    <td>{{ $dmp['family']}}</td>
                    <td>{{ $dmp['category']}}</td>
                </tr>
                @foreach($dmp['sub_products'] as $sp)
                    @if($sp->stock > 0)
                        <tr>
                            <td>{{ $no++}}</td>
                            <td>{{ $sp->main_product->name}}</td>
                            <td>{{ str_replace($dmp['name'].'.',"",$sp->name)}}</td>
                            <td>{{ $sp->description}}</td>
                            <td>{{ $sp->stock}}</td>
                            <td>{{ $sp->main_product->unit->name}}</td>
                            <td>{{ $sp->main_product->family->name}}</td>
                            <td>{{ $sp->main_product->category->name}}</td>
                        </tr>
                    @endif
                @endforeach
              @endforeach
          </tbody>
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
    $(document).ready(function(){
        $('#table-product').DataTable({
            "lengthMenu": [[10,25,50,-1],[10,25,50,"All"]]
        });
    });
  </script>
@endsection
