@extends('layouts.frontend.index')
@section('content')
<!-- content start -->
    <div class="container-fluid p-0 home-content">
        <!-- banner start -->
        <div class="subpage-slide-blue">
            <div class="container">
                <h1>My Transactions</h1>
            </div>
        </div>
        <!-- banner end -->

        <!-- breadcrumb start -->
        <div class="breadcrumb-container">
            <div class="container">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">My Transactions</li>
              </ol>
            </div>
        </div>
        <div class="panel-actions">
				<form method="GET" action="{{ route('mytransactions') }}">
					<div class="input-group">
						<label for="start_date">Start Date</label>
						<input type="date" id="start_date" class="form-control" name="startdate" placeholder="Start Date" value="{{ Request::input('startdate') }}" />
						<label for="end_date">End Date</label>
						<input type="date" id="end_date" class="form-control" name="enddate" placeholder="End Date" value="{{ Request::input('enddate') }}" />
						<input type="text" class="form-control" name="search" placeholder="Search..." value="{{ Request::input('search') }}">
						<span class="input-group-btn">
							<button type="submit" class="btn btn-primary" data-toggle="tooltip" data-original-title="Search"><i class="icon wb-search" aria-hidden="true"></i></button>
							<a href="{{ route('mytransactions') }}" class="btn btn-danger" data-toggle="tooltip" data-original-title="Clear Search"><i class="icon wb-close" aria-hidden="true"></i></a>
						</span>
					</div>
				</form>
			</div>
        </div>
        
        <!-- breadcrumb end -->

        <!-- course list start -->
        <div class="container">
            <div class="row">
                <table class="table table-hover table-striped w-full">
                    <thead>
                        <tr>
                            <th>Sl.no</th>
                            <th>Course</th>
                            <th>Plan / Package Hours</th>
                            <th>Plan / Package Amount</th>
                            <th>Remaining Time</th>
                            <th>Amount Paid</th>
                            <th>Purchased On</th>
                            <th>Status</th>
                            <th>Used</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $transaction)
                            <?php
                                $hour = 0;
                                if ($transaction->type == 'package') {
                                    $plan = \DB::table('course_prices')->where('id', $transaction->type_id)->first();
                                    $hour = $plan->hours;
                                } else {
                                    $plan = \DB::table('subscription_plans')->where('id', $transaction->type_id)->first();
                                    $hour = $plan->per_month;
                                }
                                $appointments = \DB::table('appointments')->where('transaction_id', $transaction->id)->get();
                            ?>
                            <tr>
                                <td>{{ $transaction->id }}</td>
                                <td>{{ $transaction->course_title }}</td>
                                <td>{{ $hour }}</td>
                                <td>{{ $plan->price }}</td>
                                <td>{{ date("H:i:s", ($hour * 60 * 60) - (count($appointments) * 45 * 60)) }}</td>
                                <td>{{ $transaction->amount }}</td>
                                <td>{{ $transaction->created_at }}</td>
                                <td>{{ ucfirst($transaction->status) }}</td>
                                <td>{{ date("H:i:s", count($appointments) * 45 * 60) }}</td>
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