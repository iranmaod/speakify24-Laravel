@php
	use Carbon\Carbon;	
@endphp
@extends('layouts.backend.index')
@section('content')
<div class="page-header">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{ route('instructor.dashboard') }}">Dashboard</a></li>
		<li class="breadcrumb-item active"><a href="{{ route('appointments') }}">Calendar</a></li>
		<li class="breadcrumb-item active">Appointments</li>
	</ol>
	<h1 class="page-title">Appointments</h1>
</div>

<div class="page-content">

	<div class="panel">
        <div class="panel-heading">
            <div class="panel-title">
              <a href="{{ route('appointments') }}" class="btn btn-primary btn-sm pull-right">Calendar</a>
              <a href="{{ route('instructor.schedule') }}" class="btn btn-primary btn-sm pull-right">Schedule</a>
            </div>
        </div>
        
        <div class="panel-body">
			<table class="table table-hover table-striped w-full">
				<thead>
					<tr>
						<th>Sl.no</th>
						<th>Title</th>
						<th>Student</th>
						<th>Course</th>
						<th>Start</th>
						<th>End</th>
						<th>Conference Started</th>
						<th>Time Taken</th>
						<th>Status</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$status = array(
							0 => 'Pending',
							1 => 'Accepted',
							2 => 'Rejected',
							3 => 'Cancelled',
							4 => 'Completed',
						);
						$start = array(
							0 => 'No',
							1 => 'Yes',
							2 => 'Paused',
							3 => 'Completed',
							4 => 'Stopped'
						);
						$to_time = date("Y-m-d H:i:s");
					?>
					@foreach($appointments as $appointment)
						@php
						if($appointment->timezone != "")
						{
							date_default_timezone_set($appointment->timezone);
						}
						else
						{
							date_default_timezone_set("Europe/Madrid");
						}  
				
							$from_time = date("Y-m-d H:i:s");
							$from_time = date("Y-m-d H:i:s");
							$start = date("Y")."-03-26";
							$end = date("Y")."-04-29";
							$now = date("Y-m-d H:i:s");

							if ($now >= $start && $now <= $end)
							{
								$diff = "+60 minutes";	
							}
							else
							{
								$diff = round(abs(strtotime($to_time) - strtotime($from_time)) / 60,2). " minutes";	
							}
							
						@endphp
						<tr>
							<td>{{ $appointment->id }}</td>
							<td>{{ $appointment->title }}</td>
							<td>{{ $appointment->st_fname }} {{ $appointment->st_lname }}</td>
							<td>{{ $appointment->course_title }}</td>
							<td>{{ date('d-m-Y H:i', strtotime($appointment->startdate . " +" . $diff)) }}</td>
							<td>{{ date('d-m-Y H:i', strtotime($appointment->enddate . " +" . $diff)) }}</td>
							<td>{{ $start[$appointment->start] }}</td>
							<td>{{ $appointment->time_taken }}</td>
							<td>{{ $status[$appointment->status] }}</td>
							<td>
								@if(strtotime('+2 day', strtotime($appointment->startdate . " +" . $diff)) > time() && $appointment->status != 3)
									<a href="{{ route('appointment.destroy', $appointment->id) }}" class="btn btn-sm btn-danger">Cancel</a>
								@endif
								@if(!$appointment->start && time() <= strtotime($appointment->enddate . " +" . $diff))
								<form method="POST" action="{{ route('joinmeeting') }}" accept-charset="UTF-8" class="">
									@csrf
									<input name="appointment_id" type="hidden" value="{{$appointment->id}}">
									<button class="btn btn-success btn-sm" type="submit" style="width: 100%;"> 
										<span class="hidden-xs hidden-sm">Start Conference</span>
									</button>
								</form>
								@elseif($appointment->status == '1' && $appointment->start && time() <= strtotime($appointment->enddate . " +" . $diff))
								<form method="POST" action="{{ route('joinmeeting') }}" accept-charset="UTF-8" class="">
									@csrf
									<input name="appointment_id" type="hidden" value="{{$appointment->id}}">
									<button class="btn btn-success btn-sm" type="submit" style="width: 100%;"> 
										<span class="hidden-xs hidden-sm">Join Conference</span>
									</button>
								</form>
								@endif
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>

        </div>
    </div>
</div>

@endsection

@section('javascript')
<script type="text/javascript">
    $(document).ready(function()
    { 

    });
</script>
@endsection