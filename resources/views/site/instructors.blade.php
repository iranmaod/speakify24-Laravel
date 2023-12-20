@extends('layouts.frontend.index')
@section('content')
    <!-- content start -->
<!-- <pre><?php //print_r($instructors); ?></pre><?php //exit; ?> -->
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
            padding-left: 0px;
        }
        #progressbar li {
            list-style-type: none;
            text-transform: uppercase;
            font-size: 9px;
            width: 50%;
            /* float: left; */
            position: relative;
            letter-spacing: 1px;
            margin: 0px auto;
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
        .nav-profile_info{
            overflow: auto;
            max-height: 220px;
        }
        /*
        .fc-timegrid-event-harness {
            left: -2px !important;
            right: -2px !important;
        }
        .fc-timegrid-event {
            border-radius: 0px !important;
            height: 100% !important;
        }
        */
    </style>

    <div class="container-fluid p-0 home-content">

        <?php
        $session = \App::getLocale();
        if (session()->get('locale') != '') {
            $session = session()->get('locale');
        }
        
       
           
        ?>
   
        <!-- banner start -->
      
        <!-- banner end -->

        <!-- breadcrumb start -->
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-9 col-sm-12 mx-auto mt-5">
                    <form method="GET" action="{{ route('instructor.list') }}" id="courseList">
                        <span class="blue-title">
                            {{ __('teacher.filterresult') }}
                        </span>
                        @if($_GET)
                            <a href="{{ route('instructor.list') }}" class="clear-filters"><i class="fa fa-sync"></i>&nbsp;
                                {{ __('teacher.filterclear') }}
                            </a>
                        @endif
                        <h6 class="mt-2 underline-heading">Languages</h6>
                        <ul class="ul-no-padding languages_ul">
                            @foreach ($categories as $category)
                            <li> 
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input filter-results" id="{{ 'cat-'.$category->id }}" name="language_id[]" value="{{ $category->id }}" 
                                    @if(isset($_GET['language_id']))
                                        {{ in_array($category->id, $_GET['language_id']) ? 'checked' : '' }}
                                    @endif
                                    >
                                    <label class="custom-control-label" for="{{ 'cat-'.$category->id }}">{{ $category->title }}</label>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </form>
                </div>
            </div>

            <!-- instructor block start -->
            <article class="instructor-block">
                @if ( count( $instructors ) > 0 )
                <div class="container">
                    <div class="row mt-4 mb-5">
                        @foreach($instructors as $instructor)
                        <div class="col-md-9 col-sm-12 mx-auto">
                            <div class="instructor-box mx-auto row">
                                <div class="col-md-6">
                                    <main>
                                        <div class="row">
                                            <div class="teacher-imgmain text-center col">
                                                <a href="{{ route('instructor.view', $instructor->instructor_slug) }}">
                                                <span class="imgwrp" style="background-image: url('@if(Storage::exists($instructor->instructor_image)){{ str_replace(' ', '%20', Storage::url($instructor->instructor_image)) }}@else{{ asset('backend/assets/images/course_detail_thumb.jpg') }}@endif');">
                                                   <!--  <img src="@if(Storage::exists($instructor->instructor_image)){{ Storage::url($instructor->instructor_image) }}@else{{ asset('backend/assets/images/course_detail_thumb.jpg') }}@endif"> -->
                                                </span>
                                                </a>
                                                <!--  <div class="rating-main">
                                                    <span><i class="fa fa-star" aria-hidden="true"></i></span>
                                                    <span><i class="fa fa-star" aria-hidden="true"></i></span>
                                                    <span><i class="fa fa-star" aria-hidden="true"></i></span>
                                                    <span><i class="fa fa-star" aria-hidden="true"></i></span>
                                                    <span><i class="fa fa-star" aria-hidden="true"></i></span>
                                                    <span class="reating-sc">5.0</span>
                                                </div> -->
                                                {{-- <div class="total-lessons">{{$instructor->metrics['lectures']}} Lessons</div> --}}
                                                <div class="book-btn">
                                                    <a href="javascript:void(0);" onclick="$(makeModal({{$instructor->user_id}}, 'Somehting here')).modal('show');" class="btn btn-ulearn">
                                                        {{ __('teacher.book') }}
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <a href="{{ route('instructor.view', $instructor->instructor_slug) }}">
                                                    <h6 class="instructor-title">
                                                        {{ $instructor->first_name }}
                                                    </h6>
                                                </a>
                                                <p class="teacher-cart">
                                                    {{ __('teacher.profteacher') }}
                                                </p>
                                                <p class="card-divider"></p>
                                                <span class="span-label">
                                                    {{ __('teacher.teacher') }}
                                                </span>
                                                <p class="teacher-lang">{{$instructor->taught}}</p>
                                                <!--  <div class="row">
                                                    <div class="col-md-6 hourly-price">
                                                        <span class="span-label">Hourly Rate From</span>
                                                        <p>USD 60.00</p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="trial-price">
                                                        <span class="span-label">TRIAL</span>
                                                        <p>USD 26.00</p>
                                                    </div>
                                                    </div>
                                                </div> -->
                                            </div>
                                        </div>
                                    </main>
                                </div>
                                <div class="col-md-6">
                                    <div class="row" id="tabs{{ $instructor->user_id }}">
                                        <div class="nav nav-tabs nav-fill" id="nav-tab{{ $instructor->user_id }}" role="tablist">
                                            <!-- <a class="nav-item nav-link" id="nav-home-tab{{ $instructor->user_id }}" data-toggle="tab" href="#nav-home{{ $instructor->user_id }}" role="tab" aria-controls="nav-home" aria-selected="true">Video</a> -->
                                            <a class="nav-item nav-link active" id="nav-profile-tab{{ $instructor->user_id }}" data-toggle="tab" href="#nav-profile{{ $instructor->user_id }}" role="tab" aria-controls="nav-profile" aria-selected="false">
                                                {{ __('teacher.intro') }}
                                            </a>
                                            <a class="nav-item nav-link nav-contact" id="nav-contact-tab{{ $instructor->user_id }}" data-toggle="tab" href="#nav-contact{{ $instructor->user_id }}" role="tab" aria-controls="nav-contact" aria-selected="false">
                                                {{ __('teacher.calendar') }}
                                            </a>
                                        </div>
                                        <div class="tab-content py-3 px-3 px-sm-0 col-md-12" id="nav-tabContent{{ $instructor->user_id }}">
                                            <!-- <div class="tab-pane fade" id="nav-home{{ $instructor->user_id }}" role="tabpanel" aria-labelledby="nav-home-tab{{ $instructor->user_id }}">
                                                <div class="video-banner">
                                                    <div class="video-player">
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
                                                            <img src="frontend/img/youtube.png" alt="poster">
                                                        @else
                                                            <iframe height="100%" width="100%" src="https://www.youtube.com/embed/{{$youtube}} "></iframe>
                                                        @endif
                                                        <div class="play-btn"><i class="fa fa-play-circle-o" aria-hidden="true"></i></div>
                                                    </div>
                                                </div>
                                            </div> -->
                                            <div class="tab-pane fade show active" id="nav-profile{{ $instructor->user_id }}" role="tabpanel" aria-labelledby="nav-profile-tab{{ $instructor->user_id }}">
                                                <div class="nav-profile_info">
                                                    {!! mb_strimwidth($instructor->who, 0, 120, ".....") !!}
                                                    {!! mb_strimwidth($instructor->experience, 0, 120, ".....") !!}
                                                    {!! mb_strimwidth($instructor->love_job, 0, 120, ".....") !!}
                                                </div>
                                            </div>
                                            <div class="tab-pane fade nav-contact" id="nav-contact{{ $instructor->user_id }}" role="tabpanel" aria-labelledby="nav-contact-tab{{ $instructor->user_id }}">
                                                <div class="calendar" id="cal_{{ $instructor->user_id }}">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <!-- pagination start -->
                <div class="paginationMain">
                    {{ $instructors->links() }}
                </div>
                @endif
                <!-- pagination end -->
            </article>
            <!-- instructor block end -->
        </div>

        <?php
            $credits = 0;
            $credits_end = Date('Y-m-d' , strtotime('+1 year'));
            // date_default_timezone_set('Europe/Madrid');
            $endTime = date('Y-m-d H:i:s');
            $course_id =  \DB::table('courses')->where('id',$instructor->course->id)->first(); 
            
            if (\Auth::user()) {
                $cred = \DB::table('students_credits')
                        ->where('user_id', \Auth::user()->id)
                        ->where('lang_id', $course_id->id)
                        ->where('hours','>',0)
                        ->where('start_time','<',$endTime)
                        ->where('end_time','>',$endTime)
                        ->orderBy('end_time','asc')
                        ->latest()->first();
            }
                    
            if(isset($cred))
            {
                $credits = $cred->hours;
                $credits_end = $cred->end_time;
                
            }     
            // if ( \Auth::user()->id == '162' ) {
            //     echo'<pre>';
            //     print_r(\Auth::user()->id);
            //     print_r($course_id);
            //     print_r($cred);
            //     var_dump($credits);
            //     exit;
            // }
        ?>

        <form id="appointform" method="post" action="{{ url('/addappointment') }}">
            @csrf
            <input type="hidden" name="time" value="" />
            <input type="hidden" name="course_id" value="" />
            <input type="hidden" name="instructor_id" value="" />
            <input type="hidden" name="transaction_id" value="" />
        </form>

        <form id="adminappointform" method="post" action="{{ url('/adminaddappointment') }}">
            @csrf
            <input type="hidden" name="time" value="" />
            <input type="hidden" name="course_id" value="" />
            <input type="hidden" name="instructor_id" value="" />
            <input type="hidden" name="credits" value="{{$credits}}" />
        </form>

        <div id="myLessonModalNew" class="modal fade" role="dialog" style="display: none">
            <div class="modal-dialog modal-fullscreen mw-100">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            {{ __('teacher.selectplan') }}
                        </h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form id="msform" method="post" action="{{ url('/') }}">
                                    @csrf
                                    <input type="hidden" name="time" value="" />
                                    <ul id="progressbar">
                                        <li class="active">
                                            {{ __('teacher.selectplan') }}
                                        </li>
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
                                    {!!  str_replace('../../', '', $con->option_value) !!}
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
                                    {!!  str_replace('../../', '', $con->option_value) !!}
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
       
    <!-- content end -->
@endsection

@section('javascript')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
	<script type="text/javascript">
    var credits = "<?php echo $credits; ?>";
    
    var end = "{{$credits_end ? $credits_end : ''}}";
    var credits_end = new Date(end)
    // console.log(credits_end)
   
        $(document).ready(function() {
            $('.filter-results').change(function() {
                $('#courseList').submit();
            });

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
        });

        var events = [];
        var lessons = [];
        var course = [{}];
        var schedule = [];
        var time_used = [];
        @foreach($instructors as $instructor)
            @if($instructor->course)
                time_used['{{$instructor->user_id}}'] = {
                    hours: '{{$instructor->hours}}',
                    spent: '{{$instructor->spent}}',
                    remaining: '{{$instructor->remaining}}',
                    transaction_id: '{{$instructor->transaction_id}}',
                    course_id: '{{$instructor->course->id}}',
                    end_time: '{{$instructor->end_time}}',
                };
            @else
                time_used['{{$instructor->user_id}}'] = {
                    hours: '{{$instructor->hours}}',
                    spent: '{{$instructor->spent}}',
                    remaining: '{{$instructor->remaining}}',
                    transaction_id: '{{$instructor->transaction_id}}',
                    course_id: '0',
                    end_time: '{{$instructor->end_time}}',
                };
            @endif

            var instructor = [];
            @foreach($instructor->appointments as $appointment)
                <?php
                    $from_time = date("Y-m-d H:i:s");
                    $start = date("Y").env('DAYLIGHT_SAVING_START');
                    $end = date("Y").env('DAYLIGHT_SAVING_END');
                    $now = date("Y-m-d H:i:s");

                    if ($now >= $start && $now <= $end)
                    {
                        $diff = "-60 minutes";	
                    }
                    else
                    {
                        $diff = "-0 minutes";	
                    }
                    // $tm_df = isset($_COOKIE['offset'])?$_COOKIE['offset']:'00';
                    $appStart = date("Y-m-d H:i:s", strtotime($diff, strtotime($appointment->startdate)));
                    $appEnd = date("Y-m-d H:i:s", strtotime($diff, strtotime($appointment->enddate)));
                ?>

                instructor.push({
                    id: '{{$appointment->id}}',
                    start: '{{str_replace(" ","T",$appStart)}}',
                    end: '{{str_replace(" ","T",$appEnd)}}',
                    title: '{{$appointment->title}}',
                });
            @endforeach
            // events['{{$instructor->user_id}}'] = instructor;

            var tech_schedule = [];
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
                    tech_schedule.push({
                        daysOfWeek: '{{$day}}',
                        startTime: '{{$start[$key]}}',
                        endTime: '{{$endTime}}',
                    });

                    instructor.push({
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
            events['{{$instructor->user_id}}'] = instructor;
            schedule['{{$instructor->user_id}}'] = tech_schedule;
            
            var teacher = [];
            @foreach($instructor->lessons as $lesson)
                teacher.push({
                    id: '{{$lesson->lecture_quiz_id}}',
                    title: '{{$lesson->title}}',
                    price: '{{$lesson->price}}',
                    description: '{{$lesson->description}}',
                });
            @endforeach
            lessons['{{$instructor->user_id}}'] = teacher;

            @if($instructor->course)
                course['{{$instructor->user_id}}'] = {
                    course_id: '{{$instructor->course->id}}',
                    title: '{{$instructor->course->course_title}}'
                };
            @else
                course['{{$instructor->user_id}}'] = [];
            @endif
        @endforeach

        $(".nav-contact").on("click", function() {
            var today = new Date();
            var id = $(this).attr("id").split("nav-contact-tab");
            var id = id[1];
            if (id != undefined) {
                setTimeout(function() {
                    var calendar = new FullCalendar.Calendar(document.getElementById('cal_'+id), {
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
                        selectable: false,
                        selectMirror: false,
                        nowIndicator: false,
                        events: events[id],
                        selectable: true,
                        allDaySlot: false,
                        longPressDelay: 0,
        		        businessHours: schedule[id],
                        firstDay: today.getDay(),
                        eventTimeFormat: {
                            hour: '2-digit',
                            minute: '2-digit',
                            hour12: false
                        },
                        // selectMirror: true,
                        select: function(arg) {
                            var modal = $(makeModal(id, 'Somehting here'));
                            modal.modal('show');
                            calendar.unselect();
                        },
                    });

                    calendar.render();
                }, 200);
            }
        });

        function makeModal(id, text) {
            setTimeout(function() {
                loadCalender(id);
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
                            <button type="button" class="btn btn-danger btn-large cm_btn" disabled data-dismiss="modal" onclick="openLessonModal(' + id + ');"> {{ __('teacher.booklesson') }}</button>\n\
                        </div>\n\
                    </div>\n\
                </div>\n\
            </div>';
        }

        function loadCalender(id) {
            var utilised = time_used[id];
            
            var lastDay = new Date(utilised.end_time);
            // console.log(lastDay)
            var today = new Date();
            var monthsArray = ['01','02','03','04','05','06','07','08','09','10','11','12'];
            var todayDate = today.getFullYear() + '-' + monthsArray[today.getMonth()] + '-' + today.getDate();
            if (today.getDate() < 10) {
                var todayDate = today.getFullYear() + '-' + monthsArray[today.getMonth()] + '-0' + today.getDate();
            }
            var endDay = new Date(today.setDate(today.getDate() + 3 * 7));
            var enddayDate = endDay.getFullYear() + '-' + monthsArray[endDay.getMonth()] + '-' + endDay.getDate();
            if (endDay.getDate() < 10) {
                var enddayDate = endDay.getFullYear() + '-' + monthsArray[endDay.getMonth()] + '-0' + endDay.getDate();
            }
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
                longPressDelay: 0,
                allDaySlot: false,
                snapDuration: '01:30',
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
                unselect: function(func) {
                    console.log(func);
                    console.log(func.jsEvent);
                    console.log(func.jsEvent.target);
                    if ( !$(func.jsEvent.target).hasClass('cm_btn') ) {
                        $(".cm_btn").attr('disabled', true);
                    }
                },
                select: function(arg) {
                    $("input[name=time]").val(arg.startStr + '|' + arg.endStr);
                    $("input[name=course_id]").val(utilised.course_id);
                    $("input[name=instructor_id]").val(id);
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
                            $(".cm_btn").attr('onclick', 'openLessonModal(' + id + ');');
                        }
                    @else
                        $.ajax({
                            type: "POST",
                            url: "{{ route('saveloginsession') }}",
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "time": arg.startStr + '|' + arg.endStr,
                                "course_id": utilised.course_id,
                                "instructor_id": id,
                                "transaction_id": utilised.transaction_id,
                            },
                            success: function (data) {
                                var data = JSON.parse(data);
                            }
                        });
                        $(".cm_btn").attr('onclick', 'loginForm();');
                    @endif
                },
                nowIndicator: false,
                events: events[id],
                selectAllow: function(info) {
                    console.log(info);
                    var date = new Date();
                    date.setDate(date.getDate() + 1);
                    var startDate = date.getTime();
                    // console.log(info);
                    if (info.start.getTime() < startDate || info.start.getTime() > lastDay.getTime()) {
                        return false;
                    }

                    if ( ( (new Date(info.end.getTime()) - new Date(info.start.getTime())) / 60 / 1000 ) > 45) {
                        return false;
                    }

                    return true;          
                },
                selectConstraint: "businessHours",
        		businessHours: schedule[id],
            });

            calendar.render();
        }

        function openLessonModal(id) {
            var cour = course[id];
            var modal = $("#myLessonModalNew");
            if (cour.length <= 0) {
                $("#lesson_plan_pack").html('<p>No Course Assigned.</p>');
            } else {
                $("#lesson_plan_pack").html('<input type="radio" name="url" id="pac_1" onclick="courseUrl(this);" value="/choose-plan/'+cour.course_id+'/'+id+'/1" />\n\
                <label for="pac_1"> {{ __('teacher.monthlyplan') }}</label><a href="javascript:void(0);" onclick="openPackagePlanModal(' + "'monthly_plan_detail'" + ');" style="float:right;margin-right:133px;margin-top:-60px;" class="btn btn-sm btn-primary">{{ __('teacher.details') }}</a><input type="radio" name="url" id="pac_2" onclick="courseUrl(this);" value="/choose-plan/'+cour.course_id+'/'+id+'/2" />\n\
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