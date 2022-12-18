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
    <div class="section-header">
        <div class="row">
            <div class="col-6 col-md-6 col-lg-6">
                <h3>{{ __('roles.roles') }}</h3>
            </div>
            <div class="col-6 col-md-6 col-lg-6">
                {{ Breadcrumbs::render('roles/edit') }}
            </div>
        </div>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default card-view">
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h6 class="panel-title txt-dark">{{ __('roles.edit_role') }}</h6>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body">
                            <div class="form-wrap">
                                <form action="{{route('roles.update', $role->id)}}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <label class="control-label mb-10 text-left">{{ __('roles.name') }} <span class="star">*</span></label>
                                        <input type="text" name="name" class="form-control" value="{{$role->name}}">
                                    </div>
                                    <!-- <div class="form-group mb-30">
                                        <label class="control-label mb-10 text-left">{{ __('roles.Permission') }}<span class="star">*</span></label>
                                        @foreach($permission as $value)
                                            <div class="checkbox checkbox-success">
                                                <input id="" type="checkbox" name="permission[]" value="{{$value->id}}" @if (in_array($value->id, $rolePermissions)) checked @endif>
                                                <label for="permission">
                                                    {{$value->name}}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div> -->
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