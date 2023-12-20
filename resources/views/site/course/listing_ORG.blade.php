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
        <div class="subpage-slide-blue bgcoverimg">
            <div class="container">
                <h1>
                    {{ __('booking.appointmentlisting') }}
                </h1>
                <a href="{{ route('my.appointments') }}" class="btn btn-success btn-sm" style="margin-top:-47px;float:right;">
                    {{ __('booking.appointmentcalbtn') }}
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
                    {{ __('booking.appointmentcal') }}
                </li>
              </ol>
            </div>
        </div>
        <!-- breadcrumb end -->

        <!-- course list start -->
        <div class="container" id="my-appointments">
            <h4>{{ __('booking.myappointment') }}</h4>
            <div class="row">
                <table class="table table-hover table-striped w-full">
                    <thead>
                        <tr>
                            <!-- <th>Sl.no</th> -->
                            <th>{{ __('booking.language') }}</th>
                            <th>{{ __('teacher.teacher') }}</th>
                            <th>
                                {{ __('booking.s_date') }}
                            </th>
                            <th>
                                {{ __('booking.e_date') }}
                            </th>
                            <!-- <th>Added At</th> -->
                            <th>
                                {{ __('booking.status') }}
                            </th>
                            <!-- <th>Start</th> -->
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $status = array("Pending", "Accepted", "Rejected", "Cancelled", "Completed");
                            // $start = array("No", "Yes", "Paused", "Completed", "Stopped");

                            $to_time = date("Y-m-d H:i:s");
                            if (isset($user->timezone) && !empty($user->timezone)) {
                                date_default_timezone_set($user->timezone);
                            } else {
                                date_default_timezone_set("Europe/Madrid");
                            }
                            // $from_time = date("Y-m-d H:i:s");
                            // $diff = round(abs(strtotime($to_time) - strtotime($from_time)) / 60,2). " minutes";

                            $from_time = date("Y-m-d H:i:s");
                            $start = date("Y").env('DAYLIGHT_SAVING_START');
                            $end = date("Y").env('DAYLIGHT_SAVING_END');
                            $now = date("Y-m-d H:i:s");

                            if ($now >= $start && $now <= $end)
                            {
                                $diff = "60 minutes";	
                            }
                            else
                            {
                                $diff = round(abs(strtotime($to_time) - strtotime($from_time)) / 60,2). " minutes";	
                            }
                        ?>
                        @foreach($appointments as $appointment)
                            <tr>
                                <!-- <td>{{-- $appointment->id --}}</td> -->
                                <td>{{ $appointment->course_title }}</td>
                                <td>{{ $appointment->first_name }} {{ $appointment->last_name }}</td>
                                <td>{{ date('d-m-Y H:i', strtotime($appointment->startdate . " -" . $diff)) }}</td>
                                <td>{{ date('d-m-Y H:i', strtotime($appointment->enddate . " -" . $diff)) }}</td>
                                <!-- <td>{{-- $appointment->created_at --}}</td> -->
                                <td>{{ $status[$appointment->status] }}</td>
                                <!-- <td>{{ $start[$appointment->start] }}</td> -->
                                <td>
                                    @if($appointment->status == 3 )
                                       
                                        <button class="btn btn-sm btn-danger" disabled>
                                            {{ __('booking.cancelled') }}
                                        </button>
                                    @elseif(strtotime($appointment->startdate . " -" . $diff) > strtotime('+1 day', time()))
                                    <a href="{{ route('cancel.appointment', $appointment->id) }}" class="btn btn-sm btn-danger">
                                        {{ __('booking.cancel') }}
                                    </a>
                                    @endif
                                    
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
            
    </div>
    <!-- course list end -->
@endsection

@section('javascript')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        
    });
</script>
@endsection