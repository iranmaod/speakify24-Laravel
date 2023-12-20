@extends('layouts.backend.index')
@section('content')
<style>
    .loading_main {
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        width: 100%;
        background-color: #007cff2b;
        z-index: 1;
        display: none;
    }
    .loading {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        height: 50px;
        display: flex;
        align-items: center;
    }

    .obj {
        width: 6px;
        height: 0px;
        background: #007cff;
        margin: 0 3px;
        border-radius: 10px;
        animation: loading 0.8s infinite;
    }

    .obj:nth-child(2){
        animation-delay: 0.1s;
    }
    .obj:nth-child(3){
        animation-delay: 0.2s;
    }
    .obj:nth-child(4){
        animation-delay: 0.3s;
    }
    .obj:nth-child(5){
        animation-delay: 0.4s;
    }
    .obj:nth-child(6){
        animation-delay: 0.5s;
    }
    .obj:nth-child(7){
        animation-delay: 0.6s;
    }
    .obj:nth-child(8){
        animation-delay: 0.7s;
    }

    @keyframes loading {
        0% {
            height: 0;
        }
        50% {
            height: 50px;
        }
        100% {
            height: 0;
        }
    }
</style>
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('instructor.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('appointments') }}">Appintments</a></li>
        <li class="breadcrumb-item active">Add</li>
    </ol>
    <h1 class="page-title">Add Appointment</h1>
</div>

<div class="page-content">

    <div class="panel">
        <div class="panel-body">
            <div class="loading_main">
                <div class="loading">
                    <div class="obj"></div>
                    <div class="obj"></div>
                    <div class="obj"></div>
                    <div class="obj"></div>
                    <div class="obj"></div>
                    <div class="obj"></div>
                    <div class="obj"></div>
                    <div class="obj"></div>
                </div>
            </div>
            <form method="POST" action="{{ route('appointment.update') }}" id="appintmentForm">
                {{ csrf_field() }}
                <div class="row">
        
                    <input type="hidden" name="instructor_id" value="{{Auth::user()->id}}" />
                    <div class="form-group col-md-4">
                        <label class="form-control-label">Title <span class="required">*</span></label>
                        <input type="text" class="form-control" name="title" placeholder="Title" value="{{ old('title') }}" />
                            @if ($errors->has('title'))
                                <label class="error" for="title">{{ $errors->first('title') }}</label>
                            @endif
                    </div>

                    <div class="form-group col-md-4">
                        <label class="form-control-label">Course <span class="required">*</span></label>
                        <select class="form-control" name="course_id" id="course_id">
                            <option value="">Select</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}"
                                @if($course->id == old('course_id')){{ 'selected' }}@endif>
                                    {{ $course->course_title }}
                                </option>
                            @endforeach
                        </select>
                        
                        @if ($errors->has('course_id'))
                            <label class="error" for="course_id">{{ $errors->first('course_id') }}</label>
                        @endif
                    </div>

                    <div class="form-group col-md-4">
                        <label class="form-control-label">Lecture</label>
                        <select class="form-control" name="lecture_id" id="lecture_id">
                            <option value="">Select</option>
                        </select>
                        
                        @if ($errors->has('lecture_id'))
                            <label class="error" for="lecture_id">{{ $errors->first('lecture_id') }}</label>
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
                        <label class="form-control-label">Start Time <span class="required">*</span></label>
                        <input type="datetime" class="form-control datetime" name="startdate" 
                            placeholder="Start Time" value="{{ old('startdate') }}" />
                        <!-- <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span> -->
                    </div>

                    <div class="form-group col-md-4">
                        <label class="form-control-label">End Time <span class="required">*</span></label>
                        <input type="datetime" class="form-control datetime" name="enddate" 
                            placeholder="End Time" value="{{ old('enddate') }}" />
                        <!-- <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span> -->
                    </div>

                    <div class="form-group col-md-4">
                        <label class="form-control-label">Status <span class="required">*</span></label>
                        <select class="form-control" name="status">
                            <option value="">Select</option>
                            <option value="0" {{ old('user_id') == '0' ? 'selected' : '' }}>Pending</option>
                            <option value="1" {{ old('user_id') == '1' ? 'selected' : '' }}>Accepted</option>
                            <option value="2" {{ old('user_id') == '2' ? 'selected' : '' }}>Rejected</option>
                            <option value="3" {{ old('user_id') == '3' ? 'selected' : '' }}>Cancelled</option>
                            <option value="4" {{ old('user_id') == '4' ? 'selected' : '' }}>Completed</option>
                        </select>
                        
                        @if ($errors->has('status'))
                            <label class="error" for="status">{{ $errors->first('status') }}</label>
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
        $("#appointmentForm").validate({
            rules: {
                title: {
                    required: true
                },
                user_id: {
                    required: true
                },
                course_id: {
                    required: true
                },
                lecture_id: {
                    // required: true
                },
                startdate: {
                    required: true
                },
                enddate: {
                    required: true
                }
            },
            messages: {
                title: {
                    required: 'The title field is required.'
                },
                user_id: {
                    required: 'The student field is required.'
                },
                course_id: {
                    required: 'The course field is required.'
                },
                lecture_id: {
                    // required: 'The lecture field is required.'
                },
                startdate: {
                    required: 'The start date field is required.'
                },
                enddate: {
                    required: 'The end date field is required.'
                }
            }
        });

        $("#course_id").on("change", function() {
            var course_id = $(this).val();
            var _token = $('input[name="_token"]').val();
            $(".loading_main").show();
            $.ajax ({
                type: "POST",
                url: '{{url("appointment/getlecture")}}',
                data: "&course_id="+course_id+"&_token="+_token,
                success: function (response) {
                    $(".loading_main").hide();
                    if ( response ) {
                        $("#lecture_id").html('<option value="">Select</option>');
                        $.each(response, function(i, e) {
                            $("#lecture_id").append('<option value="' + i + '">' + e + '</option>');
                        });
                    }
                }
            });
        });

        $(".datetime").datetimepicker();
    });
</script>
@endsection