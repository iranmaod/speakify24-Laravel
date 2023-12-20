@extends('layouts.bookemail')


@section('content')

  
   <h3 style="text-align: center; font-size:25px;">Hi {{$data->msg_to->first_name}}</h3>
     <p style="text-align: center;">You have unread chat messages <br>
        Log-in to read.
        
    </p>

    <p style="text-align: center; font-size:16px;">
        Your {{ env('APP_NAME') }} Team<br>
    </p>   
        <small>
          <p style="text-align: center; font-size:12px;">Log-in: <a href="https://speakify24.de/login">https://speakify24.de/login</a> <br>
            Follow us on Instagram: <a href="www.instagram.com/speakify24/">www.instagram.com/speakify24/</a> <br>
            and Facebook:  <a href="www.facebook.com/Speakify24">www.facebook.com/Speakify24</a>
          </p>

        </small>
       
        
      
       
  
@endsection
