@extends('admin.layouts.main')

@section('main-content')
<section class="section">
    <div class="section-header mt">
        <div class="row">
            <div class="col-6 col-md-6 col-lg-6">
                <h3>{{ __('sub_categories.show_sub_category') }}</h3>
            </div>
            <div class="col-6 col-md-6 col-lg-6">
                {{ Breadcrumbs::render('sub_categories/show') }}
            </div>
        </div>
    </div>
    <div class="section-body mt">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default card-view">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h6 class="panel-title txt-dark">{{ __('sub_categories.show_sub_category') }}</h6>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <div class="form-wrap">
                                        @foreach($data as $datas)
                                        <form class="form-horizontal">
                                            <div class="form-group">
                                                <div class="">
                                                    <label for="exampleInputuname_4" class="col-sm-3 control-label">{{ __('sub_categories.category') }}:</label>
                                                </div>
                                                <div class="col-sm-6 mt-5">
                                                    <div class="input-group">
                                                        {{$datas->getcategory->name}}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="">
                                                    <label for="exampleInputuname_4" class="col-sm-3 control-label">{{ __('sub_categories.sub_category_name') }}:</label>
                                                </div>
                                                <div class="col-sm-6 mt-5">
                                                    <div class="input-group">
                                                        {{$datas->name}}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="">  
                                                    <label for="exampleInputEmail_4" class="col-sm-3 control-label">{{ __('sub_categories.sub_category_sub_title') }}:</label>
                                                </div>
                                                <div class="col-sm-6 mt-5">
                                                    <div class="input-group">
                                                        {{$datas->subtitle}}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="">  
                                                    <label for="exampleInputEmail_4" class="col-sm-3 control-label">{{ __('sub_categories.sub_category_image') }}:</label>
                                                </div>
                                                <div class="col-sm-6 mt-5">
                                                    <div class="input-group">
                                                        <img src="{{ asset('images/'.$datas->image) }}" alt="" width="200px">
                                                    </div>
                                                </div>
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
        </div>
    </div>
</section>
@endsection