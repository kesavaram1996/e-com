
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
                <h3>{{ __('users.admins') }}</h3>
            </div>
            <div class="col-6 col-md-6 col-lg-6">
                {{ Breadcrumbs::render('admins/edit') }}
            </div>
        </div>
    </div>
    <div class="section-body mt">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default card-view">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h6 class="panel-title txt-dark">{{ __('users.edit_admin') }}</h6>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                            <div class="form-wrap">
                                <form action="{{route('users.update', $user->id)}}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label class="control-label mb-10 text-left">{{ __('users.name') }} <span class="star">*</span></label>
                                        <input type="text" name="name" class="form-control" value="{{$user->name}}">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label mb-10 text-left">{{ __('users.email') }} <span class="star">*</span></label>
                                        <input type="email" name="email" class="form-control" value="{{$user->email}}">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label mb-10 text-left">{{ __('users.phone') }} <span class="star">*</span></label>
                                        <input type="number" name="phone" class="form-control" value="{{$user->phone}}">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label mb-10 text-left">{{ __('users.password') }} </label>
                                        <input type="password" name="password" class="form-control" value="">
                                    </div>
                                    <!-- <div class="form-group">
                                        <label class="control-label mb-10 text-left">{{ __('users.cpassword') }} <span class="star">*</span></label>
                                        <input type="password" name="cpassword" class="form-control" value="">
                                    </div> -->
                                    <div class="form-group">
                                        <label class="control-label mb-10 text-left">{{ __('users.role') }}</label>
                                        <select name="roles" class="form-control">
                                            @foreach($roles as $role)
                                            <option value="{{$role}}" @if (in_array($role, $userRole)) selected @endif >{{$role}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group mb-30 text-center">
                                        <button type="submit" class="btn btn-primary">Submit</button>
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
@endsection