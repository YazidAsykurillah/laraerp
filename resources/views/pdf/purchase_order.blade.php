<!DOCTYPE html>
<html lang="en">

<head>
    <meta http:equiv="Content-Type" content="text/html; charset=utf-8">
    <title>{{ $purchase_order->code }}</title>
    <!-- Bootstrap Core CSS -->
    {!! Html::style('css/bootstrap/bootstrap.css') !!}
<style>
    p{
        font-size:8pt;
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
    #data-purchase-order td{
        padding-left: 3px;
        padding-right: 3px;
    }
    th{
        text-align: center;
    }
    td{
        font-size:8pt;
    }
    .field-so{
        padding-left: 3px;
    }
</style>
</head>

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
                        <h2>PURCHASE ORDER</h2>
                    </td>
                </tr>
            </table>
        </div>
        <br/>
        <div class="row">
            <table style="width:100%" border="0">
                <tr>
                    <td rowspan="3" style="width:10%;vertical-align:top">Supplier</td>
                    <td rowspan="3" style="width:2%;vertical-align:top">:</td>
                    <td rowspan="3" style="width:46%;vertical-align:top">
                        <div class="box-attention" style="height:70px;padding:2px">
                            <p>{{ $purchase_order->supplier->name }}</p>
                            <p>{{ $purchase_order->supplier->address }}</p>
                        </div>
                    </td>
                    <td style="width:15%" class="field-so">Purchase No</td>
                    <td style="width:2%">:</td>
                    <td style="width:25%">{{ $purchase_order->code }}</td>
                </tr>
                <tr>
                    <td class="field-so">Created At</td>
                    <td>:</td>
                    <td>{{ $purchase_order->created_at }}</td>
                </tr>
                <tr>
                    <td class="field-so">Status</td>
                    <td>:</td>
                    <td>{{ $purchase_order->status }}</td>
                </tr>
            </table>
        </div>
        <br/>
        <div class="row">
            <table style="width:100%" border="1" id="data-purchase-order">
                <thead>
                    <tr>
                        <th style="width:5%">No</th>
                        <th style="width:25%">Kode Barang</th>
                        <th style="width:25%">Keterangan Barang</th>
                        <th style="width:10%">Jumlah</th>
                        <th style="width:10%">Satuan</th>
                        <th style="width:25%">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; $jml = 0;?>
                    @foreach($purchase_order->products as $product )
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $product->code }}</td>
                        <td>{{ $product->name }}</td>
                        <td style="text-align:center">{{ $product->pivot->quantity }}</td>
                        <td style="text-align:center">{{ $product->unit->name }}</td>
                        <td>{{ $product->status }}</td>
                    </tr>
                    @if($product->pivot->quantity)
                        <?php $jml += $product->pivot->quantity; ?>
                    @endif
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5" style="text-align:right">Total Roll :{{ $no-1 }}</td>
                        <td style="text-align:right">Total Meter : {{ $jml  }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

</body>
</html>
