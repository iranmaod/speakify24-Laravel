@extends('layouts.backend.index')
@section('content')
<div class="page-header">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Pages</li>
  </ol>
  <h1 class="page-title">School Children & Students</h1>
</div>

<div class="page-content">
	<ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link bg-aqua-active" href="#" id="english-link">EN</a>
        </li>
        <!-- <li class="nav-item">
            <a class="nav-link" href="#" id="spanish-link">ES</a>
        </li> -->
        <li class="nav-item">
            <a class="nav-link" href="#" id="german-link">DE</a>
        </li>
    </ul>
	<div class="panel">
		<div class="panel-body">
			<form method="POST" action="{{ route('admin.saveConfig') }}">
			{{ csrf_field() }}
			<input type="hidden" name="code" value="pageSchoolstudent">
			<div class="row">
				<div class="col-6">
					<label for="">SEO Title</label>
					<input class="form-control" name="seo_title" @isset($options->seo_title)value="{{$options->seo_title}}" @endisset type="text" placeholder="Enter seo title">
				</div>
				<div class="col-6">
					<label for="">SEO Description</label>
					<input class="form-control" name="seo_description" @isset($options->seo_description)value="{{$options->seo_description}}" @endisset type="text" placeholder="Enter seo description">
				</div>
				<div class="col-6">
					<label for="">SEO Keywords <small class="text-danger">(Enter keywords with comma separated)</small></label>
					<input class="form-control" name="seo_keywords" @isset($options->seo_keywords)value="{{$options->seo_keywords}}" @endisset type="text" placeholder="Enter seo keywords">
				</div>
			</div>
			<div class="card-body" id="english-form">
				<div class="form-group">
					<label class="form-control-label">{{ trans('cruds.page.fields.content') }} (EN)</label>
					<textarea name="content[en]">{{ isset($config['en']['content']) ? $config['en']['content'] : '' }}</textarea>
				</div>
			</div>
			<!-- <div class="card-body d-none" id="spanish-form">
				<div class="form-group">
					<label class="form-control-label">{{-- trans('cruds.page.fields.content') --}} (ES)</label>
					<textarea name="content[es]">{{-- isset($config['es']['content']) ? $config['es']['content'] : '' --}}</textarea>
				</div>
			</div> -->
			<div class="card-body d-none" id="german-form">
				<div class="form-group">
					<label class="form-control-label">{{ trans('cruds.page.fields.content') }} (DE)</label>
					<textarea name="content[de]">{{ isset($config['de']['content']) ? $config['de']['content'] : '' }}</textarea>
				</div>
			</div>

			<div class="form-group row">
				<div class="col-md-4">
				<button type="submit" class="btn btn-primary">Submit</button>
				<button type="reset" class="btn btn-default btn-outline">Reset</button>
				</div>
			</div>
			
			</form>
		</div>
	</div>

       
      <!-- End Panel Basic -->
</div>

@endsection

@section('javascript')
<script type="text/javascript">
    $(document).ready(function() {

		$(".nav-link").on("click", function() {
			$(".nav-link").removeClass("bg-aqua-active");
			$(this).addClass("bg-aqua-active");

			var id = $(this).attr("id").split("-");
			$(".card-body").removeClass("d-none");
			$(".card-body").addClass("d-none");
			$("#"+id[0]+"-form").removeClass("d-none");
			
			console.log($(this).attr("id").split("-"));
		});

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
    });
</script>

@endsection
