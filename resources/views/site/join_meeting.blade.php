@extends('layouts.frontend.index')
@section('content')
<div class="container-fluid p-0 home-content container-top-border">
    <div class="container">
        <div class="row">
            <div class="col-xl-10 offset-xl-0 col-lg-10 offset-lg-0 col-md-8 mt-5 ml-auto mr-auto">
                <div id="meet"></div>
            </div>
        </div>
    </div>
</div>
<form action="{{ route('meetdata') }}" method="post" id="meetdata_form">
    @csrf
    <input type="hidden" name="time" value="" />
    <input type="hidden" name="appointment_id" value="{{$appointment->id}}" />
</form>
@endsection

@section('javascript')
<script src='https://8x8.vc/external_api.js'></script>
<script type="text/javascript">
    var api_id = 'vpaas-magic-cookie-f28545654cdf498f82c4dea3a5a591e5';
    var name = '{{str_replace(" ", "", $appointment->title)}}_{{$appointment->id}}';
    var token = '{{ $token }}';
    @if($api_id != null)
        api_id = '{{ $api_id }}';
    @endif
    @if($name != null)
        name = '{{ $name }}';
    @endif

    window.onload = () => {
        var starttime = new Date();
        var endtime = new Date();
        const api = new JitsiMeetExternalAPI("8x8.vc", {
            roomName: api_id + "/" + name,
            parentNode: document.querySelector('#meet'),
            jwt: token,
            width: 1050,
            height: 620,
        });

        api.addListener('readyToClose', function(e) {

        });

        api.addListener('participantJoined', function(e) {

        });

        api.addListener('participantLeft', function(e) {

        });

        api.addListener('videoConferenceJoined', function(e) {
            starttime = new Date();
        });

        api.addListener('videoConferenceLeft', function(e) {
            endtime = new Date();
            var startHour = starttime.getHours();
            var endHour = endtime.getHours();
            var startMins = starttime.getMinutes();
            var endMins = endtime.getMinutes();
            var startSecs = starttime.getSeconds();
            var endSecs = endtime.getSeconds();
            var secDiff = endSecs - startSecs;
            var minDiff = endMins - startMins;
            var hrDiff = endHour - startHour;
            console.log("HR: " + hrDiff);
            console.log("MN: " + minDiff);
            console.log("SE: " + secDiff);
            console.log(hrDiff+":"+minDiff+":"+secDiff);

            $("input[name=time]").val(hrDiff+":"+minDiff+":"+secDiff);
            $("#meetdata_form").submit();
        });
    }
</script>
@endsection