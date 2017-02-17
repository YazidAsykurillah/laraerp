@extends('layouts.app')

@section('page_title')
  Banks
@endsection

@section('page_header')
  <h1>
    Banks
    <small>Edit Bank </small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('bank') }}"><i class="fa fa-dashboard"></i> Bank</a></li>
    <li><a href="{{ URL::to('bank/'.$bank->id) }}"><i class="fa fa-dashboard"></i> {{ $bank->code }}</a></li>
    <li class="active"><i></i>Detail</li>
  </ol>
@endsection
  
@section('content')
  
  <div class="row">
    <div class="col-lg-12">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Bank Detail</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <table class="table">
            <tr>
              <td><b>Bank Code</b></td>
              <td>{{ $bank->code }}</td>
            </tr>
            <tr>
              <td><b>Bank Name</b></td>
              <td>{{ $bank->name }}</td>
            </tr>
            <tr>
              <td><b>Account Name</b></td>
              <td>{{ $bank->account_name }}</td>
            </tr>
            <tr>
              <td><b>Account Number</b></td>
              <td>{{ $bank->account_number }}</td>
            </tr>
            <tr>
              <td><b>Value</b></td>
              <td>{{ number_format($bank->value) }}</td>
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
  {!! Html::script('js/autoNumeric.js') !!}
  <script type="text/javascript">
    $('#value').autoNumeric('init',{
        aSep:',',
        aDec:'.'
    });
  </script>
@endsection