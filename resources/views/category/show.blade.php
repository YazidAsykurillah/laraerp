@extends('layouts.app')

@section('page_title')
    Kategori Produk
@endsection

@section('page_header')
  <h1>
    Kategori Produk
    <small>Detail Kategori Produk</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('category') }}"><i class="fa fa-dashboard"></i> Kategori Produk</a></li>
    <li class="active"><i></i> {{ $category->name }}</li>
  </ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-lg-4">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Informasi</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <table class="table">
            <tr>
              <td><b>Kode</b></td>
              <td>{{ $category->code }}</td>
            </tr>
            <tr>
              <td><b>Nama</b></td>
              <td>{{ $category->name }}</td>
            </tr>
            
          </table>
        </div><!-- /.box-body -->
        <div class="box-footer clearfix">
          
        </div>
      </div><!-- /.box -->
    </div>
    <div class="col-lg-8">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Produk</h3>&nbsp;
          <small>Produk yang termasuk kategori {{ $category->name }}</small>
        </div><!-- /.box-header -->
        <div class="box-body">

          @if($category->products->count() > 0)
            <table class="table table-responsive">
              <tr>
                <th>Kode Produk</th>
                <th>Nama</th>
              </tr>
              @foreach($category->products as $product)
              <tr>
                <td>{{ $product->code }}</td>
                <td>{{ $product->name }}</td>
              </tr>
              @endforeach
            </table>
          @else
            <p class="alert alert-info">
              <i class="fa fa-info-circle"></i>&nbsp;Tidak ada produk dalam kategori ini, klik tombol tambah produk untuk menambahkan
            </p>
            <p>
              
            </p>
          @endif
        </div><!-- /.box-body -->
        <div class="box-footer clearfix">
          <a href="#" class="btn btn-link">
            Tambah Produk
          </a>
        </div>
      </div><!-- /.box -->
    </div>
  </div>

@endsection

@section('additional_scripts')
  
@endsection