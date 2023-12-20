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
		<li class="breadcrumb-item active">Teachers Monthly Income</li>
	</ol>
	<h1 class="page-title">Teachers Monthly Income for {{ date('F') }}</h1>
</div>

<div class="page-content">

	<div class="panel">
        <div class="panel-heading">
            <div class="panel-title">
              {{-- <a href="{{ route('admin.subscription.create') }}" class="btn btn-success btn-sm"><i class="icon wb-plus" aria-hidden="true"></i> Add Subscription Plan</a> --}}
            </div>
        </div>
        
        <div class="panel-body">
			<table class="table table-hover table-striped w-full">
				<thead>
					<tr>
						<th>Teacher</th>
						<th>Course</th>
						<th>Total Price</th>
						<th>Lecture Count</th>
					</tr>
				</thead>
				<tbody>
					@foreach($transactions as $item)
						<tr>
							<td>{{ $item->u_fname }} {{ $item->u_lname }}</td>
							<td>{{ $item->course_title }}</td>
							<td>{{ $item->total }}</td>
							<td>{{ $item->count }}</td>
						</tr>
					@endforeach
				</tbody>
			</table>

        </div>
    </div>
</div>

@endsection