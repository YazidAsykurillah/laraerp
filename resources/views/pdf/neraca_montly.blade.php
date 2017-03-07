<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Neraca</title>
    <!-- Bootstrap Core CSS -->
    {!! Html::style('css/bootstrap/bootstrap.css') !!}
    <style>
        *{
            padding: 0;
            margin: 0;
        }
        .container{
            padding: 50px;
        }
        h1,h4{
            text-align: center;
        }
        td{
            font-size: 10pt;
        }
        th{
            text-align: center;
        }
        table tr .parent{
            color: navy;
            padding-left: 20px;
        }
        table tr .sub_child{
            padding-left: 40px;
        }
        table tr .total_child{
            color: navy;
            padding-left: 40px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h1 class="box-title">CATRA<small>TEXTILE</small></h1>
                        <h4>NERACA</h4>
                        <h4 style="line-height:1.7">DARI BULAN {{ $sort_by_month_start }} TAHUN {{ $sort_by_month_year_start }} KE DARI BULAN {{ $sort_by_month_end }} TAHUN {{ $sort_by_month_year_end }}</h4>
                    </div>
                    <br/>
                    <div class="box-body">
                        <table style="width:100%" border="0">
                            <tbody>
                                <tr>
                                    <td style="width:70%;color:navy">Harta</td>
                                    <td style="width:30%;text-align:right;border-bottom:1px solid black">IDR</td>
                                </tr>
                                @foreach($chart_account as $key)
                                <tr>
                                    <td class="parent">{{ $key->description }}</td>
                                    <td></td>
                                </tr>
                                    @foreach($key->sub_chart_account as $sub_chart)
                                        <tr>
                                            @if($sub_chart->chart_account_id == 8)
                                            <td class="sub_child">{{ $sub_chart->banks->name }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $sub_chart->account_number }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{!! amount_sales_order_bank($sub_chart->reference,$sub_chart->chart_account_id) !!}</td>
                                            <td align="right">50,000,000.00</td>
                                            @else
                                            <td class="sub_child">{{ $sub_chart->cashs->name }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $sub_chart->account_number }}</td>
                                            <td align="right">20,000,000.00</td>
                                            @endif
                                        </tr>
                                    @endforeach
                                        <tr>
                                            <td class="total_child">Total {{ $key->description }}</td>
                                            <td style="border-top:1px solid black;color:navy" align="right">40,000,000.00</td>
                                        </tr>
                                @endforeach

                                <!-- <tr>
                                    <td style="width:50%">Kas</td>
                                    <td style="width:50%">IDR</td>
                                </tr> -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
