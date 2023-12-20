@extends('layouts.frontend.index')
@section('content')
<!-- content start -->
<style type="text/css">
    .selectplanimg > p:first-child{
        max-height: 260px;
        overflow: hidden;
    }
    .selectplanprice .course-block{
        height: 410px;
    }
    .prev_price {
        text-decoration: line-through;
        color:red;
    }
    .coupon_wrapper{
    	max-width: 400px;
    }
    .coupon_wrapper .login-page-button{
    	line-height: 1;
    }
    .selectplanimg{
    	max-height: 290px;
    	overflow: hidden;
    }
</style>
    <div class="container-fluid p-0 home-content bg-gray selectplanprice">

        <div class="container mt-5 pt-4">
        	<div class="mt-4  coupon_wrapper">
        		<div class="message mb-2"></div>
                <div class="input-group">
                    <input type="text" name="coupon_code" id="coupon_code" placeholder="{{ __('booking.usecoupon') }}" class="form-control">
                    <button class="btn login-page-button coupon_codebtn" type="button" id="use_coupon">
                        {{ __('booking.usecoupon') }}
                    </button>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="row text-center">
                       <!--  <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 coupon_wrapper">
                            <div class="col-md-9">
                                <input type="text" name="coupon_code" id="coupon_code" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <button class="btn" type="button" id="use_coupon">Use Coupon</button>
                            </div>
                            <div class="col-md-12 message mt-1"></div>
                        </div> -->
                        @if($type == '1')
                            @if(count($subscriptions)>0)
                                @foreach($subscriptions as $subscription)
                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                                        <div class="course-block mx-auto ">
                                        <a class="btna" href="{{ route('subscribe', ['id' => $subscription->id, 'course_id' => $course_id, 'instructor_id' => $instructor_id, 'time' => $time]) }}">
                                            <main>
                                                <div class="col-md-12"><h6 class="course-title">{{ $subscription->name }}</h6></div>
                                                <div class="col-md-12 selectplanimg">
                                                    @if(strpos($subscription->description, '../../../../') !== false)
                                                        {!! str_replace('../../../../', url('/').'/', $subscription->description) !!}
                                                    @elseif(strpos($subscription->description, '../../../') !== false)
                                                        {!! str_replace('../../../', url('/').'/', $subscription->description) !!}
                                                    @elseif(strpos($subscription->description, '../../') !== false)
                                                        {!! str_replace('../../', url('/').'/', $subscription->description) !!}
                                                    @elseif(strpos($subscription->description, '../') !== false)
                                                        {!! str_replace('../', url('/').'/', $subscription->description) !!}
                                                    @endif
                                                </div>
                                            </main>
                                            <footer>
                                                <div class="c-row">
                                                    <div class="col-md-12 col-sm-12 col-12">
                                                        <h5 class="course-price cp_{{ $subscription->id }}"><span>€ <span>{{ $subscription->price }}</span></span></h5>
                                                    </div>
                                                </div>
                                            </footer>
                                        </a>   
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="alert alert-warning" role="alert">
                                    No plan found against this course.
                                </div>
                            @endif
                        @elseif($type == '2')
                            @if(count($prices)>0)
                                @foreach($prices as $pr)
                                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                                        <div class="course-block mx-auto">
                                        <a class="btna" href="{{ route('course.checkout', ['course_slug' => $course->course_slug, 'p_id' => $pr->id, 'instructor_id' => $instructor_id, 'time' => $time]) }}">
                                            <main>
                                                <div class="col-md-12">
                                                    <h6 class="course-title">{{ $pr->hours }} 
                                                        {{ __('booking.hoursfor') }}
                                                        € {{ $pr->price }}</h6>
                                                    <div class="selectplanimg">
                                                        @if(Storage::exists($pr->image))
                                                            <img src="{{ Storage::url($pr->image) }}" class="" />
                                                        @endif
                                                    </div>
                                                </div>
                                            </main>
                                            <footer>
                                                <div class="c-row">
                                                    <div class="col-md-12 col-sm-12 col-12">
                                                        <h5 class="course-price cp_{{ $pr->id }}"><span>€ <span>{{ $pr->price }}</span></span></h5>
                                                    </div>
                                                </div>
                                            </footer>
                                        </a>   
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="alert alert-warning" role="alert">
                                    No package found against this course.
                                </div>
                            @endif
                        @endif
                        
                    </div>
                </div>
                
            </div>
        </div>
        
    <!-- content end -->
@endsection

@section('javascript')
<script type="text/javascript">

 var clicked = false;
 $('.btna').on("click", function (e) {
    if(clicked===false){
       clicked=true;
       $('.btna').fadeTo("fast", .5).attr('disabled', 'disabled');
    }else{
        
        $('.btna').css("pointer-events", "none");
        e.preventDefault();
    }
  });

    $(document).ready(function() {
        $("#use_coupon").on("click", function() {
            var coupon = $("#coupon_code").val();
            console.log(coupon);
            if (coupon != '' && coupon != undefined && coupon != null) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('applycoupon') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        coupon: coupon
                    },
                    success: function (response) {
                        var data = $.parseJSON(response);
                        var Html = '';
                        if (!data.status) {
                            var Html = '<div class="alert alert-danger">'+
                            '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
                            '<strong><i class="glyphicon glyphicon-ok-sign push-5-r"></</strong> '+ data.message +
                            '</div>';
                        } else {
                            var Html = '<div class="alert alert-success">'+
                            '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
                            '<strong><i class="glyphicon glyphicon-ok-sign push-5-r"></</strong> '+ data.message +
                            '</div>';
                            var coupon = data.coupon;
                            console.log(coupon);
                            var main_wrapper = $('.course-price > span > span');
                            console.log(main_wrapper);
                            if (main_wrapper.length > 1) {
                                $.each(main_wrapper, function(i, e) {
                                    console.log($(e).parent().parent());
                                    var main_price = $(e).text();
                                    var discountedPrice = 0;
                                    if (coupon.type == 'flat') {
                                        if (parseInt(main_price) > parseInt(coupon.discount)) {
                                            discountedPrice = parseInt(main_price) - parseInt(coupon.discount);
                                            if (discountedPrice < 0) {
                                                discountedPrice = 0
                                            }
                                        }
                                    } else {
                                        discountedPrice = parseInt(main_price) - (parseInt(main_price) * parseInt(coupon.discount) / 100);
                                    }
                                    console.log(discountedPrice);
                                    $(e).parent().addClass('prev_price');
                                    $(e).parent().parent().append(' - <span class="new_price"><span>€ </span>' + discountedPrice + '</span>');
                                });
                            } else {
                                var main_price = main_wrapper.text();
                                console.log(main_price);
                                var discountedPrice = 0;
                                if (coupon.type == 'flat') {
                                    if (parseInt(main_price) > parseInt(coupon.discount)) {
                                        discountedPrice = parseInt(main_price) - parseInt(coupon.discount);
                                        if (discountedPrice < 0) {
                                            discountedPrice = 0
                                        }
                                    }
                                } else {
                                    discountedPrice = parseInt(main_price) - (parseInt(main_price) * parseInt(coupon.discount) / 100);
                                }
                                console.log(discountedPrice);
                                $('.course-price > span').addClass('prev_price');
                                $('.course-price').append(' - <span class="new_price"><span>€ </span>' + discountedPrice + '</span>');
                            }
                        }

                        $('.coupon_wrapper .message').html(Html);
                    }
                });
            }
        });
    });
</script>
@endsection