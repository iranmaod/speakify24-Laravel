@extends('layouts.backend.index')
@section('content')
<style>
	.td_desc img{
		max-width: 100%;
		height: auto;
	}
</style>
<div class="page-header">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
		<li class="breadcrumb-item active">Subscription Plans</li>
	</ol>
	<h1 class="page-title">Subscription Plans</h1>
</div>

<div class="page-content">

	<div class="panel">
        <div class="panel-heading">
            <div class="panel-title">
              <a href="{{ route('admin.subscription.create') }}" class="btn btn-success btn-sm"><i class="icon wb-plus" aria-hidden="true"></i> Add Subscription Plan</a>
            </div>
        </div>
        
        <div class="panel-body">
			<table class="table table-hover table-striped w-full">
				<thead>
					<tr>
						<th>Sl.no</th>
						<th>Name</th>
						<th>Description</th>
						<th>Hours Per Month</th>
						<th>Course</th>
						<th>Price</th>
						<th>Status</th>
						<!-- <th>Expiry</th> -->
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php
						$status = array(
							0 => 'Pending',
							1 => 'Active'
						);
					?>
					@foreach($subscriptions as $subscription)
						<tr>
							<td>{{ $subscription->id }}</td>
							<td>{{ $subscription->name }}</td>
							<td width="250px" class="td_desc">
								@if(strpos($subscription->description, '../../../../') !== false)
									{!! str_replace('../../../../', '../', $subscription->description) !!}
								@elseif(strpos($subscription->description, '../../../') !== false)
									{!! str_replace('../../../', '../', $subscription->description) !!}
								@elseif(strpos($subscription->description, '../../') !== false)
									{!! str_replace('../../', '../', $subscription->description) !!}
								@else
									{!! $subscription->description !!}
								@endif
							</td>
							<td>{{ $subscription->per_month }}</td>
							<td>{{ $subscription->course_title }}</td>
							<td>{{ $subscription->price }}</td>
							<td>{{ $status[$subscription->status] }}</td>
							<!-- <td>{{-- $subscription->expiry --}}</td> -->
							<td>
							<a href="{{ route('admin.subscription.edit', $subscription->id) }}" class="btn btn-xs btn-icon btn-inverse btn-round" data-toggle="tooltip" data-original-title="Edit" >
								<i class="icon wb-pencil" aria-hidden="true"></i>
							</a>

							<a href="{{ url('admin/subscription/delete/'.$subscription->id) }}" class="delete-record btn btn-xs btn-icon btn-inverse btn-round" data-toggle="tooltip" data-original-title="Delete" >
								<i class="icon wb-trash" aria-hidden="true"></i>
							</a>
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