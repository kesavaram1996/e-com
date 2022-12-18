@extends('admin.layouts.main')

@section('main-content')
@if ($message = Session::get('success'))
<div class="alert alert-success">
  <p>{{ $message }}</p>
</div>
@endif


<section class="section">
    <div class="section-header mt">
        <div class="row">
            <div class="col-6 col-md-6 col-lg-6">
                <h3>{{ __('privacy_policy.privacy_policy') }}</h3>
            </div>
            <div class="col-6 col-md-6 col-lg-6">
                {{ Breadcrumbs::render('privacy_policy') }}
            </div>
        </div>
    </div>
    <div class="section-body">
        <!-- privacy_policy -->
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt">
                <div class="panel panel-default card-view panel-refresh">
                    <div class="refresh-container">
                        <div class="la-anim-1"></div>
                    </div>
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h6 class="panel-title txt-dark">{{ __('privacy_policy.update_privacy_policy') }}</h6>
                        </div>
                        
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body row pa-0">
                            <form action="{{route('privacy_policy.store')}}" method="POST" class="text-center mb-30">
                                @csrf
                                <textarea name="editor1">{{$data[0]->value}}</textarea>
                                <input type="submit" class="btn btn-primary mt-30">
                            </form>
                        </div>	
                    </div>
                </div>
            </div>
        </div>
        <!-- terms_conditions -->
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mt">
                <div class="panel panel-default card-view panel-refresh">
                    <div class="refresh-container">
                        <div class="la-anim-1"></div>
                    </div>
                    <div class="panel-heading">
                        <div class="pull-left">
                            <h6 class="panel-title txt-dark">{{ __('privacy_policy.update_terms_conditions') }}</h6>
                        </div>
                        
                        <div class="clearfix"></div>
                    </div>
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body row pa-0">
                            <form action="{{route('privacy_policy.terms_conditions')}}" method="POST" class="text-center mb-30">
                                @csrf
                                <textarea name="editor2">{{$terms_conditions[0]->value}}</textarea>
                                <input type="submit" class="btn btn-primary mt-30">
                            </form>
                        </div>	
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    CKEDITOR.replace('editor1', {
        filebrowserUploadUrl: "{{route('privacy_policy.upload', ['_token' => csrf_token() ])}}",
        filebrowserUploadMethod: 'form'
    });
</script>
<script type="text/javascript">
    CKEDITOR.replace('editor2', {
        filebrowserUploadUrl: "{{route('privacy_policy.terms_conditions_upload', ['_token' => csrf_token() ])}}",
        filebrowserUploadMethod: 'form'
    });
</script>

@endsection