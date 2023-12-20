@extends('layouts.backend.index')
@section('content')
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.subscriptions') }}">Subscription Plans</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>
    <h1 class="page-title">Edit Subscription</h1>
</div>

<div class="page-content">

    <div class="panel">
        <div class="panel-body">
            <form method="POST" action="{{ route('admin.subscription.update') }}" id="subscriptionForm">
                {{ csrf_field() }}
                <input type="hidden" name="id" value="{{$subscription->id}}" />
                <div class="row">
                    <div class="form-group col-md-4">
                        <label class="form-control-label">Name <span class="required">*</span></label>
                        <input type="text" class="form-control" name="name" placeholder="Name" value="{{ $subscription->name }}" />
                            @if ($errors->has('name'))
                                <label class="error" for="title">{{ $errors->first('name') }}</label>
                            @endif
                    </div>

                    <div class="form-group col-md-4">
                        <label class="form-control-label">Hours Per Month <span class="required">*</span></label>
                        <input type="number" class="form-control" name="per_month" placeholder="Hours Per Month" value="{{ $subscription->per_month }}" />
                            @if ($errors->has('per_month'))
                                <label class="error" for="title">{{ $errors->first('per_month') }}</label>
                            @endif
                    </div>

                    <div class="form-group col-md-4">
                        <label class="form-control-label">Course <span class="required">*</span></label>
                        <select class="form-control" name="course_id" id="course_id">
                            <option value="">Select</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}" {{ $subscription->course_id == $course->id ? 'selected' : '' }}>
                                    {{ $course->course_title }}
                                </option>
                            @endforeach
                        </select>
                        
                        @if ($errors->has('course_id'))
                            <label class="error" for="course_id">{{ $errors->first('course_id') }}</label>
                        @endif
                    </div>

                    <div class="form-group col-md-4">
                        <label class="form-control-label">Price <span class="required">*</span></label>
                        <input type="number" class="form-control" name="price" placeholder="Price" value="{{ $subscription->price }}" />
                            @if ($errors->has('price'))
                                <label class="error" for="title">{{ $errors->first('price') }}</label>
                            @endif
                    </div>

                    <div class="form-group col-md-4">
                        <label class="form-control-label">Status <span class="required">*</span></label>
                        <select class="form-control" name="status">
                            <option value="">Select</option>
                            <option value="0" {{ $subscription->status == '0' ? 'selected' : '' }}>Pending</option>
                            <option value="1" {{ $subscription->status == '1' ? 'selected' : '' }}>Active</option>
                        </select>
                        
                        @if ($errors->has('status'))
                            <label class="error" for="status">{{ $errors->first('status') }}</label>
                        @endif
                    </div>

                    <!-- <div class="form-group col-md-4">
                        <label class="form-control-label">Expiry <span class="required">*</span></label>
                        <input type="datetime" class="form-control datetime" name="expiry" 
                            placeholder="Expiry" value="{{ $subscription->expiry }}" />

                        @if ($errors->has('expiry'))
                            <label class="error" for="expiry">{{ $errors->first('expiry') }}</label>
                        @endif
                    </div> -->

                    <div class="form-group col-md-12">
                        <label class="form-control-label">Description</label>
                        <textarea name="description">
                            {!! str_replace('../../', '../../../', $subscription->description) !!}
                        </textarea>
                    </div>
                </div>
                <hr>
                <div class="form-group row">
                    <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="reset" class="btn btn-default btn-outline">Reset</button>
                    </div>
                </div>
        
            </form>
        </div>
    </div>
</div>

@endsection

@section('javascript')
<script type="text/javascript">
    $(document).ready(function() {
        tinymce.init({ 
			selector: "textarea",  // change this value according to your HTML
  			plugins: 'image code',
			toolbar: "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | code| image ",
			menubar: false,
			height: 500,
			content_style: "#tinymce {color:#76838f;}",
			extended_valid_elements: 'i[class]',
			images_upload_url: "{{route('admin.saveloginsession')}}",
			automatic_uploads: true,
            file_picker_types: 'image',
            file_picker_callback: function(cb, value, meta) {
                var input = document.createElement('input');
                input.setAttribute('type', 'file');
                input.setAttribute('accept', 'image/*');

                input.onchange = function() {
                    var file = this.files[0];

                    var reader = new FileReader();
                    reader.readAsDataURL(file);
                    reader.onload = function () {
                        var id = 'blobid' + (new Date()).getTime();
                        var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                        var base64 = reader.result.split(',')[1];
                        var blobInfo = blobCache.create(id, file, base64);
                        blobCache.add(blobInfo);
                        cb(blobInfo.blobUri(), { title: file.name });
                    };
                };
                input.click();
            }
        });
        
        $(".datetime").datetimepicker();
    });
</script>
@endsection