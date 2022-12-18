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
                <h3>{{ __('price_slabs.price_slabs') }}</h3>
            </div>
            <div class="col-6 col-md-6 col-lg-6">
                {{ Breadcrumbs::render('price_slabs') }}
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
                            <h6 class="panel-title txt-dark">{{ __('price_slabs.price_slab_manegement') }}</h6>
                        </div>
                        <div class="pull-right">
                            <a class="btn btn-success" href="{{ route('price_slabs.create') }}"> {{ __('price_slabs.add_price_slab') }}</a>
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
                                                <th>{{ __('price_slabs.id') }}</th>
                                                <th>{{ __('price_slabs.title') }}</th>
                                                <th>{{ __('price_slabs.actions') }}</th>
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
        ajax: "{{ route('price_slabs.index') }}",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'title', name: 'title'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
      
  });
</script>

@endsection