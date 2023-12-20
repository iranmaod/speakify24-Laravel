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

            <form method="POST" action="{{ route('admin.course.prices.save') }}" id="courseForm" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="course_id" value="{{ $course->id }}">
                @if(count($prices) > 0)
                    @php
                        {{$i = 1;}}
                    @endphp
                    @foreach($prices as $dis)
                        <div class="row discounted_row discount_{{$i}}">
                            <input type="hidden" name="id[]" value="{{$dis->id}}" />
                            <div class="form-group col-md-4">
                                <label class="form-control-label">Number of Hours</label>
                                <input type="number" class="form-control" name="hours[]" 
                                    placeholder="Number of Hours" value="{{$dis->hours}}" />
                                    @if ($errors->has('hours'))
                                        <label class="error" for="hours">{{ $errors->first('hours') }}</label>
                                    @endif
                            </div>

                            <div class="form-group col-md-4">
                                <label class="form-control-label">Price</label>
                                <input type="number" class="form-control" name="price[]" 
                                    placeholder="Price" value="{{$dis->price}}" />
                                    @if ($errors->has('price'))
                                        <label class="error" for="course_title">{{ $errors->first('price') }}</label>
                                    @endif
                            </div>

                            <div class="form-group col-md-4">
                                <label class="form-control-label">Image</label>
                                <i data-toggle="tooltip" data-original-title="Delete" onclick="removeRow(this);" data-id="course_image" class="fa fa-trash remove-lp"></i>
                                <label class="cabinet center-block">
									<figure class="course-image-container">
										{{-- <i data-toggle="tooltip" data-original-title="Delete" data-id="course_image" class="fa fa-trash remove-lp" style="float:right;" data-content="{{  Crypt::encryptString(json_encode(array('model'=>'courses', 'field'=>'course_image', 'pid' => 'id', 'id' => $dis->id, 'photo'=>$dis->image))) }}" style="display: @if(Storage::exists($dis->image)){{ 'block' }} @else {{ 'none' }} @endif"></i> --}}
										<img style="max-width:150px;" src="@if(Storage::exists($dis->image)){{ Storage::url($dis->image) }}@else{{ asset('backend/assets/images/course_detail.jpg') }}@endif" class="gambar img-responsive" id="course_image-output" name="course_image-output" />
										<input type="file" class="item-img file center-block" name="image[]" />
									</figure>
								</label>
                                <!-- <input type="file" class="form-control" name="image[]" value="{{--$dis->image--}}" /> -->
                                @if ($errors->has('image'))
                                    <label class="error" for="course_title">{{ $errors->first('image') }}</label>
                                @endif
                            </div>
                        </div>
                        @php
                            {{$i++;}}
                        @endphp
                    @endforeach
                @else
                    <div class="row discounted_row discount_1">
                        <input type="hidden" name="id[]" value="0" />
                        <div class="form-group col-md-4">
                            <label class="form-control-label">Number of Hours</label>
                            <input type="number" class="form-control" name="hours[]" 
                                placeholder="Number of Hours" value="" />
                                @if ($errors->has('hours'))
                                    <label class="error" for="course_title">{{ $errors->first('hours') }}</label>
                                @endif
                        </div>

                        <div class="form-group col-md-4">
                            <label class="form-control-label">Price</label>
                            <input type="number" class="form-control" name="price[]" 
                                placeholder="Price" value="" />
                                @if ($errors->has('price'))
                                    <label class="error" for="course_title">{{ $errors->first('price') }}</label>
                                @endif
                        </div>

                        <div class="form-group col-md-4">
                            <label class="form-control-label">Image</label>
                            <i data-toggle="tooltip" data-original-title="Delete" onclick="removeRow(this);" data-id="course_image" class="fa fa-trash remove-lp"></i>
                            <label class="cabinet center-block">
                                <figure class="course-image-container">
                                    <img src="{{ asset('backend/assets/images/course_detail.jpg') }}" class="gambar img-responsive" name="course_image-output" />
                                    <input type="file" class="item-img file center-block" name="image[]" />
                                </figure>
                            </label>
                                @if ($errors->has('image'))
                                    <label class="error" for="course_title">{{ $errors->first('image') }}</label>
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
        $(eleClone).attr("class", "row discounted_row discount_" + nextEleNumber);
        $(eleClone).insertAfter($("." + eleMainClassSplit[2]));
        console.log($(".discount_" + nextEleNumber).find(":input").val(""));
        var source = "{!! asset('backend/assets/images/course_detail.jpg') !!}";
        console.log($(".discount_" + nextEleNumber).find("img.img-responsive").attr("src", source));
    }

    function removeRow(val) {
        console.log($(val).parent().parent().remove());
    }
</script>
@endsection