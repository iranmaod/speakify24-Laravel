@php
	use Carbon\Carbon;	
@endphp
@extends('layouts.backend.index')
@section('content')
<div class="page-header">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
		<li class="breadcrumb-item active">Appointments</li>
	</ol>
	<h1 class="page-title">Appointments</h1>
</div>

<div class="page-content">
	<div class="panel">
        <div class="panel-heading">
            <div class="panel-title">
              <a href="{{ route('admin.appointment.create') }}" class="btn btn-success btn-sm"><i class="icon wb-plus" aria-hidden="true"></i> Add Appointment</a>
              <a href="{{ route('admin.appointments') }}" class="btn btn-default btn-sm pull-right"><i class="icon wb-plus" aria-hidden="true"></i> Calendar</a>
			  <a href="{{ url('admin/appointment/export?search=').$search }}" class="btn btn-info btn-sm"><i class="fas fa-file-export"></i> Export</a>
            </div>
			<div class="panel-actions">
				<form method="GET" action="{{route('admin.appointment.listings')}}">
					
					<div class="input-group">
					  <input type="text" class="form-control" name="search" placeholder="Search..." value="{{ Request::input('search') }}">
					  <span class="input-group-btn">
						<button type="submit" class="btn btn-primary" data-toggle="tooltip" data-original-title="Search"><i class="icon wb-search" aria-hidden="true"></i></button>
						<a href="/admin/appointment/listing" class="btn btn-danger" data-toggle="tooltip" data-original-title="Clear Search"><i class="icon wb-close" aria-hidden="true"></i></a>
					  </span>
					</div>
				</form>
			</div>
        </div>
        
        <div class="panel-body">
			<table class="table table-hover table-striped w-full">
				<thead>
					<tr>
						<th>Sl.no</th>
						<th>Title</th>
						<th>Instructor</th>
						<th>Student</th>
						<th>Course</th>
						<th>Start</th>
						<th>End</th>
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
						$to_time = date("Y-m-d H:i:s");
					?>
					@foreach($appointments as $appointment)
						@php
					
						date_default_timezone_set("Europe/Madrid");
						
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

						@endphp
						<tr>
							<td>{{ $appointment->id }}</td>
							<td>{{ $appointment->title }}</td>
							<td>{{ $appointment->in_fname }} {{ $appointment->in_lname }}</td>
							<td>{{ $appointment->st_fname }} {{ $appointment->st_lname }}</td>
							<td>{{ $appointment->course_title }}</td>
							<td>
								{{ date('d-m-Y H:i', strtotime($appointment->startdate . " -" . $diff)) }}
							
							</td>
							<td>{{ date('d-m-Y H:i', strtotime($appointment->enddate . " -" . $diff)) }}</td>
							<td>{{ $status[$appointment->status] }}</td>
							<td>
							<a href="{{ route('admin.appointment.edit', $appointment->id) }}" class="btn btn-xs btn-icon btn-inverse btn-round" data-toggle="tooltip" data-original-title="Edit" >
								<i class="icon wb-pencil" aria-hidden="true"></i>
							</a>

							<a href="{{ url('admin/appointment/delete/'.$appointment->id) }}" class="delete-record btn btn-xs btn-icon btn-inverse btn-round" data-toggle="tooltip" data-original-title="Delete" >
								<i class="icon wb-trash" aria-hidden="true"></i>
							</a>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
			{{ $appointments->appends(['search' => Request::input('search')])->links() }}
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