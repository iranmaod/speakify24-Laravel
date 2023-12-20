@extends('layouts.frontend.index')
@section('content')
<!-- content start -->
<style type="text/css">html{overflow-x: hidden;}</style>
    <div class="container-fluid p-0 home-content">
        @if (session()->has('notification'))
            <div class="notification alert alert-success alert-dismissible fade show" role="alert">
                {!! session('notification') !!}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @foreach($config as $con)
            {!!  str_replace('../../', '', $con->option_value) !!}
        @endforeach

        {{-- <div id="carouselExampleIndicators" class="carousel slide carousel-fade" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="frontend/img/MainSlider01.jpg" alt="Main Slider">
                    <div class="carousel-caption d-none d-md-block">
                        <p>For companies </p>
                        <h5> At home all over the world in the office at Home</h5>
                        <p><a href="#" class="btn btn-ulearn">Learn More</a></p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="frontend/img/MainSlider02.jpg" alt="Main Slider">
                    <div class="carousel-caption d-none d-md-block">
                        <p>For companies </p>
                        <h5> At home all over the world in the office at Home</h5>
                        <p><a href="#" class="btn btn-ulearn">Learn More</a></p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="frontend/img/MainSlider03.jpg" alt="Main Slider">
                    <div class="carousel-caption d-none d-md-block">
                        <p>For companies </p>
                        <h5> At home all over the world in the office at Home</h5>
                        <p><a href="#" class="btn btn-ulearn">Learn More</a></p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="frontend/img/MainSlider04.jpg" alt="Main Slider">
                    <div class="carousel-caption d-none d-md-block">
                        <p>For companies </p>
                        <h5> At home all over the world in the office at Home</h5>
                        <p><a href="#" class="btn btn-ulearn">Learn More</a></p>
                    </div>
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>

        <div class="online-advantages p-100">
            <div class="container">
                <div class="heading-main">
                    <h3>The advantages of online learning with Speakify24</h3>
                </div>
                <div class="row">
                    <div class="col-md-3" data-aos="fade-right" data-aos-duration="1000">
                        <div class="advantages-box einzelunterrricht">
                            <div class="image-main">
                                <img class="img-fluid" src="frontend/img/einzelunterrricht.jpg">
                            </div>
                            <div class="info-box">
                                <h3>One-to-one lessons</h3>
                                <p>45 minutes of intensive one-to-one tuition via video conference</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3" data-aos="fade-right" data-aos-duration="1000">
                        <div class="advantages-box einzelunterrricht">
                             <div class="image-main">
                                <img class="img-fluid" src="frontend/img/interaktive.jpg">
                            </div>
                            <div class="info-box">
                                <h3>Interactive learning material</h3>
                                <p>Interactive learning material, additional material for self-learning</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3" data-aos="fade-left" data-aos-duration="1000">
                        <div class="advantages-box einzelunterrricht">
                            <div class="image-main">
                                <img class="img-fluid" src="frontend/img/Angepasstes_Lernmaterial.jpg">
                            </div>
                            <div class="info-box">
                                <h3>Adapted learning material</h3>
                                <p>Adapted learning material for special topics (professions, etc.)</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3" data-aos="fade-left" data-aos-duration="1000">
                        <div class="advantages-box einzelunterrricht">
                             <div class="image-main">
                                <img class="img-fluid" src="frontend/img/Eigene_Schwerpunkte.jpg">
                            </div>
                            <div class="info-box">
                                <h3>Own focus</h3>
                                <p>et your own priorities with our teachers (exam preparation, etc.)</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="howitwork p-100">
            <div class="container">
                <div class="heading-main">
                    <h3>This is how it works</h3>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="step-box">
                            <div class="img-main">
                                <img class="img-fluid" src="frontend/img/step1.png">
                            </div>
                            <div class="info-box">
                                <h3>Step 1</h3>
                                <p>Sign up and have a look around</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="step-box">
                            <div class="img-main">
                                <img class="img-fluid" src="frontend/img/step2.jpg">
                            </div>
                            <div class="info-box">
                                <h3>Step 2</h3>
                                <p>Book an hour and get access to all learning materials</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="step-box">
                            <div class="img-main">
                                <img class="img-fluid" src="frontend/img/step3.jpg">
                            </div>
                            <div class="info-box">
                                <h3>Step 3</h3>
                                <p>Choose a teacher and make an appointment</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

    </div>
    <!-- content end -->
@endsection