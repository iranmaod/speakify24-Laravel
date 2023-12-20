@extends('layouts.debookemail')
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
  
   <h3 style="text-align: center;font-size:25px;">Hallo {{$data->student->first_name}}</h3>
     <p style="text-align: center;font-size:16px;">Deine nächste Stunde mit {{$data->instructor->first_name}} ist morgen am<br>
      {{$date}}
      um {{$time}} CET. 
      
      <br>
        Logge dich ein und klicke auf das blaue Kamerasymbol neben deinem Namen.<br>
        Viel Spaß!
        
    </p>

    <p style="text-align: center;font-size:16px;">
        Dein {{ env('APP_NAME') }} Team<br>
        <p style="text-align: center;font-size:12px;">Log-in: <a href="https://speakify24.de/login">https://speakify24.de/login</a> <br>
         Folge uns auf Instagram: <a href="www.instagram.com/speakify24/">www.instagram.com/speakify24/</a><br>
         und Facebook:  <a href="www.facebook.com/Speakify24">www.facebook.com/Speakify24</a>
         </p> 
      </p>
  
@endsection
