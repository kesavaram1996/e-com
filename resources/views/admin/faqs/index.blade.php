@extends('admin.layouts.main')

@section('main-content')
@if ($message = Session::get('success'))
<div class="alert alert-success">
  <p>{{ $message }}</p>
</div>
@endif
<style>
    .error{
        color: red;
    }
</style>

<section class="section">
    <div class="section-header mt">
        <div class="row">
            <div class="col-6 col-md-6 col-lg-6">
                <h3>{{ __('faqs.faqs') }}</h3>
            </div>
            <div class="col-6 col-md-6 col-lg-6">
                {{ Breadcrumbs::render('faqs') }}
            </div>
        </div>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-md-12">
                <div class="pull-right mt-5 mb-5">
                    <button class="btn btn-primary" id="add" data-toggle="modal" data-target="#myModal">Add Query</button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default card-view">
                    <div class="panel-wrapper collapse in">
                        <div class="panel-body pa-15">
                            <div class="panel-group accordion-struct"  role="tablist" aria-multiselectable="true">
                                @foreach($data as $datas)
                                <div class="panel panel-default">
                                    <div class="panel-heading activestate" role="tab" id="headingFive{{$datas->id}}">
                                        <a role="button" data-toggle="collapse" href="#collapseFive{{$datas->id}}" aria-expanded="true" aria-controls="collapseFive">{{$datas->question}}</a>
                                    </div>
                                    <div id="collapseFive{{$datas->id}}" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingFive{{$datas->id}}">
                                        <div class="panel-body pa-15">
                                            <div>
                                                {{$datas->answer}} 
                                            </div>
                                            <div class="text-right">
                                                <a href="javascript:void(0);" data-id="{{$datas->id}}" data-question="{{$datas->question}}" data-answer="{{$datas->answer}}" data-status="{{$datas->status}}"  id="edit_faq"><i class="fa-solid fa-pen-to-square" data-toggle="modal" data-target="#myModal"></i></a>
                                                <a href="javascript:void(0);" data-id="{{$datas->id}}" id="delete_faq"><i class="fa-solid fa-trash"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <div class="d-flex justify-content-center">
                                {!! $data->links('pagination::bootstrap-4') !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
	    </div>
    </div>
</section>
<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" id="title">Add Query</h4>
        </div>
        <div class="modal-body">
            <form action="{{route('faqs.store')}}" method="POST" id="query">
                @csrf
                <input type="hidden" name="id" id="id" value="">
                <div class="form-group">
                    <label class="control-label mb-10 text-left">Question<span class="star">*</span></label>
                    <input type="text" id="question" name="question" class="form-control" value="">
                </div>
                <div class="form-group">
                    <label class="control-label mb-10 text-left">Answer<span class="star">*</span></label>
                    <input type="text" id="answer" name="answer" class="form-control" value="">
                </div>
                <div class="form-group">
                    <label class="control-label mb-10 text-left">Status<span class="star">*</span></label>
                    <select name="status" id="status" class="form-control">
                        <option value="">Select Status</option>
                        <option value="pending">Pending</option>
                        <option value="answered">Answered</option>
                    </select>
                </div>
                <div class="form-group text-center">
                    <button type="submit" id="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
        <div class="modal-footer">
          
        </div>
      </div>
      
    </div>
  </div>
  <!-- Model1 End -->
  
<script>
    $(document).ready(function() {
        // Form Validation
        $('#query').submit(function(e) {
            var question = $('#question').val();
            var answer = $('#answer').val();
            var status = $('#status').val();
            $(".error").remove();
            if (question.length < 1) {
                e.preventDefault();
                $('#question').after('<span class="error">This field is required</span>');
            }
            if (answer.length < 1) {
                e.preventDefault();
                $('#answer').after('<span class="error">This field is required</span>');
            }
            if (status.length < 1) {
                e.preventDefault();
                $('#status').after('<span class="error">This field is required</span>');
            }
        });

        // Set Value for Edit FAQ
        $(document).on("click","#edit_faq",function() {
            var id          = $(this).attr('data-id');
            var question    = $(this).attr('data-question');
            var answer      = $(this).attr('data-answer');
            var status      = $(this).attr('data-status');
            $('#id').val(id);
            $('#question').val(question);
            $('#answer').val(answer);
            $('#status').val(status);
            $('#submit').text('Update');
            $('#title').text('Update Query');
        });

        // Refresh Value for Add FAQ
        $(document).on("click","#add",function() {
            $('#id').val('');
            $('#question').val('');
            $('#answer').val('');
            $('#status').val('');
            $('#submit').text('Add');
            $('#title').text('Add Query');
        });

        // Delete FAQ's
        $(document).on("click","#delete_faq",function() {
            let res = confirm('Are you sure want to delete this');
            if(res == true){
                let id = $(this).attr("data-id");
                $.ajax({
                        type: 'POST',
                        url: '{{route("faqs.faqdelete")}}',
                        dataType: 'json',
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        data: {id:id,"_token": "{{ csrf_token() }}"},

                        success: function (data) {
                        },
                        error: function (data) {
                            location.reload();
                        }
                });
            }
            
        });
    });
</script>
@endsection