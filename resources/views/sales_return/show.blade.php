@extends('layouts.app')

@section('page_title')
    Sales Order return
@endsection

@section('page_header')
    <h1>
        Sales order
        <small>Sales Return Detail</small>
    </h1>
@endsection

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{ URL::to('sales-order') }}"><i class="fa fa-dashboard"></i> Sales Order</a></li>
        <li><a href="{{ URL::to('sales-order/'.$sales_return->sales_order->id) }}">{{ $sales_return->sales_order->code }}</a></li>
        <li><a href="{{ URL::to('sales-return') }}"><i class="fa fa-dashboard"></i>Return</a></li>
        <li><i></i>{{ $sales_return->id }}</li>
        <li class="active"><i></i>Detail</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Sales Return Detail</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                    <div class="table responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>PO Refference</th>
                                    <th>Product</th>
                                    <th>Sales Quantity</th>
                                    <th>Returned Quantity</th>
                                    <th>Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $sales_return->sales_order->code }}</td>
                                    <td>{{ $sales_return->product->name }}</td>
                                    <td class="salesed_qty">
                                        {{ \DB::table('product_sales_order')->select('quantity')->where('product_id',$sales_return->product_id)->where('sales_order_id',$sales_return->sales_order_id)->value('quantity') }}
                                    </td>
                                    <td>{{ $sales_return->quantity }}</td>
                                    <td>{{ $sales_return->notes }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div><!-- /.table-responsive -->
                    <br/>
                    <div class="row">
                        <div class="col-md-3">Status</div>
                        <div class="col-md-1">:</div>
                        <div class="col-md-3">
                            <p>{{ strtoupper($sales_return->status) }}</p>
                            @if($sales_return->status == 'posted')
                                <button type="button" id="btn-accept-sales-return" class="btn btn-warning btn-xs" data-id="{{ $sales_return->id }}" title="Change status to Accept">
                                    <i class="fa fa-sign-in"></i>&nbsp;Accept
                                </button>
                            @endif
                            @if($sales_return->status == 'accept')
                                <button type="button" id="btn-resent-sales-return" class="btn btn-success btn-xs" data-id="{{ $sales_return->id }}" title="Change status to Resent">
                                    <i class="fa fa-check"></i>&nbsp;Resent
                                </button>
                            @endif
                        </div>
                    </div><!-- /.row -->
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">

                </div><!-- /.box-footer -->
            </div><!-- /.box -->
        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->

    <!-- Modal send sales-return -->
    <div class="modal fade" id="modal-accept-sales-return" tabindex="-1" role="dialog" aria-labelledby="modal-accept-sales-returnLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
          {!! Form::open(['url'=>'acceptSalesReturn', 'method'=>'post', 'id'=>'form-accept-sales-return']) !!}
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="modal-accept-sales-returnLabel">Accept Sales Return Confirmation</h4>
            </div>
            <div class="modal-body">
              This sales return status will be changed to "Accept".
              <br/>
              <p class="text text-danger">
                <i class="fa fa-info-circle"></i>&nbsp;The product will be returned to the supplier.
              </p>
              <input type="hidden" id="id_to_be_accept" name="id_to_be_accept">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-danger" id="btn-accept-sales-return">accept</button>
            </div>
          {!! Form::close() !!}
          </div>
        </div>
    </div>
    <!--ENDModal Accept purchase-return-->

    <!--Modal Resent sales-return-->
      <div class="modal fade" id="modal-resent-sales-return" tabindex="-1" role="dialog" aria-labelledby="modal-resent-sales-returnLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
          {!! Form::open(['url'=>'resentSalesReturn', 'method'=>'post', 'id'=>'form-resent-sales-return']) !!}
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="modal-resent-sales-returnLabel">Resent Sales Return Confirmation</h4>
            </div>
            <div class="modal-body">
              This return status will be changed to Resent
              <br/>
              <p class="text text-danger">
                <i class="fa fa-info-circle"></i>&nbsp;The product will be re-added to the inventory
              </p>
              <input type="hidden" id="id_to_be_resent" name="id_to_be_resent">
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-danger" id="btn-resent-sales-return">Complete</button>
            </div>
          {!! Form::close() !!}
          </div>
        </div>
      </div>
    <!--ENDModal complete purchase-return-->
@endsection

@section('additional_scripts')

<script type="text/javascript">
  //Handler send purchase return
    $('#btn-accept-sales-return').on('click', function (e) {
      var id = $(this).attr('data-id');
      $('#id_to_be_accept').val(id);
      $('#modal-accept-sales-return').modal('show');
    });
</script>

<script type="text/javascript">
  //Handler send purchase return
    $('#btn-resent-sales-return').on('click', function (e) {
      var id = $(this).attr('data-id');
      $('#id_to_be_resent').val(id);
      $('#modal-resent-sales-return').modal('show');
    });
</script>

@endsection
