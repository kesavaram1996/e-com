
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
                <h3>{{ __('sales_persons.sales_persons') }}</h3>
            </div>
            <div class="col-6 col-md-6 col-lg-6">
                {{ Breadcrumbs::render('sales_persons/add') }}
            </div>
        </div>
    </div>
    <div class="section-body mt">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default card-view">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h6 class="panel-title txt-dark">{{ __('sales_persons.add_sales_person') }}</h6>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                            <div class="form-wrap">
                                <form action="{{route('sales_persons.store')}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <label class="control-label mb-10 text-left">{{ __('sales_persons.name') }} <span class="star">*</span></label>
                                        <input type="text" name="name" class="form-control" value="{{ old('name') }}">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label mb-10 text-left">{{ __('sales_persons.phone') }} <span class="star">*</span></label>
                                        <input type="number" name="phone" class="form-control" value="{{ old('phone') }}">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label mb-10 text-left">{{ __('sales_persons.email') }} (Optional)</label>
                                        <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label mb-10 text-left">{{ __('sales_persons.password') }} <span class="star">*</span></label>
                                        <input type="password" name="password" class="form-control" value="{{ old('password') }}">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label mb-10 text-left">{{ __('sales_persons.select_state') }}<span class="star">*</span></label>
                                        <select name="state_id" id="state_id" class="form-control">
                                            <option value="">{{ __('sales_persons.select_state') }}</option>
                                            @foreach($states as $state)
                                                <option value="{{$state->id}}">{{$state->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label mb-10 text-left">{{ __('sales_persons.select_city') }}<span class="star">*</span></label>
                                        <select name="city_id" id="city_id" class="form-control">
                                            <option value="">{{ __('sales_persons.select_state') }}</option>
                                        </select>
                                    </div>
                                    <!-- <div class="form-group">
                                        <label class="control-label mb-10 text-left">{{ __('sales_persons.select_area') }}<span class="star">*</span></label>
                                        <select name="area_id" id="area_id" class="form-control">
                                            <option value="">{{ __('sales_persons.select_city') }}</option>
                                        </select>
                                    </div> -->
                                    <div class="form-group">
                                        <label class="control-label mb-10 text-left">{{ __('sales_persons.address') }} <span class="star">*</span></label>
                                        <input type="text" name="address" class="form-control" value="{{ old('address') }}">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label mb-10 text-left">{{ __('sales_persons.pincode') }} <span class="star">*</span></label>
                                        <input type="number" name="pincode" class="form-control" value="{{ old('pincode') }}">
                                    </div>
                                    <div class="form-group mb-30 text-center">
                                        <button type="submit" class="btn btn-primary">{{ __('sales_persons.submit') }}</button>
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