@extends('layouts.backend.index')
@section('content')
<div class="page-header">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('admin.languages') }}">Languages</a></li>
    <li class="breadcrumb-item active">Add</li>
  </ol>
  <h1 class="page-title">Add Language</h1>
</div>

<div class="page-content">

<div class="panel">
  <div class="panel-body">
    <form method="POST" action="{{ route('admin.saveLanguage') }}" id="languageForm">
      {{ csrf_field() }}
      <input type="hidden" name="language_id" value="{{ $language->id }}">
      <div class="row">
      
        <div class="form-group col-md-4">
          <label class="form-control-label">Language Name <span class="required">*</span></label>
          <input type="text" class="form-control" name="title" 
            placeholder="Language Name" value="{{ $language->title }}" />
            @if ($errors->has('name'))
                <label class="error" for="name">{{ $errors->first('name') }}</label>
            @endif
        </div>
		
		<div class="form-group col-md-4">
          <label class="form-control-label">Language Code</label>
          <input type="text" class="form-control" name="code" 
            placeholder="Language Code" value="{{ $language->code }}" />
        </div>
       
        
      <div class="form-group col-md-4">
        <label class="form-control-label">Status</label>
        <div>
          <div class="radio-custom radio-default radio-inline">
            <input type="radio" id="inputBasicActive" name="is_enabled" value="1" @if($language->is_enabled) checked @endif />
            <label for="inputBasicActive">Active</label>
          </div>
          <div class="radio-custom radio-default radio-inline">
            <input type="radio" id="inputBasicInactive" name="is_enabled" value="0" @if(!$language->is_enabled) checked @endif/>
            <label for="inputBasicInactive">Inactive</label>
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

@section('javascript')
<script type="text/javascript">
    $(document).ready(function()
    { 
        $("#languageForm").validate({
            rules: {
                title: {
                    required: true
                }
            },
            messages: {
                title: {
                    required: 'The Language name field is required.'
                }
            }
        });
    });
</script>
@endsection