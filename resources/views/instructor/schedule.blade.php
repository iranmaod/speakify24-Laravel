@extends('layouts.backend.index')
@section('content')
	<style type="text/css">
	/*
	#calendar .fc .fc-timegrid-slot:empty::before {
		background: green;
	}
	.fc-today {
        background-color: #ffffff;
 	}
	*/
	</style>
	<div class="page-header">
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="{{ route('instructor.dashboard') }}">Dashboard</a></li>
			<li class="breadcrumb-item"><a href="{{ route('appointments') }}">Appointments</a></li>
			<li class="breadcrumb-item active">Schedule</li>
		</ol>
		<h1 class="page-title">Add Schedule</h1>
	</div>

	<div class="page-content">

		<div class="panel">
			<div class="panel-body">

				<form method="POST" action="{{ route('instructor.addschedule') }}" id="scheduleForm">
					{{ csrf_field() }}
					<div class="row">
	 					<?php
							$schedule = json_decode($instructor->schedule);
							$selectDay = array();
							if (!empty($schedule) && $schedule != '') {
								$selectDay = $schedule->select_day;
								$start = $schedule->start;
								$end = $schedule->end;
							}
						?>

						<?php $range=range(strtotime("00:00"),strtotime("24:00"),45*60); ?>

						@if (!empty($selectDay))
							@foreach($selectDay as $key => $value)
								<?php
									$starttime = $start[$key];
									$endtime = $end[$key];
								?>
								<div class="time-{{$key}} all_times" style="display: contents;">
									<div class="form-group col-md-4">
										<label class="form-control-label">Select Day <span class="required">*</span></label>
										<select class="form-control selday" name="select_day[]">
											<option value="0" @if( $value == '0') selected @elseif(old('select_day') == '0') selected @endif>Sunday</option>
											<option value="1" @if( $value == '1') selected @elseif(old('select_day') == '1') selected @endif>Monday</option>
											<option value="2" @if( $value == '2') selected @elseif(old('select_day') == '2') selected @endif>Tuesday</option>
											<option value="3" @if( $value == '3') selected @elseif(old('select_day') == '3') selected @endif>Wednesday</option>
											<option value="4" @if( $value == '4') selected @elseif(old('select_day') == '4') selected @endif>Thursday</option>
											<option value="5" @if( $value == '5') selected @elseif(old('select_day') == '5') selected @endif>Friday</option>
											<option value="6" @if( $value == '6') selected @elseif(old('select_day') == '6') selected @endif>Saturday</option>
										</select>
										
										@if ($errors->has('selday'))
											<label class="error" for="selday">{{ $errors->first('selday') }}</label>
										@endif
									</div>
									
									<div class="form-group col-md-4">
										<label class="form-control-label">Select Start Time <span class="required">*</span></label>
										<select class="form-control" name="start[]" id="start">
											@foreach($range as $time)
												<option value="{{date('H:i',$time)}}" @if($starttime == date('H:i',$time)) selected @endif>{{date('H:i',$time)}}</option>
											@endforeach
										</select>
										
										@if ($errors->has('start'))
											<label class="error" for="start">{{ $errors->first('start') }}</label>
										@endif
									</div>

									<div class="form-group col-md-4">
										<label class="form-control-label">Select End Time <span class="required">*</span></label>
										<i style="float: right; @if($key == '0') display:none; @endif" data-toggle="tooltip" data-original-title="Delete" onclick="removeRow(this);" data-id="course_image" class="fa fa-trash remove-lp"></i>
										<select class="form-control" name="end[]" id="end">
											@foreach($range as $time)
												<option value="{{date('H:i',$time)}}" @if($endtime == date('H:i',$time)) selected @endif>{{date('H:i',$time)}}</option>
											@endforeach
										</select>
										
										@if ($errors->has('end'))
											<label class="error" for="end">{{ $errors->first('end') }}</label>
										@endif
									</div>
								</div>
							@endforeach
						@else
							<div class="time-0 all_times" style="display: contents;">
								<div class="form-group col-md-4">
									<label class="form-control-label">Select Day <span class="required">*</span></label>
									<select class="form-control selday" name="select_day[]">
										<option value="0" @if(old('select_day') == '0') selected @endif>Sunday</option>
										<option value="1" @if(old('select_day') == '1') selected @endif>Monday</option>
										<option value="2" @if(old('select_day') == '2') selected @endif>Tuesday</option>
										<option value="3" @if(old('select_day') == '3') selected @endif>Wednesday</option>
										<option value="4" @if(old('select_day') == '4') selected @endif>Thursday</option>
										<option value="5" @if(old('select_day') == '5') selected @endif>Friday</option>
										<option value="6" @if(old('select_day') == '6') selected @endif>Saturday</option>
									</select>
									
									@if ($errors->has('selday'))
										<label class="error" for="selday">{{ $errors->first('selday') }}</label>
									@endif
								</div>
								
								<div class="form-group col-md-4">
									<label class="form-control-label">Select Start Time <span class="required">*</span></label>
									<select class="form-control" name="start[]" id="start">
										@foreach($range as $time)
											<option value="{{date('H:i',$time)}}">{{date('H:i',$time)}}</option>
										@endforeach
									</select>
									
									@if ($errors->has('start'))
										<label class="error" for="start">{{ $errors->first('start') }}</label>
									@endif
								</div>

								<div class="form-group col-md-4">
									<label class="form-control-label">Select End Time <span class="required">*</span></label>
									<i style="float: right; display:none;" data-toggle="tooltip" data-original-title="Delete" onclick="removeRow(this);" data-id="course_image" class="fa fa-trash remove-lp"></i>
									<select class="form-control" name="end[]" id="end">
										@foreach($range as $time)
											<option value="{{date('H:i',$time)}}">{{date('H:i',$time)}}</option>
										@endforeach
									</select>
									
									@if ($errors->has('end'))
										<label class="error" for="end">{{ $errors->first('end') }}</label>
									@endif
								</div>
							</div>
						@endif
						<div class="form-group row"><span type="button" id="addrow" class="btn btn-default addrow pull-right"><i class="dripicons-plus"></i> Add New</span></div>
					</div>
					<hr>
					<div class="form-group row">
						<div class="col-md-4">
							<button type="submit" class="btn btn-primary">Submit</button>
							<button type="reset" class="btn btn-default btn-outline">Reset</button>
						</div>
					</div>
			
				</form>
			</div>
		</div>
	</div>
@endsection

@section('javascript')
	<script type="text/javascript">
		function selectDay() {
			$('.selday option').removeAttr("disabled");
			var week = ['0','1','2','3','4','5','6']
			var days = $("#days").val();
			var diff = week.filter(x => !days.includes(x));

			$.each(diff, function(i, e) {
				$('.selday option[value="' + e + '"]').attr("disabled", "disabled");
			});
		}

		$(document).ready(function() {
			var counter = 0;

			$("#addrow").on("click", function () {
				var times = $(".all_times").last().clone();
				console.log(times);
				console.log(times.find('i.remove-lp').show());
				times.insertAfter($(".all_times").last());
			});
		});

		function removeRow(val) {
			console.log($(val).parent().parent().remove());
		}
	</script>
@endsection