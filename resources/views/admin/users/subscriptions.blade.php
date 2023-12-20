@extends('layouts.backend.index')
@section('content')
<div class="page-header">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
		<li class="breadcrumb-item active">User Subscriptions</li>
	</ol>
	<h1 class="page-title">User Subscriptions</h1>
</div>

<div class="page-content">

	<div class="panel">
        <div class="panel-heading">
            <div class="panel-title">
              &nbsp;<!-- <a href="{{-- route('admin.getForm') --}}" class="btn btn-success btn-sm"><i class="icon wb-plus" aria-hidden="true"></i> Add User</a> -->
            </div>
          
			<div class="panel-actions">
				<form method="GET" action="{{ route('admin.member.subscriptions') }}">
					<div class="input-group">
						<label for="start_date">Start Date</label>
						<input type="date" id="start_date" class="form-control" name="startdate" placeholder="Start Date" value="{{ Request::input('startdate') }}" />
						<label for="end_date">End Date</label>
						<input type="date" id="end_date" class="form-control" name="enddate" placeholder="End Date" value="{{ Request::input('enddate') }}" />
						<input type="text" class="form-control" name="search" placeholder="Search..." value="{{ Request::input('search') }}">
						<span class="input-group-btn">
							<button type="submit" class="btn btn-primary" data-toggle="tooltip" data-original-title="Search"><i class="icon wb-search" aria-hidden="true"></i></button>
							<a href="{{ route('admin.member.subscriptions') }}" class="btn btn-danger" data-toggle="tooltip" data-original-title="Clear Search"><i class="icon wb-close" aria-hidden="true"></i></a>
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
						<th>User Name</th>
						{{-- <th>Instructor</th> --}}
						<th>Course</th>
						<th>Plan</th>
						<!-- <th>Next Billing</th> -->
						<th>Subscribed at</th>
						<th>Status</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					@foreach($transactions as $sub)
						<?php
							$hour = 0;
							$name = '';
							if ($sub->type == 'package') {
								$plan = \DB::table('course_prices')->where('id', $sub->type_id)->first();
								$hour = $plan->hours;
								$name = $plan->hours . 'hours for $' . $plan->price;
							} else {
								$plan = \DB::table('subscription_plans')->where('id', $sub->type_id)->first();
								$hour = $plan->per_month;
								$name = $plan->name;
							}
						?>
						<tr>
							<td>{{ $sub->id }}</td>
							<td>{{ $sub->user_fname }} {{ $sub->user_lname }}</td>
						
							<td>{{ $sub->course_title }}</td>
							<td>{{ $name }}</td>
							<!-- <td>{{-- date("F j, Y", strtotime($sub->next_billing)) --}}</td> -->
							<td>{{ date("F j, Y", strtotime($sub->created_at)) }}</td>
							<td>{{ ucfirst($sub->status) }}</td>
							<td>
								@if ($sub->type != 'package')
									<?php
										$orderDetail = json_decode($sub->order_details);
										if ( isset( $orderDetail->id ) && !empty( $orderDetail->id ) && $sub->status == 'completed' ) {
											?>
											<a href="{{ route('admin.member.cancel', ['t_id'=>$sub->id,'id'=>$orderDetail->id, 'type' => 'admin']) }}" class="btn btn-xs btn-icon btn-inverse btn-round btn-danger" data-toggle="tooltip" data-original-title="Cancel">
												<i class="icon wb-trash" aria-hidden="true"></i>
											</a>
											<?php
										}
									?>
								@endif
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
          
			<div class="float-right">
				{{ $transactions->appends(['search' => Request::input('search')])->links() }}
			</div>
          
          
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