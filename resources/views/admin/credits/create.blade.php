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
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('credits.home') }}">Credits</a></li>
        <li class="breadcrumb-item active">Add</li>
    </ol>
    <h1 class="page-title">Add Credits</h1>
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
          
            <form method="POST" action="{{ route('admin.credits.create') }}" id="appintmentForm">
                {{ csrf_field() }}
                <div class="row">
        

                    <div class="form-group col-md-4">
                        <label class="form-control-label">Student <span class="required">*</span></label>
                        <select required class="form-control" name="user_id" id="user_id">
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
                        <label class="form-control-label">Hours <span class="required">*</span></label>
                        <input required type="number" class="form-control" name="hours" placeholder="No. of hours" />
                            @if ($errors->has('title'))
                                <label class="error" for="title">{{ $errors->first('title') }}</label>
                            @endif
                    </div>


                    <div class="form-group col-md-4">
                        <label class="form-control-label">Languages <span class="required">*</span></label>
                        <select required class="form-control" name="lang_id" id="lang_id">
                            <option value="">Select</option>
                            @foreach($languages as $lang)
                                <option value="{{ $lang->id }}">
                                    {{ $lang->course_title }}
                                </option>
                            @endforeach
                        </select>
                        
                        @if ($errors->has('lang_id'))
                            <label class="error" for="user_id">{{ $errors->first('lang_id') }}</label>
                        @endif
                    </div>


                    <div class="form-group col-md-4">
                        <label class="form-control-label">Start Time <span class="required">*</span></label>
                        <input type="datetime" class="form-control datetime" name="start_time" 
                        placeholder="Start Time" value="{{ old('startdate') }}" />    
                    </div>

                    <div class="form-group col-md-4">
                        <label class="form-control-label">End Time <span class="required">*</span></label>
                        <input type="datetime" class="form-control datetime" name="end_time" 
                        placeholder="End Time" value="{{ old('enddate') }}" />    
                    </div>

                    <div class="form-group col-md-4">
                        <label class="form-control-label">Max. Number of cancellable credits <span class="required">*</span></label>
                        <input required  type="number" class="form-control" name="max_credits" placeholder="No. of hours" value="{{ old('title') }}" />
                            @if ($errors->has('title'))
                                <label class="error" for="title">{{ $errors->first('title') }}</label>
                            @endif
                    </div>

                    <div class="form-group col-md-4">
                        <label class="form-control-label">Hours per week</label>
                        <input  type="number" class="form-control" name="weekly_hours" placeholder="No. of hours" value="{{ old('title') }}" />
                            @if ($errors->has('title'))
                                <label class="error" for="title">{{ $errors->first('title') }}</label>
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
<script>
    $(document).ready(function() {
        $(document).on('submit', 'form', function() {
            $('button').attr('disabled', 'disabled');
        });
    });
    </script>
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
                instructor_id: {
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
                instructor_id: {
                    required: 'The instruction field is required.'
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

        // $("#instructor_id").on("change", function() {
        //     var instructor_id = $(this).val();
        //     var _token = $('[name="_token"]').val();
        //     $(".loading_main").show();
        //     $.ajax ({
        //         type: "POST",
        //         url: '{{url("admin/appointment/getcourse")}}',
        //         data: "&instructor_id="+instructor_id+"&_token="+_token,
        //         success: function (response) {
        //             $(".loading_main").hide();
        //             if ( response ) {
        //                 $("#course_id").html('<option value="">Select</option>');
        //                 $.each(response, function(i, e) {
                            
        //                     $("#course_id").append('<option value="' + i + '">' + e + '</option>');
        //                 });
        //             }
        //         }
        //     });
        // });

        // $("#course_id").on("change", function() {
        //     var course_id = $(this).val();
        //     var _token = $('input[name="_token"]').val();
        //     $(".loading_main").show();
        //     $.ajax ({
        //         type: "POST",
        //         url: '{{url("admin/appointment/getlecture")}}',
        //         data: "&course_id="+course_id+"&_token="+_token,
        //         success: function (response) {
        //             $(".loading_main").hide();
        //             if ( response ) {
        //                 $("#lecture_id").html('<option value="">Select</option>');
        //                 $.each(response, function(i, e) {
        //                     $("#lecture_id").append('<option value="' + i + '">' + e + '</option>');
        //                 });
        //             }
        //         }
        //     });
        // });

        $(".datetime").datetimepicker();
    });
</script>
@endsection