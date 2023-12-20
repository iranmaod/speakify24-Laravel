@extends('layouts.frontend.index')
@section('content')
<!-- content start -->
    <div class="container-fluid p-0 home-content">
        <!-- banner start -->
        <div class="subpage-slide-blue bgcoverimg My-Courses-bg">
            <div class="container">
                <h1>
                    {{ __('booking.mycourses') }}
                </h1>
            </div>
        </div>
        <!-- banner end -->

        <!-- breadcrumb start -->
        <div class="breadcrumb-container">
            <div class="container">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ __('booking.mycourses') }}
                </li>
              </ol>
            </div>
        </div>
        
        <!-- breadcrumb end -->

        <!-- course list start -->
        <div class="container" id="my-courses">
            <div class="row">
            @if(count($courses)> 0 )
                @foreach($courses as $course)
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                        <div class="course-block mx-auto" style="height: 250px;">
                            <a href="{{ route('course.learn', $course->course_slug) }}" class="c-view">
                                <main style="height: 250px;">
                                    <img src="@if(Storage::exists($course->thumb_image)){{ Storage::url($course->thumb_image) }}@else{{ asset('backend/assets/images/course_detail_thumb.jpg') }}@endif">
                                    <div class="col-md-12 text-center"><h6 class="course-title">{{ $course->course_title }}</h6></div>
                                    
                                    <!-- <div class="instructor-clist">
                                        <div class="col-md-12">
                                            <i class="fa fa-chalkboard-teacher"></i>&nbsp;
                                            <span>Created by <b></b></span>
                                        </div>
                                    </div> -->
                                </main>
                                <!-- <footer>
                                    <div class="c-row">
                                        <div class="col-md-6 col-sm-6 col-6">
                                            <h5 class="course-price"></h5>
                                        </div>
                                        <div class="col-md-5 offset-md-1 col-sm-5 offset-sm-1 col-5 offset-1">
                                            <star class="course-rating">
                                            <?php //for ($r=1;$r<=5;$r++) { ?>
                                                <span class="fa fa-star <?php //echo $r <= 4 ? 'checked' : '';?>"></span>
                                            <?php //}?>
                                            </star>
                                        </div>
                                    </div>
                                </footer> -->
                            </a>
                        </div>
                    </div>
                @endforeach
            @else
                <?php
                    $session = \App::getLocale();
                    if (session()->get('locale') != '') {
                        $session = session()->get('locale');
                    }
                ?>
                <article class="container not-found-block">
                    <div class="row">
                        <div class="col-12 not-found-col">
                            <!-- 
                            <span><b>2<span class="blue">0</span>4</b></span>
                            <h3>Sorry! No courses added to your account</h3>
                             -->
                            {{-- <a href="{{ route('course.list') }}" class="btn btn-ulearn-cview mt-3">Explore Courses</a> --}}
                            <ul class="dropdown mt-5">
                                <li>
                                    <a href="{{ url('/teachers') }}" class="btn btn-ulearn booknowbtn">@if($session == 'de') {{ __('Jetzt buchen') }} @else {{ __('Book now') }} @endif</a>
                                    {{-- <div class="dropdown-menu" aria-labelledby="bookNowMenuButton">
                                        <a href="{{ url('/teachers?language_id%5B%5D=2') }}" class="dropdown-item">@if($session == 'de') {{ __('Englisch') }} @else {{ __('English') }} @endif</a>
                                        <a href="{{ url('/teachers?language_id%5B%5D=3') }}" class="dropdown-item">@if($session == 'de') {{ __('Spanisch') }} @else {{ __('Spanish') }} @endif</a>
                                        <a href="{{ url('/teachers?language_id%5B%5D=4') }}" class="dropdown-item">@if($session == 'de') {{ __('Deutsch') }} @else {{ __('German') }} @endif</a>
                                        <a href="{{ url('/teachers?language_id%5B%5D=5') }}" class="dropdown-item">@if($session == 'de') {{ __('Italienisch') }} @else {{ __('Italian') }} @endif</a>
                                    </div> --}}
                                </li>
                            </ul>
                        </div>
                    </div>
                </article>
            @endif                             
            </div>
        </div>
        
    </div>
    <!-- course list end -->
@endsection