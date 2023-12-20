@extends('layouts.frontend.index')
@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css" integrity="sha256-mmgLkCYLUQbXn0B1SRqzHar6dCnv9oZFPEC1g1cwlkk=" crossorigin="anonymous" />
<style>
    .card {
    background-color: #fff;
    border-radius: 10px;
    border: none;
    position: relative;
    margin-bottom: 30px;
    box-shadow: 0 0.46875rem 2.1875rem rgba(90,97,105,0.1), 0 0.9375rem 1.40625rem rgba(90,97,105,0.1), 0 0.25rem 0.53125rem rgba(90,97,105,0.12), 0 0.125rem 0.1875rem rgba(90,97,105,0.1);
}
.l-bg-cherry {
    background: linear-gradient(to right, #493240, #f09) !important;
    color: #fff;
}

.l-bg-blue-dark {
    background: linear-gradient(to right, #373b44, #4286f4) !important;
    color: #fff;
}

.l-bg-green-dark {
    background: linear-gradient(to right, #0a504a, #38ef7d) !important;
    color: #fff;
}

.l-bg-orange-dark {
    background: linear-gradient(to right, #a81308, #fc6666) !important;
    color: #fff;
}

.card .card-statistic-3 .card-icon-large .fas, .card .card-statistic-3 .card-icon-large .far, .card .card-statistic-3 .card-icon-large .fab, .card .card-statistic-3 .card-icon-large .fal {
    font-size: 110px;
}

.card .card-statistic-3 .card-icon {
    text-align: center;
    line-height: 50px;
    margin-left: 15px;
    color: #000;
    position: absolute;
    right: -5px;
    top: 20px;
    opacity: 0.1;
}

.l-bg-cyan {
    background: linear-gradient(135deg, #289cf5, #84c0ec) !important;
    color: #fff;
}

.l-bg-green {
    background: linear-gradient(135deg, #23bdb8 0%, #43e794 100%) !important;
    color: #fff;
}

.l-bg-orange {
    background: linear-gradient(to right, #f9900e, #ffba56) !important;
    color: #fff;
}

.l-bg-cyan {
    background: linear-gradient(135deg, #289cf5, #84c0ec) !important;
    color: #fff;
}
</style>
@endsection

@section('content')
<?php
            $transactions = \DB::table('transactions')
                                ->where('user_id', \Auth::user()->id)
                                ->where('created_at', '>=', date('Y-m-d H:i:s', strtotime('-1 month')))
                                ->orderBy('created_at', 'desc')
                                ->get()
                                ;
            $remainingLectures = 0;
            if ($transactions) {
                            foreach($transactions as $item) {
                                $hour = 0;
                                if ($item->type == 'package') {
                                    $plan = \DB::table('course_prices')->where('id', $item->type_id)->first();
                                    $hour = $plan->hours;
                                } else {
                                    $plan = \DB::table('subscription_plans')->where('id', $item->type_id)->first();
                                    $hour = $plan->per_month;
                                }
                                $remainingLectures = $remainingLectures + $hour;
                                $appointments = \DB::table('appointments')->where('transaction_id', $item->id)->get();
                                $remainingLectures = $remainingLectures - count($appointments);
                            }
                        
                        }                     
                        
          
    ?>
<!-- content start -->
    
        <!-- banner start -->
        <div style="background-image: url({{asset('frontend/img/MainSlider01.jpg')}})" class="subpage-slide-blue bgcoverimg">
            <div class="container">
                <h1 style="margin-top: 40px">
                    @if(Auth::user()->comm_lang == 'deEmail')
                    Hallo {{Auth::user()->first_name}}
                    @else
                    Hi {{Auth::user()->first_name}}
                    @endif
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
                    Credits
                </li>
              </ol>
            </div>
        </div>      
        <!-- breadcrumb end -->


        
        <div style="display: flex;justify-content: center;" class="my-3">

            <div class="col-md-10 ">
                <div class="row ">
                    <div class="col-xl-6 col-lg-6">
                        <div class="card l-bg-cherry">
                            <div class="card-statistic-3 p-4">
                                <div class="card-icon card-icon-large"><i class="fas site-menu-icon wb-user"></i></div>
                                <div class="mb-4">
                                    <h5 class="card-title mb-0">{{ __('booking.credits') }}</h5>
                                </div>
                                <div class="row align-items-center mb-2 d-flex">
                                    <div class="col-8">
                                        <h2 class="d-flex align-items-center mb-0">





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
                                } else {
                                    $plan = \DB::table('subscription_plans')->where('id', $item->type_id)->first();
                                    $hour = $plan->per_month;
                                }
                                $remainingLectures = $remainingLectures + $hour;
                                $appointments = \DB::table('appointments')->where('transaction_id', $item->id)->get();
                                $remainingLectures = $remainingLectures - count($appointments);
                            }
                        ?>
                           
                        <?php
                        }
                    ?>

                    @endif



                    {{ $remainingLectures + $stu_credits }}
                                        </h2>
                                    </div>
                                   
                                </div>
                              
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6">
                        <div class="card l-bg-blue-dark">
                            <div class="card-statistic-3 p-4">
                                <div class="card-icon card-icon-large"><i class="fas fa-regular fa-clock"></i></div>
                                <div class="mb-4">
                                    <h5 class="card-title mb-0">{{ __('booking.recredits') }}</h5>
                                </div>
                                <div class="row align-items-center mb-2 d-flex">
                                    <div class="col-8">
                                        <h2 class="d-flex align-items-center mb-0">
                                            {{$remain_credits}}
                                        </h2>
                                    </div>
                                  
                                </div>

                            </div>
                        </div>
                    </div>
                  
                   

                </div>
            </div>

        </div>








        {{-- <div class="container my-3">
            <div class="row">
                <div class="col-md-3">
                    <div class="card">
                        <h5 class="card-header">Total Credits</h5>
                        <div class="card-body">
                          <h5 class="card-title">{{$total_credits}}</h5>
                        </div>
                    </div>
                   
                 </div>
                 <div class="col-md-3">
                    <div class="card">
                        <h5 class="card-header">Remaining Credits</h5>
                        <div class="card-body">
                          <h5 class="card-title">{{$remain_credits}}</h5>
                        </div>
                    </div>
                 </div>
                 <div class="col-md-3">
                    <div class="card">
                        <h5 class="card-header">Total Languages</h5>
                        <div class="card-body">
                          <h5 class="card-title">{{$lang}}</h5>
                        </div>
                    </div>
                 </div>
            </div>
        </div> --}}





        <!-- course list start -->
        <div class="container">
            <h2>My Credits</h2>
            <div class="row tablesMain">
                <table class="table table-hover table-striped w-full">
                    <thead>
                        <tr>
                            <th>#</th>
                           
                            <th>
                                Language
                            </th>
                            <th>
                                Total Credits
                            </th>
                            <th>
                                Remaining Credits
                            </th>
                            <th>
                                Start Date
                            </th>
                            <th>
                                End  Date
                            </th>
                            <th>
                                Status
                            </th>
                            {{-- <th>Action</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @if($credits)
                        @foreach($credits as $item)
                        <?php
                        $hour = 0;
                        if ($transaction->type == 'package') {
                            $plan = \DB::table('course_prices')->where('id', $item->type_id)->first();
                            $hour = $plan->hours;
                        } else {
                            $plan = \DB::table('subscription_plans')->where('id', $item->type_id)->first();
                            $hour = $plan->per_month;
                        }
                        $appointments = \DB::table('appointments')->where('transaction_id', $item->id)->get();
                           
                    ?>
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->course_title }}</td>
                                <td>{{ $item->total_hours }}</td>
                                {{-- <td>{{ $item->hours }}</td> --}}
                                {{-- <td>{{ $item->start_time }}</td> --}}
                                {{-- <td>{{ $item->end_time }}</td> --}}
                                <td>
                                    <?php
                                    date_default_timezone_set('Europe/London');
                                     $endTime = date('Y-m-d H:i:s');
                                        
                                    ?>
                                    {{-- @if($item->end_time > $endTime)
                                    <span class="badge badge-success">Active</span>
                                    @else
                                    <span class="badge badge-danger">Expired</span>
                                    @endif --}}
                                </td>
                                <td>
                                    {{-- @if($item->end_time > $endTime)
                                    <a href="{{ route('cancelcredits',$item->id) }}" class="btn btn-sm btn-danger">
                                        Cancel Credits
                                    </a>
                                    @else
                                    
                                    @endif --}}
                                </td>
                            </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>

                
            </div>
        </div>
            
    </div>
    <!-- course list end -->
@endsection

@section('javascript')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {

    });
</script>
@endsection