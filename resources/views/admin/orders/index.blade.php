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
                <h3>{{ __('orders.orders') }}</h3>
            </div>
            <div class="col-6 col-md-6 col-lg-6">
                {{ Breadcrumbs::render('orders') }}
            </div>
        </div>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt">
                    <div class="panel panel-default card-view panel-refresh">
                        <div class="refresh-container">
                            <div class="la-anim-1"></div>
                        </div>
                        <div class="panel-heading">
                            <div class="pull-left">
                                <h6 class="panel-title txt-dark">{{ __('orders.orders_manegement') }}</h6>
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
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-wrap">
                                    <div class="table-responsive">
                                        <table class="table table-bordered data-table table-hover ml-20" style="width:97%;">
                                            <thead>
                                                <tr>
                                                    <th>{{ __('orders.id') }}</th>
                                                    <th>{{ __('orders.buyer') }}</th>
                                                    <th>{{ __('orders.mobile') }}</th>
                                                    <th>{{ __('orders.order_by') }}</th>
                                                    <th>{{ __('orders.total')  }} (₹)</th>
                                                    <th>{{ __('orders.delivery_charge') }}</th>
                                                    <th>{{ __('orders.final_total') }} (₹)</th>
                                                    <th>{{ __('orders.payment_method') }} (₹)</th>
                                                    <th>{{ __('orders.status') }}</th>
                                                    <th>{{ __('orders.actions') }}</th>
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
        
    </div>
</section>
<script type="text/javascript">
  $(function () {
      
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
          url: "{{ route('orders.index') }}",
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
            {data: 'getuser.name', name: 'user_id'},
            {data: 'getaddress.phone', name: 'phone'},
            {data: 'order_by', name: 'order_by'},
            {data: 'total', name: 'total'},
            {data: 'delivery_charge', name: 'delivery_charge'},
            {data: 'final_total', name: 'final_total'},
            {data: 'payment_method', name: 'payment_method'},
            {data: 'active_status', name: 'active_status'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
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