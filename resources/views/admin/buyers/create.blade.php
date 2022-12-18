
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
                <h3>{{ __('buyers.buyers') }}</h3>
            </div>
            <div class="col-6 col-md-6 col-lg-6">
                {{ Breadcrumbs::render('buyers/add') }}
            </div>
        </div>
    </div>
    <div class="section-body mt">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default card-view">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h6 class="panel-title txt-dark">{{ __('buyers.add_buyer') }}</h6>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                            <div class="form-wrap">
                                <form action="{{route('buyers.store')}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label class="control-label mb-10 text-left">{{ __('buyers.name') }} <span class="star">*</span></label>
                                        <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label mb-10 text-left">{{ __('buyers.company_name') }} <span class="star">*</span></label>
                                        <input type="text" name="company_name" class="form-control" value="{{ old('company_name') }}">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label mb-10 text-left">{{ __('buyers.phone') }} <span class="star">*</span></label>
                                        <input type="number" name="phone" class="form-control" value="{{ old('phone') }}">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label mb-10 text-left">{{ __('buyers.email') }} (Optional)</label>
                                        <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label mb-10 text-left">{{ __('buyers.password') }} <span class="star">*</span></label>
                                        <input type="password" name="password" class="form-control" value="{{ old('password') }}">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label mb-10 text-left">{{ __('buyers.gst_no') }} (Optional)</label>
                                        <input type="text" name="gst_no" class="form-control" value="{{ old('gst_no') }}">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label mb-10 text-left">{{ __('buyers.select_state') }}<span class="star">*</span></label>
                                        <select name="state_id" id="state_id" class="form-control">
                                            <option value="">{{ __('buyers.select_state') }}</option>
                                            @foreach($states as $state)
                                                <option value="{{$state->id}}">{{$state->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label mb-10 text-left">{{ __('buyers.select_city') }}<span class="star">*</span></label>
                                        <select name="city_id" id="city_id" class="form-control">
                                            <option value="">{{ __('buyers.select_state') }}</option>
                                        </select>
                                    </div>
                                    <!-- <div class="form-group">
                                        <label class="control-label mb-10 text-left">{{ __('buyers.select_area') }}<span class="star">*</span></label>
                                        <select name="area_id" id="area_id" class="form-control">
                                            <option value="">{{ __('buyers.select_city') }}</option>
                                        </select>
                                    </div> -->
                                    <div class="form-group">
                                        <label class="control-label mb-10 text-left">{{ __('buyers.address') }} <span class="star">*</span></label>
                                        <input type="text" name="address" class="form-control" value="{{ old('address') }}">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label mb-10 text-left">{{ __('buyers.pincode') }} <span class="star">*</span></label>
                                        <input type="number" name="pincode" class="form-control" value="{{ old('pincode') }}">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label mb-10 text-left">{{ __('buyers.slab') }}<span class="star">*</span></label>
                                        <select name="slab_id" id="slab_id" class="form-control">
                                            <option value="">{{ __('buyers.select_slab') }}</option>
                                            @foreach($slab as $slabs)
                                                <option value="{{$slabs->id}}">{{$slabs->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label mb-10">{{ __('buyers.invoice_type') }}</label>
                                        <div class="radio-list">
                                            <div class="radio-inline pl-0">
                                                <span class="radio radio-info">
                                                    <input type="radio" name="invoice_type" id="gst" value="1">
                                                    <label for="gst">{{ __('buyers.gst') }}</label>
                                                </span>
                                            </div>
                                            <div class="radio-inline">
                                                <span class="radio radio-info">
                                                    <input type="radio" name="invoice_type" id="non_gst" value="0">
                                                    <label for="non_gst">{{ __('buyers.non_gst') }}</label>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-30 text-center">
                                        <button type="submit" class="btn btn-primary">{{ __('buyers.submit') }}</button>
                                    </div>
                                </form>
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
    // Get City List
    $(document).on("change","#state_id",function() {
        var state_id = $(this).val();
        if(state_id){
            $.ajax({
            type:"get",
            url:"/get_city_list/"+state_id,
            success:function(res)
            {     
                if(res)
                {
                    $("#city_id").empty();
                    $("#city_id").append('<option>Select City</option>');
                    $.each(res,function(key,value){
                        $("#city_id").append('<option value="'+value.id+'">'+value.name+'</option>');
                    });
                }
            }

            });
        }
    });

    // Get Area List
    $(document).on("change","#city_id",function() {
        var city_id = $(this).val();
        if(city_id){
            $.ajax({
            type:"get",
            url:"/get_area_list/"+city_id,
            success:function(res)
            {     
                if(res)
                {
                    $("#area_id").empty();
                    $("#area_id").append('<option>Select Area</option>');
                    $.each(res,function(key,value){
                        $("#area_id").append('<option value="'+value.id+'">'+value.name+'</option>');
                    });
                }
            }
            });
        }
    });

});
</script>
@endsection