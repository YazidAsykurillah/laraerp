@extends('layouts.app')

@section('page_title')
  Purchase Hutang
@endsection

@section('page_header')
  <h1>
    Purchase Order
    <small>Purchase Hutang Detail</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('purchase-hutang') }}"><i class="fa fa-cart-arrow-down"></i> Purchase Hutang</a></li>
    <li class="active">Index</li>
  </ol>
@endsection

@section('content')
    <ul class="nav nav-tabs">
      <li class="active">
        <a data-toggle="tab" href="#section-riwayat-hutang"><i class="fa fa-desktop"></i>&nbsp;Riwayat Hutang</a>
      </li>
      <li>
        <a data-toggle="tab" href="#section-belum-lunas"><i class="fa fa-bookmark"></i>&nbsp;Faktur Belum Lunas</a>
      </li>
    </ul>
    <div class="tab-content">
        <div id="section-riwayat-hutang" class="tab-pane fade in active">
            <div class="row">
                <div class="col-lg-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Supplier Summary</h3>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width:15%">Supplier Code</th>
                                            <th style="width:40%" colspan="3">Supplier Name</th>
                                            <th style="width:30%" colspan="2">Balance</th>
                                            <th style="width:15%">Detail</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $sum_balance = 0; ?>
                                        @foreach($data_hutang as $dat)
                                        <?php $sum_bill_price = 0; $sum_paid_price = 0;?>
                                            <tr>
                                                <td>{{ $dat['code'] }}</td>
                                                <td colspan="3">{{ $dat['name'] }}</td>
<<<<<<< HEAD
                                                <td colspan="2"></td>
=======
                                                <td colspan="2" class="target_sum"></td>
>>>>>>> 114a33c613be846042a42c4fc88e574ebdceaab7
                                                <td><a data-toggle="collapse" href=".demo{{$dat['id']}}">detail</a></td>
                                            </tr>
                                            <tr class="demo{{ $dat['id']}} collapse">
                                                <th></th>
                                                <th>Code Invoice</th>
                                                <th>Created At</th>
                                                <th>Due Date</th>
                                                <th>Bill Price</th>
                                                <th>Paid Price</th>
                                                <th>Age</th>
                                            </tr>
                                            @foreach($dat['purchase'] as $pur)
                                                <tr class="demo{{$dat['id']}} collapse">
                                                    <td></td>
                                                    <td>{{ $pur['code'] }}</td>
                                                    <td>{{ $pur['created_at'] }}</td>
                                                    <td></td>
                                                    <td>
                                                        {{ number_format($pur['bill_price']) }}
                                                        <?php $sum_bill_price += $pur['bill_price']; ?>
                                                    </td>
                                                    <td>
                                                        {{ number_format($pur['paid_price']) }}
                                                        <?php $sum_paid_price += $pur['paid_price']; ?>
                                                    </td>
                                                    <td></td>
                                                </tr>
                                            @endforeach
                                            <tr style="display:none">
                                              <td colspan="3" class="sum">
                                                  {{ number_format($sum_bill_price-$sum_paid_price) }}
                                                  <?php $sum_balance += $sum_bill_price-$sum_paid_price; ?>
                                              </td>
                                            </tr>
                                        @endforeach
                                            <tr>
                                                <td colspan="6" align="right">Total Hutang</td>
                                                <td>{{ number_format($sum_balance) }}</td>
                                            </tr>
                                    </tbody>
                                    <tfoot>

                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="box-footer">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="section-belum-lunas" class="tab-pane fade">

        </div>
    </div>
@endsection

@section('additional_scripts')
<script type="text/javascript">
    var sum = document.getElementsByClassName('sum');
    for(var a = 0; a < sum.length; a++){
      document.getElementsByClassName('target_sum')[a].innerHTML = document.getElementsByClassName('sum')[a].innerHTML;
    }
</script>
@endsection
