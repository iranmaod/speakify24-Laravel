@extends('layouts.frontend.index')
@section('content')
<!-- content start -->
    <div class="container-fluid p-0 home-content">
        <!-- banner start -->
        <div class="subpage-slide-blue">
            <div class="container">
                <h1>Appointment Listing</h1>
                <a href="{{ route('my.appointments') }}" class="btn btn-success btn-sm" style="margin-top:-47px;float:right;">Appointment Calendar</a>
            </div>
        </div>
        <!-- banner end -->

        <!-- breadcrumb start -->
        <div class="breadcrumb-container">
            <div class="container">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">My Appointments</li>
              </ol>
            </div>
        </div>
        <!-- breadcrumb end -->

        <!-- course list start -->
        <div class="container" id="my-appointments">
            <div class="row">
                <table class="table table-hover table-striped w-full">
                    <thead>
                        <tr>
                            <th>Sl.no</th>
                            <th>Course</th>
                            <th>Instructor</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Added At</th>
                            <th>Status</th>
                            <th>Start</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $status = array("Pending", "Accepted", "Rejected", "Cancelled", "Completed");
                            $start = array("No", "Yes", "Paused", "Completed");
                        ?>
                        @foreach($appointments as $appointment)
                            <?php
                                $tm_df = isset($_COOKIE['offset'])?$_COOKIE['offset']:'00';
                                $appStart = date("Y-m-d H:i:s", strtotime("+" .$tm_df. " minutes", strtotime($appointment->startdate)));
                                $appEnd = date("Y-m-d H:i:s", strtotime("+" .$tm_df. " minutes", strtotime($appointment->enddate)));
                            ?>
                            <tr>
                                <td>{{ $appointment->id }}</td>
                                <td>{{ $appointment->course_title }}</td>
                                <td>{{ $appointment->first_name }} {{ $appointment->last_name }}</td>
                                <td>{{ $appStart }}</td>
                                <td>{{ $appEnd }}</td>
                                <td>{{ $appointment->created_at }}</td>
                                <td>{{ $status[$appointment->status] }}</td>
                                <td>{{ $start[$appointment->start] }}</td>
                                <td>
                                    @if(strtotime($appointment->startdate) > strtotime('+1 day', time()) )
                                        <a href="{{ route('cancel.appointment', $appointment->id) }}" class="btn btn-sm btn-danger">Cancel</a>
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