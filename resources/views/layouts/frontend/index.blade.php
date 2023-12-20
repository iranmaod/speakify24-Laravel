<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Speakify24  @yield('title')</title>
        <meta name="description" content="@yield('meta_description','Speakify24 offers high-quality language courses and professional language services. Learn, improve, and master languages with our experienced instructors. Join us for effective and engaging language learning.')">
        <meta name="keywords" content="@yield('meta_keywords','Language courses, Speakify24 Learning, Online language learning, Language tutors, Multilingual education, Speakify24 Appointments')">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="robots" content="all,follow">


        @yield('css')
        <!-- Bootstrap CSS-->
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/css/fancybox.css') }}">
        
        <link rel="stylesheet" href="{{ asset('frontend/css/font-awesome.css') }}">

        <link rel="stylesheet" href="{{ asset('backend/fonts/web-icons/web-icons.min599c.css?v4.0.2') }}">
        <link rel="stylesheet" href="{{ asset('backend/vendor/toastr/toastr.min599c.css?v4.0.2') }}">
        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('js/calendar_lib/main.css') }}">
        
    </head>
    <body>
        <div class="se-pre-con"></div>
        <!-- Header -->
        <?php
            $session = \App::getLocale();
            if (session()->get('locale') != '') {
                $session = session()->get('locale');
            }
        ?>
        <nav class="navbar navbar-default fixed-top">
            <div class="row container">
                <div class="col-6 col-sm-4 col-md-3 col-lg-2 col-xl-2" id="logo">
                    <i class="fa fa-bars d-inline-block d-md-none mobile-nav"></i>
                    <a href="{{ route('home') }}" class=""><img src="{{ asset('frontend/img/logo.png') }}" width="100" height="23" /></a>
                </div>
                <div class="col-md-3 col-lg-6 col-xl-6 d-none d-md-block">
                    <ul class="dropdown pl-0 float-left" >
                        <li class="active"><a href="{{ route('home') }}">@if($session == 'de') {{ __('Home') }} @else {{ __('Home') }} @endif</a></li>
                        
                        <?php $categories = SiteHelpers::active_categories(); ?>

                        @if(Auth::check() && !Auth::user()->hasRole('instructor'))
                            <li>
                                <a href="#" id="dropdownMenuButton" class="btn btn-ulearn booknowbtn" data-toggle="dropdown">@if($session == 'de') {{ __('Jetzt buchen') }} @else {{ __('Book now') }} @endif<i class="fa fa-chevron-down"></i></a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a href="{{ url('/teachers?language_id%5B%5D=2') }}" class="dropdown-item">@if($session == 'de') {{ __('Englisch') }} @else {{ __('English') }} @endif</a>
                                    <a href="{{ url('/teachers?language_id%5B%5D=3') }}" class="dropdown-item">@if($session == 'de') {{ __('Spanisch') }} @else {{ __('Spanish') }} @endif</a>
                                    <a href="{{ url('/teachers?language_id%5B%5D=4') }}" class="dropdown-item">@if($session == 'de') {{ __('Deutsch') }} @else {{ __('German') }} @endif</a>
                                    <a href="{{ url('/teachers?language_id%5B%5D=5') }}" class="dropdown-item">@if($session == 'de') {{ __('Italienisch') }} @else {{ __('Italian') }} @endif</a>
                                
                                </div>
                            </li>
                        @endif

                        <li><a href="#" id="dropdownMenuButton" data-toggle="dropdown">@if($session == 'de') {{ __('So funktioniert es') }} @else {{ __('How it works') }} @endif<i class="fa fa-chevron-down"></i></a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a href="{{ url('/ourplatform') }}" class="dropdown-item">@if($session == 'de') {{ __('Unsere Plattform') }} @else {{ __('Our Platform') }} @endif</a>
                                <a href="{{ url('/ourmethod') }}" class="dropdown-item">@if($session == 'de') {{ __('Unsere Methode') }} @else {{ __('Our Method') }} @endif</a>
                                <a href="{{ url('/ourteachers') }}" class="dropdown-item">@if($session == 'de') {{ __('Unsere Lehrkräfte') }} @else {{ __('Our Teachers') }} @endif</a>
                                <a href="{{ url('/ourcertificates') }}" class="dropdown-item">@if($session == 'de') {{ __('Unsere Zertifikate') }} @else {{ __('Our Certificates') }} @endif</a>
                            
                            </div>
                        </li>
                        <li><a href="#" id="dropdownMenuButton" data-toggle="dropdown">@if($session == 'de') {{ __('Sprachen') }} @else {{ __('Languages') }} @endif <i class="fa fa-chevron-down"></i></a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a href="{{ url('/english') }}" class="dropdown-item">@if($session == 'de') {{ __('Englisch') }} @else {{ __('English') }} @endif</a>
                                <a href="{{ url('/spanish') }}" class="dropdown-item">@if($session == 'de') {{ __('Spanisch') }} @else {{ __('Spanish') }} @endif</a>
                                <a href="{{ url('/german') }}" class="dropdown-item">@if($session == 'de') {{ __('Deutsch') }} @else {{ __('German') }} @endif</a>
                                <a href="{{ url('/italian') }}" class="dropdown-item">@if($session == 'de') {{ __('Italienisch') }} @else {{ __('Italian') }} @endif</a>
                            </div>
                        </li>
                        <!-- <li><a href="{{-- route('instructor.list') --}}">Teachers</a></li> -->
                        <li><a href="#" id="dropdownMenuButton" data-toggle="dropdown">@if($session == 'de') {{ __('Unsere Zielgruppen') }} @else {{ __('Our Clients') }} @endif <i class="fa fa-chevron-down"></i></a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a href="{{ url('/schoolchildrenandstudent') }}" class="dropdown-item">@if($session == 'de') {{ __('Schüler & Studenten') }} @else {{ __('Students') }} @endif</a>
                                <a href="{{ url('/privatecitizen') }}" class="dropdown-item">@if($session == 'de') {{ __('Privatperson') }} @else {{ __('Private Clients') }} @endif</a>
                                <a href="{{ url('/forcompanies') }}" class="dropdown-item">@if($session == 'de') {{ __('Für Unternehmen') }} @else {{ __('Companies') }} @endif</a>
                            
                            </div>
                        </li>
                        <li><a href="{{ url('/prices') }}">@if($session == 'de') {{ __('Preise') }} @else {{ __('Prices') }} @endif</a></li>
                    </ul>
                </div>
    
                <div class="col-6 col-sm-3 col-md-6 col-lg-4 col-xl-4 rightmenu text-right">
                    @if(Auth::check())
                        @php
                            $messages = \DB::table('messages')->where('to', \Auth::user()->id)
                                                ->where('is_read', '0')
                                                ->get();
                        @endphp
                        <div id="messagelink" style="display:inline-block;margin-right: 10px;">
                            <a class="remining_lectures" title="Messages" href="{{ url('/messages') }}"><img style="width:22px;" src="{{ asset('frontend/img/menu-chat.png') }}" /><span class="message_count">{{ count($messages) }}</span></a>
                        </div>
                    @endif
                    <div id="chk_meet" style="display:inline-block;margin-right: 10px;">
                    @if(Auth::check() && !Auth::user()->hasRole('instructor') && !Auth::user()->hasRole('admin'))
                        <?php
                            $appointment = \DB::table('appointments')->where('user_id', \Auth::user()->id)
                                                ->where('status', '1')
                                                ->whereIn('start', ['1', '2'])
                                                ->orderBy('updated_at', 'desc')
                                                ->first();
                        ?>
                        @if ($appointment)
                            @if(time() <= strtotime($appointment->enddate))
                                <?php
                                    $name = str_replace(" ", "", $appointment->title) . "_" . $appointment->id;
                                ?>
                            <a class="btn btn-sm btn-primary" title="Join Meeting" href="{{ route('joinmeeting', ['api_id' => 'vpaas-magic-cookie-f28545654cdf498f82c4dea3a5a591e5', 'name' => $name]) }}"><i class="fas fa-video"></i></a>
                            @endif
                        @endif
                    @endif
                    </div>

                    <div id="remain_lectures" style="display:inline-block;margin-right: 10px;">
                    @if(Auth::check() && !Auth::user()->hasRole('instructor') && !Auth::user()->hasRole('admin'))
                        <?php
                        $transactions = \DB::table('transactions')
                                            ->where('user_id', \Auth::user()->id)
                                            ->where('created_at', '>=', date('Y-m-d H:i:s', strtotime('-1 month')))
                                            ->orderBy('created_at', 'desc')
                                            ->get()
                                            ;


                        //new//
                        date_default_timezone_set('Europe/London');
                         $endTime = date('Y-m-d H:i:s');
                        $stu_credits = 0;                    
                        $stu_credits = \DB::table('students_credits')
                                        ->where('user_id', \Auth::user()->id)
                                        ->where('end_time','>',$endTime)
                                        ->get()->sum('hours')
                                        ;
                        //end//
                        
                        $remainingLectures = 0;
                        if ($transactions) {
                            foreach($transactions as $item) {
                                $hour = 0;
                                if ($item->type == 'package') {
                                    $plan = \DB::table('course_prices')->where('id', $item->type_id)->first();
                                    $hour = $plan->hours;
                                } elseif($item->type == 'plan') {
                                    $plan = \DB::table('subscription_plans')->where('id', $item->type_id)->first();
                                    $hour = $plan->per_month;
                                }
                                $remainingLectures = $remainingLectures + $hour;
                                $appointments = \DB::table('appointments')->where('transaction_id', $item->id)->get();
                                $remainingLectures = $remainingLectures - count($appointments);
                            }
                        ?>
                           <a style="text-decoration: none" href="{{url('mycredits')}}"><span class="remining_lectures" title="Lectures"><i class="fas fa-book-open"></i><span>{{ $remainingLectures + $stu_credits }}</span></span></a> 
                           
                        <?php
                        }
                    ?>

                    @endif
                    </div>
                
                    @guest
                        <span class="search-header beforelogin"><i class="fa fa-search"></i></span>
                        <div class="search-home">
                            <form method="GET" action="{{ route('course.list') }}">
                                <div class="searchbox-contrainer container">
                                    <input name="keyword" type="text" class="searchbox d-none d-sm-inline-block" placeholder="Search for courses by course titles"><input name="keyword" type="text" class="searchbox d-inline-block d-sm-none" placeholder="Search for courses"><button type="submit" class="searchbox-submit"><i class="fa fa-search"></i></button>
                                </div>
                            </form>
                        </div>
                        <div class="dropdown float-sm-right float-right" style="margin-left:10px;margin-top:10px;">
                            <span id="dropdownMenuButtonRightLang" data-toggle="dropdown"><i class="fa fa-globe"></i>&nbsp; {{ strtoUpper($session) }} &nbsp;<i class="fa fa-caret-down"></i></span>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButtonRightLang">
                                <a href="{{route('locale', 'en')}}" class="dropdown-item">EN</a>
                                <!-- <a href="{{route('locale', 'es')}}" class="dropdown-item">ES</a> -->
                                <a href="{{route('locale', 'de')}}" class="dropdown-item">DE</a>
                            </div>
                        </div>
                        <span class="loginsign">
                            <ul>
                                <li><a class="btn btn-learna login-btn" href="{{ route('login') }}">@if($session == 'de') {{ __('Einloggen') }} @else {{ __('Sign in') }} @endif</a></li>
                                <li class="dropdown">
                                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">@if($session == 'de') {{ __('Registrieren') }} @else {{ __('Sign Up') }} @endif
                                    <span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="{{ route('register') }}">@if($session == 'de') {{ __('Als Schüler') }} @else {{ __('As Student') }} @endif</a></li>
                                        <li><a href="{{ route('register.teacher') }}">@if($session == 'de') {{ __('Als Lehrer') }} @else {{ __('As Teacher') }} @endif</a></li>
                                    </ul>
                                </li>
                            </ul>
                            <!-- <a class="btn btn-learna signin-btn" href="{{ route('register') }}">Sign Up</a> -->
                        </span>
                    @else
                        <span class="search-header"><i class="fa fa-search"></i></span>
                        <div class="search-home">
                            <form method="GET" action="{{ route('course.list') }}">
                                <div class="searchbox-contrainer container">
                                    <input name="keyword" type="text" class="searchbox d-none d-sm-inline-block" placeholder="Search for courses by course titles"><input name="keyword" type="text" class="searchbox d-inline-block d-sm-none" placeholder="Search for courses"><button type="submit" class="searchbox-submit"><i class="fa fa-search"></i></button>
                                </div>
                            </form>
                        </div>
                        <div class="dropdown float-sm-right float-right" style="margin-left: 10px;">
                            <?php
                                $session = \App::getLocale();
                                if (session()->get('locale') != '') {
                                    $session = session()->get('locale');
                                }
                            ?>
                            <span id="dropdownMenuButtonRightLang" data-toggle="dropdown"><i class="fa fa-globe"></i>&nbsp; {{ strtoUpper($session) }} &nbsp;<i class="fa fa-caret-down"></i></span>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButtonRightLang">
                                <a href="{{route('locale', 'en')}}" class="dropdown-item">EN</a>
                                <!-- <a href="{{route('locale', 'es')}}" class="dropdown-item">ES</a> -->
                                <a href="{{route('locale', 'de')}}" class="dropdown-item">DE</a>
                            </div>
                        </div>
                        <div class="dropdown float-sm-right float-right">
                            <span id="dropdownMenuButtonRight" data-toggle="dropdown">{{ Auth::user()->first_name }} &nbsp;<i class="fa fa-caret-down"></i></span>
                        
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButtonRight">
                                @if(Auth::user()->hasRole('admin'))
                                <a class="dropdown-item" href="{{ route('admin.dashboard') }}" >
                                    <i class="fa fa-sign-out-alt"></i> @if($session == 'de') {{ __('Administrator') }} @else {{ __('Admin') }} @endif
                                </a>
                                @endif
                                @if(Auth::user()->hasRole('instructor'))
                                <a class="dropdown-item" href="{{ route('instructor.dashboard') }}" >
                                    <i class="fa fa-sign-out-alt"></i> @if($session == 'de') {{ __('Lehrer') }} @else {{ __('Instructor') }} @endif
                                </a>
                                @endif
                                {{-- @if(Auth::user()->hasRole('student'))
                                <a class="dropdown-item" href="{{ route('mytransactions') }}" >
                                    <i class="fa fa-sign-out-alt"></i> @if($session == 'de') {{ __('Meine Transaktionen') }} @else {{ __('My Transactions') }} @endif
                                </a>
                                @endif --}}
                                @if(Auth::user()->hasRole('student'))
                                <a class="dropdown-item" href="{{ route('my.appointments') }}" >
                                    <i class="fa fa-sign-out-alt"></i> @if($session == 'de') {{ __('Meine Termine') }} @else {{ __('My Appointments') }} @endif
                                </a>
                                @endif

                                @if(Auth::user()->hasRole('student'))
                                <a class="dropdown-item" href="{{ route('my.courses') }}" >
                                    <i class="fa fa-sign-out-alt"></i> @if($session == 'de') {{ __('Meine Kurse') }} @else {{ __('My Courses') }} @endif
                                </a>
                                @endif

                                {{-- @if(Auth::user()->hasRole('student'))
                                <a class="dropdown-item" href="{{ route('mycredits') }}" >
                                    <i class="fa fa-sign-out-alt"></i> @if($session == 'de') {{ __('Meine Credits') }} @else {{ __('My Credits') }} @endif
                                </a>
                                @endif --}}

                                <a class="dropdown-item" href="{{ route('logOut') }}" >
                                    <i class="fa fa-sign-out-alt"></i> @if($session == 'de') {{ __('Ausloggen') }} @else {{ __('Logout') }} @endif
                                </a>
                            </div>
                        </div>
                    @endguest
                </div>
            </div>
        </nav>

        <div id="sidebar">
            <ul>
                <li class="active"><a href="{{ route('home') }}">Home</a></li>
                @if(Auth::check() && !Auth::user()->hasRole('instructor'))
                    <li class="dropdown-menuMain">
                        <a href="javascript:void(0)" id="dropdownMenuButton" class="booknowbtn" data-toggle="dropdown">@if($session == 'de') {{ __('Jetzt buchen') }} @else {{ __('Book now') }} @endif<i class="fa fa-chevron-down"></i></a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a href="{{ url('/teachers?language_id%5B%5D=2') }}" class="dropdown-item">@if($session == 'de') {{ __('Englisch') }} @else {{ __('English') }} @endif</a>
                            <a href="{{ url('/teachers?language_id%5B%5D=3') }}" class="dropdown-item">@if($session == 'de') {{ __('Spanisch') }} @else {{ __('Spanish') }} @endif</a>
                            <a href="{{ url('/teachers?language_id%5B%5D=4') }}" class="dropdown-item">@if($session == 'de') {{ __('Deutsch') }} @else {{ __('German') }} @endif</a>
                            <a href="{{ url('/teachers?language_id%5B%5D=5') }}" class="dropdown-item">@if($session == 'de') {{ __('Italienisch') }} @else {{ __('Italian') }} @endif</a>
                        </div>
                    </li>
                @endif

                <li class="dropdown-menuMain">
                    <a href="#" id="dropdownMenuButton" data-toggle="dropdown">@if($session == 'de') {{ __('So funktioniert es') }} @else {{ __('How it works') }} @endif<i class="fa fa-chevron-down"></i></a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a href="{{ url('/ourplatform') }}" class="dropdown-item">@if($session == 'de') {{ __('Unsere Plattform') }} @else {{ __('Our Platform') }} @endif</a>
                        <a href="{{ url('/ourmethod') }}" class="dropdown-item">@if($session == 'de') {{ __('Unsere Methode') }} @else {{ __('Our Method') }} @endif</a>
                        <a href="{{ url('/ourteachers') }}" class="dropdown-item">@if($session == 'de') {{ __('Unsere Lehrkräfte') }} @else {{ __('Our Teachers') }} @endif</a>
                        <a href="{{ url('/ourcertificates') }}" class="dropdown-item">@if($session == 'de') {{ __('Unsere Zertifikate') }} @else {{ __('Our Certificates') }} @endif</a>
                    </div>
                </li>
                <li class="dropdown-menuMain">
                    <a href="#" id="dropdownMenuButton" data-toggle="dropdown">@if($session == 'de') {{ __('Sprachen') }} @else {{ __('Languages') }} @endif <i class="fa fa-chevron-down"></i></a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a href="{{ url('/english') }}" class="dropdown-item">@if($session == 'de') {{ __('Englisch') }} @else {{ __('English') }} @endif</a>
                        <a href="{{ url('/spanish') }}" class="dropdown-item">@if($session == 'de') {{ __('Spanisch') }} @else {{ __('Spanish') }} @endif</a>
                        <a href="{{ url('/german') }}" class="dropdown-item">@if($session == 'de') {{ __('Deutsch') }} @else {{ __('German') }} @endif</a>
                        <a href="{{ url('/italian') }}" class="dropdown-item">@if($session == 'de') {{ __('Italienisch') }} @else {{ __('Italian') }} @endif</a>
                    </div>
                </li>
                <!-- <li><a href="{{-- route('instructor.list') --}}">Teachers</a></li> -->
                <li class="dropdown-menuMain">
                    <a href="#" id="dropdownMenuButton" data-toggle="dropdown">@if($session == 'de') {{ __('Unsere Zielgruppen') }} @else {{ __('Our Clients') }} @endif <i class="fa fa-chevron-down"></i></a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a href="{{ url('/schoolchildrenandstudent') }}" class="dropdown-item">@if($session == 'de') {{ __('Schüler & Studenten') }} @else {{ __('Students') }} @endif</a>
                        <a href="{{ url('/privatecitizen') }}" class="dropdown-item">@if($session == 'de') {{ __('Privatperson') }} @else {{ __('Private Clients') }} @endif</a>
                        <a href="{{ url('/forcompanies') }}" class="dropdown-item">@if($session == 'de') {{ __('Für Unternehmen') }} @else {{ __('Companies') }} @endif</a>
                    </div>
                </li>
                <li><a href="{{ url('/prices') }}">@if($session == 'de') {{ __('Preise') }} @else {{ __('Prices') }} @endif</a></li>
                {{-- <li><a href="{{ url('/prices') }}">Prices</a></li>
                <li class="dropdown-menuMain"><a href="#" id="dropdownMenuButton" data-toggle="dropdown">Languages <i class="fa fa-chevron-down"></i></a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a href="{{route('locale', 'en')}}" class="dropdown-item">EN</a>
                        <a href="{{route('locale', 'de')}}" class="dropdown-item">DE</a>
                    </div>
                </li>
                <li><a href="{{ route('instructor.list') }}">Teachers</a></li>
                <li><a href="{{ route('page.about') }}">About Us</a></li>
                     --}}
            </ul>
        </div>
        @yield('content')

        <!-- footer start -->
        <footer id="main-footer">
            <div class="row m-auto container">
                <div class="col-lg-3 col-md-12 col-sm-12 text-center mt-4">
                    <img src="{{ asset('frontend/img/logo.png') }}" class="img-fluid" width="210" height="48">
                </div>

                <div class="col-lg-3 col-md-4 col-sm-4 col-6 mt-3">
                    <ul>
                        <li class="mb-1"><b>@if($session == 'de') {{ __('Unternehmen') }} @else {{ __('Companies') }} @endif</b></li>
                        <li><a href="{{ url('/forcompanies') }}" >@if($session == 'de') {{ __('Für Unternehmen') }} @else {{ __('For Companies') }} @endif</a></li>
                        <li><a href="{{ url('/blogs') }}" >@if($session == 'de') {{ __('Blog') }} @else {{ __('Blog') }} @endif</a></li>
                        <li><a href="{{ url('/contact') }}" >@if($session == 'de') {{ __('Kontakt') }} @else {{ __('Contact') }} @endif</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-4 col-6 mt-3">
                    <ul>
                        <li class="mb-1"><b>@if($session == 'de') {{ __('Sprachen') }} @else {{ __('Languages') }} @endif</b></li>
                        <li><a href="{{ url('/english') }}" >@if($session == 'de') {{ __('Englisch') }} @else {{ __('English') }} @endif</a></li>
                        <li><a href="{{ url('/spanish') }}" >@if($session == 'de') {{ __('Spanisch') }} @else {{ __('Spanish') }} @endif</a></li>
                        <li><a href="{{ url('/german') }}" >@if($session == 'de') {{ __('Deutsch') }} @else {{ __('German') }} @endif</a></li>
                        <li><a href="{{ url('/italian') }}" >@if($session == 'de') {{ __('Italienisch') }} @else {{ __('Italian') }} @endif</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-4 col-6 mt-3">
                    <ul>
                        <li class="mb-1"><b>@if($session == 'de') {{ __('So funktioniert es') }} @else {{ __('How it works') }} @endif</b></li>
                        <li><a href="{{ url('/ourplatform') }}" >@if($session == 'de') {{ __('Unsere Plattform') }} @else {{ __('Our Platform') }} @endif</a></li>
                        <li><a href="{{ url('/ourmethod') }}" >@if($session == 'de') {{ __('Unsere Methode') }} @else {{ __('Our Method') }} @endif</a></li>
                        <li><a href="{{ url('/ourteachers') }}" >@if($session == 'de') {{ __('Unsere Lehrkräfte') }} @else {{ __('Our Teachers') }} @endif</a></li>
                        <li><a href="{{ url('/ourcertificates') }}" >@if($session == 'de') {{ __('Unsere Zertifikate') }} @else {{ __('Our Certificates') }} @endif</a></li>
                    </ul>
                </div>
                
            </div>
            <div class="copyright-main">
                <div class="row container m-auto">
                    <div class="col-md-6">
                        <span id="c-copyright">
                                © {{ date('Y') }} - speakify24
                        </span>
                    </div>
                    <div class="col-md-6 text-right">
                        <ul>
                            <li><a href="{{ url('/imprint') }}">@if($session == 'de') {{ __('Impressum') }} @else {{ __('Imprint') }} @endif</a></li>
                            <li><a href="{{ url('/agreement') }}">@if($session == 'de') {{ __('Datenschutz') }} @else {{ __('Data protection agreements') }} @endif</a></li>
                            <li><a href="{{ url('/condition') }}">@if($session == 'de') {{ __('AGB') }} @else {{ __('Conditions') }} @endif</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
        <!-- footer end -->

        <!-- The Modal start -->
        <div class="modal" id="myModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bi-header ">
                        <h5 class="col-12 modal-title text-center bi-header-seperator-head">Become an Instructor</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                
                <div class="becomeInstructorForm">
                    <form id="becomeInstructorForm" class="form-horizontal" method="POST" action="{{ route('become.instructor') }}">
                        {{ csrf_field() }}
                            <div class="px-4 py-2">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-6">
                                            <label>First Name</label>
                                            <input type="text" class="form-control form-control-sm" placeholder="First Name" name="first_name">
                                        </div>
                                        <div class="col-6">
                                            <label>Last Name</label>
                                            <input type="text" class="form-control form-control-sm" placeholder="Last Name" name="last_name">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Contact Email</label>
                                    <input type="text" class="form-control form-control-sm" placeholder="Contact Email" name="contact_email">
                                </div>

                                <div class="form-group">
                                    <label>Telephone</label>
                                    <input type="text" class="form-control form-control-sm" placeholder="Telephone" name="telephone">
                                </div>

                                <div class="form-group">
                                    <label>Paypal ID</label>
                                    <input type="text" class="form-control form-control-sm" placeholder="Paypal ID" name="paypal_id">
                                </div>

                                <div class="form-group">
                                    <label>Biography</label>
                                    <textarea class="form-control form-control" placeholder="Biography" name="biography"></textarea>
                                </div>

                                <div class="form-group mt-4">
                                    <button type="submit" class="btn btn-lg btn-block login-page-button">Submit</button>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- The Modal end -->
    </body>
    <script src="{{ asset('frontend/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('frontend/js/fancybox.min.js') }}"></script>
    <script src="{{ asset('frontend/js/modernizr.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.validate.js') }}"></script>
    
    <!-- Toastr -->
    <script src="{{ asset('backend/vendor/toastr/toastr.min599c.js?v4.0.2') }}"></script>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="{{ asset('backend/vendor/tinymce/tinymce.min.js?v4.0.2') }}"></script>
    <script src="{{ asset('js/calendar_lib/main.js') }}"></script>

    

    <script>
    $(window).on("load", function (e){
        // Animate loader off screen
        $(".se-pre-con").fadeOut("slow");
    });
    </script>
    <script type="text/javascript">
        $(document).ready(function()
        {   
            /* Delete record */
            $('.delete-record').click(function(event)
            {
                var url = $(this).attr('href');
                event.preventDefault();
                
                if(confirm('Are you sure want to delete this record?'))
                {
                    window.location.href = url;
                } else {
                    return false;
                }

            });

            /* Toastr messages */
            toastr.options.closeButton = true;
            toastr.options.timeOut = 5000;
            @if(session()->has('success'))
                toastr.success("{{ session('success') }}");
            @endif
            @if(session()->has('status'))
                toastr.success("{{ session('status') }}");
            @endif
            @if(session()->has('error'))
                toastr.error("{{ session('error') }}");
            @endif
            @if(session()->has('info'))
                toastr.info("{{ session('info') }}");
            @endif

            $('.mobile-nav').click(function()
            {
                $('#sidebar').toggleClass('active');
                
                $(this).toggleClass('fa-bars');
                $(this).toggleClass('fa-times');
            });

            $("#becomeInstructorForm").validate({
                rules: {
                    first_name: {
                        required: true
                    },
                    last_name: {
                        required: true
                    },
                    contact_email:{
                        required: true,
                        email:true
                    },
                    telephone: {
                        required: true
                    },
                    paypal_id:{
                        required: true,
                        email:true
                    },
                    biography: {
                        required: true
                    },
                },
                messages: {
                    first_name: {
                        required: 'The first name field is required.'
                    },
                    last_name: {
                        required: 'The last name field is required.'
                    },
                    contact_email: {
                        required: 'The contact email field is required.',
                        email: 'The contact email must be a valid email address.'
                    },
                    telephone: {
                        required: 'The telephone field is required.'
                    },
                    paypal_id: {
                        required: 'The paypal id field is required.',
                        email: 'The paypal id must be a valid email address.'
                    },
                    biography: {
                        required: 'The biography field is required.'
                    },
                }
            });
            var dateVar = new Date();
            console.log(dateVar);
            var offset = -(dateVar.getTimezoneOffset());
            document.cookie = "offset="+offset;
        });
        AOS.init();
        $('.carousel').carousel();

        @if(Auth::check() && !Auth::user()->hasRole('instructor') && !Auth::user()->hasRole('admin')) 
            setInterval(() => {
                checkMeeting();
            }, '10000');
        @endif  

        function checkMeeting() {
            $.ajax({
                type: "GET",
                url: "{{ route('checkmeeting') }}",
                success: function (data) {
                    var data = JSON.parse(data);
                    console.log(data);
                    $("#chk_meet").html("");
                    if (data || data.length > 0) {
                        var name = data.title;
                        var name = name.replace(/\s+/g, "") + "_" + data.id;
                        var url = "{{ url('joinmeeting/vpaas-magic-cookie-f28545654cdf498f82c4dea3a5a591e5') }}/"+ name;
                        $("#chk_meet").append('<a class="btn btn-sm btn-primary" title="Join Meeting" href="'+url+'"><i class="fas fa-video"></i></a>');
                    }
                }
            });
        }

        @if(Auth::check())
            setInterval(() => {
                $.ajax({
                    type: "GET",
                    url: "{{ route('checkunread') }}",
                    success: function (data) {
                        var data = JSON.parse(data);
                        console.log(data);
                        $("#messagelink span.message_count").text(data.count);
                    }
                });
            }, '5000');
        @endif
    </script>
    @yield('javascript')
</html>