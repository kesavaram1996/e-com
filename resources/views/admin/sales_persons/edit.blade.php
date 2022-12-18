
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
                {{ Breadcrumbs::render('sales_persons/edit') }}
            </div>
        </div>
    </div>
    <div class="section-body mt">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default card-view">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h6 class="panel-title txt-dark">{{ __('sales_persons.edit_sales_person') }}</h6>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                            <div class="form-wrap">
                                @foreach($data as $datas)
                                <form action="{{route('sales_persons.update',$datas->id)}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" value="{{$datas->user_id}}" name="user_id">
                                    <!-- name -->
                                    <div class="form-group">
                                        <label class="control-label mb-10 text-left">{{ __('sales_persons.name') }} <span class="star">*</span></label>
                                        <input type="text" name="name" class="form-control" value="{{ old('name',$datas->name) }}">
                                    </div>
                                    <!-- phone -->
                                    <div class="form-group">
                                        <label class="control-label mb-10 text-left">{{ __('sales_persons.phone') }} <span class="star">*</span></label>
                                        <input type="number" name="phone" class="form-control" value="{{ old('phone',$datas->phone) }}">
                                    </div>
                                    <!-- email -->
                                    <div class="form-group">
                                        <label class="control-label mb-10 text-left">{{ __('sales_persons.email') }} (Optional)</label>
                                        <input type="email" name="email" class="form-control" value="{{ old('email',$datas->email) }}">
                                    </div>
                                    <!-- state_id -->
                                    <div class="form-group">
                                        <label class="control-label mb-10 text-left">{{ __('sales_persons.select_state') }}<span class="star">*</span></label>
                                        <select name="state_id" id="state_id" class="form-control">
                                            @foreach($states as $state)
                                                <option value="{{$state->id}}" {{ $state->id==$datas->state_id  ? 'selected' : '' }}>{{$state->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <!-- city_id -->
                                    <div class="form-group">
                                        <label class="control-label mb-10 text-left">{{ __('sales_persons.select_city') }}<span class="star">*</span></label>
                                        <select name="city_id" id="city_id" class="form-control">
                                            @foreach($cities as $city)
                                                <option value="{{$city->id}}" {{ $city->id==$datas->city_id  ? 'selected' : '' }}>{{$city->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <!-- area_id -->
                                    <!-- <div class="form-group">
                                        <label class="control-label mb-10 text-left">{{ __('sales_persons.select_area') }}<span class="star">*</span></label>
                                        <select name="area_id" id="area_id" class="form-control">
                                            @foreach($areas as $area)
                                                <option value="{{$area->id}}" {{ $area->id==$datas->area_id  ? 'selected' : '' }}>{{$area->name}}</option>
                                            @endforeach
                                        </select>
                                    </div> -->
                                    <!-- address -->
                                    <div class="form-group">
                                        <label class="control-label mb-10 text-left">{{ __('sales_persons.address') }} <span class="star">*</span></label>
                                        <input type="text" name="address" class="form-control" value="{{ old('address',$datas->address) }}">
                                    </div>
                                    <!-- pincode -->
                                    <div class="form-group">
                                        <label class="control-label mb-10 text-left">{{ __('sales_persons.pincode') }} <span class="star">*</span></label>
                                        <input type="number" name="pincode" class="form-control" value="{{ old('pincode',$datas->pincode) }}">
                                    </div>
                                    <!-- Status -->
                                    <div class="form-group">
                                        <label class="control-label mb-10">{{ __('sales_persons.status') }}</label>
                                        <div class="radio-list">
                                            <div class="radio-inline pl-0">
                                                <span class="radio radio-info">
                                                    <input type="radio" name="status" id="active" value="1" {{ $datas->getuser->status==1 ? 'checked' : ''  }}>
                                                    <label for="active">{{ __('sales_persons.active') }}</label>
                                                </span>
                                            </div>
                                            <div class="radio-inline">
                                                <span class="radio radio-info">
                                                    <input type="radio" name="status" id="in_active" value="0" {{ $datas->getuser->status==0 ? 'checked' : ''  }}>
                                                    <label for="in_active">{{ __('sales_persons.in_active') }}</label>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-30 text-center">
                                        <button type="submit" class="btn btn-primary">{{ __('sales_persons.update') }}</button>
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