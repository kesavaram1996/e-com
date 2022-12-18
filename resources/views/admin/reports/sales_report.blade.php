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
                <h3>{{ __('sales_report.sales_report') }}</h3>
            </div>
            <div class="col-6 col-md-6 col-lg-6">
                {{ Breadcrumbs::render('sales_report') }}
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
                            <h6 class="panel-title txt-dark">{{ __('sales_report.sales_report') }}</h6>
                        </div>
                        
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body row pa-0">
                            <div class="table-wrap">
                                <div class="table-responsive">
                                    <table class="table table-bordered data-table table-hover ml-20" style="width:97%;">
                                        <thead>
                                            <tr>
                                                <th>{{ __('sales_report.id') }}</th>
                                                <th>{{ __('sales_report.mobile') }}</th>
                                                <th>{{ __('sales_report.address') }}</th>
                                                <th>{{ __('sales_report.order_date') }}</th>
                                                <th>{{ __('sales_report.final_total') }}</th>
                                                <th>{{ __('sales_report.payment_method') }}</th>
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
        ajax: "{{ route('sales_report') }}",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'getaddress.phone', name: 'mobile'},
            {data: 'address', name: 'address'},
            {data: 'created_at', name: 'order_date'},
            {data: 'final_total', name: 'final_total'},
            {data: 'payment_method', name: 'payment_method'},
        ]
    });
      
  });
</script>

@endsection