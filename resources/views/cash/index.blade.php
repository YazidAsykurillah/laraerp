@extends('layouts.app')

@section('page_title')
    Cash
@endsection

@section('page_header')
    <h1>
        Cash
        <small>Cash List</small>
    </h1>
@endsection

@section('breadcrumb')
    <ol class="breadcrumb">
        <li><a href="{{ URL::to('home') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{ URL::to('cash') }}"><i class="fa fa-dashboard"></i> Cash</a></li>
        <li class="active"><i></i>Index</li>
    </ol>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="box" style="box-shadow:0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);border-top:none">
                <div class="box-header with-border">
                    <h3 class="box-title">Cashs</h3>
                    <!-- <a href="{{ URL::to('cash/create') }}" class="btn btn-primary pull-right" title="Create new cash">
                        <i class="fa fa-plus"></i>&nbsp;Add New
                    </a> -->
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-striped table-hover" id="table-cash">
                        <thead>
                            <tr style="background-color:#3c8dbc;color:white">
                                <th style="width:5%;">#</th>
                                <th style="width:20%;">Name</th>
                                <th style="width:20%;">Balance</th>
                                <th style="text-align:center;width:15%;">Actions</th>
                            </tr>
                        </thead>
                        <thead id="searchid">
                            <tr>
                                <th style="width:5%;"></th>
                                <th style="width:20%;">Name</th>
                                <th style="width:20%;">Balance</th>
                                <th style="text-align:center;width:15%;"></th>
                            </tr>
                        </thead>
                        <tbody>
                          <?php $no = 1; ?>
                          @foreach($sub_chart_account as $sub_chart_accounts)
                            @if($sub_chart_accounts->parent_id != 0 AND substr_count($sub_chart_accounts->name,'KAS'))
                            <tr>
                              <td>{{ $no++ }}</td>
                              <td>{{ $sub_chart_accounts->name }}</td>
                              <td>
                                @if(\DB::table('transaction_chart_accounts')->select('amount')->where('sub_chart_account_id',$sub_chart_accounts->id)->where('type','masuk')->sum('amount') > 0)
                                  {{ number_format(\DB::table('transaction_chart_accounts')->select('amount')->where('sub_chart_account_id',$sub_chart_accounts->id)->where('type','masuk')->sum('amount')) }}
                                @else
                                  0.00
                                @endif
                              </td>
                              <td style="text-align:center">
                                <a href="{{ url('cash/'.$sub_chart_accounts->id.'') }}" class="btn btn-info btn-xs" title="Click to view the detail">
                                  <i class="fa fa-external-link-square"></i>
                                </a>&nbsp;
                                <?php
                                if(\Auth::user()->can('delete-bank-module'))
                                {

                                }
                                ?>
                              </td>
                            </tr>
                            @endif
                          @endforeach
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">

                </div><!-- /.box-footer -->
            </div>
        </div>
    </div>

    <!--Modal Delete cash-->
    <div class="modal fade" id="modal-delete-cash" tabindex="-1" role="dialog" aria-labelledby="modal-delete-cashLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
        {!! Form::open(['url'=>'deleteCash', 'method'=>'post']) !!}
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="modal-delete-cashLabel">Confirmation</h4>
          </div>
          <div class="modal-body">
            You are going to remove cash&nbsp;<b id="cash-name-to-delete"></b>
            <br/>
            <p class="text text-danger">
              <i class="fa fa-info-circle"></i>&nbsp;This process can not be reverted
            </p>
            <input type="hidden" id="cash_id" name="cash_id">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-danger">Delete</button>
          </div>
        {!! Form::close() !!}
        </div>
      </div>
    </div>
  <!--ENDModal Delete cash-->
@endsection

@section('additional_scripts')
    <script type="text/javascript">
        var tableCash = $('#table-cash').DataTable();

        // Delete button handler
        tableCash.on('click', '.btn-delete-cash', function (e) {
          var id = $(this).attr('data-id');
          var name = $(this).attr('data-text');
          $('#cash_id').val(id);
          $('#cash-name-to-delete').text(name);
          $('#modal-delete-cash').modal('show');
        });

        // Setup - add a text input to each header cell
      $('#searchid th').each(function() {
            if ($(this).index() != 0 && $(this).index() != 4) {
                $(this).html('<input class="form-control" type="text" placeholder="Search" data-id="' + $(this).index() + '" />');
            }

      });
      //Block search input and select
      $('#searchid input').keyup(function() {
        tableCash.columns($(this).data('id')).search(this.value).draw();
      });
      //ENDBlock search input and select
    </script>
@endsection
