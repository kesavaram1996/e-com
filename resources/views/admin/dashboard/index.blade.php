@extends('admin.layouts.main')

@section('main-content')
<section class="section">
    <div class="section-header">
        <div class="row">
            <div class="col-6 col-md-6 col-lg-6">
                <h3>{{ __('dashboard.dashboard') }}</h3>
            </div>
            <div class="col-6 col-md-6 col-lg-6">
                {{ Breadcrumbs::render('dashboard') }}
            </div>
        </div>
    </div>
    <div class="section-body">
        <div class="row">
            <!-- Orders -->
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                <div class="panel panel-default card-view pa-0">
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body pa-0">
                            <div class="sm-data-box">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                            <span class="txt-dark block counter"><span class="counter-anim">{{$orders}}</span></span>
                                            <span class="weight-500 uppercase-font block font-13">{{ __('dashboard.orders') }}</span>
                                        </div>
                                        <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                            <i class="icon-user-following data-right-rep-icon txt-light-grey"></i>
                                        </div>
                                    </div>	
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Products -->
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                <div class="panel panel-default card-view pa-0">
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body pa-0">
                            <div class="sm-data-box">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                            <span class="txt-dark block counter"><span class="counter-anim">{{$products}}</span></span>
                                            <span class="weight-500 uppercase-font block">{{ __('dashboard.products') }}</span>
                                        </div>
                                        <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                            <i class="icon-layers data-right-rep-icon txt-light-grey"></i>
                                        </div>
                                    </div>	
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Buyers -->
            <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                <div class="panel panel-default card-view pa-0">
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body pa-0">
                            <div class="sm-data-box">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-xs-6 text-center pl-0 pr-0 data-wrap-left">
                                            <span class="txt-dark block counter"><span class="counter-anim">{{$admin_users_count}}</span></span>
                                            <span class="weight-500 uppercase-font block">{{ __('dashboard.users') }}</span>
                                        </div>
                                        <div class="col-xs-6 text-center  pl-0 pr-0 data-wrap-right">
                                            <i class="icon-layers data-right-rep-icon txt-light-grey"></i>
                                        </div>
                                    </div>	
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt">
                <div class="panel panel-default card-view panel-refresh">
                    <div class="refresh-container">
                        <div class="la-anim-1"></div>
                    </div>
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h6 class="panel-title txt-dark">{{ __('dashboard.latest_orders') }}</h6>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body row pa-0">
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 mt-25">
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 mt-25">
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 mt-25">
                                    <div class="pull-right mr-15">
                                        <label><strong>Filter by Status</strong></label>
                                        <select id='status_filter' id='status_filter' class="form-control" style="width: 200px">
                                            <option value="">All Status</option>
                                            <option value="received">Received</option>
                                            <option value="processed">Processed</option>
                                            <option value="shipped">Shipped</option>
                                            <option value="delivered">Delivered</option>
                                            <option value="returned">Returned</option>
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
                                                <!-- <th>{{ __('orders.delivery_charge') }}</th> -->
                                                <th>{{ __('orders.final_total') }} (₹)</th>
                                                <th>{{ __('orders.payment_method') }}</th>
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
          url: "{{ route('orders') }}",
          data: function (d) {
                d.search = $('input[type="search"]').val(),
                d.status_filter = $('#status_filter').val()
            }
        },
        columns: [
            {data: 'id', name: 'id'},
            {data: 'getuser.name', name: 'user_id'},
            {data: 'getaddress.phone', name: 'phone'},
            {data: 'order_by', name: 'order_by'},
            {data: 'total', name: 'total'},
            // {data: 'delivery_charge', name: 'delivery_charge'},
            {data: 'total', name: 'total'},
            {data: 'payment_method', name: 'payment_method'},
            {data: 'active_status', name: 'active_status'},
            {data: 'action', name: 'action', orderable: false, searchable: true},
        ]
    });

    // status Filter
    $('#status_filter').change(function(){
        var status_filter = $('#status_filter').val();
        table.draw();
    });
      
  });
</script>
@endsection