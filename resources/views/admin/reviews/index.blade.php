@extends('layouts.backend.index')
@section('content')
<div class="page-header">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
		<li class="breadcrumb-item active">Testimonials</li>
	</ol>
	<h1 class="page-title">Testimonials</h1>
</div>

<div class="page-content">

	<div class="panel">
        <div class="panel-heading">
            <div class="panel-title">
              <a href="{{ route('admin.testimonial.create') }}" class="btn btn-success btn-sm"><i class="icon wb-plus" aria-hidden="true"></i> Add Testimonial</a>
            </div>
        </div>
        
        <div class="panel-body">
			<table class="table table-hover table-striped w-full">
				<thead>
					<tr>
						<th>Sl.no</th>
						<th>Instructor</th>
						<th>Student</th>
						<th>Course</th>
						<th>Review</th>
						<th>Rating</th>
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
					@foreach($reviews as $review)
						<tr>
							<td>{{ $review->id }}</td>
							<td>{{ $review->in_fname }} {{ $review->in_lname }}</td>
							<td>{{ $review->st_fname }} {{ $review->st_lname }}</td>
							<td>{{ $review->course_title }}</td>
							<td>{{ $review->review }}</td>
							<td>{{ $review->rating }}</td>
							<td>
							<a href="{{ route('admin.testimonial.edit', $review->id) }}" class="btn btn-xs btn-icon btn-inverse btn-round" data-toggle="tooltip" data-original-title="Edit" >
								<i class="icon wb-pencil" aria-hidden="true"></i>
							</a>

							<a href="{{ url('admin/testimonial/delete/'.$review->id) }}" class="delete-record btn btn-xs btn-icon btn-inverse btn-round" data-toggle="tooltip" data-original-title="Delete" >
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