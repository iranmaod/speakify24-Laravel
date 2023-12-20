@extends('layouts.frontend.index')
@section('content')
<!-- content start -->
    <style type="text/css">
        /*form styles*/
        #msform {
            text-align: center;
            position: relative;
            margin-top: 30px;
        }
        #msform fieldset {
            background: white;
            border: 0 none;
            border-radius: 0px;
            padding: 20px 30px;
            box-sizing: border-box;
            width: 80%;
            margin: 0 10%;
            /*stacking fieldsets above each other*/
            position: relative;
        }
        /*Hide all except first fieldset*/
        #msform fieldset:not(:first-of-type) {
            display: none;
        }
        /*inputs*/
        #msform input, #msform textarea {
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 0px;
            margin-bottom: 10px;
            width: 100%;
            box-sizing: border-box;
            color: #2C3E50;
            font-size: 13px;
        }
        #msform input[type="radio"]{
            display: none;
        }
        #msform input[type="radio"] + label{
            border-radius: 6px;
            background-color: #fff;
            box-shadow: 0 2px 12px rgb(0 40 117 / 6%);
            background-color: #fff;
            text-align: left;
            display: block;
            padding:0px 20px;
            border:1px solid transparent;
            max-width: 700px;
            margin: 10px auto;
            cursor: pointer;
        }
        #msform input[type="radio"] + label .bookCard-priceNew{
                font-size: 14px;
                font-weight: 500;
                padding: 8px 20px;
                display: block;
                border-radius: 50px;
                background-color: #d5e8fd;
                color: #007cff;
        }
        #msform input[type="radio"] + label:hover{
            box-shadow: 0 2px 8px rgb(0 40 117 / 10%);
        }
        #msform input[type="radio"]:checked + label{
            border-color:#007CFF;
            background-color: #e6f2ff;
        }
        #msform #lesson_plan_pack input[type="radio"] + label{
            height: 70px;
            line-height: 70px;
            font-size: 16px;
            color: #007cff;
        }
        #msform input:focus, #msform textarea:focus {
            -moz-box-shadow: none !important;
            -webkit-box-shadow: none !important;
            box-shadow: none !important;
            border: 1px solid #007CFF;
            outline-width: 0;
            transition: All 0.5s ease-in;
            -webkit-transition: All 0.5s ease-in;
            -moz-transition: All 0.5s ease-in;
            -o-transition: All 0.5s ease-in;
        }
        /*buttons*/
        #msform .action-button {
            width: 100px;
            background: #007CFF;
            font-weight: bold;
            color: white;
            border: 0 none;
            border-radius: 25px;
            cursor: pointer;
            padding: 10px 5px;
            margin: 10px 5px;
        }
        #msform .action-button:hover, #msform .action-button:focus {
            box-shadow: 0 0 0 2px white, 0 0 0 3px #007CFF;
        }
        #msform .action-button-previous {
            width: 100px;
            background: #C5C5F1;
            font-weight: bold;
            color: white;
            border: 0 none;
            border-radius: 25px;
            cursor: pointer;
            padding: 10px 5px;
            margin: 10px 5px;
        }
        #msform .action-button-previous:hover, #msform .action-button-previous:focus {
            box-shadow: 0 0 0 2px white, 0 0 0 3px #C5C5F1;
        }
        /*headings*/
        .fs-title {
            font-size: 18px;
            text-transform: uppercase;
            color: #2C3E50;
            margin-bottom: 10px;
            letter-spacing: 2px;
            font-weight: bold;
        }
        .fs-subtitle {
            font-weight: normal;
            font-size: 13px;
            color: #666;
            margin-bottom: 20px;
        }
        /*progressbar*/
        #progressbar {
            margin-bottom: 30px;
            overflow: hidden;
            /*CSS counters to number the steps*/
            counter-reset: step;
        }
        #progressbar li {
            list-style-type: none;
            text-transform: uppercase;
            font-size: 9px;
            width: 50%;
            /* float: left; */
            position: relative;
            letter-spacing: 1px;
        }
        #progressbar li:before {
            content: counter(step);
            counter-increment: step;
            width: 24px;
            height: 24px;
            line-height: 26px;
            display: block;
            font-size: 12px;
            color: #333;
            background: #efefef;
            border-radius: 25px;
            margin: 0 auto 10px auto;
        }
        /*progressbar connectors*/
        #progressbar li:after {
            content: '';
            width: 96%;
            height: 2px;
            background: #efefef;
            position: absolute;
            left: -47.7%;
            top: 9px;
        }
        #progressbar li:first-child:after {
            /*connector not needed before the first step*/
            content: none;
        }
        /*marking active/completed steps green*/
        /*The number of the step and the connector before it = green*/
        #progressbar li.active:before, #progressbar li.active:after {
            background: #007CFF;
            color: white;
        }
        /* Not relevant to this form */
        .dme_link {
            margin-top: 30px;
            text-align: center;
        }
        .dme_link a {
            background: #FFF;
            font-weight: bold;
            color: #007CFF;
            border: 0 none;
            border-radius: 25px;
            cursor: pointer;
            padding: 5px 25px;
            font-size: 12px;
        }
        .dme_link a:hover, .dme_link a:focus {
            background: #C5C5F1;
            text-decoration: none;
        }
        #myLessonModalNew .modal-body{
            height: 100vh;
        }
        #myLessonModalNew .modal-header h4{
            width: 100%;
            text-align: center;
        }
        .fc-day-today {
            background-color: inherit !important;
        }
        .fc-timegrid-event-harness {
            left: -2px !important;
            right: -2px !important;
        }
        .fc-timegrid-event {
            border-radius: 0px !important;
            height: 100% !important;
        }
    </style>
    <div class="container-fluid p-0 home-content bg-gray">
        <!-- banner start -->
       <!--  <div class="subpage-slide-blue">
            <div class="container">
                <h1>{{ $instructor->first_name.' '.$instructor->last_name }}</h1>
            </div>
        </div> -->
        <!-- banner end -->

        <!-- breadcrumb start -->
           <!--  <div class="breadcrumb-container">
                <div class="container">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('instructor.list') }}">Teacher</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $instructor->first_name.' '.$instructor->last_name }}</li>
                  </ol>
                </div>
            </div> -->
        
        <!-- breadcrumb end -->
        
        <div class="container mt-5 pt-4">
            <?php
            $session = \App::getLocale();
            if (session()->get('locale') != '') {
                $session = session()->get('locale');
            }

        ?>
            <div class="row mt-4">
                <div class="col-md-8">
                    <!--
                    <div class="vide-cover-main">
                        <div class="video-cover">
                            <?php
                            $youtube = '';
                            if (strpos($instructor->link_youtube, 'watch?v=') !== false) {
                                $link = explode('watch?v=', $instructor->link_youtube);
                                $youtube = end($link);
                            } else {
                                $link = explode('/', $instructor->link_youtube);
                                $youtube = end($link);
                            }
                            ?>
                            @if($youtube == '')
                                <video width="300" height="240" poster="/frontend/videos/intro-video.jpg">
                                    <source src="/frontend/videos/intro-video.mp4" type="video/mp4">
                                </video>
                                <div class="Video-mask"><img src="https://scdn.italki.com/orion/static/media/video_play_button.3c6220f8.svg" alt="" class="playbtn"></div>
                            @else
                                <iframe height="360px" width="100%" src="https://www.youtube.com/embed/{{--$youtube--}} "></iframe>
                            @endif
                        </div>
                    </div>
                    -->

                    <div class="row profile-introMain" style="margin-top:0px;">
                        <div class="col profileimage-col">
                            <div class="teacher-profileimage" style="background-image:url('@if(Storage::exists($instructor->instructor_image)){{ str_replace(' ', '%20', Storage::url($instructor->instructor_image)) }}@else{{ asset('backend/assets/images/course_detail_thumb.jpg') }}@endif')">
                                 <!-- <img src="@if(Storage::exists($instructor->instructor_image)){{ Storage::url($instructor->instructor_image) }}@else{{ asset('backend/assets/images/course_detail_thumb.jpg') }}@endif"> -->
                            </div>
                        </div>
                        <div class="col teacherdetails">
                            <h4>{{ $instructor->first_name.' '.$instructor->last_name }}</h4>
                            <div class="teacher-info">
                                {{ __('teacher.profteacher') }}
                            </div>
                            <!-- <div class="teacher-info">From <span>Australia</span></div>
                            <div class="teacher-info">Living in Madrid, Spain (16:35 UTC+01:00)</div> -->
                            <div class="teacher-info">
                                {{ __('teacher.from') }}   
                            <span>{{ $instructor->country_name }}</span></div>
                            <div class="teacher-info">
                                
                                {{ __('teacher.livingin') }}
                                {{ $instructor->city }}, {{ $instructor->country_name }}</div>
                            <p class="card-divider"></p>
                            {{-- <ul class="list-unstyled social-icons">
                                    <li>
                                        <a href="{{ $instructor->link_facebook }}" target="_blank">
                                            <i class="fab fa-facebook-f"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ $instructor->link_linkedin }}" target="_blank">
                                            <i class="fab fa-linkedin-in"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ $instructor->link_twitter }}" target="_blank">
                                            <i class="fab fa-twitter"></i>
                                        </a>
                                    </li>
                                    
                                    <li>
                                        <a href="{{ $instructor->link_googleplus }}" target="_blank">
                                            <i class="fab fa-google-plus-g"></i>
                                        </a>
                                    </li>
                                </ul> --}}
                        </div>
                        <div class="col profile-rating">
                            <div class="like-main">
                                <i class="far fa-heart" aria-hidden="true"></i>
                            </div>
                            {{-- <div class="rating-main">
                                                <span><i class="fa fa-star" aria-hidden="true"></i></span>
                                                <span><i class="fa fa-star" aria-hidden="true"></i></span>
                                                <span><i class="fa fa-star" aria-hidden="true"></i></span>
                                                <span><i class="fa fa-star" aria-hidden="true"></i></span>
                                                <span><i class="fa fa-star" aria-hidden="true"></i></span>
                                                <span class="reating-sc">5.0</span>
                                            </div> --}}
                                            {{-- <p>{{ $metrics['courses'] }} LESSONS</p>
                                            <p>{{ $metrics['lectures'] }} LECTURES</p>
                                            <p>{{ $metrics['videos'] }} VIDEOS</p>
                                            <p>24 STUDENTS</p> --}}
                        </div>
                        <div class="col-md-12 pl-4 pr-4">
                            <hr class="mt-4">
                            <div class="">
                                <h4>
                                    {{ __('teacher.aboutme') }}
                                </h4>
                                <div class="des-main">{!! $instructor->who !!}</div>
                                <div class="des-main">{!! $instructor->experience !!}</div>
                                <div class="des-main">{!! $instructor->love_job !!}</div>
                            </div>
                        </div>
                    </div>

                    <div class="row profile-introMain ml-0">
                        <div class="px-4 py-2">
                            <div class="calendar  mx-auto mt-0" id="teacher_calendar">
                            </div>
                        </div>
                    </div>
                   
                    @if(isset($instructor->courses) && count($instructor->courses) > 0)
                    <div class="row">
                        <div class="col-12 text-center seperator-head mt-0">
                            <h4>Courses</h4>
                            <p class="mt-3">Courses taught by {{ $instructor->first_name.' '.$instructor->last_name }}</p>
                        </div>
                    </div>

                    <!-- course start -->
                    <div class="row">
                    @foreach($instructor->courses as $course)
                        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                            <div class="course-block mx-auto">
                            <a href="{{ route('course.view', $course->course_slug) }}">
                                <main>
                                    <img src="@if(Storage::exists($course->thumb_image)){{ Storage::url($course->thumb_image) }}@else{{ asset('backend/assets/images/course_detail_thumb.jpg') }}@endif">
                                    <div class="col-md-12"><h6 class="course-title">{{ $course->course_title }}</h6></div>
                                    
                                    <div class="instructor-clist">
                                        <div class="col-md-12">
                                            <i class="fa fa-chalkboard-teacher"></i>&nbsp;
                                            <span>Created by <b>{{ $course->first_name.' '.$course->last_name }}</b></span>
                                        </div>
                                    </div>
                                </main>
                                <footer>
                                    <div class="c-row">
                                        <div class="col-md-6 col-sm-6 col-6">
                                            @php $course_price = $course->price ? config('config.default_currency').$course->price : 'Free'; @endphp
                                            <h5 class="course-price">{{  $course_price }}&nbsp;<s>{{ $course->strike_out_price ? $course->strike_out_price : '' }}</s></h5>
                                        </div>
                                        <div class="col-md-5 offset-md-1 col-sm-5 offset-sm-1 col-5 offset-1">
                                            <star class="course-rating">
                                            @for ($r=1;$r<=5;$r++)
                                                <span class="fa fa-star {{ $r <= $course->average_rating ? 'checked' : '' }}"></span>
                                            @endfor
                                            </star>
                                        </div>
                                    </div>
                                </footer>
                             </a>   
                            </div>
                        </div>
                    @endforeach
                    </div>
                    <!-- course end -->
                    @endif
                </div>
                <div class="col-md-4 d-none d-md-block right_bar">
                    <!-- <div class="profile-introMain mx-auto mt-0">
                        <main>
                            <div class="col-12"></div>
                            <ul class="list-unstyled cf-pricing-li">
                                <li><i class="fa fa-chalkboard"></i>{{ $metrics['courses'] }} Courses</li>
                                <li><i class="fas fa-bullhorn"></i>Lectures: {{ $metrics['lectures'] }}</li>
                                <li><i class="far fa-play-circle"></i>Videos: {{ $metrics['videos'] }}</li>
                            </ul>
                        </main>
                    </div> -->
                <!--
                    <div class="teacher-book profile-introMain mt-0">
                        <div class="bookCards">
                            @foreach($lessons as $key => $lesson)
                            <?php if($key < 2) { ?>
                                <div class="bookCard-box">
                                    <div class="bookCard">
                                        <div class="bookCard-left">
                                            <div class="bookCard-title"><span>{{$lesson->title}}</span></div></div>
                                        <div class="bookCard-right">
                                            <div class="bookCard-priceNew"><span>USD {{$lesson->price}}</span></div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            @endforeach

                            @if(Auth::user())
                                <a href="javascript:void(0);" onclick="$(makeModal()).modal('show');" class="btn btn-lg btn-block login-page-button"><span>BOOK NOW</span></a>
                            @else
                                <a href="{{ url('login') }}" class="btn btn-lg btn-block login-page-button"><span>BOOK NOW</span></a>
                            @endif
                        </div>
                    </div>
                -->

                    <div class="rightRegisterForm profile-introMain ml-0 mt-0">
                        <!-- <div class="box-header">
                            Drop a Message
                        </div> -->
                        <div class="px-4 py-2">
                            <form class="form-horizontal" method="POST" action="{{ route('contact.instructor') }}" id="instructorForm">
                                {{ csrf_field() }}
                                <input type="hidden" name="instructor_email" value="{{ $instructor->contact_email }}">
                                <div class="form-group">
                                    <div class="form-group">
                                    <label>
                                        {{ __('teacher.fullName') }}
                                    </label>
                                    <input type="text" class="form-control form-control-sm" placeholder="{{ __('teacher.fullName') }}" name="full_name">
                                </div>
                                </div>
                                <div class="form-group">
                                    <label>Email ID</label>
                                    <input type="text" class="form-control form-control-sm" placeholder="Email ID" name="email_id">
                                </div>

                                <div class="form-group">
                                    <label>
                                        {{ __('teacher.message') }}
                                    </label>
                                    <textarea class="form-control form-control" placeholder="{{ __('teacher.message') }}" name="message"></textarea>
                                </div>

                                <div class="form-group mt-4  mb-0">
                                    <button type="submit" class="btn btn-lg btn-block login-page-button">
                                        {{ __('teacher.sendmsg') }}
                                    </button>
                                </div>
                            </form>

                        </div>
                    </div>
                    
                </div>
                
            </div>
        </div>

        <div id="myLessonModalNew" class="modal fade" role="dialog" style="display: none">
            <div class="modal-dialog modal-fullscreen mw-100">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{ __('teacher.selectplan') }}</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form id="msform" method="post" action="{{ url('/') }}">
                                    @csrf
                                    <input type="hidden" name="time" value="" />
                                    <ul id="progressbar">
                                        <li class="active">{{ __('teacher.selectplan') }}</li>
                                    </ul>

                                    <fieldset id="lesson_plan_pack">
                                        
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="hourly_package_detail" class="modal fade" role="dialog" style="display: none;background-color: #000000ad;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                @foreach($hourconfig as $con)
                                    {!!  str_replace('../../', '../', $con->option_value) !!}
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="monthly_plan_detail" class="modal fade" role="dialog" style="display: none;background-color: #000000ad;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                @foreach($monthconfig as $con)
                                    {!!  str_replace('../../', '../', $con->option_value) !!}
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        <?php
            $credits = 0;
            $credits_end = Date('Y-m-d' , strtotime('+1 year'));
            date_default_timezone_set('Europe/London');
            $endTime = date('Y-m-d H:i:s');   
    
            $cred = \DB::table('students_credits')
                    ->where('user_id',Auth::id())
                    ->where('lang_id',$course->id)
                    ->where('hours','>',0)
                    ->where('start_time','<',$endTime)
                    ->where('end_time','>',$endTime)
                    ->latest()->first();

                 
            if(isset($cred))
            {
                $credits = $cred->hours;
                $credits_end = $cred->end_time;
            }  
            // echo '<pre>';
            // print_r($cred);exit;          

        ?>

        <form id="adminappointform" method="post" action="{{ url('/adminaddappointment') }}">
            @csrf
            <input type="hidden" name="time" value="" />
            <input type="hidden" name="course_id" value="" />
            <input type="hidden" name="instructor_id" value="" />
            <input type="hidden" name="credits" value="{{$credits}}" />
        </form>



        <form id="appointform" method="post" action="{{ url('/addappointment') }}">
            @csrf
            <input type="hidden" name="time" value="" />
            <input type="hidden" name="course_id" value="" />
            <input type="hidden" name="instructor_id" value="" />
            <input type="hidden" name="transaction_id" value="" />
        </form>

@endsection

@section('javascript')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
<script type="text/javascript">
var credits = "<?php echo $credits; ?>";
var end = "{{$credits_end ? $credits_end : ''}}";
var credits_end = new Date(end)
console.log(credits_end)
    var schedule = [];

    var appointment = [];
    var time_used = [];
    @foreach($appointments as $appointment)
        <?php
            $tm_df = isset($_COOKIE['offset'])?$_COOKIE['offset']:'00';
            $appStart = date("Y-m-d H:i:s", strtotime("+" .$tm_df. " minutes", strtotime($appointment->startdate)));
            $appEnd = date("Y-m-d H:i:s", strtotime("+" .$tm_df. " minutes", strtotime($appointment->enddate)));
        ?>
        appointment.push({
            id: '{{$appointment->id}}',
            start: '{{str_replace(" ","T",$appStart)}}',
            end: '{{str_replace(" ","T",$appEnd)}}',
            title: '{{$appointment->title}}',
        });
    @endforeach
    
    <?php
    if ($instructor->schedule != '') {
        $schedule = json_decode($instructor->schedule);
        $selectDay = $schedule->select_day;
        $start = $schedule->start;
        $end = $schedule->end;

        foreach($selectDay as $key => $day) {
            $endTime = $end[$key];
            $endTime == '00:00' ? $endTime = '24:00' : $endTime = $end[$key];
            ?>
            schedule.push({
                daysOfWeek: '{{$day}}',
                startTime: '{{$start[$key]}}',
                endTime: '{{$endTime}}',
            });

            appointment.push({
                groupId: 'availableForMeeting',
                startTime: '{{$start[$key]}}',
                endTime: '{{$endTime}}',
                display: 'background',
                daysOfWeek: '{{$day}}',
            });
            <?php
        }
    }
    ?>
    var lessons = [];
    @foreach($lessons as $lesson)
        lessons.push({
            id: '{{$lesson->lecture_quiz_id}}',
            title: '{{$lesson->title}}',
            price: '{{$lesson->price}}',
            description: '{{$lesson->description}}',
        });
    @endforeach

    var course = [];
    @if($course)
        course.push({
            course_id: '{{$course->id}}',
            title: '{{$course->course_title}}'
        });
    @endif
    
    @if($course)
        time_used = {
            hours: '{{$hours}}',
            spent: '{{$spent}}',
            remaining: '{{$remaining}}',
            transaction_id: '{{$transaction_id}}',
            course_id: '{{$course->id}}',
            end_time: '{{$end_time}}',
        };
    @else
        time_used = {
            hours: '{{$hours}}',
            spent: '{{$spent}}',
            remaining: '{{$remaining}}',
            transaction_id: '{{$transaction_id}}',
            course_id: '0',
            end_time: '{{$end_time}}',
        };
    @endif

    $(document).ready(function() {
        var today = new Date();
        $('body').on('hidden.bs.modal', '.modal', function () {
            setTimeout(function() {
                var element = document.getElementById("myCalendarModalNew");
                if (element != null && element != undefined) {
                    element.parentNode.removeChild(element);
                }

                if (document.getElementById("myLessonModalNew") != null && document.getElementById("myLessonModalNew") != undefined) {
                    $("#progressbar li").removeClass('active');
                    $("#progressbar li:first").addClass('active');
                    $("#msform fieldset").hide();
                    $("#msform fieldset:first").show();
                    $("#msform fieldset:first").removeAttr('style');
                }
            }, 100);
        }); 

        $('.video-cover .Video-mask').click(function(){
            $(this).hide();
        });

        $("#instructorForm").validate({
            rules: {
                full_name: {
                    required: true
                },
                email_id:{
                    required: true,
                    email:true
                },
                message:{
                    required: true
                }
            },
            messages: {
                full_name: {
                    required: 'This field is required.'
                },
                email_id: {
                    required: 'This field is required.',
                    email: 'Please enter valid Email ID'
                },
                message: {
                    required: 'This field is required.'
                }
            }
        });

        var calendar = new FullCalendar.Calendar(document.getElementById('teacher_calendar'), {
            headerToolbar: {
                left: '',
                center: '',
                right: ''
            },
            dayHeaderContent: (args) => {
                var argDate = args.text;
                var dateParts = argDate.split(' ');
                var dayMonth = dateParts[1].split('/');
                var newText = dateParts[0] + ' ' + dayMonth[1] + '/' + dayMonth[0];

                return newText;
            },
            initialView: 'timeGridWeek',
            slotDuration: '04:00',
            slotLabelFormat: [{
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            }],
            height: 'auto',
            navLinks: false,
            nowIndicator: false,
            events: appointment,
            selectable: true,
            selectMirror: false,
            allDaySlot: false,
            longPressDelay: 0,
            firstDay: today.getDay(),
            eventTimeFormat: {
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            },
            businessHours: schedule,
            select: function(arg) {
                var modal = $(makeModal());
                modal.modal('show');
                calendar.unselect();
            },
        });

        calendar.render();

        
        @if($session_id)
            setTimeout(function() {
                var modal = $(makeModal());
                modal.modal('show');
            }, 500);
            // makeModal();
        @endif
    });

    function makeModal() {
        setTimeout(function() {
            loadCalender();
        }, 500);

        return '<div id="myCalendarModalNew" class="modal fade" role="dialog" style="display: none">\n\
            <div class="modal-dialog">\n\
                <div class="modal-content">\n\
                    <div class="modal-header">\n\
                        <button type="button" class="close" data-dismiss="modal">&times;</button>\n\
                        <h4 class="modal-title" id="calendarHeader"></h4>\n\
                    </div>\n\
                    <div class="modal-body" id="calendarModal">\n\
                    </div>\n\
                    <div class="modal-footer">\n\
                        <button type="button" class="btn btn-danger btn-large cm_btn" disabled onclick="openLessonModal();" data-dismiss="modal">{{ __('teacher.booklesson') }}</button>\n\
                    </div>\n\
                </div>\n\
            </div>\n\
        </div>';
    }

    function loadCalender() {
        var utilised = time_used;
      
        var today = new Date();
        var monthsArray = ['01','02','03','04','05','06','07','08','09','10','11','12'];
        var todayDate = today.getFullYear() + '-' + monthsArray[today.getMonth()] + '-' + today.getDate();
        if (today.getDate() < 10) {
            var todayDate = today.getFullYear() + '-' + monthsArray[today.getMonth()] + '-0' + today.getDate();
        }
        console.log(todayDate);
        var endDay = new Date(today.setDate(today.getDate() + 3 * 7));
        var enddayDate = endDay.getFullYear() + '-' + monthsArray[endDay.getMonth()] + '-' + endDay.getDate();
        if (endDay.getDate() < 10) {
            var enddayDate = endDay.getFullYear() + '-' + monthsArray[endDay.getMonth()] + '-0' + endDay.getDate();
        }
        console.log(enddayDate);
        var lastDay = new Date(utilised.end_time);
        console.log(utilised.remaining)
        var calendar = new FullCalendar.Calendar(document.getElementById('calendarModal'), {
            headerToolbar: {
                left: 'prev,next',
                center: 'title',
                right: ''
            },
            dayHeaderContent: (args) => {
                var argDate = args.text;
                var dateParts = argDate.split(' ');
                var dayMonth = dateParts[1].split('/');
                var newText = dateParts[0] + ' ' + dayMonth[1] + '/' + dayMonth[0];

                return newText;
            },
            titleFormat: {
                year: 'numeric',
                month: 'long'
            },
            initialView: 'timeGridWeek',
            slotDuration: '00:45',
            slotLabelFormat: [{
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            }],
            validRange: {
                start: todayDate,
                end: enddayDate
            },
            height: 'auto',
            navLinks: false,
            selectable: true,
            selectMirror: true,
            nowIndicator: false,
            longPressDelay: 0,
            allDaySlot: false,
            firstDay: today.getDay(),
            eventTimeFormat: {
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            },
            selectOverlap: function(event) {
                if (event._def.title != '') {
                    return false;
                }

                return true;
            },
            unselect: function(jsEvent, view) {
                if ( !$(func.jsEvent.target).hasClass('cm_btn') ) {
                    $(".cm_btn").attr('disabled', true);
                }
            },
            selectAllow: function(info) {
                var date = new Date();
                date.setDate(date.getDate() + 1);
                var startDate = date.getTime();

                if (info.start.getTime() < startDate || info.start.getTime() > lastDay.getTime()) {
                    return false;
                }

                if ( ( (new Date(info.end.getTime()) - new Date(info.start.getTime())) / 60 / 1000 ) > 45) {
                    return false;
                }

                return true;
            },
            select: function(arg) {
                $("input[name=time]").val(arg.startStr + '|' + arg.endStr);
                $("input[name=course_id]").val(utilised.course_id);
                $("input[name=instructor_id]").val('{{$instructor->user_id}}');
                $("input[name=transaction_id]").val(utilised.transaction_id);
                $(".cm_btn").removeAttr('disabled');
                var bookdate = new Date(arg.startStr);
                console.log(bookdate);
                console.log(credits_end);
                @if(\Auth::user())
                if(credits > 0)
                    {
                        if (utilised.remaining > 0 && lastDay < credits_end) {
                            $(".cm_btn").attr('onclick', 'appointForm();');
                        }
                        else if(credits > 0 && bookdate < credits_end){
                            $(".cm_btn").attr('onclick', 'adminappointform();');
                        }
                         else {
                            $(".cm_btn").attr('onclick', 'openLessonModal(' + id + ');');
                        }
                    }
                    if (utilised.remaining > 0) {
                        $(".cm_btn").attr('onclick', 'appointForm();');
                    }
                    else if(credits > 0 && bookdate < credits_end){
                        $(".cm_btn").attr('onclick', 'adminappointform();');
                    }
                    else {
                        $(".cm_btn").attr('onclick', 'openLessonModal();');
                    }
                @else
                    $.ajax({
                        type: "POST",
                        url: "{{ route('saveloginsession') }}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "time": arg.startStr + '|' + arg.endStr,
                            "course_id": utilised.course_id,
                            "instructor_id": '{{$instructor->user_id}}',
                            "transaction_id": utilised.transaction_id,
                        },
                        success: function (data) {
                            var data = JSON.parse(data);
                            console.log(data);
                        }
                    });
                    $(".cm_btn").attr('onclick', 'loginForm();');
                @endif
            },
            events: appointment,
            selectConstraint: "businessHours",
            businessHours: schedule
        });

        calendar.render();
    }

    function openLessonModal() {
        var insLesson = lessons;
        var cour = course[0];
        var modal = $("#myLessonModalNew");

        var id = '{{ $instructor->id }}';
        if (cour) {
            $("#lesson_plan_pack").html('<input type="radio" name="url" id="pac_1" onclick="courseUrl(this);" value="/choose-plan/'+cour.course_id+'/'+id+'/1" />\n\
            <label for="pac_1">{{ __('teacher.monthlyplan') }} </label><a href="javascript:void(0);" onclick="openPackagePlanModal(' + "'monthly_plan_detail'" + ');" style="float:right;margin-right:133px;margin-top:-60px;" class="btn btn-sm btn-primary">{{ __('teacher.details') }}</a><input type="radio" name="url" id="pac_2" onclick="courseUrl(this);" value="/choose-plan/'+cour.course_id+'/'+id+'/2" />\n\
            <label for="pac_2">{{ __('teacher.hourlyplan') }}</label><a href="javascript:void(0);" onclick="openPackagePlanModal(' + "'hourly_package_detail'" + ');" style="float:right;margin-right:133px;margin-top:-60px;" class="btn btn-sm btn-primary">{{ __('teacher.details') }}</a>\n\
            <div class="alert alert-danger" style="display:none;">Please select Package or Plan to proceed.</div>\n\
            <input onclick="checkPP(this);" type="button" name="submit" class="submit_pp submit action-button" value="{{ __('teacher.submit') }}" />');
        }
        
        modal.modal('show');
    }

    function openPackagePlanModal(ele) {
        var modal = $("#" + ele);
        modal.modal('show');
    }

    //jQuery time
    var current_fs, next_fs, previous_fs; //fieldsets
    var left, opacity, scale; //fieldset properties which we will animate
    var animating; //flag to prevent quick multi-click glitches

    function nextTab(ele) {
        if(animating) return false;
        animating = true;
        
        current_fs = $(ele).parent();
        next_fs = $(ele).parent().next();

        //activate next step on progressbar using the index of next_fs
        $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
        
        //show the next fieldset
        next_fs.show(); 
        //hide the current fieldset with style
        current_fs.animate({opacity: 0}, {
            step: function(now, mx) {
                //as the opacity of current_fs reduces to 0 - stored in "now"
                //1. scale current_fs down to 80%
                scale = 1 - (1 - now) * 0.2;
                //2. bring next_fs from the right(50%)
                left = (now * 50)+"%";
                //3. increase opacity of next_fs to 1 as it moves in
                opacity = 1 - now;
                current_fs.css({
                    'transform': 'scale('+scale+')',
                    'position': 'absolute'
                });
                next_fs.css({'left': left, 'opacity': opacity});
            }, 
            duration: 800, 
            complete: function(){
                current_fs.hide();
                animating = false;
            }, 
            //this comes from the custom easing plugin
            easing: 'easeInOutBack'
        });
    }

    function prevTab(ele) {
        if(animating) return false;
        animating = true;
        
        current_fs = $(ele).parent();
        previous_fs = $(ele).parent().prev();
        
        //de-activate current step on progressbar
        $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");
        
        //show the previous fieldset
        previous_fs.show(); 
        //hide the current fieldset with style
        current_fs.animate({opacity: 0}, {
            step: function(now, mx) {
                //as the opacity of current_fs reduces to 0 - stored in "now"
                //1. scale previous_fs from 80% to 100%
                scale = 0.8 + (1 - now) * 0.2;
                //2. take current_fs to the right(50%) - from 0%
                left = ((1-now) * 50)+"%";
                //3. increase opacity of previous_fs to 1 as it moves in
                opacity = 1 - now;
                current_fs.css({'left': left});
                previous_fs.css({'transform': 'scale('+scale+')', 'opacity': opacity});
            }, 
            duration: 800, 
            complete: function(){
                current_fs.hide();
                animating = false;
            }, 
            //this comes from the custom easing plugin
            easing: 'easeInOutBack'
        });
    }

    function checkPP(ele) {
        if ( $('#msform').attr('action') == 'https://speakify24.de' ) {
            $('.alert-danger').show();
        } else {
            $('.alert-danger').hide();
            $('#msform').submit();
        }
    }

    function courseUrl(ele) {
        var APP_URL = {!! json_encode(url('/')) !!}
        $('#msform').attr('action', APP_URL + $(ele).val());
        $('.alert-danger').hide();
        $('.submit_pp').removeAttr('onclick');
        $('.submit_pp').attr('type', 'submit');
    }

    function submitForm(ele) {
        var url = $("input[name=url]:checked").val();
        $('#msform').attr('action', url);
        setTimeout(function() {
            $('#msform').submit();
        }, 100);
    }

    function appointForm() {
        $('#appointform').submit();
    }

    function adminappointform() {
            $('#adminappointform').submit();
    }

    function loginForm() {
        window.location = {!! json_encode(url('/')) !!} + "/login";
    }

    $(".next").click(function(){
        if(animating) return false;
        animating = true;
        
        current_fs = $(this).parent();
        next_fs = $(this).parent().next();
        
        //activate next step on progressbar using the index of next_fs
        $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
        
        //show the next fieldset
        next_fs.show(); 
        //hide the current fieldset with style
        current_fs.animate({opacity: 0}, {
            step: function(now, mx) {
                //as the opacity of current_fs reduces to 0 - stored in "now"
                //1. scale current_fs down to 80%
                scale = 1 - (1 - now) * 0.2;
                //2. bring next_fs from the right(50%)
                left = (now * 50)+"%";
                //3. increase opacity of next_fs to 1 as it moves in
                opacity = 1 - now;
                current_fs.css({
                    'transform': 'scale('+scale+')',
                    'position': 'absolute'
                });
                next_fs.css({'left': left, 'opacity': opacity});
            }, 
            duration: 800, 
            complete: function(){
                current_fs.hide();
                animating = false;
            }, 
            //this comes from the custom easing plugin
            easing: 'easeInOutBack'
        });
    });

    $(".previous").click(function(){
        if(animating) return false;
        animating = true;
        
        current_fs = $(this).parent();
        previous_fs = $(this).parent().prev();
        
        //de-activate current step on progressbar
        $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");
        
        //show the previous fieldset
        previous_fs.show(); 
        //hide the current fieldset with style
        current_fs.animate({opacity: 0}, {
            step: function(now, mx) {
                //as the opacity of current_fs reduces to 0 - stored in "now"
                //1. scale previous_fs from 80% to 100%
                scale = 0.8 + (1 - now) * 0.2;
                //2. take current_fs to the right(50%) - from 0%
                left = ((1-now) * 50)+"%";
                //3. increase opacity of previous_fs to 1 as it moves in
                opacity = 1 - now;
                current_fs.css({'left': left});
                previous_fs.css({'transform': 'scale('+scale+')', 'opacity': opacity});
            }, 
            duration: 800, 
            complete: function(){
                current_fs.hide();
                animating = false;
            }, 
            //this comes from the custom easing plugin
            easing: 'easeInOutBack'
        });
    });
</script>
@endsection