@extends('layouts.backend.index')
@section('content')
<div class="page-header">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.course.list') }}">Courses</a></li>
        <li class="breadcrumb-item active">Add</li>
    </ol>
    <h1 class="page-title">Add Course</h1>
</div>

<div class="page-content">
    <div class="panel">
        <div class="panel-body">
            @include('admin/course/tabs')

            <form method="POST" action="{{ route('admin.course.discount.save') }}" id="courseForm">
                {{ csrf_field() }}
                <input type="hidden" name="course_id" value="{{ $course->id }}">
                @if(count($discounts) > 0)
                    @php
                        {{$i = 1;}}
                    @endphp
                    @foreach($discounts as $dis)
                        <div class="row discounted_row discount_{{$i}}">
                            <input type="hidden" name="id[]" value="{{$dis->id}}" />
                            <div class="form-group col-md-6">
                                <label class="form-control-label">Number of Courses</label>
                                <input type="number" class="form-control" name="number[]" 
                                    placeholder="Number of Courses" value="{{$dis->number}}" />
                                    @if ($errors->has('number'))
                                        <label class="error" for="course_title">{{ $errors->first('number') }}</label>
                                    @endif
                            </div>

                            <div class="form-group col-md-6">
                                <label class="form-control-label">Discount</label>
                                <input type="number" class="form-control" name="discount[]" 
                                    placeholder="Discount" value="{{$dis->discount}}" />
                                    @if ($errors->has('discount'))
                                        <label class="error" for="course_title">{{ $errors->first('discount') }}</label>
                                    @endif
                            </div>
                        </div>
                        @php
                            {{$i++;}}
                        @endphp
                    @endforeach
                @else
                    <div class="row discounted_row discount_1">
                        <input type="hidden" name="id" value="" />
                        <div class="form-group col-md-6">
                            <label class="form-control-label">Number of Courses</label>
                            <input type="number" class="form-control" name="number[]" 
                                placeholder="Number of Courses" value="" />
                                @if ($errors->has('number'))
                                    <label class="error" for="course_title">{{ $errors->first('number') }}</label>
                                @endif
                        </div>

                        <div class="form-group col-md-6">
                            <label class="form-control-label">Discount</label>
                            <input type="number" class="form-control" name="discount[]" 
                                placeholder="Discount" value="" />
                                @if ($errors->has('discount'))
                                    <label class="error" for="course_title">{{ $errors->first('discount') }}</label>
                                @endif
                        </div>
                    </div>
                @endif
                <div class="form-group row">
                    <div class="col-md-3">
                        <a href="javascript:void(0);" onclick="cloneElement();" class="btn btn-success btn-sm">Add More</a>
                    </div>
                </div>
                <hr>
                <div class="form-group row">
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            
            </form>
        </div>
    </div>
      <!-- End Panel Basic -->
</div>
@endsection

@section('javascript')
<script type="text/javascript">
    $(document).ready(function() { 
        
    });

    function cloneElement() {
        var eleClone = $(".discounted_row").last().clone();
        var eleClass = eleClone.attr("class");
        var eleClassSplit = eleClass.split("discount_");
        var eleMainClassSplit = eleClass.split(" ");
        var nextEleNumber = Number(eleClassSplit[1]) + 1;
        eleClone.find("input").val("");
        eleClone.attr("class", "row discounted_row discount_" + nextEleNumber);
        eleClone.insertAfter($("." + eleMainClassSplit[2]));
    }
</script>
@endsection