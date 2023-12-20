@extends('layouts.bookemail')
<?php
use Carbon\Carbon;


$to_time = date("Y-m-d H:i:s");
date_default_timezone_set('Europe/Berlin');
$from_time = date("Y-m-d H:i:s");
$diff = round(abs(strtotime($to_time) - strtotime($from_time)) / 60,2). " minutes";
$now = date("Y-m-d H:i:s",strtotime($data->startdate . " +" . $diff));
// $now = date("Y-m-d H:i:s",strtotime($data->startdate));

$date_time = new DateTime($now);
$date = $date_time->format('l d-m-Y');
$time = $date_time->format('h:i A');
 
$time  = date("H:i", strtotime($time));
?>
@section('content')

     <h3 style="text-align: center;font-size:25px;">Hallo {{$data->instructor->first_name}}</h3>
     <p style="text-align: center;font-size:16px;"> {{$data->student->first_name}} hat gerade eine Unterrichtsstunde bei dir gebucht<br>
      {{-- {{ \Carbon\Carbon::parse( $now )->toDayDateTimeString() }} --}}
      {{$date}}
      um {{$time}} CET.
       <br>
       Viel Spaß!
    </p>

    <p style="text-align: center;font-size:16px;">
        Dein {{ env('APP_NAME') }} Team<br>
        <p style="text-align: center;font-size:12px;">Unterricht stornieren:
            <a href="https://speakify24.de/listing">https://speakify24.de/listing</a>
        </p> <br>
        
      </p>

@endsection
