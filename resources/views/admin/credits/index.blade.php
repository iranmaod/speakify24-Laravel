@php
	use Carbon\Carbon;	
@endphp
@extends('layouts.backend.index')
@section('content')
<div class="page-header">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
		<li class="breadcrumb-item active">Credits</li>
	</ol>
	<h1 class="page-title">Credits</h1>
</div>

<div class="page-content">

	<div class="panel">
        <div class="panel-heading">
            <div class="panel-title">
              <a href="{{ route('credits.view') }}" class="btn btn-success btn-sm"><i class="icon wb-plus" aria-hidden="true"></i> Add Credits</a>
            </div>
        </div>
        
        <div class="panel-body">
			<table class="table table-hover table-striped w-full">
				<thead>
					<tr>
						<th>Sl.no</th>
						<th>Student Name</th>
						<th>Language</th>
						<th>Credits</th>
						<th>Remaining Credits</th>
						<th>Weekly Credits</th>
						<th>Cancellable Credits</th>
						<th>Start Date</th>
						<th>End Date</th>
						<th>Status</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					
					@foreach($credits as $item)
						<tr>
							<td>{{ $item->id }}</td>
							<td>{{ $item->first_name }} {{ $item->last_name }}</td>
							<td>{{ $item->course_title }}</td>
							<td>{{ $item->total_hours }}</td>
							<td>{{ $item->hours }}</td>
							<td>{{ $item->weekly_hours }}</td>
							<td>{{ $item->canc_credits }}</td>
							<td>{{ $item->start_time }}</td>
							<td>{{ $item->end_time }}</td>
							<td>
								<?php
								date_default_timezone_set('Europe/London');
								 $endTime = date('Y-m-d H:i:s');
									
								?>
								@if($item->end_time > $endTime)
								<span class="badge badge-success">Active</span>
								@else
								<span class="badge badge-danger">Expired</span>
								@endif
							</td>
							
							<td>
								
								<a href="{{ route('admin.credits.edit', $item->id) }}" class="btn btn-xs btn-icon btn-inverse btn-round" data-toggle="tooltip" data-original-title="Edit" >
									<i class="icon wb-pencil" aria-hidden="true"></i>
								</a>
								<a href="{{ url('credits/delete/'.$item->id) }}" class="delete-record btn btn-xs btn-icon btn-inverse btn-round" data-toggle="tooltip" data-original-title="Delete" >
									<i class="icon wb-trash" aria-hidden="true"></i>
								</a>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
			{{ $credits->links() }}
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