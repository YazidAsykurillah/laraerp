@extends('layouts.app')


@section('page_title')
    Main Product
@endsection

@section('page_header')
    <h1>
        Main Product
        <small>Add New Main Product</small>
    </h1>
@endsection

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{ URL::to('main-product') }}"><i class="fa fa-dashboard"></i> Main Products</a></li>
        <li class="active"><i></i> Create</li>
    </ol>
@endsection

@section('content')
    <!-- <ul class="nav nav-tabs">
        <li class="active">
            <a data-toggle="tab" href="#section-create-main-product"><i class="fa fa-desktop"></i>&nbsp;Main Product</a>
        </li>
        <li>
            <a data-toggle="tab" href="#section-create-sub-product"><i class="fa fa-desktop"></i>&nbsp;Sub Product</a>
        </li>
    </ul> -->

    <!-- <div class="tab-content">
        <div id="section-create-main-product" class="tab-pane fade in active"> -->
            {!! Form::open(['route'=>'main-product.store','role'=>'form','class'=>'form-horizontal','id'=>'form-create-main-product','files'=>true]) !!}
            <div class="row">
                <div class="col-md-8">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Basic Informations</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                              {!! Form::label('name', 'Name', ['class'=>'col-sm-2 control-label']) !!}
                              <div class="col-sm-10">
                                {!! Form::text('name',null,['class'=>'form-control', 'placeholder'=>'Name of the product', 'id'=>'name']) !!}
                                @if ($errors->has('name'))
                                  <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                  </span>
                                @endif
                              </div>
                            </div>
                            <div class="form-group{{ $errors->has('unit_id') ? ' has-error' : '' }}">
                              {!! Form::label('unit_id', 'Unit', ['class'=>'col-sm-2 control-label']) !!}
                              <div class="col-sm-10">
                                {{ Form::select('unit_id', $unit_options, null, ['class'=>'form-control', 'placeholder'=>'Select unit', 'id'=>'unit_id']) }}
                                @if ($errors->has('unit_id'))
                                  <span class="help-block">
                                    <strong>{{ $errors->first('unit_id') }}</strong>
                                  </span>
                                @endif
                              </div>
                            </div>
                        </div>
                    </div>
                    <div class="box">
                      <div class="box-body">
                        <div class="form-group">
                            {!! Form::label('', '', ['class'=>'col-sm-2 control-label']) !!}
                          <div class="col-sm-10">
                            <a href="{{ url('product') }}" class="btn btn-default">
                              <i class="fa fa-repeat"></i>&nbsp;Cancel
                            </a>&nbsp;
                            <button type="submit" class="btn btn-info" id="btn-submit-product">
                              <i class="fa fa-save"></i>&nbsp;Submit
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
                <div class="col-md-4">
                  <!--BOX Image-->
                  <div class="box">
                    <div class="box-header with-border">
                      <h3 class="box-title">Main Product Image</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">

                      <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                        {!! Form::label('image', 'Image', ['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                          {{ Form::file('image', ['class']) }}
                          @if ($errors->has('image'))
                            <span class="help-block">
                              <strong>{{ $errors->first('image') }}</strong>
                            </span>
                          @endif
                        </div>
                      </div>
                    </div><!-- /.box-body -->
                  </div>
                  <!--ENDBOX Image-->
                  <!--BOX Category and Family-->
                  <div class="box">
                    <div class="box-header with-border">
                      <h3 class="box-title">Category and Family</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                      <div class="form-group{{ $errors->has('family_id') ? ' has-error' : '' }}">
                        {!! Form::label('family_id', 'Family', ['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                          {{ Form::select('family_id', $family_options, null, ['class'=>'form-control', 'placeholder'=>'Select Family', 'id'=>'family_id']) }}
                          @if ($errors->has('family_id'))
                            <span class="help-block">
                              <strong>{{ $errors->first('family_id') }}</strong>
                            </span>
                          @endif
                        </div>
                      </div>
                      <div class="form-group{{ $errors->has('category_id') ? ' has-error' : '' }}">
                        {!! Form::label('category_id', 'Category', ['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                          {{ Form::select('category_id', $category_options, null, ['class'=>'form-control', 'placeholder'=>'Select category', 'id'=>'category_id']) }}
                          @if ($errors->has('category_id'))
                            <span class="help-block">
                              <strong>{{ $errors->first('category_id') }}</strong>
                            </span>
                          @endif
                        </div>
                      </div>
                    </div><!-- /.box-body -->
                  </div>
                  <!--ENDBOX Category and Family-->
                </div>
            </div>
            {!! Form::close() !!}
        <!-- </div> -->
        
    </div>
@endsection
