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
 
   <h3 style="text-align: center;font-size:25px;">Hi {{$data->student->first_name}}</h3>
     <p style="text-align: center;font-size:16px;">Your teacher {{$data->instructor->first_name}} just cancelled your lesson on<br>
      {{$date}}
      at {{$time}} CET.
       <br>
        
    </p>

    <p style="text-align: center;font-size:16px;">
        Your {{ env('APP_NAME') }} Team<br>
        <p style="text-align: center;font-size:12px;">Book new lesson <a href="https://speakify24.de/teachers">https://speakify24.de/teachers</a> <br>
          Follow us on Instagram: <a href="www.instagram.com/speakify24/">www.instagram.com/speakify24/</a> <br>
          and Facebook:  <a href="www.facebook.com/Speakify24">www.facebook.com/Speakify24</a>
        </p>
        
      </p>
       
  

@endsection
