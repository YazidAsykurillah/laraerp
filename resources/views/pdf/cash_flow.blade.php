<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>Cash Flow</title>
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
        #table-cash-flow td{
            font-size: 10pt;
            padding-left: 5px;
        }
        #table-cash-flow .data{
            text-align: right;
            padding-right: 5px;
        }
        th{
            text-align: center;
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
                        <h4>ARUS KAS</h4>
                        <h4 style="line-height:1.7">
                            <?php
                            $date_start_nya = date_create($date_start);
                            $date_end_nya = date_create($date_end);
                            ?>
                            TANGGAL&nbsp;{{ date_format($date_start_nya,'d-m-Y') }}&nbsp;SAMPAI TANGGAL&nbsp;{{ date_format($date_end_nya,'d-m-Y')}}
                        </h4>
                    </div>
                    <br/>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table" id="table-cash-flow">
                                <thead>
                                    <tr>
                                        <th colspan="2">Deskripsi</th>
                                        <th>Saldo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="3">Cash Flow From : Operating Activities</td>
                                    </tr>
                                    <tr>
                                        <td>Net Income</td>
                                        <td>(From Profit&nbsp;&amp;&nbsp;Loss Statement)</td>
                                        <td class="data">{{ $lost_profit }}</td>
                                    </tr>
                                    <tr>
                                        <td>Tambah</td>
                                        <td>Akumulasi Penyusutan</td>
                                        <td class="data">{{ $akumulasi_penyusutan }}</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td style="border-top:1px solid black;">Net Income sesudah akumulasi penyusutan</td>
                                        <td style="border-top:1px solid black;" class="data">{{ number_format(str_replace(',','',$lost_profit)-str_replace(',','',$akumulasi_penyusutan))}}</td>
                                    </tr>
                                    <tr>
                                        <td>Kurang</td>
                                        <td>Akun Hutang</td>
                                        <td class="data">{{ $akun_hutang }}</td>
                                    </tr>
                                    <tr>
                                        <td>Kurang</td>
                                        <td>Kewajiban Lancar Lainnya</td>
                                        <td class="data">{{ $kewajiban_lancar_lainnya }}</td>
                                    </tr>
                                    <tr>
                                        <td>Tambah</td>
                                        <td>Akun Piutang</td>
                                        <td class="data">{{ $akun_piutang }}</td>
                                    </tr>
                                    <tr>
                                        <td>Tambah</td>
                                        <td>Aset Lancar Lainnya</td>
                                        <td class="data">{{ $aset_lancar_lainnya }}</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td style="border-top:1px solid black;">Net Income</td>
                                        <td style="border-top:1px solid black;" class="data">
                                            {{ number_format(((str_replace(',','',$lost_profit)-str_replace(',','',$akumulasi_penyusutan))+(str_replace(',','',$akun_piutang)))-(str_replace(',','',$akun_hutang)+str_replace(',','',$kewajiban_lancar_lainnya)))}}
                                            <?php $sum_net = ((str_replace(',','',$lost_profit)-str_replace(',','',$akumulasi_penyusutan))+(str_replace(',','',$akun_piutang)))-(str_replace(',','',$akun_hutang)+str_replace(',','',$kewajiban_lancar_lainnya)); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">Cash Flow From : Investing</td>
                                    </tr>
                                    <tr>
                                        <td>Tambah</td>
                                        <td>Nilai Histori</td>
                                        <td class="data">{{ $nilai_histori }}</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td style="border-top:1px solid black;">Net Investing</td>
                                        <td style="border-top:1px solid black;" class="data">{{ number_format(str_replace(',','',$nilai_histori)-0)}}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3">Cash Flow From : Financing</td>
                                    </tr>
                                    <tr>
                                        <td>Kurang</td>
                                        <td>Kewajiban Jangka Panjang</td>
                                        <td class="data">{{ $kewajiban_jangka_panjang }}</td>
                                    </tr>
                                    <tr>
                                        <td>Tambah</td>
                                        <td>Ekuitas</td>
                                        <td class="data">{{ $ekuitas }}</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td style="border-top:1px solid black;">Net Financing</td>
                                        <td style="border-top:1px solid black;" class="data">{{ number_format(str_replace(',','',$ekuitas)-str_replace(',','',$kewajiban_jangka_panjang))}}</td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td style="border-top:1px solid black;">Net Cash Periode</td>
                                        <td style="border-top:1px solid black;" class="data">{{ number_format(str_replace(',','',$sum_net)+str_replace(',','',$nilai_histori)+(str_replace(',','',$ekuitas)-str_replace(',','',$kewajiban_jangka_panjang))) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
