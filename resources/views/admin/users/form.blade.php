@extends('layouts.backend.index')
@section('content')
<style type="text/css">
    label.cabinet{
		display: block;
		cursor: pointer;
	}
	label.cabinet input.file{
		position: relative;
		height: 100%;
		width: auto;
		opacity: 0;
		-moz-opacity: 0;
		filter:progid:DXImageTransform.Microsoft.Alpha(opacity=0);
		margin-top:-30px;
	}
	.cabinet.center-block{
		margin-bottom: -1rem;
	}
	figure figcaption {
		position: absolute;
		bottom: 0;
		color: #fff;
		width: 100%;
		padding-left: 9px;
		padding-bottom: 5px;
		text-shadow: 0 0 10px #000;
	}
	.course-image-container{
		/* width: 300px; */
		height: 200px;
		border: 1px solid #e4eaec;;
		position: relative;
	}
	.course-image-container img{
		width: 258px;
		height: 172px;
		position: absolute;  
		top: 0;  
		bottom: 0;  
		left: 0;  
		right: 0;  
		margin: auto;
	}
	.remove-lp{
		font-size: 16px;
		color: red;
		float: right;
		padding-right: 2px;
	}
	#upload-demo{
		width: 558px;
		height: 372px;
		padding-bottom:25px;
	}
	figure figcaption {
		position: absolute;
		bottom: 0;
		color: #fff;
		width: 100%;
		padding-left: 9px;
		padding-bottom: 5px;
		text-shadow: 0 0 10px #000;
	}
	.course-image-container{
		width: 435px;
		height: 290px;
		border: 1px solid #e4eaec;;
		position: relative;
	}
	.course-image-container img{
		width: 399px;
		height: 266px;
		position: absolute;  
		top: 0;  
		bottom: 0;  
		left: 0;  
		right: 0;  
		margin: auto;
	}
</style>
<div class="page-header">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
		<li class="breadcrumb-item"><a href="{{ route('admin.users') }}">Users Management</a></li>
		<li class="breadcrumb-item active">Add</li>
	</ol>
	<h1 class="page-title">Add User</h1>
</div>

<div class="page-content">
	<div class="panel">
		<div class="panel-body">
			<form method="POST" action="{{ route('admin.saveUser') }}" id="userForm" enctype="multipart/form-data">
				{{ csrf_field() }}
				<input type="hidden" name="user_id" value="{{ $user->id }}">
				<input type="hidden" name="instructor_id" @if(!empty($user->instructor)) value="{{ $user->instructor->id }}" @endif />
				<div class="row">
				
					<div class="form-group col-md-4">
						<label class="form-control-label">First Name</label>
						<input type="text" class="form-control" name="first_name" 
						placeholder="First Name" value="{{ $user->first_name }}" />
						@if ($errors->has('first_name'))
							<label class="error" for="first_name">{{ $errors->first('first_name') }}</label>
						@endif
					</div>
				
					<div class="form-group col-md-4">
						<label class="form-control-label">Last Name</label>
						<input type="text" class="form-control" name="last_name"
						placeholder="Last Name" value="{{ $user->last_name }}" />
						@if ($errors->has('last_name'))
							<label class="error" for="last_name">{{ $errors->first('last_name') }}</label>
						@endif
					</div>
				
					<div class="form-group col-md-4">
						<label class="form-control-label">Email Address</label>
						<input type="text" class="form-control" name="email"
						placeholder="Email Address" value="{{ $user->email }}" @if($user->email) readonly @endif/>
						@if ($errors->has('email'))
							<label class="error" for="email">{{ $errors->first('email') }}</label>
						@endif
					</div>
					<div class="form-group col-md-4">
						<label class="form-control-label">Status</label>
						<div>
							<select class="form-control" name="is_active">
								<option value="1" @if($user->is_active == '1'){{ 'selected' }}@endif>Active</option>
								<option value="0" @if($user->is_active == '0'){{ 'selected' }}@endif>Pending</option>
								<option value="2" @if($user->is_active == '2'){{ 'selected' }}@endif>Inactive</option>
								<option value="3" @if($user->is_active == '3'){{ 'selected' }}@endif>Denied</option>
							</select>
							@if ($errors->has('is_active'))
								<label class="error" for="is_active">{{ $errors->first('is_active') }}</label>
							@endif
						</div>
					</div>

					<div class="form-group col-md-4">
						<label class="form-control-label">Email Verified</label>
						<div>
							<select class="form-control" name="verify">
								<option value="0" @if($user->email_verified_at == ''){{ 'selected' }}@endif>No</option>
								<option value="1" @if($user->email_verified_at != ''){{ 'selected' }}@endif>Yes</option>
							</select>
							@if ($errors->has('verify'))
								<label class="error" for="verify">{{ $errors->first('verify') }}</label>
							@endif
						</div>
					</div>

					<div class="form-group col-md-4">
						<label class="form-control-label">Role</label>
						<div>
							<div class="checkbox-custom checkbox-default checkbox-inline">
								<input type="checkbox" id="inputCheckboxStudent" name="roles[]" value="student" @if($user->id && $user->hasRole('student')) checked @endif>
								<label for="inputCheckboxStudent">Student</label>
							</div>
							<div class="checkbox-custom checkbox-default checkbox-inline">
								<input type="checkbox" id="inputCheckboxInstructor" name="roles[]" value="instructor" @if($user->id &&  $user->hasRole('instructor')) checked @endif>
								<label for="inputCheckboxInstructor">Instructor</label>
							</div>
							<div id="role-div-error">
							@if ($errors->has('roles'))
								<label class="error">{{ $errors->first('roles') }}</label>
							@endif
							</div>
						</div>
					</div>
				
					<div class="form-group col-md-4">
						<label class="form-control-label" >Password</label>
						<input type="password" class="form-control"  name="password"
						placeholder="Password"/>
						@if ($errors->has('password'))
							<label class="error" for="password">{{ $errors->first('password') }}</label>
						@endif
					</div>

					

					<div class="instructorView row" style="display:none;padding: 0px 15px;">
						<div class="form-group col-md-4">
							<label class="form-control-label">Telephone </label>
							<input type="text" class="form-control" name="telephone" 
								placeholder="Telephone" @if(!empty($user->instructor)) value="{{ $user->instructor->telephone }}" @endif />
							@if ($errors->has('telephone'))
								<label class="error" for="telephone">{{ $errors->first('telephone') }}</label>
							@endif  
						</div>

						<div class="form-group col-md-4">
							<label class="form-control-label">Mobile </label>
							<input type="text" class="form-control" name="mobile" 
								placeholder="Mobile" @if(!empty($user->instructor)) value="{{ $user->instructor->mobile }}" @endif />               
						</div>

						<div class="form-group col-md-4">
							<label class="form-control-label">Amount per call </label>
							<input type="number" class="form-control" name="amount" 
								placeholder="Amount" @if(!empty($user->instructor)) value="{{ $user->instructor->amount }}" @endif />               
							@if ($errors->has('amount'))
								<label class="error" for="amount">{{ $errors->first('amount') }}</label>
							@endif
						</div>

						<div class="form-group col-md-4">
							<label class="form-control-label">Paypal ID </label>
							<input type="text" class="form-control" name="paypal_id" 
								placeholder="Paypal ID" @if(!empty($user->instructor)) value="{{ $user->instructor->paypal_id }}" @endif />               
							@if ($errors->has('paypal_id'))
								<label class="error" for="paypal_id">{{ $errors->first('paypal_id') }}</label>
							@endif
						</div>
						
						<div class="form-group col-md-4">
							<label class="form-control-label">Youtube Inro Link </label>
							<input type="text" class="form-control" name="youtube_link" 
								placeholder="Youtube Intro Link" @if(!empty($user->instructor)) value="{{ $user->instructor->link_youtube }}" @endif />               
						</div>
						<div class="form-group col-md-4">
							<label class="form-control-label">City </label>
							<input type="text" class="form-control" name="city" 
								placeholder="City" @if(!empty($user->instructor)) value="{{ $user->instructor->city }}" @endif />
							@if ($errors->has('city'))
								<label class="error" for="city">{{ $errors->first('city') }}</label>
							@endif
					
						</div>
						@php
							$userInstId = NULL;
							$checked = NULL;
							$iibChecked = NULL;
							$lSpeakId = NULL;
							$lTeachId = NULL;
							$Icv = NULL;
							$Iimage = NULL;
							$Itax = NULL;
							$Iid = NULL;
							$who = '';
							$exp = '';
							$lov = '';
							if(!empty($user->instructor)){
								$userInstId = $user->instructor->country_id;
								$lSpeakId = $user->instructor->language_speak_id;
								$lTeachId = $user->instructor->language_teach_id;
								if($user->instructor->is_native) $checked = 1;
								if($user->instructor->is_instant_booking) $iibChecked = 1;
								$Icv = $user->instructor->cv;
								$Iimage = $user->instructor->instructor_image;
								$Itax = $user->instructor->tax_number;
								$Iid = $user->instructor->id;
								$who = $user->instructor->who;
								$exp = $user->instructor->experience;
								$lov = $user->instructor->love_job;
							}
							
									
						@endphp
						<div class="form-group col-md-4">
							<label class="form-control-label">Country </label>
							<select class="form-control" name="country_id">
								<option value="">Select</option>
								@foreach($countries as $country)
									<option value="{{ $country->id }}"
									@if($country->id == $userInstId){{ 'selected' }}@endif>
										{{ $country->name }}
									</option>
								@endforeach				
							</select>
							@if ($errors->has('country_id'))
								<label class="error" for="country_id">{{ $errors->first('country_id') }}</label>
							@endif
						</div>		
						<div class="form-group col-md-4">
							<label class="form-control-label">Native Speaker </label>
							<div>
								<div class="radio-custom radio-default radio-inline">
									<input type="radio" id="inputBasicActive" name="is_native" value="1" @if($checked) checked @endif />
									<label for="inputBasicActive">Yes</label>
								</div>
								<div class="radio-custom radio-default radio-inline">
									<input type="radio" id="inputBasicInactive" name="is_native" value="0" @if(!$checked) checked @endif />
									<label for="inputBasicInactive">No</label>
								</div>
							</div>
						</div>
						<div class="form-group col-md-4">
							<label class="form-control-label">Instant Booking </label>
							<div>
								<div class="radio-custom radio-default radio-inline">
									<input type="radio" id="inputBasicActive" name="is_instant_booking" value="1" @if($iibChecked) checked @endif />
									<label for="inputBasicActive">Yes</label>
								</div>
								<div class="radio-custom radio-default radio-inline">
									<input type="radio" id="inputBasicInactive" name="is_instant_booking" value="0" @if(!$iibChecked) checked @endif/>
									<label for="inputBasicInactive">No</label>
								</div>
							</div>
						</div>
						<div class="form-group col-md-4">
							<label class="form-control-label">Language Speaks </label>
							<select class="form-control" name="language_speak_id">
								<option value="">Select</option>
								@foreach($languages as $language)
									<option value="{{ $language->id }}"
									@if($language->id == $lSpeakId){{ 'selected' }}@endif>
										{{ $language->title }}
									</option>
								@endforeach					
							</select>
							@if ($errors->has('language_speak_id'))
								<label class="error" for="language_speak_id">{{ $errors->first('language_speak_id') }}</label>
							@endif
						</div>
						<div class="form-group col-md-4">
							<label class="form-control-label">Language Teaches </label>
							<select class="form-control" name="language_teach_id">
								<option value="">Select</option>
								@foreach($languages as $language)
									<option value="{{ $language->id }}"
									@if($language->id == $lTeachId){{ 'selected' }}@endif>
										{{ $language->title }}
									</option>
								@endforeach				
							</select>
							@if ($errors->has('language_teach_id'))
								<label class="error" for="language_teach_id">{{ $errors->first('language_teach_id') }}</label>
							@endif
						</div>
						<div class="form-group col-md-4">
							<label class="form-control-label">Tax Number <span class="required">*</span></label>
							<input type="text" class="form-control" name="tax_number" 
								placeholder="Tax Number" value="{{ $Itax }}" />
								@if ($errors->has('tax_number'))
									<label class="error" for="city">{{ $errors->first('tax_number') }}</label>
								@endif
						</div>
						<div class="row col-md-12" style="padding:0px 15px;">
							<div class="form-group col-md-6">
								<label class="form-control-label" style="margin-bottom: -5px;">Profile Image</label>
								<label class="cabinet center-block">
									<figure class="course-image-container">
										<i data-toggle="tooltip" data-original-title="Delete" data-id="course_image" class="fa fa-trash remove-lp" data-content="{{  Crypt::encryptString(json_encode(array('model'=>'courses', 'field'=>'course_image', 'pid' => 'id', 'id' => $Iid, 'photo'=>$Iimage))) }}" style="display: @if(Storage::exists($Iimage)){{ 'block' }} @else {{ 'none' }} @endif"></i>
										<img src="@if(Storage::exists($Iimage)){{ Storage::url($Iimage) }}@else{{ asset('backend/assets/images/course_detail.jpg') }}@endif" class="gambar img-responsive" id="course_image-output" name="course_image-output" />
										<input type="file" class="item-img file center-block" name="course_image" id="course_image" />
									</figure>
									<span style="font-size: 10px;">
										Supported File Formats: jpg,jpeg,png
									</span>
								</label>
								<input type="hidden" name="course_image_base64" id="course_image_base64">
							</div>
							<div class="form-group col-md-6">
								<label>CV</label>
								<input type="file" class="form-control form-control-sm" placeholder="CV" value="{{ $Icv }}" name="cv">
								@if(Storage::exists($Icv))
									<a href="{{ Storage::url($Icv) }}" target="_new" class="btn btn-sm btn-success">Download</a>
								@endif
								@if ($errors->has('cv'))
									<label class="error" for="email">{{ $errors->first('cv') }}</label>
								@endif
							</div> 
						</div>
						<div class="row col-md-12" style="padding:0px 15px;">
							<div class="form-group col-md-12"><h3>Biography</h3></div>
							<div class="form-group col-md-4">
								<label class="form-control-label">Who are you? <span class="required">*</span></label>
								<textarea name="who">
									{!! $who !!}
								</textarea>
								@if ($errors->has('who'))
									<label class="error" for="who">{{ $errors->first('who') }}</label>
								@endif
							</div>
							<div class="form-group col-md-4">
								<label class="form-control-label">What teaching experience do you have? <span class="required">*</span></label>
								<textarea name="experience">
									{!! $exp !!}
								</textarea>
								@if ($errors->has('experience'))
									<label class="error" for="experience">{{ $errors->first('experience') }}</label>
								@endif
							</div>
							<div class="form-group col-md-4">
								<label class="form-control-label">Why do you love your job? <span class="required">*</span></label>
								<textarea name="love_job">
									{!! $lov !!}
								</textarea>
								@if ($errors->has('love_job'))
									<label class="error" for="love_job">{{ $errors->first('love_job') }}</label>
								@endif
							</div>
						</div>
					</div>
					<div class="form-group col-md-4">
						<label class="form-control-label">Communication Language</label>
						<select class="form-control" name="comm_lang">
							<option>Select</option>
							<option value="enEmail" @if($user->comm_lang == 'enEmail'){{ 'selected' }}@endif>English</option>
							<option value="deEmail" @if($user->comm_lang == 'deEmail'){{ 'selected' }}@endif>German</option>
						</select>
						
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

       
      <!-- End Panel Basic -->
</div>

<div class="modal fade" id="cropImagePop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Edit Photo</h4>
            </div>
            <div class="modal-body">
                <div id="upload-demo" class="center-block"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" id="cropImageBtn" class="btn btn-primary">Crop</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('javascript')
<script type="text/javascript">
    $(document).ready(function() {
      	if ($('#inputCheckboxInstructor').is(":checked")) {
			$('.instructorView').show();
		}
		$(".checkbox-custom").click(function(){			
			if ($('#inputCheckboxInstructor').is(":checked")) {
				$('.instructorView').show();
			} else {
				$('.instructorView').hide();
			}
		});
		$(".gambar").attr("src", @if(Storage::exists($Iimage))"{{ Storage::url($Iimage) }}" @else "{{ asset('backend/assets/images/course_detail.jpg') }}" @endif);

        var $uploadCrop,
        tempFilename,
        rawImg,
        imageId;

        function readFile(input, id) {    
            
            var file_name = input.files[0].name;
            var extension = (input.files[0].name).split('.').pop();
            var allowed_extensions = ["jpg", "jpeg", "png"];
            var fsize = input.files[0].size;
            toastr.options.closeButton = true;
            toastr.options.timeOut = 5000;

            if (input.files && input.files[0]) {

                if ($.inArray(extension, allowed_extensions) == -1) {
                    toastr.error("Image format mismatch");
                    return false;
                } else if(fsize > 5145728) {
                    toastr.error("Image size exceeds");
                    return false;
                } 
                $('.input-group-file input').attr('value', file_name);
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('.upload-demo').addClass('ready');

                    $('#cropImageBtn').attr('data-id', id);

                    $('#cropImagePop').modal('show');
                    rawImg = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        $uploadCrop = $('#upload-demo').croppie({
            viewport: {
                width: 758,
                height: 572,
            },
			imageSmoothingEnabled: true,
			imageSmoothingQuality: 'high',
    		// showZoomer: false,
            // enforceBoundary: true,
            // enableExif: true
        });

        $('#cropImagePop').on('shown.bs.modal', function(){
            // alert('Shown pop');
            $uploadCrop.croppie('bind', {
                url: rawImg
            }).then(function(){
                console.log('jQuery bind complete');
            });
        });

        $('.item-img').on('change', function () {
			imageId = $(this).data('id');
			tempFilename = $(this).val();
         	readFile(this, $(this).attr('id'));
		});

        $('#cropImageBtn').on('click', function (ev) {
            var data_id = $(this).attr('data-id');
			console.log(data_id);
            $uploadCrop.croppie('result', {
                type: 'base64',
                format: 'png',
                size: {
					width: 758,
					height: 572
				}
            }).then(function (resp) {
                $("#"+data_id+"_base64").val(resp);
				console.log($("#"+data_id+"_base64"));
                $("#"+data_id+"-output").attr("src", resp);
                $("#cropImagePop").modal("hide");
            });
        });
        //image crop end

        $('.remove-lp').click(function(event)
        {
            event.preventDefault();
            var this_id = $(this);
            var current_id = $(this).attr('data-id');

            alertify.confirm('Are you sure want to delete this image?', function () {
                var url = "{{ url('delete-photo') }}";
                var data_content = this_id.attr('data-content');
                 $.ajax({
                    type: "POST",
                    url: url,
                    data: {data_content: data_content, _token: "{{ csrf_token() }}"},
                    success: function (data) {
                        $("#"+current_id+"-output").attr("src", "{{ asset('backend/assets/images/course_detail.jpg') }}");
                        this_id.hide();
                    }
                });
            }, function () {    
                return false;
            });

            
        });

        tinymce.init({ 
            selector:'textarea',
            menubar:false,
            statusbar: false,
            height: 280,
            content_style: "#tinymce p{color:#76838f;}"
        });
    
        $("#userForm").validate({
            rules: {
                first_name: {
                    required: true
                },
                last_name: {
                    required: true
                },
                @if(!$user->id)
                email:{
                    required: true,
                    email:true,
                    remote: "{{ url('checkUserEmailExists') }}"
                },
                password:{
                    required: true,
                    minlength: 6
                },
                @endif
                "roles[]": {
                    required: true
                }
            },
            messages: {
                first_name: {
                    required: 'The first name field is required.'
                },
                last_name: {
                    required: 'The last name field is required.'
                },
                email: {
                    required: 'The email field is required.',
                    email: 'The email must be a valid email address.',
                    remote: 'The email has already been taken.'
                },
                password: {
                    required: 'The password field is required.',
                    minlength: 'The password must be at least 6 characters.'
                },
                "roles[]": {
                    required: 'The role field is required.'
                }
            },
            errorPlacement: function(error, element) {
                if(element.attr("name") == "roles[]") {
                    error.appendTo("#role-div-error");
                }else {
                    error.insertAfter(element);
                }
            }
        });
    });
</script>
@endsection