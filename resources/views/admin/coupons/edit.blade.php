@extends('layouts.backend.index')
@section('content')
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.coupons') }}">Coupons</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>
    <h1 class="page-title">Edit Coupon</h1>
</div>

<div class="page-content">

    <div class="panel">
        <div class="panel-body">
            <form method="POST" action="{{ route('admin.coupon.update') }}" id="couponForm">
                {{ csrf_field() }}
                <input type="hidden" name="id" value="{{$coupon->id}}" />
                <div class="row">
                    <div class="form-group col-md-4">
                        <label class="form-control-label">Name <span class="required">*</span></label>
                        <input type="text" class="form-control" name="name" 
                            placeholder="Name" value="{{ $coupon->name }}" />
                            @if ($errors->has('name'))
                                <label class="error" for="title">{{ $errors->first('name') }}</label>
                            @endif
                    </div>

                    <div class="form-group col-md-4">
                        <label class="form-control-label">Code <span class="required">*</span></label>
                        <input type="text" class="form-control" name="code" placeholder="Code" value="{{ $coupon->code }}" />
                            @if ($errors->has('name'))
                                <label class="error" for="title">{{ $errors->first('code') }}</label>
                            @endif
                    </div>
                    
                    <div class="form-group col-md-4">
                        <label class="form-control-label">Discount <span class="required">*</span></label>
                        <input type="text" class="form-control" name="discount" placeholder="Discount" value="{{ $coupon->discount }}" />
                            @if ($errors->has('discount'))
                                <label class="error" for="title">{{ $errors->first('discount') }}</label>
                            @endif
                    </div>

                    <div class="form-group col-md-4">
                        <label class="form-control-label">Type <span class="required">*</span></label>
                        <select class="form-control" name="type">
                            <option value="">Select</option>
                            <option value="flat" {{ $coupon->type == 'flat' ? 'selected' : '' }}>Flat</option>
                            <option value="percentage" {{ $coupon->type == 'percentage' ? 'selected' : '' }}>Percentage</option>
                        </select>
                        
                        @if ($errors->has('type'))
                            <label class="error" for="type">{{ $errors->first('type') }}</label>
                        @endif
                    </div>
                    
                    <div class="form-group col-md-4">
                        <label class="form-control-label">Number of Use <span class="required">*</span></label>
                        <input type="text" class="form-control" name="number_of_usage" placeholder="Number of Use" value="{{ $coupon->number_of_usage }}" />
                            @if ($errors->has('number_of_usage'))
                                <label class="error" for="title">{{ $errors->first('number_of_usage') }}</label>
                            @endif
                    </div>

                    <div class="form-group col-md-4">
                        <label class="form-control-label">Start Date <span class="required">*</span></label>
                        <input type="date" class="form-control" name="startdate" 
                            placeholder="Start Date" value="{{ $coupon->startdate }}" />
                    </div>

                    <div class="form-group col-md-4">
                        <label class="form-control-label">End Date <span class="required">*</span></label>
                        <input type="date" class="form-control" name="enddate" 
                            placeholder="End Date" value="{{ $coupon->enddate }}" />
                    </div>

                    <div class="form-group col-md-4">
                        <label class="form-control-label">Status <span class="required">*</span></label>
                        <select class="form-control" name="status">
                            <option value="">Select</option>
                            <option value="0" @if('0' == $coupon->status){{ 'selected' }}@endif>Pending</option>
                            <option value="1" @if('1' == $coupon->status){{ 'selected' }}@endif>Active</option>
                        </select>
                        
                        @if ($errors->has('status'))
                            <label class="error" for="status">{{ $errors->first('status') }}</label>
                        @endif
                    </div>

                </div>
                <hr>
                <div class="form-group row">
                    <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="reset" class="btn btn-default btn-outline">Reset</button>
                    </div>
                </div>
        
            </form>
        </div>
    </div>
</div>

@endsection

@section('javascript')
<script type="text/javascript">
    $(document).ready(function() {
        $(".datetime").datetimepicker();
    });
</script>
@endsection