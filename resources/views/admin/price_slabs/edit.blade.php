
@extends('admin.layouts.main')

@section('main-content')
@if (count($errors) > 0)
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
@endif


<section class="section">
    <div class="section-header mt">
        <div class="row">
            <div class="col-6 col-md-6 col-lg-6">
                <h3>{{ __('price_slabs.price_slabs') }}</h3>
            </div>
            <div class="col-6 col-md-6 col-lg-6">
                {{ Breadcrumbs::render('price_slabs/edit') }}
            </div>
        </div>
    </div>
    <div class="section-body mt">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default card-view">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h6 class="panel-title txt-dark">{{ __('price_slabs.edit_price_slab') }}</h6>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                            <div class="form-wrap">
                                @foreach($data as $datas)
                                <form action="{{route('price_slabs.update',$datas->id)}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label class="control-label mb-10 text-left">{{ __('price_slabs.title') }} <span class="star">*</span></label>
                                        <input type="text" name="title" class="form-control" value="{{ old('title',$datas->title) }}">
                                    </div>
                                    <!-- Status -->
                                    <div class="form-group">
                                        <label class="control-label mb-10">{{ __('price_slabs.status') }}</label>
                                        <div class="radio-list">
                                            <div class="radio-inline pl-0">
                                                <span class="radio radio-info">
                                                    <input type="radio" name="status" id="active" value="1" {{ $datas->status==1 ? 'checked' : ''  }}>
                                                    <label for="active">{{ __('price_slabs.active') }}</label>
                                                </span>
                                            </div>
                                            <div class="radio-inline">
                                                <span class="radio radio-info">
                                                    <input type="radio" name="status" id="in_active" value="0" {{ $datas->status==0 ? 'checked' : ''  }}>
                                                    <label for="in_active">{{ __('price_slabs.in_active') }}</label>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-30 text-center">
                                        <button type="submit" class="btn btn-primary">{{ __('price_slabs.update') }}</button>
                                    </div>
                                </form>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection