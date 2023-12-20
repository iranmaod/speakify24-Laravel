<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title></title>

<link href="https://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700" rel="stylesheet" type="text/css">


</head>
<body >
  
  <div style="margin:0 auto;padding:0;max-width:600px;">
    <a href="#"><img style="display: block;margin-bottom:-10px;background-color:#EFEDE9;" src="{{ asset('https://speakify24.de/frontend/speakifyemailtop.png') }}" alt=""></a>
     <div style="background-color:#EFEDE9; max-width:600px;width:100%; height:auto;">
      <div style="padding-top: 30px;">
        @yield('content')

        

      </div>
      <a href="#"><img src="{{ asset('https://speakify24.de/frontend/speakifyemailbot.png') }}" alt=""></a>
     
     <p style="font-size: 10px;">
        © Speakify24 Bitte antworte nicht auf diese Nachricht.
     </p>
     </div>
   
          
</div>
</body>
</html>
