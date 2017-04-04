<!DOCTYPE html>
<html lang="en">

<head>
    <meta http:equiv="Content-Type" content="text/html; charset=utf-8">
    <title></title>
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
    #data-sales-order td{
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
            <table style="width:100%" border="1" id="data-sales-order">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Code</th>
                        <th>Description</th>
                        <th>System Stock</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    @foreach($products as $view)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $view->name }}</td>
                            <td>{{ $view->description }}</td>
                            <td>{{ $view->stock }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>

                </tfoot>
            </table>
        </div>
    </div>

</body>
</html>
