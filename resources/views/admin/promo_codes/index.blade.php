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
                <h3>{{ __('promo_codes.promo_codes') }}</h3>
            </div>
            <div class="col-6 col-md-6 col-lg-6">
                {{ Breadcrumbs::render('promo_codes') }}
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
                            <h6 class="panel-title txt-dark">{{ __('promo_codes.promo_code_manegement') }}</h6>
                        </div>
                        <div class="pull-right">
                            <a class="btn btn-success" href="{{ route('promo_codes.create') }}"> {{ __('promo_codes.add_promo_code') }}</a>
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
                                                <th>{{ __('promo_codes.id') }}</th>
                                                <th>{{ __('promo_codes.promo_code') }}</th>
                                                <th>{{ __('promo_codes.message') }}</th>
                                                <th>{{ __('promo_codes.start_date') }}</th>
                                                <th>{{ __('promo_codes.end_date') }}</th>
                                                <th>{{ __('promo_codes.no_of_users') }}</th>
                                                <th>{{ __('promo_codes.minimum_order_amount') }}</th> 
                                                <th>{{ __('promo_codes.discount') }}</th>
                                                <th>{{ __('promo_codes.discount_type') }}</th>
                                                <th>{{ __('promo_codes.status') }}</th>
                                                <th>{{ __('promo_codes.actions') }}</th>
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
        ajax: "{{ route('promo_codes.index') }}",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'promo_code', name: 'promo_code'},
            {data: 'message', name: 'message'},
            {data: 'start_date', name: 'start_date'},
            {data: 'end_date', name: 'end_date'},
            {data: 'no_of_users', name: 'no_of_users'},
            {data: 'minimum_order_amount', name: 'minimum_order_amount'},
            {data: 'discount', name: 'discount'},
            {data: 'discount_type', name: 'discount_type'},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
      
  });
</script>

@endsection