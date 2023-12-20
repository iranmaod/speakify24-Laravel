@extends('layouts.debookemail')


@section('content')

   
   <h3 style="text-align: center;font-size:25px;">Hallo {{$data->msg_to->first_name}}</h3>
     <p style="text-align: center;font-size:16px;">Du hast eine neue Chat-Nachricht <br>
        Logge dich bei Speakify24 ein, um sie zu lesen. 
        
    </p>

    <p style="text-align: center;font-size:16px;">
        Dein {{ env('APP_NAME') }} Team<br>
        <p style="text-align: center;font-size:12px;">Weitere Stunde buchen: <a href="https://speakify24.de/teachers">https://speakify24.de/teachers</a> <br>
         Folge uns auf Instagram: <a href="www.instagram.com/speakify24/">www.instagram.com/speakify24/</a><br>
         und Facebook:  <a href="www.facebook.com/Speakify24">www.facebook.com/Speakify24</a>
         </p>
        
      </p>
   
   
@endsection
