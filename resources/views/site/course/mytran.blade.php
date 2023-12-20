@extends('layouts.frontend.index')
@section('content')
<!-- content start -->
    
        <!-- banner start -->
        <div class="subpage-slide-blue bgcoverimg">
            <div class="container">
                <h1>
                    {{ __('booking.transactions') }}
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
                    {{ __('booking.transactions') }}
                </li>
              </ol>
            </div>
        </div>
        <div class="panel-actions myTransactionsMain">
        	<div class="container">
        		<div class="row">
					<form method="GET" action="{{ route('mytransactions') }}">
						<div class="input-group">
							<label for="start_date">Start Date</label>
							<input type="date" id="start_date" class="form-control" name="startdate" placeholder="Start Date" value="{{ Request::input('startdate') }}" />
							<label class="ml-5" for="end_date">End Date</label>
							<input type="date" id="end_date" class="form-control" name="enddate" placeholder="End Date" value="{{ Request::input('enddate') }}" />
							<input type="text" class="form-control ml-5 mr-2" name="search" placeholder="Search..." value="{{ Request::input('search') }}">
							<span class="input-group-btn">
								<button type="submit" class="btn btn-primary" data-toggle="tooltip" data-original-title="Search"><i class="icon wb-search" aria-hidden="true"></i></button>
								<a href="{{ route('mytransactions') }}" class="btn btn-danger" data-toggle="tooltip" data-original-title="Clear Search"><i class="icon wb-close" aria-hidden="true"></i></a>
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
            <div class="row tablesMain">
                <table class="table table-hover table-striped w-full">
                    <thead>
                        <tr>
                            <th>Sl.no</th>
                            <th>
                                {{ __('booking.course') }}
                            </th>
                            <th>
                                {{ __('booking.lectures') }}
                            </th>
                            <th>
                                {{ __('booking.remainingLectures') }}
                            </th>
                            <th>
                                {{ __('booking.amountPaid') }}
                            </th>
                            <th>
                                {{ __('booking.purchasedOn') }}
                            </th>
                            <th>
                                {{ __('booking.expiredOn') }}
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
                                } elseif($transaction->type == 'plan') {
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
                                    @if($transaction->type == 'package' || 'plan')
                                    {{ $hour }}
                                    @endif
                                </td>
                                <td>{{ $hour - count($appointments) }}</td>
                                <td>{{ $transaction->amount }}</td>
                                <td>{{ date("d-m-Y", strtotime($transaction->created_at)) }}</td>
                                <td>{{ date("d-m-Y", strtotime("+1 month", strtotime($transaction->created_at))) }}</td>
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