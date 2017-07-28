<!DOCTYPE html>
<html lang="en">

<head>
    <meta http:equiv="Content-Type" content="text/html; charset=utf-8">
    <title></title>
    <!-- Bootstrap Core CSS -->
    {!! Html::style('css/bootstrap/bootstrap.css') !!}
<style>
  *{
      padding: 0;
      margin: 0;
  }
  .container{
      padding: 20px;
  }
  h1,h4{
      text-align: center;
  }
  th{
      text-align:center;
      font-size:10pt;
  }
  table td{
      font-size:9pt;
      padding-left:3px;
  }
  hr{
    margin-top:5px;
    border:1px solid black;
  }
</style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
              <div class="box">
                <div class="box-header with-border">
                    <center>
                      <h2>PT.CATRA TEXTILE RAYA</h2>
                      <h5>Green Sedayu Bizpark DM 5 No.12 Jl.Daan Mogot KM 18 Kalideres - Jakarta Barat</h5>
                      <h5>Telp. 021-22522283, 021-22522334</h5>
                    </center>
                    <hr>
                    <br>
                    <table style="width:100%" border="0">
                        <tr>
                            <td style="width:70%">Stock Balance</td>
                            <td style="width:10%">Code</td>
                            <td style="width:1%">:</td>
                            <td style="width:19%">{{ $stock_balance->code}}</td>
                        </tr>
                        <tr>
                            <td>
                                <?php
                                  $date = date_create($stock_balance->created_at);
                                ?>
                                Tanggal {{date_format($date,'d-m-Y')}}
                            </td>
                            <td>Created By</td>
                            <td>:</td>
                            <td>{{ $stock_balance->creator->name}}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Created At</td>
                            <td>:</td>
                            <td>
                                <?php
                                    $date_stock_balance = date_create($stock_balance->created_at);
                                ?>
                                {{ date_format($date_stock_balance,'d-m-Y')}}
                            </td>
                        </tr>
                    </table>
                    <br>
                </div>
                <div class="box-body">
                  <table style="width:100%" border="1" id="data-sales-order">
                      <thead>
                          <tr>
                              <th>No</th>
                              <th>Family</th>
                              <th>Name</th>
                              <th>Description</th>
                              <th>Unit</th>
                              <th>Category</th>
                              <th>System Stock</th>
                              <th>Real Stock</th>
                              <th>Information</th>
                          </tr>
                      </thead>
                      <tbody>
                          <?php $no = 1; ?>
                          @foreach($products as $view)
                              <tr>
                                  <td>{{ $no++ }}</td>
                                  <td>{{ \DB::table('families')->select('name')->where('id',$view->family_id)->value('name') }}</td>
                                  <td>{{ $view->name }}</td>
                                  <td>{{ $view->description }}</td>
                                  <td>{{ \DB::table('units')->select('name')->where('id',$view->unit_id)->value('name') }}</td>
                                  <td>{{ \DB::table('categories')->select('name')->where('id',$view->category_id)->value('name') }}</td>
                                  <td>{{ $view->system_stock }}</td>
                                  <td>{{ $view->real_stock }}</td>
                                  <td>{{ $view->information }}</td>
                              </tr>
                          @endforeach
                      </tbody>
                      <tfoot>

                      </tfoot>
                  </table>
                </div>
              </div>
            </div>
        </div>
    </div>

</body>
</html>
