@extends('layouts.app')

@section('page_title')
    Kategori Produk
@endsection

@section('page_header')
  <h1>
    Kategori Produk
    <small>Daftar kategori produk</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('category') }}"><i class="fa fa-dashboard"></i> Kategori Produk</a></li>
    <li class="active"><i></i> Index</li>
  </ol>
@endsection

@section('content')
  <div class="row">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Kategori Produk</h3>
              <a href="{{ URL::to('category/create')}}" class="btn btn-primary pull-right" title="Create new category">
                <i class="fa fa-plus"></i>&nbsp;Add New
              </a>
            </div><!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered">
                <tr>
                  <th style="width:5%;">#</th>
                  <th style="width:10%;">Code</th>
                  <th>Nama Kategori</th>
                  <th style="width:10%;text-align:center;">Aksi</th>
                </tr>
                @if($categories->count() >0 )
                  @foreach($categories as $category)
                    <tr>
                      <td>#</td>
                      <td>{{ $category->code }}</td>
                      <td>{{ $category->name }}</a>
                      </td>
                      <td style="text-align:center;">
                        <a href="{{ url('category/'.$category->id.'/edit') }}" class="btn btn-info btn-xs" title="Klik untuk mengedit kategori ini">
                          <i class="fa fa-edit"></i>
                        </a>&nbsp;
                        <button type="button" class="btn btn-danger btn-xs btn-delete-category" data-id="{{ $category->id }}" data-text="{{$category->name}}">
                          <i class="fa fa-trash"></i>
                        </button>
                      </td>
                    </tr>
                  @endforeach
                @else
                <tr>
                  <td colspan="4">Tidak ada kategori terdaftar</td>
                </tr>
                @endif
              </table>
            </div><!-- /.box-body -->
            <div class="box-footer clearfix">

            </div>
        </div><!-- /.box -->

    </div>
  </div>

  <!--Modal Delete Category-->
  <div class="modal fade" id="modal-delete-category" tabindex="-1" role="dialog" aria-labelledby="modal-delete-categoryLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'deleteCategory', 'method'=>'post']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-delete-categoryLabel">Konfirmasi</h4>
        </div>
        <div class="modal-body">
          Anda akan menghapus kategori <b id="category-name-to-delete"></b>
          <br/>
          <p class="text text-danger">
            <i class="fa fa-info-circle"></i>&nbsp;Proses menghapus tidak bisa dibatalkan
          </p>
          <input type="hidden" id="category_id" name="category_id">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger">Delete</button>
        </div>
      {!! Form::close() !!}
      </div>
    </div>
  </div>
<!--ENDModal Delete Category-->
@endsection

@section('additional_scripts')
  <script type="text/javascript">
    $('.btn-delete-category').on('click', function(){
      var id = $(this).attr('data-id');
      var name = $(this).attr('data-text');
      $('#category_id').val(id);
      $('#category-name-to-delete').text(name);
      $('#modal-delete-category').modal('show');
    });
  </script>
@endsection
