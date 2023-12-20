@extends('layouts.backend.index')
@section('content')
<div class="page-header">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Settings</li>
  </ol>
  <h1 class="page-title">Payment</h1>
</div>

<div class="page-content">

<div class="panel">
  <div class="panel-body">
    <form method="POST" action="{{ route('admin.saveConfig') }}">
      {{ csrf_field() }}
      <input type="hidden" name="code" value="settingPayment">
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
              <label class="form-control-label">Username</label>
              <input type="text" class="form-control" name="username[en]" 
                placeholder="Username" value="{{ isset($config['en']['username']) ? $config['en']['username'] : '' }}" />
            </div>
        
            <div class="form-group col-md-6">
              <label class="form-control-label">Password</label>
              <input type="text" class="form-control" name="password[en]" 
                placeholder="Password" value="{{ isset($config['en']['password']) ? $config['en']['password'] : '' }}" />
            </div>

            <div class="form-group col-md-6">
              <label class="form-control-label">Signature</label>
              <input type="text" class="form-control" name="signature[en]" 
                placeholder="Signature" value="{{ isset($config['en']['signature']) ? $config['en']['signature'] : '' }}" />
            </div>

            <div class="form-group col-md-3">
                <label class="form-control-label">Test Mode</label>
                <div>
                  <div class="radio-custom radio-default radio-inline">
                    <input type="radio" id="inputBasicActive" name="test_mode[en]" value="1" @if(!isset($config['en']['test_mode'])) checked @endif @if(isset($config['en']['test_mode']) && $config['en']['test_mode'] == 1) checked @endif/>
                    <label for="inputBasicActive">Active</label>
                  </div>
                  <div class="radio-custom radio-default radio-inline">
                    <input type="radio" id="inputBasicInactive" name="test_mode[en]" value="0" @if(isset($config['en']['test_mode']) && $config['en']['test_mode'] == 0) checked @endif/>
                    <label for="inputBasicInactive">Inactive</label>
                  </div>
                </div>
            </div>

            <div class="form-group col-md-3">
                <label class="form-control-label">Status</label>
                <div>
                  <div class="radio-custom radio-default radio-inline">
                    <input type="radio" id="inputBasic1Active" name="is_active[en]" value="1" 
                    @if(!isset($config['en']['is_active'])) checked @endif @if(isset($config['en']['is_active']) && $config['en']['is_active'] == 1) checked @endif/>
                    <label for="inputBasic1Active">Active</label>
                  </div>
                  <div class="radio-custom radio-default radio-inline">
                    <input type="radio" id="inputBasic1Inactive" name="is_active[en]" value="0" 
                    @if(isset($config['en']['is_active']) && $config['en']['is_active'] == 0) checked @endif/>
                    <label for="inputBasic1Inactive">Inactive</label>
                  </div>
                </div>
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
