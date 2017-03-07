<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>{{ $sales_order_invoice->code  }}</title>
    <!-- Bootstrap Core CSS -->
    {!! Html::style('css/bootstrap/bootstrap.css') !!}
</head>
<style>
    /* TODO CSS Style */
    p{
        font-size:8pt;
    }
    hr{
        width:90%;
        border:1px solid black;
        margin-left: 0px
    }
    .box-attention{
        border:1px solid black;
        padding:5px;
    }
    *{
        padding: 0;
        margin: 0;
    }
    .container{
        padding: 30px;
    }
    #data-invoice td{
        padding-right: 3px;
        padding-left: 3px;
    }
    th{
        text-align: center;
    }
    td{
        font-size:8pt;
    }
</style>

<body>
    <div class="container">
        <div class="row">
            <table style="width:100%">
                <tr>
                    <td style="width:30%;vertical-align:top;text-align:left">
                        <h1>CATRA<small>TEXTILE</small></h1>
                    </td>
                    <td style="width:40%;text-align:left">
                        <p>Green Sedayu Bizpark</p>
                        <p>DMS No. 12 Jl. Daan Mogot KM 18</p>
                        <p>Kalideres- Jakarta Barat</p>
                        <p>Telp. 021-22522283, 021-22522334</p>
                    </td>
                    <td style="width:30%;vertical-align:top;text-align:left">
                        <h2>FAKTUR</h2>
                    </td>
                </tr>
            </table>
        </div>
        <br/>
        <div class="row">
            <table style="width:100%" border="0">
                <tr>
                    <td rowspan="6" style="width:10%;vertical-align:top">Bill To</td>
                    <td rowspan="6" style="width:2%;vertical-align:top">:</td>
                    <td rowspan="6" style="width:46%;vertical-align:top">
                        <div class="box-attention" style="height:70px;padding:2px">
                            <p>{{ $sales_order->customer->name }}</p>
                            <p>{{ $sales_order->customer->address }}</p>
                        </div>
                    </td>
                    <td style="width:15%">Invoice No</td>
                    <td style="width:2%">:</td>
                    <td style="width:25%">{{ $sales_order_invoice->code }}</td>
                </tr>
                <tr>
                    <td>Invoice Date</td>
                    <td>:</td>
                    <td>{{ $sales_order_invoice->created_at }}</td>
                </tr>
                <tr>
                    <td>Terms</td>
                    <td>:</td>
                    <td>{{ $invoice_term->name }}</td>
                </tr>
                <tr>
                    <td>Ship Via</td>
                    <td>:</td>
                    <td>{{ $sales_order->driver->name }}&nbsp;&nbsp;{{ $sales_order->vehicle->number_of_vehicle }}</td>
                </tr>
                <tr>
                    <td>Ship Date</td>
                    <td>:</td>
                    <td>{{ $sales_order_invoice->created_at }}</td>
                </tr>
                <tr>
                    <td>D.O. No.</td>
                    <td>:</td>
                    <td>{{ $sales_order->code}}</td>
                </tr>
            </table>
        </div>
        <br/>
        <div class="row">
            <table style="width:100%" border="1" id="data-invoice">
                <thead>
                    <tr>
                        <th style="width:5%">No</th>
                        <th style="width:20%">Kode Barang</th>
                        <th style="width:25%">Keterangan Barang</th>
                        <th style="width:10%">Jumlah</th>
                        <th style="width:10%">Satuan</th>
                        <th style="width:15%">Harga Satuan</th>
                        <th style="width:15%">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; $mtr = 0;?>
                    @foreach($sales_order->products as $product )
                    <tr>
                        <td>{{ $no++.'.' }}</td>
                        <td>{{ $product->code }}</td>
                        <td>{{ $product->name }}</td>
                        <td style="text-align:center">{{ $product->pivot->quantity }}</td>
                        <td style="text-align:center">{{ $product->unit->name }}</td>
                        <td style="text-align:right">{{ number_format($product->pivot->price_per_unit) }}.00</td>
                        <td style="text-align:right">{{ number_format($product->pivot->price) }}.00</td>
                    </tr>
                    @if($product->pivot->price)
                        <?php $mtr += $product->pivot->price; ?>
                    @endif
                    @endforeach
                    <tr>
                        <td colspan="6" style="text-align:right">
                            Total Meter :
                        </td>
                        <td style="text-align:right"> {{ number_format($mtr) }}.00</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <br/>
        <div class="row">
            <table style="width:100%">
                <tbody>
                    <tr>
                        <td style="height:40px;width:15%;vertical-align:top"><p>Hormat Kami</p></td>
                        <td style="height:40px;width:15%;vertical-align:top"><p>Penerima</p></td>
                        <td style="height:40px;width:15%;vertical-align:top"></td>
                        <td rowspan="2" style="width:55%;height:40px">
                            <div class="box-attention">
                            <p>PERHATIAN!!!</p>
                            <p>*Pembayaran dengan Cek/Giro akan dianggap lunsa,</p>
                            <p>jika sudah cair dalam rekening kami</p>
                            <p>BCA KCP Taman Palem Lestari</p>
                            <p>A/C: 757 054 5455</p>
                            <p>A/N: CATUR PUTRA NG</p>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><hr><p>Date :</p></td>
                        <td><hr><p>Date :</p></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>