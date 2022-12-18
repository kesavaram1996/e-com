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
                <h3>{{ __('buyers.buyers') }}</h3>
            </div>
            <div class="col-6 col-md-6 col-lg-6">
                {{ Breadcrumbs::render('buyers') }}
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
                            <h6 class="panel-title txt-dark">{{ __('buyers.buyer_manegement') }}</h6>
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
                                                <th>{{ __('buyers.id') }}</th>
                                                <th>{{ __('buyers.name') }}</th>
                                                <th>{{ __('buyers.company_name') }}</th>
                                                <th>{{ __('buyers.email') }}</th>
                                                <th>{{ __('buyers.phone') }}</th>
                                                <th>{{ __('buyers.address') }}</th>
                                                <!-- <th>{{ __('buyers.area') }}</th> -->
                                                <th>{{ __('buyers.city') }}</th>
                                                <th>{{ __('buyers.state') }}</th>
                                                <th>{{ __('buyers.actions') }}</th>
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
        ajax: "{{ route('buyers.index') }}",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'company_name', name: 'company_name'},
            {data: 'email', name: 'email'},
            {data: 'phone', name: 'phone'},
            {data: 'address', name: 'address'},
            // {data: 'area', name: 'area'},
            {data: 'city', name: 'city'},
            {data: 'state', name: 'state'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
      
  });
</script>

@endsection