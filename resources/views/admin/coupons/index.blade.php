@extends('layouts.backend.index')
@section('content')
<div class="page-header">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
		<li class="breadcrumb-item active">Coupons</li>
	</ol>
	<h1 class="page-title">Coupons</h1>
</div>

<div class="page-content">

	<div class="panel">
        <div class="panel-heading">
            <div class="panel-title">
              <a href="{{ route('admin.coupon.create') }}" class="btn btn-success btn-sm"><i class="icon wb-plus" aria-hidden="true"></i> Add Coupon</a>
            </div>
        </div>
        
        <div class="panel-body">
			<table class="table table-hover table-striped w-full">
				<thead>
					<tr>
						<th>Sl.no</th>
						<th>Name</th>
						<th>Code</th>
						<th>Discount</th>
						<th>Type</th>
						<th>Number of Use</th>
						<th>Used</th>
						<th>Start Date</th>
						<th>End Date</th>
						<th>Status</th>
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
					@foreach($coupons as $coupon)
						<tr>
							<td>{{ $coupon->id }}</td>
							<td>{{ $coupon->name }}</td>
							<td>{{ $coupon->code }}</td>
							<td>{{ $coupon->discount }}</td>
							<td>{{ ucfirst($coupon->type) }}</td>
							<td>{{ $coupon->number_of_usage }}</td>
							<td>{{ $coupon->used }}</td>
							<td>{{ $coupon->startdate }}</td>
							<td>{{ $coupon->enddate }}</td>
							<td>{{ $status[$coupon->status] }}</td>
							<td>
							<a href="{{ route('admin.coupon.edit', $coupon->id) }}" class="btn btn-xs btn-icon btn-inverse btn-round" data-toggle="tooltip" data-original-title="Edit" >
								<i class="icon wb-pencil" aria-hidden="true"></i>
							</a>

							<a href="{{ url('admin/coupon/delete/'.$coupon->id) }}" class="delete-record btn btn-xs btn-icon btn-inverse btn-round" data-toggle="tooltip" data-original-title="Delete" >
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