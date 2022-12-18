
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
@if ($message = Session::get('error'))
<div class="alert alert-danger">
    <strong>Whoops!</strong> There were some problems with your input.<br><br>
    <p>{{ $message }}</p>
</div>
@endif

<section class="section">
    <div class="section-header mt">
        <div class="row">
            <div class="col-6 col-md-6 col-lg-6">
                <h3>{{ __('admin_settings.admin_settings') }}</h3>
            </div>
            <div class="col-6 col-md-6 col-lg-6">
                {{ Breadcrumbs::render('admin_settings') }}
            </div>
        </div>
    </div>
    <div class="section-body mt">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default card-view">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h6 class="panel-title txt-dark">{{ __('admin_settings.update_settings') }}</h6>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                            <div class="form-wrap">
                                <form action="{{route('admin_settings.store')}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <!-- delivery_charge -->
                                    <div class="row mb-30 ml-20">
                                        <div class="form-group">
                                            <label class="control-label mb-10">{{ __('admin_settings.delivery_charge') }}</label>
                                            <div class="radio-list">
                                                <div class="radio-inline pl-0">
                                                    <span class="radio radio-info">
                                                        <input type="radio" class="delivery_charge" name="delivery_charge" id="enable" value="1" {{$delivery_data[0]->status==1 ? 'checked' : ''}}>
                                                        <label for="enable">{{ __('admin_settings.enable') }}</label>
                                                    </span>
                                                </div>
                                                <div class="radio-inline">
                                                    <span class="radio radio-info">
                                                        <input type="radio" class="delivery_charge" name="delivery_charge" id="disable" value="0" {{$delivery_data[0]->status==0 ? 'checked' : ''}}>
                                                        <label for="disable">{{ __('admin_settings.disable') }}</label>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- delivery_charge details -->
                                        <div id="delivery_charge_details">
                                            
                                        </div>
                                    </div>
                                    <!-- cut_off -->
                                    <div class="row mb-30 ml-20">
                                        <div class="form-group">
                                            <label class="control-label mb-10">{{ __('admin_settings.cut_off') }}</label>
                                            <div class="radio-list">
                                                <div class="radio-inline pl-0">
                                                    <span class="radio radio-info">
                                                        <input type="radio" class="cut_off" name="cut_off" id="cut_off_enable" value="1" {{$cut_off_data[0]->status==1 ? 'checked' : ''}}>
                                                        <label for="cut_off_enable">{{ __('admin_settings.enable') }}</label>
                                                    </span>
                                                </div>
                                                <div class="radio-inline">
                                                    <span class="radio radio-info">
                                                        <input type="radio" class="cut_off" name="cut_off" id="cut_off_disable" value="0" {{$cut_off_data[0]->status==0 ? 'checked' : ''}}>
                                                        <label for="cut_off_disable">{{ __('admin_settings.disable') }}</label>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- cut_off details -->
                                        <div id="cut_off_details">
                                            
                                    </div>
                                    <!-- form submit -->
                                    <div class="form-group mb-30 text-center">
                                        <button type="submit" class="btn btn-primary">{{ __('admin_settings.update') }}</button>
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

        // Delivery Charge

        // Page Load DOM Render
        var delivery_charge_status = $(".delivery_charge:checked").val();
        if(delivery_charge_status==1){
            $("#delivery_charge_details").append('<label class="control-label mb-10 text-left">{{ __('admin_settings.delivery_charge_type') }} <span class="star">*</span></label><div class="form-group"><div class="col-xs-2"><select name="delivery_charge_type" id="delivery_charge_type" class="form-control"><option value="km" {{$delivery_data[0]->key== 'km' ? 'selected' : ''}}>{{ __('admin_settings.per_km') }}</option><option value="standard" {{$delivery_data[0]->key== 'standard' ? 'selected' : ''}}>{{ __('admin_settings.standard') }}</option></select></div><div class="col-xs-3"><input type="number" name="amount" class="form-control" value="{{ old('amount',$delivery_data[0]->value) }}" placeholder="Enter Amount"></div><div class="col-xs-7" style="height:50px"></div></div>');
        }else{
            $("#delivery_charge_details").empty();
        }

        //OnClick DOM Render
        $("body").on("click","#enable",function(){   
            $("#delivery_charge_details").append('<label class="control-label mb-10 text-left">{{ __('admin_settings.delivery_charge_type') }} <span class="star">*</span></label><div class="form-group"><div class="col-xs-2"><select name="delivery_charge_type" id="delivery_charge_type" class="form-control"><option value="km" {{$delivery_data[0]->key== 'km' ? 'selected' : ''}}>{{ __('admin_settings.per_km') }}</option><option value="standard" {{$delivery_data[0]->key== 'standard' ? 'selected' : ''}}>{{ __('admin_settings.standard') }}</option></select></div><div class="col-xs-3"><input type="number" name="amount" class="form-control" value="{{ old('amount',$delivery_data[0]->value) }}" placeholder="Enter Amount"></div><div class="col-xs-7" style="height:50px"></div></div>');
        }); 
        $("body").on("click","#disable",function(){   
            $("#delivery_charge_details").empty();
        });  

        // Cut Off

        // Page Load DOM Render
        var cut_off_status = $(".cut_off:checked").val();
        if(cut_off_status==1){
            $("#cut_off_details").append('<label class="control-label mb-10">{{ __('admin_settings.set_cut_off_time') }}</label><div class="form-group"><div class="col-xs-2 text-right" style="margin-top:10px;"><span>Monday: </span><br></div><div class="col-xs-3"><input type="time" class="form-control" value="{{$cut_off_time[0]->time}}" name="day[]"></div><div class="col-xs-7" style="height:50px"></div><div class="col-xs-2 text-right" style="margin-top:10px;"><span>Tuesday: </span><br></div><div class="col-xs-3"><input type="time" class="form-control" value="{{$cut_off_time[1]->time}}" name="day[]"></div><div class="col-xs-7" style="height:50px"></div><div class="col-xs-2 text-right" style="margin-top:10px;"><span>Wednesday: </span><br></div><div class="col-xs-3"><input type="time" class="form-control" value="{{$cut_off_time[2]->time}}" name="day[]"></div><div class="col-xs-7" style="height:50px"></div><div class="col-xs-2 text-right" style="margin-top:10px;"><span>Thursday: </span><br></div><div class="col-xs-3"><input type="time" class="form-control" value="{{$cut_off_time[3]->time}}" name="day[]"></div><div class="col-xs-7" style="height:50px"></div><div class="col-xs-2 text-right" style="margin-top:10px;"><span>Friday: </span><br></div><div class="col-xs-3"><input type="time" class="form-control" value="{{$cut_off_time[4]->time}}" name="day[]"></div><div class="col-xs-7" style="height:50px"></div><div class="col-xs-2 text-right" style="margin-top:10px;"><span>Saturday: </span><br></div><div class="col-xs-3"><input type="time" class="form-control" value="{{$cut_off_time[5]->time}}" name="day[]"></div><div class="col-xs-7" style="height:50px"></div><div class="col-xs-2 text-right" style="margin-top:10px;"><span>Sunday: </span><br></div><div class="col-xs-3"><input type="time" class="form-control" value="{{$cut_off_time[6]->time}}" name="day[]"></div><div class="col-xs-7" style="height:50px"></div></div>');
        }else{
            $("#cut_off_details").empty();
        }

        //OnClick DOM Render
        $("body").on("click","#cut_off_enable",function(){   
            $("#cut_off_details").append('<label class="control-label mb-10">{{ __('admin_settings.set_cut_off_time') }}</label><div class="form-group"><div class="col-xs-2 text-right" style="margin-top:10px;"><span>Monday: </span><br></div><div class="col-xs-3"><input type="time" class="form-control" value="{{$cut_off_time[0]->time}}" name="day[]"></div><div class="col-xs-7" style="height:50px"></div><div class="col-xs-2 text-right" style="margin-top:10px;"><span>Tuesday: </span><br></div><div class="col-xs-3"><input type="time" class="form-control" value="{{$cut_off_time[1]->time}}" name="day[]"></div><div class="col-xs-7" style="height:50px"></div><div class="col-xs-2 text-right" style="margin-top:10px;"><span>Wednesday: </span><br></div><div class="col-xs-3"><input type="time" class="form-control" value="{{$cut_off_time[2]->time}}" name="day[]"></div><div class="col-xs-7" style="height:50px"></div><div class="col-xs-2 text-right" style="margin-top:10px;"><span>Thursday: </span><br></div><div class="col-xs-3"><input type="time" class="form-control" value="{{$cut_off_time[3]->time}}" name="day[]"></div><div class="col-xs-7" style="height:50px"></div><div class="col-xs-2 text-right" style="margin-top:10px;"><span>Friday: </span><br></div><div class="col-xs-3"><input type="time" class="form-control" value="{{$cut_off_time[4]->time}}" name="day[]"></div><div class="col-xs-7" style="height:50px"></div><div class="col-xs-2 text-right" style="margin-top:10px;"><span>Saturday: </span><br></div><div class="col-xs-3"><input type="time" class="form-control" value="{{$cut_off_time[5]->time}}" name="day[]"></div><div class="col-xs-7" style="height:50px"></div><div class="col-xs-2 text-right" style="margin-top:10px;"><span>Sunday: </span><br></div><div class="col-xs-3"><input type="time" class="form-control" value="{{$cut_off_time[6]->time}}" name="day[]"></div><div class="col-xs-7" style="height:50px"></div></div>');
        }); 
        $("body").on("click","#cut_off_disable",function(){   
            $("#cut_off_details").empty();
        });  
    });  
</script>
@endsection