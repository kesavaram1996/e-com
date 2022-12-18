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
                <h3>{{ __('sales_persons.visit_logs') }}</h3>
            </div>
            <div class="col-6 col-md-6 col-lg-6">
                {{ Breadcrumbs::render('sales_persons/daily_logs/visit_logs') }}
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
                            <h6 class="panel-title txt-dark">{{ __('sales_persons.visit_logs') }}</h6>
                        </div>
                        <div class="pull-right">
                            <h6 class="panel-title txt-dark">{{ date('d-m-Y', strtotime($sales_details[0]->created_at)) }}</h6>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body row pa-0">
                            <div class="row mb-30">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 mt-25">
                                    <div class="ml-20">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
                                                <label><strong>Sales Person: </strong></label>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-left">
                                                <span>{{$sales_details[0]->getsales->name}}</span><br>
                                                <span>{{$sales_details[0]->getsales->phone}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 mt-25">
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 mt-25">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-right">
                                            <label><strong>Checkin Time: </strong></label>
                                            <label><strong>Checkout Time: </strong></label>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 text-left">
                                            <span>{{ date('H:i:s', strtotime($sales_details[0]->checkin_time)) }}</span><br>
                                            @if($sales_details[0]->checkout_time != null)
                                            <span>{{ date('H:i:s', strtotime($sales_details[0]->checkout_time)) }}</span>
                                            @else
                                            <span>-</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-wrap">
                                <div class="table-responsive">
                                    <table class="table table-bordered data-table table-hover ml-20" style="width:97%;">
                                        <thead>
                                            <tr>
                                                <th>{{ __('sales_persons.id') }}</th>
                                                <th>{{ __('sales_persons.buyer_name') }}</th>
                                                <th>{{ __('sales_persons.phone') }}</th>
                                                <th>{{ __('sales_persons.company_name') }}</th>
                                                <th>{{ __('sales_persons.address') }}</th>
                                                <th>{{ __('sales_persons.visited_at') }}</th>
                                                <th>{{ __('sales_persons.status') }}</th>
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
          url: "{{ route('daily_logs.show',$sales_details[0]->id) }}",
        },
        columns: [
            {data: 'id', name: 'id'},
            {data: 'getuser.name', name: 'buyer_name'},
            {data: 'getuser.phone', name: 'phone'},
            {data: 'getbuyer.company_name', name: 'company_name'},
            {data: 'getbuyer.address', name: 'address'},
            {data: 'visited_at', name: 'visited_at'},
            {data: 'status', name: 'status'},
        ]
    });
  });

  
</script>

@endsection