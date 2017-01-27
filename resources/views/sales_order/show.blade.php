@extends('layouts.app')

@section('page_title')
  Sales Order Detail
@endsection

@section('page_header')
  <h1>
    Sales Order
    <small>Sales Order Detail</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('sales-order') }}"><i class="fa fa-dashboard"></i> Sales Order</a></li>
    <li class="active">{{ $sales_order->code }}</li>
  </ol>
@endsection

@section('content')
  
  <ul class="nav nav-tabs">
    <li class="active">
      <a data-toggle="tab" href="#section-general-information"><i class="fa fa-desktop"></i>&nbsp;General Information</a>
    </li>
    <li>
      <a data-toggle="tab" href="#section-invoice"><i class="fa fa-bookmark"></i>&nbsp;Invoice</a>
    </li>
    <li>
      <a data-toggle="tab" href="#section-invoice-payment"><i class="fa fa-bookmark-o"></i>&nbsp;Invoice Payments</a>
      </li>
    <li>
      <a data-toggle="tab" href="#section-return"><i class="fa fa-reply"></i>&nbsp;Return</a>
    </li>
  </ul>
  <div class="tab-content">
    <!--General Information-->
    <div id="section-general-information" class="tab-pane fade in active">
      <div class="row">
        <div class="col-lg-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">General Information</h3>
              <div class="pull-right">
                <a href="{{ url('sales-order/'.$sales_order->id.'/printPdf') }}" class="btn btn-default btn-xs">
                  <i class='fa fa-print'></i>&nbsp;Print
                </a>
              </div>
              
            </div><!-- /.box-header -->
            <div class="box-body">
              
              <div class="row">
                  <div class="col-md-2"><strong>Code</strong></div>
                  <div class="col-md-6"><strong>{{ $sales_order->code }}</strong></div>
              </div>
              <br/>
              
              <div class="table-responsive">
                
                <table class="table table-bordered" id="table-selected-products">
                  <thead>
                    <tr>
                      <th style="width:40%">Product Name</th>
                      <th style="width:20%">Quantity</th>
                      <th style="width:20%">Unit</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if($sales_order->products->count() > 0)
                      @foreach($sales_order->products as $product)
                      <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->pivot->quantity }}</td>
                        <td>{{ $product->unit->name }}</td>
                      </tr>
                    <tr>
                      @endforeach
                    @else
                      <td colspan="3">There are no product</td>
                    </tr>
                    @endif
                  </tbody>
                  <tfoot>

                  </tfoot>
                </table>
              </div>

              <div class="row">
                <div class="col-md-3">Customer</div>
                <div class="col-md-1">:</div>
                <div class="col-md-8">
                  {{ $sales_order->customer->name }}
                </div>
              </div>
              <br/>
              <div class="row">
                <div class="col-md-3">Created At</div>
                <div class="col-md-1">:</div>
                <div class="col-md-8">
                  {{ $sales_order->created_at }}
                </div>
              </div>
              <br/>
              <div class="row">
                <div class="col-md-3">Status</div>
                <div class="col-md-1">:</div>
                <div class="col-md-3">
                  {{ strtoupper($sales_order->status) }}
                </div>
                <div class="col-md-5">
                  {!! Form::open(['url'=>'sales-order/updateStatus','role'=>'form','class'=>'form-inline','id'=>'form-update-sales-order-status', 'method'=>'POST']) !!}
                    <select name="status" id="status">
                      <option value="posted" <?php echo $sales_order->status == 'posted' ? 'selected':'' ;?>>Posted</option>
                      <option value="processing" <?php echo $sales_order->status == 'processing' ? 'selected':'' ;?>>Processing</option>
                      <option value="delivering" <?php echo $sales_order->status == 'delivering' ? 'selected':'' ;?>>Delivering</option>
                      <option value="cancelled" <?php echo $sales_order->status == 'cancelled' ? 'selected':'' ;?>>Cancelled</option>
                      <option value="completed" <?php echo $sales_order->status == 'completed' ? 'selected':'' ;?>>Completed</option>
                    </select>
                    <input type="hidden" name="sales_order_id" value="{{ $sales_order->id}}" />
                    <button type="submit" class="btn btn-info btn-xs">Update Status</button>
                  {!! Form::close() !!}
                
                </div>
              </div>
              <br/>
              <div class="row">
                <div class="col-md-3">Notes</div>
                <div class="col-md-1">:</div>
                <div class="col-md-8">
                  {!! nl2br($sales_order->notes) !!}
                </div>
              </div>
            </div><!-- /.box-body -->
            
          </div><!-- /.box -->
        </div>
      </div>
      
    </div>
    <!-- ENDSection General Information-->

    <!-- Section Invoice -->
    <div id="section-invoice" class="tab-pane fade">
      <div class="row">
        <div class="col-lg-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title"> Invoice <small>Related invoice with the sales order</small></h3>
              <div class="pull-right">
                @if($invoice->count() < 1)
                <a href="{{ URL::to('sales-order-invoice/'.$sales_order->id.'/create')}}" class="btn btn-default btn-xs">
                    <i class='fa fa-bookmark'></i>&nbsp;Create Invoice
                </a>
                @endif
              </div>
              
            </div><!-- /.box-header -->
            <div class="box-body">
              @if($invoice->count() > 0)
                <div class="table-responsive">
                  <table class="table">
                    <tr>
                      <td>Invoice Code</td>
                      <td>:</td>
                      <td>
                        <a href="{{ url('sales-order-invoice/'.$sales_order->sales_order_invoice->id.'') }}" title="Click to see the detail">
                          {{ $sales_order->sales_order_invoice->code }}
                        </a>
                      </td>
                    </tr>
                    <tr>
                      <td>Bill Price</td>
                      <td>:</td>
                      <td>{{ number_format($sales_order->sales_order_invoice->bill_price) }}</td>
                    </tr>
                    <tr>
                      <td>Paid Price</td>
                      <td>:</td>
                      <td>{{ number_format($sales_order->sales_order_invoice->paid_price) }}</td>
                    </tr>
                    <tr>
                      <td>Created Date</td>
                      <td>:</td>
                      <td>{{ $sales_order->sales_order_invoice->created_at }}</td>
                    </tr>
                    <tr>
                      <td>Due Date</td>
                      <td>:</td>
                      <td>{{ $sales_order->sales_order_invoice->due_date }}</td>
                    </tr>
                    <tr>
                      <td>Status</td>
                      <td>:</td>
                      <td>
                        {{ strtoupper($sales_order->sales_order_invoice->status) }}
                        @if($sales_order->sales_order_invoice->status == 'uncompleted')
                          <p>
                            <button id="btn-complete-invoice" class="btn btn-xs btn-success" title="Click to complete this invoice" data-id="{{ $sales_order->sales_order_invoice->id }}">
                              Complete
                            </button>
                          </p>
                        @endif
                      </td>
                    </tr>
                  </table>
                </div>
              @else
                <div class="alert alert-info">
                  <p>
                    <i class="fa fa-info-circle"></i>&nbsp;
                    There is no invoice related with this sales order, you can make it by click the button "Input Invoice".
                  </p>
                </div>
              @endif
            </div><!-- /.box-body -->
            <div class="box-footer clearfix">
              
            </div>
          </div><!-- /.box -->
        </div>
      </div>
    </div>
    <!-- ENDSection Invoice -->

    <!-- Section Invoice Payment -->
    <div id="section-invoice-payment" class="tab-pane fade">
      <div class="row">
        <div class="col-lg-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Invoice Payments <small>Related payment with the sales order invoice</small></h3>
            </div><!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table" id="table-sales-invoice-payment">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Payment Date</th>
                      <th>Payment Method</th>
                      <th>Amount</th>
                      <th>Receiver</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if(count($sales_order->sales_order_invoice))
                      @if($sales_order->sales_order_invoice->sales_invoice_payment->count())
                        <?php  $payment_row = 0; ?>
                        @foreach($sales_order->sales_order_invoice->sales_invoice_payment as $payment)
                        <tr>
                          <td>{{ $payment_row +=1 }}</td>
                          <td>{{ $payment->created_at }}</td>
                          <td>{{ $payment->payment_method_id }}</td>
                          <td>{{ number_format($payment->amount) }}</td>
                        </tr>
                        @endforeach
                      @endif
                    @endif
                  </tbody>
                </table>
              </div>
            </div><!-- /.box-body -->
            <div class="box-footer clearfix"></div>
          </div><!-- /.box -->
        </div>
      </div>
    </div>
    <!-- ENDSection Invoice Payment -->

    <!-- Section Return -->
    <div id="section-return" class="tab-pane fade">
      <div class="row">
        <div class="col-lg-12">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title"> Sales Order Return <small>Related return with this sales order</small></h3>
              <div class="pull-right">
                <a href="{{ URL::to('sales-order-return/'.$sales_order->id.'/create')}}" class="btn btn-default btn-xs">
                    <i class='fa fa-bookmark'></i>&nbsp;Create Return
                </a>
              </div>
              
            </div><!-- /.box-header -->
            <div class="box-body">
              Return will goes here
            </div><!-- /.box-body -->
            <div class="box-footer clearfix">
              
            </div>
          </div><!-- /.box -->
        </div>
      </div>
    </div>
    <!-- ENDSection Return -->
  </div>



  <!--Modal Complete invoice-->
  <div class="modal fade" id="modal-complete-invoice" tabindex="-1" role="dialog" aria-labelledby="modal-complete-invoiceLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'completeSalesInvoice', 'method'=>'post']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-complete-invoiceLabel">Complete Invoice confirmation</h4>
        </div>
        <div class="modal-body">
          The invoice's status will be changed to completed&nbsp;<b id="sales-order-name-to-delete"></b>
          <br/>
          <p class="text text-danger">
            <i class="fa fa-info-circle"></i>&nbsp;This process can not be reverted
          </p>
          <input type="hidden" id="sales_order_invoice_id" name="sales_order_invoice_id">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-success">Update</button>
        </div>
      {!! Form::close() !!}
      </div>
    </div>
  </div>
<!--ENDModal Complete invoice-->
@endsection


@section('additional_scripts')
  <script type="text/javascript">
    $('#btn-complete-invoice').on('click', function(){
      $('#sales_order_invoice_id').val($(this).attr('data-id'));
      $('#modal-complete-invoice').modal('show');
    });
  </script>
@endsection






