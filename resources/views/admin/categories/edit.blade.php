
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
                <h3>{{ __('categories.categories') }}</h3>
            </div>
            <div class="col-6 col-md-6 col-lg-6">
                {{ Breadcrumbs::render('categories/edit') }}
            </div>
        </div>
    </div>
    <div class="section-body mt">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default card-view">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h6 class="panel-title txt-dark">{{ __('categories.edit_category') }}</h6>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                            <div class="form-wrap">
                                @foreach($data as $datas)
                                <form action="{{route('categories.update',$datas->id)}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label class="control-label mb-10 text-left">{{ __('categories.category_name') }} <span class="star">*</span></label>
                                        <input type="text" name="name" class="form-control" value="{{ old('name',$datas->name) }}">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label mb-10 text-left">{{ __('categories.category_sub_title') }} <span class="star">*</span></label>
                                        <input type="text" name="sub_title" class="form-control" value="{{ old('name',$datas->subtitle) }}">
                                    </div>
                                    <div class="form-group mb-30">
                                        <label class="control-label mb-10 text-left">{{ __('categories.category_image') }} <span class="star">*</span></label>
                                        <input type="file" name="image" class="form-control" value="">
                                        <p>Image   *Please choose square image of larger than 350px*350px & smaller than 550px*550px.</p>
                                        <img src="{{ asset('images/'.$datas->image) }}" alt="{{ __('categories.category_image') }}" width="200px">
                                    </div>
                                    <div class="form-group mb-30 text-center">
                                        <button type="submit" class="btn btn-primary">{{ __('categories.update') }}</button>
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