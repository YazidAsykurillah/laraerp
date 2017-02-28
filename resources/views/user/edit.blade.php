@extends('layouts.app')

@section('page_title')
  User
@endsection

@section('page_header')
  <h1>
    User
    <small>Add New User</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="#"><i class="fa fa-dashboard"></i> User </a></li>
    <li class="active"><i></i>Add User</li>
  </ol>
@endsection

@section('content')
  {!! Form::model($user, ['route'=>['user.update', $user->id], 'class'=>'form-horizontal','method'=>'put', 'files'=>true]) !!}
  <div class="row">
    <div class="col-md-8">
      <!--BOX Basic Informations-->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Basic Informations</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          
          <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            {!! Form::label('name', 'Name', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!! Form::text('name',null,['class'=>'form-control', 'placeholder'=>'Name of the user', 'id'=>'name']) !!}
              @if ($errors->has('name'))
                <span class="help-block">
                  <strong>{{ $errors->first('name') }}</strong>
                </span>
              @endif
            </div>
          </div>
          <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            {!! Form::label('email', 'Email', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {!! Form::text('email',null,['class'=>'form-control', 'placeholder'=>'Email of the user', 'id'=>'email']) !!}
              @if ($errors->has('email'))
                <span class="help-block">
                  <strong>{{ $errors->first('email') }}</strong>
                </span>
              @endif
            </div>
          </div>

        </div><!-- /.box-body -->
      </div>
      <!--ENDBOX Basic Informations-->
    </div>
    <div class="col-md-4">
      <!--BOX Role-->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Role</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          
          <div class="form-group{{ $errors->has('role_id') ? ' has-error' : '' }}">
            {!! Form::label('role_id', 'Role', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              {{ Form::select('role_id', $role_options, $user->roles->first()->id, ['class'=>'form-control', 'placeholder'=>'Select Role', 'id'=>'role_id']) }}
              @if ($errors->has('role_id'))
                <span class="help-block">
                  <strong>{{ $errors->first('role_id') }}</strong>
                </span>
              @endif
            </div>
          </div>
        </div><!-- /.box-body -->
      </div>
      <!--ENDBOX Role-->
    </div>
  </div>
  <!--ROW Submission-->
  <div class="row">
    <div class="col-md-8">
      <!--BOX submission buttons-->
      <div class="box">
        <div class="box-body">
          <div class="form-group">
              {!! Form::label('', '', ['class'=>'col-sm-2 control-label']) !!}
            <div class="col-sm-10">
              <a href="{{ url('user') }}" class="btn btn-default">
                <i class="fa fa-repeat"></i>&nbsp;Cancel
              </a>&nbsp;
              <button type="submit" class="btn btn-info" id="btn-submit-user">
                <i class="fa fa-save"></i>&nbsp;Save
              </button>
            </div>
          </div>
        </div>
      </div>
      <!--ENDBOX submission buttons-->
    </div>
  </div>
  <!--ENDROW Submission-->
  {!! Form::close() !!}

@endsection

@section('additional_scripts')
  
@endsection