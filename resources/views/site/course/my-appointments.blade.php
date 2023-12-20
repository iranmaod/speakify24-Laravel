@php
	use Carbon\Carbon;	
@endphp
@extends('layouts.frontend.index')
@section('content')
<!-- content start -->
    <div class="container-fluid p-0 home-content">
        <?php
        $session = \App::getLocale();
        if (session()->get('locale') != '') {
            $session = session()->get('locale');
        }
    

    ?>
        <!-- banner start -->
        <div class="subpage-slide-blue">
            <div class="container">
                <h1>
                    {{ __('booking.appointmentcal') }}
                </h1>
                <a href="{{ route('listing') }}" class="btn btn-success btn-sm" style="margin-top:-47px;float:right;">
                    {{ __('booking.appointmentlisting') }}
                </a>
            </div>
        </div>
        <!-- banner end -->

        <!-- breadcrumb start -->
        <div class="breadcrumb-container">
            <div class="container">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ __('booking.myappointment') }}
                </li>
              </ol>
            </div>
        </div>
        
        <!-- breadcrumb end -->

        <!-- course list start -->
        <div class="container" id="my-appointments">
            <div class="row">
                <div id="calendar"></div>
            </div>
        </div>
            
    </div>
    <!-- course list end -->
@endsection

@section('javascript')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
<script type="text/javascript">
    var appointment = [];
    @foreach($appointments as $appointment)
        @php
            $appStart = Carbon::createFromFormat('Y-m-d H:i:s', $appointment->startdate);
            $appEnd = Carbon::createFromFormat('Y-m-d H:i:s', $appointment->enddate);
            
            if (isset($user->timezone) && !empty($user->timezone)) {
                $appStart->setTimezone($user->timezone);
                $appEnd->setTimezone($user->timezone);
            }
            else{
                $appStart->setTimezone("Europe/Madrid");
                $appEnd->setTimezone("Europe/Madrid");
            }
        @endphp
        <?php
            $start = date("Y").env('DAYLIGHT_SAVING_START');
            $end = date("Y").env('DAYLIGHT_SAVING_END');
            $now = date("Y-m-d H:i:s", strtotime($appointment->startdate));

            if ($now >= $start && $now <= $end)
            {
                $diff = "60 minutes";	
            }
            else
            {
                $diff = "0 minutes";
            }
            $tm_df = '60';
            $appStart = date("Y-m-d H:i:s", strtotime("-" .$diff, strtotime($appointment->startdate)));
            $appEnd = date("Y-m-d H:i:s", strtotime("-" .$diff, strtotime($appointment->enddate)));
        ?>
        appointment.push({
            id: '{{$appointment->id}}',
            start: '{{str_replace(" ","T",$appStart)}}',
            end: '{{str_replace(" ","T",$appEnd)}}',
            title: '{{$appointment->course_title}}',
        });
    @endforeach

    $(document).ready(function() {
        var calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
            headerToolbar: {
                left: 'prev,next',
                center: 'title',
                right: ''
            },
            titleFormat: {
                year: 'numeric',
                month: 'long'
            },
            // initialView: 'timeGridMonth',
            slotDuration: '00:45',
            slotLabelFormat: [{
                hour: '2-digit',
                minute: '2-digit'
            }],
            height: 'auto',
            navLinks: false,
            nowIndicator: false,
            events: appointment,
            eventTimeFormat: {
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            },
            timeFormat: 'H:mm',
            selectable: false,
            selectMirror: false,
        });

        calendar.render();
    });

</script>
@endsection