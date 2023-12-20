@extends('layouts.frontend.index')

@section('content')
<!-- content start -->
    <div class="container-fluid p-0 home-content container-top-border">
        <div class="subpage-slide-blue bgcoverimg" style="background-image: url(././frontend/img/speakify24-methoden.jpg)">
            <div class="container">
                <?php
                $session = \App::getLocale();
                if (session()->get('locale') != '') {
                    $session = session()->get('locale');
                }
                $config = \DB::table('options')->where('code', 'pageStudent')->where('locale', $session)->get();
             
            ?>
        
                <h1>
                
                @if($session == 'de') {{ __('Melden Sie sich als Student an') }} @else {{ __('Sign Up As Student') }} @endif

                </h1>
            </div>
        </div>
        <!-- account block start -->
        <div class="container">
            <nav class="navbar clearfix secondary-nav pt-0 pb-0 login-page-seperator">
                <ul class="list mt-0">
                     <li><a href="{{ route('login') }}" >Login</a></li>
                     <li><a href="{{ route('register') }}" class="active">Register</a></li>
                </ul>
            </nav>

           
            @foreach($config as $con)
                {!!  $con->option_value !!}
            @endforeach

            <div class="row">
                <div class="col-xl-6 offset-xl-0 col-lg-6 offset-lg-0 col-md-8 m-auto">
                    <div class="rightRegisterForm">
                        <!-- <h4 class="text-center p-1">Student Registration</h4> -->
                    <form class="form-horizontal" method="POST" action="{{ route('register') }}" id="registerForm">
                        {{ csrf_field() }}
                        <div class="">
                            <input type="hidden" name="comm_lang" value="deEmail">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-6">
                                        <label>
                                            {{ __('register.fname') }}
                                            {{-- @if($session == 'de') {{ __('Vor Name') }} @else {{ __('First Name') }} @endif --}}
                                        </label>
                                        <input type="text" class="form-control form-control-sm" placeholder="{{ __('register.fname') }}" name="first_name"   >
                                        @if ($errors->has('first_name'))
                                        <label class="error" for="first_name">{{ $errors->first('first_name') }}</label>
                                        @endif
                                    </div>
                                    <div class="col-6">
                                        <label>
                                            {{ __('register.lname') }}
                                        </label>
                                        <input type="text" class="form-control form-control-sm" placeholder="{{ __('register.lname') }}" value="{{ old('last_name') }}" name="last_name">
                                        @if ($errors->has('last_name'))
                                        <label class="error" for="last_name">{{ $errors->first('last_name') }}</label>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Email ID</label>
                                <input type="text" class="form-control form-control-sm" placeholder="Email ID" value="@if(!empty($name)){{ $email }}@else{{ old('email') }}@endif" name="email">
                                @if ($errors->has('email'))
                                <label class="error" for="email">{{ $errors->first('email') }}</label>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>
                                    {{ __('register.pass') }}  
                                 </label>
                                <input type="password" class="form-control form-control-sm" placeholder="{{ __('register.pass') }}" name="password" id="password">
                                @if ($errors->has('password'))
                                <label class="error" for="password">{{ $errors->first('password') }}</label>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>
                                    {{ __('register.cpass') }}
                                </label>
                                <input type="password" class="form-control form-control-sm" placeholder="{{ __('register.cpass') }}" name="password_confirmation">
                                @if ($errors->has('password_confirmation'))
                                <label class="error" for="password_confirmation">{{ $errors->first('password_confirmation') }}</label>
                                @endif
                            </div>

                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="offer" name="offer" {{ old('offer') ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="offer">
                                        {{ __('register.regisTerms1') }}
                                    </label>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="terms" name="terms" {{ old('terms') ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="terms"><a href="/condition" target="_blank">
                                        {{ __('register.regisTerms2') }}

                                    </a></label>
                                    @if ($errors->has('terms'))
                                        <label class="error" for="terms">{{ $errors->first('terms') }}</label>
                                    @endif
                                </div>
                            </div>

                            <input type="hidden" name="ip" value="" />
                            <input type="hidden" name="timezone" value="" />

                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-lg btn-block login-page-button">
                                    @if($session == 'de') {{ __('Registrieren') }} @else {{ __('Register') }} @endif
                                </button>
                            </div>

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
$(document).ready(function()
{
    $("#registerForm").validate({
        rules: {
            first_name: {
                required: true
            },
            last_name: {
                required: true
            },
            email:{
                required: true,
                email:true,
                remote: "{{ url('checkUserEmailExists') }}"
            },
            password:{
                required: true,
                minlength: 6
            },
            password_confirmation:{
                required: true,
                equalTo: '#password'
            }
        },
        messages: {
            first_name: {
                required: 'The fname field is required.'
            },
            last_name: {
                required: 'The lname field is required.'
            },
            email: {
                required: 'The email field is required.',
                email: 'The email must be a valid email address.',
                remote: 'The email has already been taken.'
            },
            password: {
                required: 'The password field is required.',
                minlength: 'The password must be at least 6 characters.'
            },
            password_confirmation: {
                required: 'The password confirmation field is required.',
                equalTo: 'The password confirmation does not match.'
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