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

<div class="panel">
  <div class="panel-body">
    <form method="POST" action="{{ route('admin.saveConfig') }}">
      {{ csrf_field() }}
      <input type="hidden" name="code" value="settingEmail">
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
       <div class="row">
            <div class="form-group col-md-6">
              <label class="form-control-label">SMTP Host</label>
              <input type="text" class="form-control" name="smtp_host" 
                placeholder="SMTP Host" value="{{ isset($config['smtp_host']) ? $config['smtp_host'] : '' }}" />
            </div>
        
            <div class="form-group col-md-6">
              <label class="form-control-label">SMTP Port</label>
              <input type="text" class="form-control" name="smtp_port" 
                placeholder="SMTP Port" value="{{ isset($config['smtp_port']) ? $config['smtp_port'] : '' }}" />
            </div>
        
            <div class="form-group col-md-6">
              <label class="form-control-label">SMTP Secure</label>
              <input type="text" class="form-control" name="smtp_secure" 
                placeholder="SMTP Secure" value="{{ isset($config['smtp_secure']) ? $config['smtp_secure'] : '' }}" />
            </div>
        

            <div class="form-group col-md-6">
              <label class="form-control-label">SMTP Username</label>
              <input type="text" class="form-control" name="smtp_username" 
                placeholder="SMTP Username" value="{{ isset($config['smtp_username']) ? $config['smtp_username'] : '' }}" />
            </div>

            <div class="form-group col-md-6">
              <label class="form-control-label">SMTP Password</label>
              <input type="text" class="form-control" name="smtp_password" 
                placeholder="SMTP Password" value="{{ isset($config['smtp_password']) ? $config['smtp_password'] : '' }}" />
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

       
      <!-- End Panel Basic -->
</div>

@endsection

@section('javascript')
<script type="text/javascript">
    $(document).ready(function()
    { 
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