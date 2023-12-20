@php
	use Carbon\Carbon;	
@endphp
@extends('layouts.backend.index')
@section('content')
	<div class="container bg-white text-dark">
		<div class="response"></div>
		<div id='calendar'></div>  
  	</div>
@endsection

@section('javascript')
	<script type="text/javascript">
		var events = [];
		@if( count($appointments) > 0 )
			@foreach($appointments as $appointment)
				@php
					$appStart = Carbon::createFromFormat('Y-m-d H:i:s', $appointment->startdate);
					$appEnd = Carbon::createFromFormat('Y-m-d H:i:s', $appointment->enddate);
					if (isset($appointment->timezone) && !empty($appointment->timezone)) {
						$appStart->setTimezone($appointment->timezone);
						$appEnd->setTimezone($appointment->timezone);
					}
					else{
						$appStart->setTimezone("Europe/Madrid");
						$appEnd->setTimezone("Europe/Madrid");
					}
				@endphp
				<?php
					$tm_df = '60';
					$appStart = date("Y-m-d H:i:s", strtotime("+" .$tm_df. " minutes", strtotime($appointment->startdate)));
					$appEnd = date("Y-m-d H:i:s", strtotime("+" .$tm_df. " minutes", strtotime($appointment->enddate)));
				?>
				events.push({
					id: '{{$appointment->id}}',
					start: '{{str_replace(" ","T",$appStart)}}',
					end: '{{str_replace(" ","T",$appEnd)}}',
					title: '{{$appointment->course_title}} | {{$appointment->in_fname}} {{$appointment->in_lname}}',
				});
			@endforeach
		@endif

		document.addEventListener('DOMContentLoaded', function() {
			var calendarEl = document.getElementById('calendar');
        	var today = new Date();
			var calendar = new FullCalendar.Calendar(calendarEl, {
				headerToolbar: {
					left: 'prev,next today',
					center: 'title',
					right: 'dayGridMonth,timeGridWeek,timeGridDay'
				},
				navLinks: true,
				selectable: false,
				selectMirror: true,
				slotDuration: '00:45',
            	nowIndicator: false,
				slotLabelFormat: [{
					hour: '2-digit',
					minute: '2-digit',
					hour12: false
				}],
            	firstDay: today.getDay(),
				eventTimeFormat: {
					hour: '2-digit',
					minute: '2-digit',
					hour12: false
				},
				select: function(arg) {
					calendar.unselect()
				},
				eventClick: function(arg) {
					if (confirm('Are you sure you want to delete this event?')) {
						arg.event.remove()
					}
				},
				editable: true,
				dayMaxEvents: true,
				events: events
			});

			calendar.render();
		});
		function displayMessage(message) {
			$(".response").html("<div class='success'>"+message+"</div>");
			setInterval(function() { $(".success").fadeOut(); }, 1000);
		}
	</script>
@endsection