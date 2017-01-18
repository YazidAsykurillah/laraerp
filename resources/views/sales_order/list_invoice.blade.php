@extends('layouts.app')

@section('page_title')
  Sales Order Invoices
@endsection

@section('page_header')
  <h1>
    Sales Order Invoices
    <small>List of Sales Order invoices</small>
  </h1>
@endsection

@section('breadcrumb')
  <ol class="breadcrumb">
    <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
    <li><a href="{{ URL::to('sales-order') }}"><i class="fa fa-dashboard"></i> Sales Order</a></li>
    <li class="active">Invoices</li>
  </ol>
@endsection

@section('content')
  
  <div class="row">
    <div class="col-lg-12">
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Sales Order Invoices</h3>
          
        </div><!-- /.box-header -->
        <div class="box-body table-responsive">
          <table class="table table-bordered" id="table-sales-order-invoice-invoice">
            <thead>
              <tr>
                <th style="width:5%;">#</th>
                <th style="width:10%;">Code</th>
                <th>Sales Order</th>
                <th>Bill Price</th>
                <th>Paid Price</th>
                <th>Due Date</th>
                <th>Status</th>
                <th style="width:10%;text-align:center;">Actions</th>
              </tr>
            </thead>
            <thead id="searchid">
              <tr>
                <th style="width:5%;">#</th>
                <th style="width:10%;">Code</th>
                <th>Sales Order</th>
                <th>Bill Price</th>
                <th>Paid Price</th>
                <th>Due Date</th>
                <th>Status</th>
                <th style="width:10%;text-align:center;">Actions</th>
              </tr>
            </thead>
            <tbody>
              
            </tbody>
          </table>
        </div><!-- /.box-body -->
        <div class="box-footer clearfix">
          
        </div>
      </div><!-- /.box -->
    
    </div>
  </div>

  <!--Modal Delete sales-order-invoice-->
  <div class="modal fade" id="modal-delete-sales-order-invoice" tabindex="-1" role="dialog" aria-labelledby="modal-delete-sales-order-invoiceLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      {!! Form::open(['url'=>'deleteSalesOrderInvoice', 'method'=>'post']) !!}
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="modal-delete-sales-order-invoiceLabel">Confirmation</h4>
        </div>
        <div class="modal-body">
          You are going to remove sales-order-invoice&nbsp;<b id="sales-order-invoice-name-to-delete"></b>
          <br/>
          <p class="text text-danger">
            <i class="fa fa-info-circle"></i>&nbsp;This process can not be reverted
          </p>
          <input type="hidden" id="sales_order_invoice_id" name="sales_order_invoice_id">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger">Delete</button>
        </div>
      {!! Form::close() !!}
      </div>
    </div>
  </div>
<!--ENDModal Delete sales-order-invoice-->
@endsection


@section('additional_scripts')
  <script type="text/javascript">
    var tablesalesOrderInvoice =  $('#table-sales-order-invoice-invoice').DataTable({
      processing :true,
      serverSide : true,
      ajax : '{!! route('datatables.getSalesOrderInvoices') !!}',
      columns :[
        {data: 'rownum', name: 'rownum', searchable:false},
        { data: 'code', name: 'code' },
        { data: 'sales_order_id', name: 'sales_order.code' },
        { data: 'bill_price', name: 'bill_price' },
        { data: 'paid_price', name: 'paid_price' },
        { data: 'due_date', name: 'due_date' },
        { data: 'status', name: 'status' },
        { data: 'actions', name: 'actions', orderable:false, searchable:false, className:'dt-center'},
      ],
    });

    // Delete button handler
    tablesalesOrderInvoice.on('click', '.btn-delete-sales-order-invoice', function (e) { 
      var id = $(this).attr('data-id');
      var code = $(this).attr('data-text');
      $('#sales_order_invoice_id').val(id);
      $('#sales-order-invoice-name-to-delete').text(code);
      $('#modal-delete-sales-order-invoice').modal('show');
    });

      // Setup - add a text input to each header cell
    $('#searchid th').each(function() {
          if ($(this).index() != 0 && $(this).index() != 8) {
              $(this).html('<input class="form-control" type="text" placeholder="Search" data-id="' + $(this).index() + '" />');
          }
          
    });
    //Block search input and select
    $('#searchid input').keyup(function() {
      tablesalesOrderInvoice.columns($(this).data('id')).search(this.value).draw();
    });
    //ENDBlock search input and select
    
  </script>
@endsection