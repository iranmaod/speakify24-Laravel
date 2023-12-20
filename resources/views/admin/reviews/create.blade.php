@extends('layouts.backend.index')
@section('content')
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.testimonials') }}">Testimonials</a></li>
        <li class="breadcrumb-item active">Add</li>
    </ol>
    <h1 class="page-title">Add Testimonial</h1>
</div>

<div class="page-content">
    <div class="panel">
        <div class="panel-body">
            <form method="POST" action="{{ route('admin.testimonial.update') }}" id="reviewForm">
                {{ csrf_field() }}
                <div class="row">
                    <div class="form-group col-md-4">
                        <label class="form-control-label">Instructor <span class="required">*</span></label>
                        <select class="form-control" name="instructor_id" name="instructor_id" id="instructor_id">
                            <option value="">Select</option>
                            @foreach($instructors as $instructor)
                                <option value="{{ $instructor->id }}" {{ old('instructor_id') == $instructor->id ? 'selected' : '' }}>
                                    {{ $instructor->first_name }} {{ $instructor->last_name }}
                                </option>
                            @endforeach
                        </select>
                        
                        @if ($errors->has('instructor_id'))
                            <label class="error" for="instructor_id">{{ $errors->first('instructor_id') }}</label>
                        @endif
                    </div>

                    <div class="form-group col-md-4">
                        <label class="form-control-label">Student <span class="required">*</span></label>
                        <select class="form-control" name="user_id" id="user_id">
                            <option value="">Select</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}" {{ old('user_id') == $student->id ? 'selected' : '' }}>
                                    {{ $student->first_name }} {{ $student->last_name }}
                                </option>
                            @endforeach
                        </select>
                        
                        @if ($errors->has('user_id'))
                            <label class="error" for="user_id">{{ $errors->first('user_id') }}</label>
                        @endif
                    </div>

                    <div class="form-group col-md-4">
                        <label class="form-control-label">Review <span class="required">*</span></label>
                        <textarea name="review" class="form-control">{{ old('review') }}</textarea>

                        @if ($errors->has('review'))
                            <label class="error" for="review">{{ $errors->first('review') }}</label>
                        @endif
                    </div>

                    <div class="form-group col-md-4">
                        <label class="form-control-label">Rating</label>
                        <select class="form-control" name="rating">
                            <option value="">Select</option>
                            <option value="1" @if('1' == old('rating')){{ 'selected' }}@endif>1</option>
                            <option value="2" @if('2' == old('rating')){{ 'selected' }}@endif>2</option>
                            <option value="3" @if('3' == old('rating')){{ 'selected' }}@endif>3</option>
                            <option value="4" @if('4' == old('rating')){{ 'selected' }}@endif>4</option>
                            <option value="5" @if('5' == old('rating')){{ 'selected' }}@endif>5</option>
                        </select>
                        
                        @if ($errors->has('rating'))
                            <label class="error" for="rating">{{ $errors->first('rating') }}</label>
                        @endif
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

    });
</script>
@endsection