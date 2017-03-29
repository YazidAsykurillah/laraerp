@extends('layouts.app')

@section('page_title')
  Biaya Operasi
@endsection

@section('page_header')
  <h1>
    Biaya Operasi
    <small>Show Biaya Operasi </small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('biaya-operasi') }}"><i class="fa fa-dashboard"></i> Biaya Operasi</a></li>
    <li><a href="{{ URL::to('biaya-operasi/'.$trans_chart_account->id) }}"><i class="fa fa-dashboard"></i> {{ $trans_chart_account->id }}</a></li>
    <li class="active"><i></i>Detail</li>
  </ol>
@endsection

@section('content')

  <div class="row">
    <div class="col-lg-12">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Biaya Operasi Detail</h3>
        </div><!-- /.box-header -->
        <div class="box-body">
          <table class="table">
            <tr>
              <td><b>Account Number</b></td>
              <td>{{ $trans_chart_account->sub_chart_account->account_number }}</td>
            </tr>
            <tr>
              <td><b>Name</b></td>
              <td>{{ $trans_chart_account->sub_chart_account->name }}</td>
            </tr>
            <tr>
              <td><b>Amount</b></td>
              <td>{{ number_format($trans_chart_account->amount) }}</td>
            </tr>
            <tr>
              <td><b>Created At</b></td>
              <td>{{ $trans_chart_account->created_at }}</td>
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
