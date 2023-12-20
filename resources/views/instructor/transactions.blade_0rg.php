@extends('layouts.backend.index')
@section('content')

<div class="page-header">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{ route('instructor.dashboard') }}">Dashboard</a></li>
		<li class="breadcrumb-item active">Transactions</li>
	</ol>
	<h1 class="page-title">Transactions</h1>
</div>

<div class="page-content">
	<div class="panel">
        <div class="panel-heading">
            <div class="panel-title">
				&nbsp;
            </div>

			<div class="panel-actions">
				<form method="GET" action="{{ route('instructor.transactions') }}">
					<div class="input-group">
						<label for="start_date">Start Date</label>
						<input type="date" id="start_date" class="form-control" name="startdate" placeholder="Start Date" value="{{ Request::input('startdate') }}" />
						<label for="end_date">End Date</label>
						<input type="date" id="end_date" class="form-control" name="enddate" placeholder="End Date" value="{{ Request::input('enddate') }}" />
						<input type="text" class="form-control" name="search" placeholder="Search..." value="{{ Request::input('search') }}">
						<span class="input-group-btn">
							<button type="submit" class="btn btn-primary" data-toggle="tooltip" data-original-title="Search"><i class="icon wb-search" aria-hidden="true"></i></button>
							<a href="{{ route('instructor.transactions') }}" class="btn btn-danger" data-toggle="tooltip" data-original-title="Clear Search"><i class="icon wb-close" aria-hidden="true"></i></a>
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
						<th>User</th>
						<th>Course</th>
						<th>Amount</th>
						<th>Requested On</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody>
					<?php $status = array("Pending", "Accepted", "Rejected", "Cancelled", "Completed"); ?>
					@foreach($transactions as $transaction)
						<tr>
							<td>{{ $transaction->id }}</td>
							<td>{{ $transaction->u_fname }} {{ $transaction->u_lname }}</td>
							<td>{{ $transaction->course_title }}</td>
							<td>{{ $transaction->instructor_amount }}</td>
							<td>{{ $transaction->created_at }}</td>
							<td>{{ $status[$transaction->status] }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
			
			<div class="float-right">
				{{ $transactions->links() }}
			</div>
          
          
        </div>
      </div>
      <!-- End Panel Basic -->
</div>

@endsection

@section('javascript')
<script type="text/javascript">
	$(document).ready(function() {
	});
</script>
@endsection