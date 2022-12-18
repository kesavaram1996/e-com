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
                {{ Breadcrumbs::render('admin_orders') }}
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
                                            <label><strong>Filter by Admin</strong></label>
                                            <select id='admin_filter' class="form-control" style="width: 200px">
                                                <option value="">All Admin</option>
                                                @foreach($admins as $admin)
                                                    <option value="{{$admin->id}}">{{$admin->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 mt-25">
                                        <div class="pull-left">
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
                                        <div class="pull-right mr-15">
                                            <label><strong>Filter by Order ID</strong></label>
                                            <input type="text" name="serach" id="serach" class="form-control" placeholder="Enter Order ID" />
                                        </div>
                                    </div>
                                </div>
                                <div class="table-wrap mt-50">
                                    <div class="table-responsive">
                                        <table class="table table-bordered data-table table-hover ml-20" style="width:97%;">
                                            <thead>
                                                <tr>
                                                    <th width="5%" class="sorting" data-sorting_type="asc" data-column_name="id" style="cursor: pointer">{{ __('orders.id') }}<span id="id_icon"></span></th>
                                                    <th>{{ __('orders.buyer') }}</th>
                                                    <th>{{ __('orders.mobile') }}</th>
                                                    <th>{{ __('orders.order_by') }}</th>
                                                    <th>{{ __('orders.total')  }} (₹)</th>
                                                    <!-- <th>{{ __('orders.delivery_charge') }}</th> -->
                                                    <th>{{ __('orders.final_total') }} (₹)</th>
                                                    <th>{{ __('orders.payment_method') }} (₹)</th>
                                                    <th>{{ __('orders.status') }}</th>
                                                    <th>{{ __('orders.actions') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @include('superAdmin.orders.pagination_data')
                                            </tbody>
                                        </table>
                                        <input type="hidden" name="hidden_page" id="hidden_page" value="1" />
                                        <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="id" />
                                        <input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="asc" />
                                    </div>
                                </div>	
                            </div>	
                        </div>
                    </div>
            </div>
        </div>
        
    </div>
</section>
<script>
    $(document).ready(function(){

        function clear_icon()
        {
            $('#id_icon').html('');
            $('#post_title_icon').html('');
        }

        // Send Ajax Request
        function fetch_data(page, sort_type, sort_by, query,status_filter,admin_filter,start_date,end_date)
        {
            $.ajax({
            url:"/order_fetch_data?page="+page+"&sortby="+sort_by+"&sorttype="+sort_type+"&query="+query+"&status_filter="+status_filter+"&admin_filter="+admin_filter+"&start_date="+start_date+"&end_date="+end_date,
            success:function(data)
            {
                $('tbody').html('');
                $('tbody').html(data);
            }
            })
        }

        // Order ID Search
        $(document).on('keyup', '#serach', function(){
            var query           = $('#serach').val();
            var status_filter   = $('#status_filter').val();
            var admin_filter    = $('#admin_filter').val();
            var start_date      = $('#start_date').val();
            var end_date        = $('#end_date').val();
            var column_name     = $('#hidden_column_name').val();
            var sort_type       = $('#hidden_sort_type').val();
            var page            = $('#hidden_page').val();
            fetch_data(page, sort_type, column_name, query,status_filter,admin_filter,start_date,end_date);
        });

        // status_filter
        $(document).on('change', '#status_filter', function(){
            var query           = $('#serach').val();
            var status_filter   = $('#status_filter').val();
            var admin_filter    = $('#admin_filter').val();
            var start_date      = $('#start_date').val();
            var end_date        = $('#end_date').val();
            var column_name     = $('#hidden_column_name').val();
            var sort_type       = $('#hidden_sort_type').val();
            var page            = $('#hidden_page').val();
            fetch_data(page, sort_type, column_name, query,status_filter,admin_filter,start_date,end_date);
        });

        // admin_filter
        $(document).on('change', '#admin_filter', function(){
            var query           = $('#serach').val();
            var status_filter   = $('#status_filter').val();
            var admin_filter    = $('#admin_filter').val();
            var start_date      = $('#start_date').val();
            var end_date        = $('#end_date').val();
            var column_name     = $('#hidden_column_name').val();
            var sort_type       = $('#hidden_sort_type').val();
            var page            = $('#hidden_page').val();
            fetch_data(page, sort_type, column_name, query,status_filter,admin_filter,start_date,end_date);
        });

        // start_date_filter
        $(document).on('change', '#start_date', function(){
            var query           = $('#serach').val();
            var status_filter   = $('#status_filter').val();
            var admin_filter    = $('#admin_filter').val();
            var start_date      = $('#start_date').val();
            var end_date        = $('#end_date').val();
            var column_name     = $('#hidden_column_name').val();
            var sort_type       = $('#hidden_sort_type').val();
            var page            = $('#hidden_page').val();
            fetch_data(page, sort_type, column_name, query,status_filter,admin_filter,start_date,end_date);
        });

        // end_date_filter
        $(document).on('change', '#end_date', function(){
            var query           = $('#serach').val();
            var status_filter   = $('#status_filter').val();
            var admin_filter    = $('#admin_filter').val();
            var start_date      = $('#start_date').val();
            var end_date        = $('#end_date').val();
            var column_name     = $('#hidden_column_name').val();
            var sort_type       = $('#hidden_sort_type').val();
            var page            = $('#hidden_page').val();
            fetch_data(page, sort_type, column_name, query,status_filter,admin_filter,start_date,end_date);
        });


        // $(document).on('click', '.sorting', function(){
        //     var column_name = $(this).data('column_name');
        //     var order_type = $(this).data('sorting_type');
        //     var reverse_order = '';
        //     if(order_type == 'asc')
        //     {
        //         $(this).data('sorting_type', 'desc');
        //         reverse_order = 'desc';
        //         clear_icon();
        //         $('#'+column_name+'_icon').html('<span class="glyphicon glyphicon-triangle-bottom"></span>');
        //     }
        //     if(order_type == 'desc')
        //     {
        //         $(this).data('sorting_type', 'asc');
        //         reverse_order = 'asc';
        //         clear_icon
        //         $('#'+column_name+'_icon').html('<span class="glyphicon glyphicon-triangle-top"></span>');
        //     }
        //     $('#hidden_column_name').val(column_name);
        //     $('#hidden_sort_type').val(reverse_order);
        //     var page = $('#hidden_page').val();
        //     var query = $('#serach').val();
        //     fetch_data(page, reverse_order, column_name, query);
        // });

        // pagination
        $(document).on('click', '.pagination a', function(event){
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            $('#hidden_page').val(page);
            var column_name = $('#hidden_column_name').val();
            var sort_type = $('#hidden_sort_type').val();

            var query           = $('#serach').val();
            var status_filter   = $('#status_filter').val();
            var admin_filter    = $('#admin_filter').val();
            var start_date      = $('#start_date').val();
            var end_date        = $('#end_date').val();

            $('li').removeClass('active');
                    $(this).parent().addClass('active');
            fetch_data(page, sort_type, column_name, query,status_filter,admin_filter,start_date,end_date);
        });

        // End Date Filter with Validation
        $('#end_date').change(function(){
            var start_date = $('#start_date').val();
            
            if(start_date.length ==0){
                $('#start_date_label').hide();
                $('#start_date_error').html('Select Start Date');
            }else{
                $('#start_date_label').show();
                $('#start_date_error').html('');
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
            }

            if(end_date.length ==0){
                $('#end_date_label').hide();
                $('#end_date_error').html('Select End Date');
            }

        });

});
</script>

@endsection