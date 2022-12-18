@extends('admin.layouts.main')

@section('main-content')
@if ($message = Session::get('success'))
<div class="alert alert-success">
  <p>{{ $message }}</p>
</div>
@endif


<section class="section">
    <div class="section-header mt">
        <div class="row">
            <div class="col-6 col-md-6 col-lg-6">
                <h3>{{ __('sales_persons_report.sales_persons_report') }}</h3>
            </div>
            <div class="col-6 col-md-6 col-lg-6">
                {{ Breadcrumbs::render('sales_persons_report') }}
            </div>
        </div>
    </div>
    <div class="section-body">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt">
                <div class="panel panel-default card-view panel-refresh">
                    <div class="refresh-container">
                        <div class="la-anim-1"></div>
                    </div>
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h6 class="panel-title txt-dark">{{ __('sales_persons_report.sales_persons_report') }}</h6>
                        </div>
                        
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body row pa-0">
                        <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 mt-25">
                                    <div class="ml-20">
                                        <label><strong>Filter by Date</strong></label>
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                <input id="start_date" name="start_date" type="date" class="form-control">
                                                <label id="start_date_label">Start Date</label>
                                                <span style="color:red;" id="start_date_error"></span>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                                <input id="end_date" name="end_date" type="date" class="form-control">
                                                <label id="end_date_label">End Date</label>
                                                <span style="color:red;" id="end_date_error"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 mt-25">
                                    <div class="ml-50">
                                        <label><strong>Filter by Sales</strong></label>
                                        <select id='sales_filter' class="form-control" style="width: 200px">
                                            <option value="">All Sales</option>
                                            @foreach($sales as $sale)
                                                <option value="{{$sale->user_id}}">{{$sale->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 mt-25">
                                    <div class="pull-right mr-15">
                                        <label><strong>Filter by Status</strong></label>
                                        <select id='status_filter' class="form-control" style="width: 200px">
                                            <option value="">All Orders</option>
                                            <option value="received">Received</option>
                                            <option value="processed">Processed</option>
                                            <option value="shipped">Shipped</option>
                                            <option value="delivered">Delivered</option>
                                            <option value="cancelled">Cancelled</option>
                                            <option value="returned">Returned</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="table-wrap">
                                <div class="table-responsive">
                                    <table class="table table-bordered data-table table-hover ml-20" style="width:97%;">
                                        <thead>
                                            <tr>
                                                <th>{{ __('sales_persons_report.id') }}</th>
                                                <th>{{ __('sales_persons_report.name') }}</th>
                                                <th>{{ __('sales_persons_report.mobile') }}</th>
                                                <th>{{ __('sales_persons_report.final_total') }}</th>
                                                <th>{{ __('sales_persons_report.payment_method') }}</th>
                                                <th>{{ __('sales_persons_report.active_status') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>	
                        </div>	
                    </div>
                </div>
        </div>
    </div>
</section>
<script type="text/javascript">
  $(function () {
      
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
          url: "{{ route('sales_persons_report') }}",
          data: function (d) {
                d.status_filter = $('#status_filter').val(), 
                d.sales_filter = $('#sales_filter').val(),
                d.start_date = $('#start_date').val(),
                d.end_date = $('#end_date').val(),
                d.search = $('input[type="search"]').val()
            }
        },
        columns: [
            {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'getaddress.phone', name: 'mobile'},
            {data: 'final_total', name: 'final_total'},
            {data: 'payment_method', name: 'payment_method'},
            {data: 'active_status', name: 'active_status'},
        ]
    });
      

    // Status Filter
    $('#status_filter').change(function(){
        table.draw();
    });

    // Sales Filter
    $('#sales_filter').change(function(){
        table.draw();
    });

    // End Date Filter with Validation
    $('#end_date').change(function(){
        var start_date = $('#start_date').val();
        
        if(start_date.length ==0){
            console.log(start_date.length);
            $('#start_date_label').hide();
            $('#start_date_error').html('Select Start Date');
        }else{
            $('#start_date_label').show();
            $('#start_date_error').html('');
        table.draw();
        }

        if(end_date.length !=0){
            $('#end_date_label').show();
            $('#end_date_error').html('');
        }
          
    });

    // Start Date Filter with Validation
    $('#start_date').change(function(){
        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();

        if(start_date.length !=0){
            $('#start_date_label').show();
            $('#start_date_error').html('');
            table.draw();
        }

        if(end_date.length ==0){
            $('#end_date_label').hide();
            $('#end_date_error').html('Select End Date');
        }

    });
     
  });
</script>

@endsection