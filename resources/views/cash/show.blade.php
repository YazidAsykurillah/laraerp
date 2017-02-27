@extends('layouts.app')

@section('page_title')
    Cashs
@endsection

@section('page_header')
    <h1>
        Cashs
        <small>Show Cash</small>
    </h1>
@endsection

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{ URL::to('cash') }}"><i class="fa fa-dashboard"></i> Cash</a></li>
        <li><a href="{{ URL::to('cash/'.$cash->id) }}"><i class="fa fa-dashboard"></i> {{ $cash->code }}</a></li>
        <li class="active"><i></i>Detail</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Cash Details</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <table class="table">
                        <tr>
                            <td><b>Cash Code</b></td>
                            <td>{{ $cash->code }}</td>
                        </tr>
                        <tr>
                            <td><b>Cash Name</b></td>
                            <td>{{ $cash->name }}</td>
                        </tr>
                        <tr>
                            <td><b>Value</b></td>
                            <td>{{ number_format($cash->value) }}</td>
                        </tr>
                    </table>
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">

                </div><!-- /.box-footer -->
            </div><!-- /.box -->
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
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
