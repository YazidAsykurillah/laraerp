@extends('layouts.app')

@section('page_title')
  Vehicle Detail
@endsection

@section('page_header')
    <h1>
        Vehicle Detail
        <small>{{ $vehicle->code }}</small>
    </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('vehicle') }}"><i class="fa fa-dashboard"></i> Vehicles</a></li>
    <li class="active"><i></i> {{ $vehicle->code }}</li>
  </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-7">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-bars"></i>&nbsp;General Informations</h3>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <tr>
                                <td style="width:30%">Code</td>
                                <td>:</td>
                                <td>{{ $vehicle->code }}</td>
                            </tr>
                            <tr>
                                <td style="width:30%">Category</td>
                                <td>:</td>
                                <td>
                                    @if($vehicle->category == 'motorcycle')
                                    {{ "Motorcycle" }}
                                    @elseif($vehicle->category == 'truck')
                                    {{ "Truck" }}
                                    @elseif($vehicle->category == 'pick_up')
                                    {{ "Pick Up" }}
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td style="width:30%">Number of Vehicle</td>
                                <td>:</td>
                                <td>{{ $vehicle->number_of_vehicle }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="box-footer clearfix">

                </div>
            </div>
        </div>
    </div>
@endsection
