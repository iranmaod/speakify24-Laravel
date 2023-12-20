@extends('layouts.backend.index')
@section('content')
<div class="page-header">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Pages</li>
  </ol>
  <h1 class="page-title">Home</h1>
</div>

<div class="page-content">

	<ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link bg-aqua-active" href="#" id="english-link">EN</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#" id="spanish-link">ES</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#" id="german-link">DE</a>
        </li>
    </ul>
	<div class="panel">
		<div class="panel-body">
			<form method="POST" action="{{ route('admin.saveConfig') }}">
			{{ csrf_field() }}
			<input type="hidden" name="code" value="pageHome">
			<div class="card-body" id="english-form">				
				<div class="row">
					<div class="form-group col-md-6">
						<label class="form-control-label">{{ trans('cruds.page.fields.bannertitle') }} (EN)</label>
						<input type="text" class="form-control" name="banner_title[en]" 
							placeholder="{{ trans('cruds.page.fields.bannertitle') }}" value="{{ isset($config['en']['banner_title']) ? $config['en']['banner_title'] : '' }}" />
					</div>
				
					<div class="form-group col-md-6">
						<label class="form-control-label">{{ trans('cruds.page.fields.bannertext') }} (EN)</label>
						<input type="text" class="form-control" name="banner_text[en]" 
							placeholder="{{ trans('cruds.page.fields.bannertext') }}" value="{{ isset($config['en']['banner_text']) ? $config['en']['banner_text'] : '' }}" />
					</div>
				
					<div class="form-group col-md-6">
						<label class="form-control-label">{{ trans('cruds.page.fields.instructortext') }} (EN)</label>
						<input type="text" class="form-control" name="instructor_text[en]" 
							placeholder="{{ trans('cruds.page.fields.instructortext') }}" value="{{ isset($config['en']['instructor_text']) ? $config['en']['instructor_text'] : '' }}" />
					</div>
				

					<div class="form-group col-md-6">
						<label class="form-control-label">{{ trans('cruds.page.fields.learnblocktitle') }} (EN)</label>
						<input type="text" class="form-control" name="learn_block_title[en]" 
							placeholder="{{ trans('cruds.page.fields.learnblocktitle') }}" value="{{ isset($config['en']['learn_block_title']) ? $config['en']['learn_block_title'] : '' }}" />
					</div>

					<div class="form-group col-md-12">
						<label class="form-control-label">{{ trans('cruds.page.fields.learnblocktext') }} (EN)</label>
						<textarea name="learn_block_text[en]">{{ isset($config['en']['learn_block_text']) ? $config['en']['learn_block_text'] : '' }}</textarea>
					</div>
				</div>
			</div>
			<div class="card-body d-none" id="spanish-form">
			<div class="row">
					<div class="form-group col-md-6">
						<label class="form-control-label">{{ trans('cruds.page.fields.bannertitle') }} (ES)</label>
						<input type="text" class="form-control" name="banner_title[es]" 
							placeholder="{{ trans('cruds.page.fields.bannertitle') }}" value="{{ isset($config['es']['banner_title']) ? $config['es']['banner_title'] : '' }}" />
					</div>
				
					<div class="form-group col-md-6">
						<label class="form-control-label">{{ trans('cruds.page.fields.bannertext') }} (ES)</label>
						<input type="text" class="form-control" name="banner_text[es]" 
							placeholder="{{ trans('cruds.page.fields.bannertext') }}" value="{{ isset($config['es']['banner_text']) ? $config['es']['banner_text'] : '' }}" />
					</div>
				
					<div class="form-group col-md-6">
						<label class="form-control-label">{{ trans('cruds.page.fields.instructortext') }} (ES)</label>
						<input type="text" class="form-control" name="instructor_text[es]" 
							placeholder="{{ trans('cruds.page.fields.instructortext') }}" value="{{ isset($config['es']['instructor_text']) ? $config['es']['instructor_text'] : '' }}" />
					</div>
				

					<div class="form-group col-md-6">
						<label class="form-control-label">{{ trans('cruds.page.fields.learnblocktitle') }} (ES)</label>
						<input type="text" class="form-control" name="learn_block_title[es]" 
							placeholder="{{ trans('cruds.page.fields.learnblocktitle') }}" value="{{ isset($config['es']['learn_block_title']) ? $config['es']['learn_block_title'] : '' }}" />
					</div>

					<div class="form-group col-md-12">
						<label class="form-control-label">{{ trans('cruds.page.fields.learnblocktext') }} (ES)</label>
						<textarea name="learn_block_text[es]">{{ isset($config['es']['learn_block_text']) ? $config['es']['learn_block_text'] : '' }}</textarea>
					</div>
				</div>
			</div>
			<div class="card-body d-none" id="german-form">
			<div class="row">
					<div class="form-group col-md-6">
						<label class="form-control-label">{{ trans('cruds.page.fields.bannertitle') }} (DE)</label>
						<input type="text" class="form-control" name="banner_title[de]" 
							placeholder="{{ trans('cruds.page.fields.bannertitle') }}" value="{{ isset($config['de']['banner_title']) ? $config['de']['banner_title'] : '' }}" />
					</div>
				
					<div class="form-group col-md-6">
						<label class="form-control-label">{{ trans('cruds.page.fields.bannertext') }} (DE)</label>
						<input type="text" class="form-control" name="banner_text[de]" 
							placeholder="{{ trans('cruds.page.fields.bannertext') }}" value="{{ isset($config['de']['banner_text']) ? $config['de']['banner_text'] : '' }}" />
					</div>
				
					<div class="form-group col-md-6">
						<label class="form-control-label">{{ trans('cruds.page.fields.instructortext') }} (DE)</label>
						<input type="text" class="form-control" name="instructor_text[de]" 
							placeholder="{{ trans('cruds.page.fields.instructortext') }}" value="{{ isset($config['de']['instructor_text']) ? $config['de']['instructor_text'] : '' }}" />
					</div>
				

					<div class="form-group col-md-6">
						<label class="form-control-label">{{ trans('cruds.page.fields.learnblocktitle') }} (DE)</label>
						<input type="text" class="form-control" name="learn_block_title[de]" 
							placeholder="{{ trans('cruds.page.fields.learnblocktitle') }}" value="{{ isset($config['de']['learn_block_title']) ? $config['de']['learn_block_title'] : '' }}" />
					</div>

					<div class="form-group col-md-12">
						<label class="form-control-label">{{ trans('cruds.page.fields.learnblocktext') }} (DE)</label>
						<textarea name="learn_block_text[de]">{{ isset($config['de']['learn_block_text']) ? $config['de']['learn_block_text'] : '' }}</textarea>
					</div>
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
    $(document).ready(function()
    {
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
            selector:'textarea',
            menubar:false,
            statusbar: false,
            height: 280,
            content_style: "#tinymce p{color:#76838f;}"
        });
    });
</script>

@endsection