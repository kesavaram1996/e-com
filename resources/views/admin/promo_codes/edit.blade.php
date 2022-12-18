
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
                <h3>{{ __('promo_codes.promo_codes') }}</h3>
            </div>
            <div class="col-6 col-md-6 col-lg-6">
                {{ Breadcrumbs::render('promo_codes/edit') }}
            </div>
        </div>
    </div>
    <div class="section-body mt">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default card-view">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h6 class="panel-title txt-dark">{{ __('promo_codes.edit_promo_code') }}</h6>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                            <div class="form-wrap">
                                @foreach($data as $datas)
                                <form action="{{route('promo_codes.update',$datas->id)}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <!-- promo_code -->
                                    <div class="form-group">
                                        <label class="control-label mb-10 text-left">{{ __('promo_codes.promo_code') }} <span class="star">*</span></label>
                                        <input type="text" name="promo_code" class="form-control" value="{{ old('promo_code',$datas->promo_code) }}">
                                    </div>
                                    <!-- message -->
                                    <div class="form-group">
                                        <label class="control-label mb-10 text-left">{{ __('promo_codes.message') }} <span class="star">*</span></label>
                                        <input type="text" name="message" class="form-control" value="{{ old('message',$datas->message) }}">
                                    </div>
                                    <!-- start_date -->
                                    <div class="form-group">
                                        <label class="control-label mb-10 text-left">{{ __('promo_codes.start_date') }} <span class="star">*</span></label>
                                        <input type="date" name="start_date" class="form-control" value="{{ old('start_date',$datas->start_date->format('Y-m-d')) }}">
                                    </div>
                                    <!-- end_date -->
                                    <div class="form-group">
                                        <label class="control-label mb-10 text-left">{{ __('promo_codes.end_date') }} <span class="star">*</span></label>
                                        <input type="date" name="end_date" class="form-control" value="{{ old('end_date',$datas->end_date->format('Y-m-d')) }}">
                                    </div>
                                    <!-- no_of_users -->
                                    <div class="form-group">
                                        <label class="control-label mb-10 text-left">{{ __('promo_codes.no_of_users') }} <span class="star">*</span></label>
                                        <input type="number" name="no_of_users" class="form-control" value="{{ old('no_of_users',$datas->no_of_users) }}">
                                    </div>
                                    <!-- minimum_order_amount -->
                                    <div class="form-group">
                                        <label class="control-label mb-10 text-left">{{ __('promo_codes.minimum_order_amount') }}</label>
                                        <input type="number" name="minimum_order_amount" class="form-control" value="{{ old('minimum_order_amount',$datas->minimum_order_amount) }}">
                                    </div>
                                    <!-- discount -->
                                    <div class="form-group">
                                        <label class="control-label mb-10 text-left">{{ __('promo_codes.discount') }} <span class="star">*</span></label>
                                        <input type="number" name="discount" class="form-control" value="{{ old('discount',$datas->discount) }}">
                                    </div>
                                    <!-- discount_type -->
                                    <div class="form-group">
                                        <label class="control-label mb-10 text-left">{{ __('promo_codes.discount_type') }}<span class="star">*</span></label>
                                        <select name="discount_type" id="discount_type" class="form-control">
                                            <option value="">{{ __('promo_codes.select_discount_type') }}</option>
                                            <option value="percentage" {{ $datas->discount_type=='percentage' ? 'selected' : '' }}>{{ __('promo_codes.percentage') }}</option>
                                            <option value="amount" {{ $datas->discount_type=='amount' ? 'selected' : '' }}>{{ __('promo_codes.amount') }}</option>
                                        </select>
                                    </div>
                                    <!-- max_discount_amount -->
                                    <div class="form-group">
                                        <label class="control-label mb-10 text-left">{{ __('promo_codes.max_discount_amount') }}</label>
                                        <input type="number" name="max_discount_amount" class="form-control" value="{{ old('max_discount_amount',$datas->max_discount_amount) }}">
                                    </div>
                                    <!-- repeat_usage -->
                                    <div class="form-group">
                                        <label class="control-label mb-10 text-left">{{ __('promo_codes.repeat_usage') }}<span class="star">*</span></label>
                                        <select name="repeat_usage" id="repeat_usage" class="form-control">
                                            <option value="">{{ __('promo_codes.select_repeat_usage') }}</option>
                                            <option value="allowed" {{ $datas->repeat_usage=='allowed' ? 'selected' : '' }}>{{ __('promo_codes.allowed') }}</option>
                                            <option value="not_allowed" {{ $datas->repeat_usage=='not_allowed' ? 'selected' : '' }}>{{ __('promo_codes.not_allowed') }}</option>
                                        </select>
                                    </div>
                                    <!-- no_of_repeat_usage -->
                                    <div id="no_of_repeat_usage_div">
                                        @if(!blank($datas->no_of_repeat_usage))
                                        <div class="form-group">
                                            <label class="control-label mb-10 text-left">{{ __('promo_codes.no_of_repeat_usage') }}</label>
                                            <input type="number" name="no_of_repeat_usage" class="form-control" value="{{ old('no_of_repeat_usage',$datas->no_of_repeat_usage) }}">
                                        </div>
                                        @endif
                                    </div>
                                    <!-- status -->
                                    <div class="form-group">
                                        <label class="control-label mb-10 text-left">{{ __('promo_codes.status') }}<span class="star">*</span></label>
                                        <select name="status" id="status" class="form-control">
                                            <option value="">{{ __('promo_codes.select_status') }}</option>
                                            <option value="active" {{ $datas->status=='active' ? 'selected' : '' }}>{{ __('promo_codes.active') }}</option>
                                            <option value="deactive" {{ $datas->status=='deactive' ? 'selected' : '' }}>{{ __('promo_codes.deactive') }}</option>
                                        </select>
                                    </div>
                                    <div class="form-group mb-30 text-center">
                                        <button type="submit" class="btn btn-primary">{{ __('promo_codes.update') }}</button>
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
<script>
$(document).ready(function() {
    // no_of_repeat_usage
    $(document).on("change","#repeat_usage",function() {
        var res = $(this).val();
        if(res=='allowed'){
            $("#no_of_repeat_usage_div").append('<div class="form-group"><label class="control-label mb-10 text-left">{{ __('promo_codes.no_of_repeat_usage') }}</label><input type="number" name="no_of_repeat_usage" class="form-control" value="{{ old('no_of_repeat_usage') }}"></div>');
        }
        else{
            $("#no_of_repeat_usage_div").empty();
        }
    });
});
</script>

@endsection