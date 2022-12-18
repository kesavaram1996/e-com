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
                <h3>{{ __('sub_categories.sub_categories') }}</h3>
            </div>
            <div class="col-6 col-md-6 col-lg-6">
                {{ Breadcrumbs::render('sub_categories') }}
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
                                <h6 class="panel-title txt-dark">{{ __('sub_categories.sub_category_manegement') }}</h6>
                            </div>
                            <div class="pull-right">
                                <a class="btn btn-success" href="{{ route('sub_categories.create') }}"> {{ __('sub_categories.add_sub_category') }}</a>
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
                                                    <th>{{ __('sub_categories.id') }}</th>
                                                    <th>{{ __('sub_categories.name') }}</th>
                                                    <th>{{ __('sub_categories.sub_title') }}</th>
                                                    <th>{{ __('sub_categories.image') }}</th>
                                                    <th>{{ __('sub_categories.actions') }}</th>
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
        ajax: "{{ route('sub_categories.index') }}",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'subtitle', name: 'sub_title'},
            {data: 'image', name: 'image'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
      
  });
</script>

@endsection