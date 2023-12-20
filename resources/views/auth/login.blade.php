@extends('layouts.frontend.index')

@section('content')
<!-- content start -->
    <div class="container-fluid p-0 home-content container-top-border">
        <!-- account block start -->
        <div class="container">
            <nav class="navbar clearfix secondary-nav pt-0 pb-0 login-page-seperator">
                <ul class="list mt-0">
                     <li><a href="{{ route('login') }}" class="active">Login</a></li>
                     <li><a href="{{ route('register') }}">Register</a></li>
                </ul>
            </nav>

            <?php
                $session = \App::getLocale();
                if (session()->get('locale') != '') {
                    $session = session()->get('locale');
                }
                $config = \DB::table('options')->where('code', 'pageLogin')->where('locale', $session)->get();
  
            ?>
            @foreach($config as $con)
                {!!  $con->option_value !!}
           
            <div class="row">
               
                <div class="col-xl-6 offset-xl-0 col-lg-6 offset-lg-0 col-md-8 m-auto">
                    <div class="rightRegisterForm">
                        @endforeach
                        @if($errors->any())
                        <h6 class="text-danger">{{$errors->first()}}</h6>
                        @endif
                    <form id="loginForm" class="form-horizontal" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}
                        <div class="">
                            <div class="form-group">
                                <label>
                                    Email ID
                                </label>
                                <input name="email" type="text" class="form-control form-control-sm" placeholder="Email ID" value="{{ old('email') }}">
                                @if ($errors->has('email'))
                                <label class="error" for="email">{{ $errors->first('email') }}</label>
                                @endif
                                
                            </div>
                            <div class="form-group">
                                <label>
                                    @if($session == 'de') {{ __('Passwort') }} @else {{ __('Password') }} @endif

                                </label>
                                <input name="password" type="password" class="form-control form-control-sm" placeholder="@if($session == 'de') {{ __('Passwort') }} @else {{ __('Password') }} @endif" value="{{ old('password') }}">
                                @if ($errors->has('password'))
                                <label class="error" for="password">{{ $errors->first('password') }}</label>
                                @endif
                            </div>
                            <div class="form-group">
                                <div class="row m-0">
                                    <div class="custom-control custom-checkbox col-6">
                                        <input type="checkbox" class="custom-control-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="remember">
                                            {{ __('register.remember') }}

                                        </label>
                                    </div>
                                    <div class="col-6">
                                        <a href="{{ route('password.request') }}" class="float-right forgot-text">
                                            {{ __('register.forgotpass') }}

                                        </a>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" name="ip" value="" />
                            <input type="hidden" name="timezone" value="" />

                            <div class="form-group">
                                <button type="submit" class="btn btn-lg btn-block login-page-button">
                                    @if($session == 'de') {{ __('Anmeldung') }} @else {{ __('Login') }} @endif
                                </button>
                            </div>
<!--
                            <div class="hr-container">
                               <hr class="hr-inline" align="left">
                               <span class="hr-text"> or </span>
                               <hr class="hr-inline" align="right">
                            </div>

                            <div class="form-group">
                                <a href="{{-- url('login/facebook') --}}" class="btn btn-lg btn-block social-btn facebook-btn">
                                    <div class="row">
                                        <div class="col-3">
                                            <i class="fab fa-facebook-f float-right"></i>
                                        </div>
                                        <div class="col-9">
                                            <span>
                                            Login with Facebook
                                            </span>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="form-group">
                                <a href="{{-- url('login/google') --}}" class="btn btn-lg btn-block social-btn google-btn">
                                    <div class="row">
                                        <div class="col-3">
                                            <i class="fab fa-google-plus-g float-right"></i>
                                        </div>
                                        <div class="col-9">
                                            <span>
                                            Login with Google plus
                                            </span>
                                        </div>
                                    </div>
                                </a>
                            </div>
-->
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- account block end -->
    </div>
    <!-- content end -->
@endsection

@section('javascript')
<script type="text/javascript">
$(document).ready(function() {
    $("#loginForm").validate({
        rules: {
            email:{
                required: true,
                email:true
            },
            password:{
                required: true
            }
        },
        messages: {
            email: {
                required: 'The email field is required.',
                email: 'The email must be a valid email address.'
            },
            password: {
                required: 'The password field is required.'
            }
        }
    });

    $.get('https://api.db-ip.com/v2/free/self', function(data) {
        console.log(data.ipAddress);
        $("input[name=ip]").val(data.ipAddress);
    });
    $.get('https://json.geoiplookup.io/?callback=', function(data) {
        var jsonData = JSON.parse(data.slice(1,-2));
        $("input[name=timezone]").val(jsonData.timezone_name);
        console.log(JSON.parse(data.slice(1,-2)));
    });
});
</script>
@endsection