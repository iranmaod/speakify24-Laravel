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
@extends('layouts.frontend.index')
@section('content')
<!-- content start -->
    
        <!-- banner start -->
        <div style="background-image: url({{asset('frontend/img/MainSlider01.jpg')}})" class="subpage-slide-blue bgcoverimg">
            <div class="container">
                <h1 style="margin-top: 40px">
                    
                    {{ __('booking.hi') }}  {{Auth::user()->first_name}}
                    
                </h1>
            </div>
        </div>
        <!-- banner end -->

        


        <div style="display: flex;justify-content: center;" class="my-3">

            <div class="col-md-12 ">
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
                        $trans = \DB::table('transactions')
                                            ->where('user_id', \Auth::user()->id)
                                            ->where('created_at', '>=', date('Y-m-d H:i:s', strtotime('-1 month')))
                                            ->orderBy('created_at', 'desc')
                                            ->get()
                                            ;


                        //new//
                        date_default_timezone_set('Europe/London');
                         $endTime = date('Y-m-d H:i:s');
                        $stu_credits = 0;                    
                        $stu_credits_total = \DB::table('students_credits')
                                        ->where('user_id', \Auth::user()->id)
                                        ->where('end_time','>',$endTime)
                                        ->get()->sum('total_hours')
                                        ;
                        $stu_credits = \DB::table('students_credits')
                                        ->where('user_id', \Auth::user()->id)
                                        ->where('end_time','>',$endTime)
                                        ->get()->sum('hours')
                                        ;
                        //end//
                        
                        $remainingLectures = 0;
                        $total = 0;
                        if ($trans) {
                            foreach($trans as $item) {
                                $hour = 0;
                                if ($item->type == 'package') {
                                    $plan = \DB::table('course_prices')->where('id', $item->type_id)->first();
                                    $hour = $plan->hours;
                                } elseif($item->type == 'plan') {
                                    $plan = \DB::table('subscription_plans')->where('id', $item->type_id)->first();
                                    $hour = $plan->per_month;
                                }
                               $total = $remainingLectures = $remainingLectures + $hour;
                                $appointments = \DB::table('appointments')->where('transaction_id', $item->id)->get();
                                $remainingLectures = $remainingLectures - count($appointments);
                            }
                        ?>
                           
                        <?php
                        }
                    ?>

                    @endif



                    {{ $total + $stu_credits_total }}
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
                                            {{-- {{$remain_credits}} --}}
                                            {{ $remainingLectures + $stu_credits }}
                                        </h2>
                                    </div>
                                  
                                </div>

                            </div>
                        </div>
                    </div>
                  
                   

                </div>
            </div>

        </div>



         <!-- breadcrumb start -->
         <div class="breadcrumb-container">
            <div class="container">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ __('booking.mycredits') }}
                </li>
              </ol>
            </div>
        </div>
        <div class="panel-actions myTransactionsMain">
        	<div class="container">
        		<div class="row">
					<form method="GET" action="{{ route('mytransactions') }}">
						<div class="input-group">
							<label for="start_date">{{ __('booking.s_date') }}</label>
							<input type="date" id="start_date" class="form-control" name="startdate" placeholder="Start Date" value="{{ Request::input('startdate') }}" />
							<label class="ml-5" for="end_date">{{ __('booking.e_date') }}</label>
							<input type="date" id="end_date" class="form-control" name="enddate" placeholder="End Date" value="{{ Request::input('enddate') }}" />
							<input type="text" class="form-control ml-5 mr-2" name="search" placeholder="Search..." value="{{ Request::input('search') }}">
							<span class="input-group-btn">
								<button type="submit" class="btn btn-primary" data-toggle="tooltip" data-original-title="Search"><i class="icon wb-search" aria-hidden="true"></i></button>
								<a href="{{ route('mycredits') }}" class="btn btn-danger" data-toggle="tooltip" data-original-title="Clear Search"><i class="icon wb-close" aria-hidden="true"></i></a>
							</span>
						</div>
					</form>
				</div>
			</div>
			</div>
        </div>
        
        <!-- breadcrumb end -->



        <!-- course list start -->
        <div class="container">
            <h2>{{ __('booking.mycredits') }}</h2>
            <div class="row tablesMain">
                <table class="table table-hover table-striped w-full">
                    <thead>
                        <tr>
                            <th>Sl.no</th>
                            <th>
                                {{ __('booking.language') }}
                            </th>
                            <th>
                                {{ __('booking.credits') }}
                            </th>
                            <th>
                                {{ __('booking.recredits') }}
                            </th>
                            <th>
                                {{ __('booking.amountPaid') }}
                            </th>
                            <th>
                                {{ __('booking.s_date') }}
                            </th>
                            <th>
                                {{ __('booking.e_date') }}
                            </th>
                            <th>
                                Status
                            </th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $transaction)
                            <?php
                                $hour = 0;
                                if ($transaction->type == 'package') {
                                    $plan = \DB::table('course_prices')->where('id', $transaction->type_id)->first();
                                    $hour = $plan->hours;
                                } else if($transaction->type == 'plan') {
                                    // @if(isset($plan))
                                    $plan = \DB::table('subscription_plans')->where('id', $transaction->type_id)->first();
                                    $hour = $plan->per_month;
                                }
                                $appointments = \DB::table('appointments')->where('transaction_id', $transaction->id)->get();
                                   
                            ?>
                            <tr>
                                <td>{{ $transaction->id }}</td>
                                <td>{{ $transaction->course_title }}</td>
                                <td>
                                    {{-- {{$transaction->type}} --}}
                                    @if($transaction->type == 'admin_credits')
                                    <?php 
                                    $credit = \DB::table('students_credits')->find($transaction->credit_id);
                                    // print_r($credit);
                                    ?>
                                    @if(isset($credit))
                                    {{$credit->total_hours}}
                                    @endif
                                    @else
                                    @if(isset($hour))
                                    {{ $hour }}
                                    @endif
                                    @endif
                                </td>
                                <td>


                                    @if($transaction->type == 'admin_credits')
                                    <?php 
                                    $credit = \DB::table('students_credits')->find($transaction->credit_id);
                                    // print_r($credit);
                                    ?>
                                    @if(isset($credit))
                                    {{$credit->hours}}
                                    @endif
                                    @else
                                    {{ $hour - count($appointments) }}
                                    @endif


                                   
                                </td>
                                <td>
                                    @if($transaction->type == 'admin_credits')
                                    
                                    <p>AdminCredits</p>
                                    
                                    @else
                                    {{ $transaction->amount }}
                                    @endif


                                    
                                </td>
                                <td>

                                    @if($transaction->type == 'admin_credits')
                                    <?php 
                                    $credit = \DB::table('students_credits')->find($transaction->credit_id);
                                    // print_r($credit);
                                    ?>
                                    @if(isset($credit))
                                    {{date("d-m-Y", strtotime($credit->start_time))}}
                                    @endif
                                    @else
                                    {{ date("d-m-Y", strtotime($transaction->created_at)) }}
                                    @endif


                                    
                                </td>
                                <td>
                                    @if($transaction->type == 'admin_credits')
                                    <?php 
                                    $credit = \DB::table('students_credits')->find($transaction->credit_id);
                                    // print_r($credit);
                                    ?>
                                    @if(isset($credit))
                                    {{date("d-m-Y", strtotime($credit->end_time))}}
                                    @endif
                                    @else
                                    {{ date("d-m-Y", strtotime("+1 month", strtotime($transaction->created_at))) }}
                                    @endif
                                    
                                </td>
                                <td>
                                    @if($transaction->type == 'admin_credits')
                                    <?php 
                                         date_default_timezone_set('Europe/London');
                                     $endTime = date('Y-m-d H:i:s');
                                    
                                    $credit = \DB::table('students_credits')->find($transaction->credit_id);
                                    // print_r($credit);
                                    ?>
                                    @if(isset($credit))
                                    @if($credit->end_time > $endTime)
                                    <span class="badge badge-success">Active</span>
                                    @else
                                    <span class="badge badge-danger">Expired</span>
                                    @endif
                                    @endif
                                    
                                    @else
                                    <span class="badge badge-success">{{ $transaction->status }}</span>
                                    
                                    @endif

                                </td>
                                <td>
                                    @if ($transaction->type != 'package')
                                        <?php
                                            $orderDetail = json_decode($transaction->order_details);
                                            if ( isset( $orderDetail->id ) && !empty( $orderDetail->id ) && $transaction->status == 'completed' ) {
                                                ?>
                                                <a href="{{ route('canceltransaction', ['t_id'=>$transaction->id,'id'=>$orderDetail->id]) }}" class="btn btn-sm btn-danger">
                                                    {{ __('booking.cancelsubs') }}
                                                </a>
                                                <?php
                                            }
                                        ?>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="float-right">
                    {{ $transactions->links() }}
                </div>
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