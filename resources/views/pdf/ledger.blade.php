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
</style>
</head>
<body>
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="box">
          <div class="box-header with-border">
              <h1 class="box-title">CATRA<small>TEXTILE</small></h1>
              <h4>{{ $sub_account_name->account_number.' '.$sub_account_name->name }}</h4>
              <h4 style="line-height:1.7">
                  <?php
                  $date_start_c = date_create($date_start);
                  $date_end_c = date_create($date_end);
                  ?>
                  Tanggal&nbsp;{{  date_format($date_start_c,'d-m-Y') }}&nbsp;s/d&nbsp;{{ date_format($date_end_c,'d-m-Y') }}
              </h4>
          </div>
          <div class="box-body">
            <div class="table-responsive">
              @if(count($query_trans) > 0)
                <br>
                <table border="1" style="width:100%">
                    <thead>
                        <tr>
                            <th style="width:20%">No.Transaction</th>
                            <th style="width:10%">Date</th>
                            <th style="width:25%">Description</th>
                            <th style="width:25%">Memo</th>
                            <th style="width:10%">Debit</th>
                            <th style="width:10%">Credit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $sum_debit = 0; $sum_credit = 0; ?>
                        @foreach($query_trans as $qt)
                            <tr>
                                    <td>{{ $qt->source }}</td>
                                    <td>
                                      <?php $date_created_at = date_create($qt->created_at); ?>
                                      {{ date_format($date_created_at,'d-m-Y') }}
                                    </td>
                                    <td>{{ $qt->description }}</td>
                                    <td>{{ $qt->memo }}</td>
                                    @if($qt->type == 'masuk' AND $qt->memo != 'AKUMULASI PENYUSUTAN')
                                      <td align="right" style="padding-right:3px">
                                        {{ number_format($qt->amount) }}
                                        <?php $sum_debit += $qt->amount; ?>
                                      </td>
                                      <td align="right" style="padding-right:3px">0.00</td>
                                    @elseif($qt->type == 'keluar')
                                      <td align="right" style="padding-right:3px">0.00</td>
                                      <td align="right" style="padding-right:3px">
                                        {{ number_format($qt->amount) }}
                                        <?php $sum_credit += $qt->amount; ?>
                                      </td>
                                    @elseif($qt->memo = 'AKUMULASI PENYUSUTAN')
                                      <td align="right" style="padding-right:3px">
                                        <?php
                                          $date1 = date_create($date_start);
                                          $date2 = date_create($date_end);
                                          $diff = date_diff($date1,$date2);
                                          $range = $diff->format('%a');
                                         ?>
                                        {{ number_format($qt->amount*(round($range/30))) }}
                                        <?php $sum_debit += $qt->amount; ?>
                                      </td>
                                      <td align="right" style="padding-right:3px">0.00</td>
                                    @endif
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>

                    </tfoot>
                </table>
                <p>Balance : {{ number_format($sum_debit-$sum_credit) }}</p>
                @else
                <center>
                  <p>Data not available</p>
                </center>
                @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
