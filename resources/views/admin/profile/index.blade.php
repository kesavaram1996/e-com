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
@if ($message = Session::get('success'))
<div class="alert alert-success">
  <p>{{ $message }}</p>
</div>
@endif
<div class="container-fluid pt-25">
    <div class="row">
        <div class="col-lg-12 col-xs-12">
            <div class="panel panel-default card-view">
                <div class="panel-heading">
                    <div class="pull-left">
                        <h6 class="panel-title txt-dark">{{ __('profile.personal_details') }}</h6>
                    </div>  
                    <div class="pull-right">
                        <label class="label label-danger">If you change email or password you will need to login again.</label>
                    </div>                      
                    <div class="clearfix"></div>
                </div>
                <div class="panel-wrapper collapse in">
                    <div class="panel-body">
                        <div class="form-wrap">
                            @foreach($data as $datas)
                            <form action="{{route('profile.update',$datas->id)}}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label class="control-label mb-10 text-left">{{ __('profile.name') }} <span class="star">*</span></label>
                                    <input type="text" class="form-control" name="name" value="{{$datas->name}}">
                                </div>
                                <div class="form-group">
                                    <label class="control-label mb-10 text-left">{{ __('profile.email') }} <span class="star">*</span></label>
                                    <input type="email" class="form-control" name="email" value="{{$datas->email}}">
                                </div>
                                <div class="form-group">
                                    <label class="control-label mb-10 text-left">{{ __('profile.phone') }} <span class="star">*</span></label>
                                    <input type="number" class="form-control" name="phone" value="{{$datas->phone}}">
                                </div>
                                <div class="form-group">
                                    <label class="control-label mb-10 text-left">{{ __('profile.old_password') }} </label>
                                    <input type="password" class="form-control" name="old_password" value="">
                                </div>
                                <div class="form-group">
                                    <label class="control-label mb-10 text-left">{{ __('profile.new_password') }} </label>
                                    <input type="password" class="form-control" name="new_password" value="">
                                </div>
                                <div class="form-group">
                                    <label class="control-label mb-10 text-left">{{ __('profile.confirm_password') }} </label>
                                    <input type="password" class="form-control" name="confirm_password" value="">
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">{{ __('profile.update') }}</button>
                                </div>
                            </form>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>  
        </div>
        <div class="col-lg-6 col-xs-12">
                
        </div>
    </div>
</div>
@endsection