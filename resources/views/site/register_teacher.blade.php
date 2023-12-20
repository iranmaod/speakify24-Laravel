@extends('layouts.frontend.index')
@isset($config)
@php
$seo = $config->first();
@endphp
@section('title', $seo->seo_title )
@section('meta_description', $seo->seo_description)
@section('meta_keywords', $seo->seo_keywords)
@endisset

@section('content')
<div class="container-fluid p-0 home-content container-top-border">
        <div class="subpage-slide-blue bgcoverimg" style="background-image: url(././frontend/img/people-using-online-translation.jpg)">
            <div class="container">
                <?php
        $session = \App::getLocale();
        if (session()->get('locale') != '') {
            $session = session()->get('locale');
        }
         
             ?>
                <h1>
                    @if($session == 'de') {{ __('Melden Sie sich als Lehrer an') }} @else {{ __('Sign Up As Teacher') }} @endif

                </h1>
            </div>
        </div>
        
    <div class="container">

        @foreach($config as $con)
            {!!  str_replace('../../', '', $con->option_value) !!}
        @endforeach

        <div class="row">
            <div class="col-xl-10 offset-xl-0 col-lg-10 offset-lg-0 col-md-8 m-auto">
                <div style="margin-top:50px;">
                    <!-- <h4 class="text-center p-1">Teacher Registration</h4> -->
                    <form class="form-horizontal" method="POST" action="{{ route('register') }}" id="registerForm" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="teacher" value="1" />
                        <div class="">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-6">
                                        <label>
                                            {{ __('register.fname') }}
  
                                        <span class="required">*</span></label>
                                        <input type="text" class="form-control form-control-sm" placeholder="{{ __('register.fname') }}" value="@if(!empty($name)){{ $name }}@else{{ old('first_name') }}@endif" name="first_name"   >
                                        @if ($errors->has('first_name'))
                                        <label class="error" for="first_name">{{ $errors->first('first_name') }}</label>
                                        @endif
                                    </div>
                                    <div class="col-6">
                                        <label>
                                            {{ __('register.lname') }}    
                                        <span class="required">*</span></label>
                                        <input type="text" class="form-control form-control-sm" placeholder="{{ __('register.lname') }} " value="{{ old('last_name') }}" name="last_name">
                                        @if ($errors->has('last_name'))
                                        <label class="error" for="last_name">{{ $errors->first('last_name') }}</label>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-6">
                                        <label>Email <span class="required">*</span></label>
                                        <input type="text" class="form-control form-control-sm" placeholder="Email ID" value="@if(!empty($name)){{ $email }}@else{{ old('email') }}@endif" name="email">
                                        @if ($errors->has('email'))
                                        <label class="error" for="email">{{ $errors->first('email') }}</label>
                                        @endif
                                    </div>
                                    <div class="col-6">
                                        <label>
                                            {{ __('register.phone') }}      
                                        <span class="required">*</span></label>
                                        <input type="text" class="form-control form-control-sm" placeholder="{{ __('register.phone') }} " value="{{ old('telephone') }}" name="telephone">
                                        @if ($errors->has('telephone'))
                                        <label class="error" for="email">{{ $errors->first('telephone') }}</label>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-6">
                                        <label>
                                            {{ __('register.pass') }}     
                                        <span class="required">*</span></label>
                                        <input type="password" class="form-control form-control-sm" placeholder="{{ __('register.pass') }} " name="password" id="password">
                                        @if ($errors->has('password'))
                                        <label class="error" for="password">{{ $errors->first('password') }}</label>
                                        @endif
                                    </div>
                                    <div class="col-6">
                                        <label>
                                            {{ __('register.cpass') }}    
                                        <span class="required">*</span></label>
                                        <input type="password" class="form-control form-control-sm" placeholder="{{ __('register.cpass') }} " name="password_confirmation">
                                        @if ($errors->has('password_confirmation'))
                                        <label class="error" for="password_confirmation">{{ $errors->first('password_confirmation') }}</label>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-4">
                                        <label>
                                            {{ __('register.country') }}     
                                        <span class="required">*</span></label>
                                        <select class="form-control form-control-sm" name="country_id">
                                            @foreach($countries as $country)
                                                <option value="{{ $country->id }}" {{ $country->id == old('country_id') ? 'selected' : '' }}>{{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('country_id'))
                                        <label class="error" for="email">{{ $errors->first('country_id') }}</label>
                                        @endif
                                    </div>
                                    <div class="col-3">
                                        <label>
                                            {{ __('register.street') }}
                                         <span class="required">*</span></label>
                                        <input type="text" class="form-control form-control-sm" placeholder="{{ __('register.street') }}" value="{{ old('street') }}" name="street">
                                        @if ($errors->has('street'))
                                        <label class="error" for="street">{{ $errors->first('street') }}</label>
                                        @endif
                                    </div>
                                    <div class="col-3">
                                        <label>
                                            {{ __('register.city') }}    
                                        <span class="required">*</span></label>
                                        <input type="text" class="form-control form-control-sm" placeholder="{{ __('register.city') }}" value="{{ old('city') }}" name="city">
                                        @if ($errors->has('city'))
                                        <label class="error" for="city">{{ $errors->first('city') }}</label>
                                        @endif
                                    </div>
                                    <div class="col-2">
                                        <label>
                                            {{ __('register.zip') }}   
                                        <span class="required">*</span></label>
                                        <input type="text" class="form-control form-control-sm" placeholder="{{ __('register.zip') }} " value="{{ old('zip') }}" name="zip">
                                        @if ($errors->has('zip'))
                                        <label class="error" for="zip">{{ $errors->first('zip') }}</label>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-6">
                                        <label>
                                            {{ __('register.taxno') }}      
                                        <span class="required">*</span></label>
                                        <input type="text" class="form-control form-control-sm" placeholder="{{ __('register.taxno') }}" value="{{ old('tax_number') }}" name="tax_number">
                                        @if ($errors->has('tax_number'))
                                        <label class="error" for="tax_number">{{ $errors->first('tax_number') }}</label>
                                        @endif
                                    </div>
                                    <div class="col-6">
                                        <label>Paypal ID <span class="required">*</span></label>
                                        <input type="text" class="form-control form-control-sm" placeholder="Paypal ID" value="{{ old('paypal_id') }}" name="paypal_id">
                                        @if ($errors->has('paypal_id'))
                                        <label class="error" for="email">{{ $errors->first('paypal_id') }}</label>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-3">
                                        <label>
                                            {{ __('register.mtongue') }}    
                                        <span class="required">*</span></label>
                                        <select class="form-control form-control-sm" name="language_speak_id">
                                            @foreach($languages as $lang)
                                                <option value="{{ $lang->id }}" {{ $lang->id == old('language_speak_id') ? 'selected' : '' }}>{{ $lang->title }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('language_speak_id'))
                                        <label class="error" for="email">{{ $errors->first('language_speak_id') }}</label>
                                        @endif
                                    </div>
                                    <div class="col-3">
                                        <label>
                                            {{ __('register.LangTaught') }}     
                                        <span class="required">*</span></label>
                                        <select class="form-control form-control-sm" name="language_teach_id">
                                            @foreach($languages as $lang)
                                                <option value="{{ $lang->id }}" {{ $lang->id == old('language_teach_id') ? 'selected' : '' }}>{{ $lang->title }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('language_teach_id'))
                                        <label class="error" for="email">{{ $errors->first('language_teach_id') }}</label>
                                        @endif
                                    </div>
                                    <div class="col-3">
                                        <label>
                                            {{ __('register.photo') }}    
                                        <span class="required">*</span></label>
                                        <input type="file" class="form-control form-control-sm" placeholder="{{ __('register.photo') }}" value="{{ old('photo') }}" name="photo" accept="image/*;capture=camera">
                                        @if ($errors->has('photo'))
                                        <label class="error" for="email">{{ $errors->first('photo') }}</label>
                                        @endif
                                    </div>
                                    <div class="col-3">
                                        <label>CV <span class="required">*</span></label>
                                        <input type="file" class="form-control form-control-sm" placeholder="CV" value="{{ old('cv') }}" name="cv" accept="image/*;capture=camera">
                                        @if ($errors->has('cv'))
                                        <label class="error" for="email">{{ $errors->first('cv') }}</label>
                                        @endif
                                    </div>
                                </div>  
                            </div>

                            <div class="row">
                                <div class="form-group col-md-12"><h3>
                                    {{ __('register.biography') }}     
                                </h3></div>
                                <div class="form-group col-md-4">
                                    <label class="form-control-label">
                                        {{ __('register.who') }}     
                                    <span class="required">*</span></label>
                                    <textarea name="who" class="form-control form-control-sm">{!! old('who') !!}</textarea>
                                    @if ($errors->has('who'))
                                        <label class="error" for="who">{{ $errors->first('who') }}</label>
                                    @endif
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="form-control-label">
                                        {{ __('register.experience') }}      
                                    <span class="required">*</span></label>
                                    <textarea name="experience" class="form-control form-control-sm">{!! old('experience') !!}</textarea>
                                    @if ($errors->has('experience'))
                                        <label class="error" for="experience">{{ $errors->first('experience') }}</label>
                                    @endif
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="form-control-label">
                                        {{ __('register.job') }}      
                                    <span class="required">*</span></label>
                                    <textarea name="love_job" class="form-control form-control-sm">{!! old('love_job') !!}</textarea>
                                    @if ($errors->has('love_job'))
                                        <label class="error" for="love_job">{{ $errors->first('love_job') }}</label>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="custom-control custom-checkbox col-md-6">
                                        <input type="checkbox" class="custom-control-input" id="over_18" name="over_18" {{ old('over_18') ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="over_18">
                                            {{ __('register.agreement18') }} 
                                        </label>
                                        @if ($errors->has('over_18'))
                                            <label class="error" for="terms">{{ $errors->first('over_18') }}</label>
                                        @endif
                                    </div>
                                    <div class="custom-control custom-checkbox col-md-6">
                                        <input type="checkbox" class="custom-control-input" id="terms" name="terms" {{ old('terms') ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="terms"><a href="{{ url('terms-conditions') }}" target="_blank">
                                            {{ __('register.regisTerms2') }}
                                        </a></label>
                                        @if ($errors->has('terms'))
                                            <label class="error" for="terms">{{ $errors->first('terms') }}</label>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" name="ip" value="" />
                            <input type="hidden" name="timezone" value="" />

                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-lg btn-block login-page-button">Register</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script type="text/javascript">
    $(document).ready(function() {
        // tinymce.init({ 
        //     selector:'textarea',
        //     menubar:false,
        //     statusbar: false,
        //     content_style: "#tinymce p{color:#76838f;}",
        //     mobile: {
        //         theme: 'silver'
        //     }
        // });

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