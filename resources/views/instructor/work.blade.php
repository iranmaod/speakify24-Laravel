@extends('layouts.backend.index')
@section('content')
<link href="{{ asset('backend/curriculum/css/createcourse/style.css') }}" rel="stylesheet">
<div class="page-header">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('instructor.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Profile</li>
  </ol>
  <h1 class="page-title">Profile</h1>
</div>

<div class="page-content">

<div class="panel">
  <div class="panel-body">
 @include('instructor/tabs')
 <!-- Job start -->
 <div class="curriculam-block">
 <div class="container">
    <!--<form method="POST" action="{{ route('instructor.edu.save') }}" id="profileForm" enctype="multipart/form-data">-->
      {{ csrf_field() }}
      <input type="hidden" name="instructor_id" value="{{ $instructor->id }}">
      <input type="hidden" name="old_course_image" value="{{ $instructor->instructor_image }}">
	  <input name="edusave" type="hidden" value="{{ url('instructor/edu/save') }}">
	  <input name="edudelete" type="hidden" value="{{ url('instructor/edu/delete') }}">
      <div class="row">  
		<div class="container pt-15">	  
		 <div class="su_course_curriculam">
			<div class="su_course_curriculam_sortable">
                <ul class="clearfix ui-sortable su_unique_add_sort">
                  @php $sectioncount = '1'; @endphp
                  @foreach($works as $work)
				  
                  <li class="su_gray_curr parentli section-{!! $work->id !!}">
                    <div class="row-fluid sorthandle">
                      <div class="">
                        <div class="su_course_section_label su_gray_curr_block" style="background-color: #4a98ff;">
                          <div class="col col-lg-6 edit_option edit_option_section">{!! Lang::get('instructor.school')!!} <span class="serialno">{!! $sectioncount !!}</span>: <label class="slqtitle sch{!! $work->id !!}">{!! $work->school !!}</label>
                            <input type="text" maxlength="80" class="chcountfield su_school_update_section_textbox su_course_update_section_textbox"  value="{!! $work->school !!}" >
                            <span class="ch-count">{!! 80-strlen($work->school) !!}</span>
                          </div>
						  <div class="col col-lg-6 edit_option edit_option_section">{!! Lang::get('instructor.degree')!!} <span class="serialno">{!! $sectioncount !!}</span>: <label class="slqtitle deg{!! $work->id !!}">{!! $work->degree !!}</label>
                             <select class="form-control su_degree_update_section_textbox" name="degree" style="display:none;">
								<option value="">Select</option>								
								<option value="Primary" @if($work->degree == 'Primary'){{ 'selected' }}@endif>Primary</option>
								<option value="Secondary" @if($work->degree == 'Secondary'){{ 'selected' }}@endif>Secondary</option>
								<option value="Bachelor" @if($work->degree == 'Bachelor'){{ 'selected' }}@endif>Bachelor</option>
								<option value="Master" @if($work->degree == 'Master'){{ 'selected' }}@endif>Master</option>
								<option value="Certification" @if($work->degree == 'Certification'){{ 'selected' }}@endif>Certification</option>
							</select>
          
                          </div>
						   <div class="col col-lg-6 edit_option edit_option_section">{!! Lang::get('instructor.major')!!} <span class="serialno">{!! $sectioncount !!}</span>: <label class="slqtitle maj{!! $work->id !!}">{!! $work->major !!}</label>
                            <input type="text" maxlength="80" class="chcountfield su_major_update_section_textbox su_course_update_section_textbox"  value="{!! $work->major !!}" >                    
                          </div>
						   <div class="col col-lg-6 edit_option edit_option_section">{!! Lang::get('instructor.city')!!} <span class="serialno">{!! $sectioncount !!}</span>: <label class="slqtitle cit{!! $work->id !!}">{!! $work->city !!}</label>
                            <input type="text" maxlength="80" class="chcountfield su_city_update_section_textbox su_course_update_section_textbox"  value="{!! $work->city !!}" >
                            <span class="ch-count">{!! 80-strlen($work->city) !!}</span>
                          </div>
						  <div class="col col-lg-6 edit_option edit_option_section">{!! Lang::get('instructor.country')!!} <span class="serialno">{!! $sectioncount !!}</span>: <label class="slqtitle cou{!! $work->id !!}">{!! $work->country->name !!}</label>
						    <select class="form-control su_country_update_section_textbox" name="country_id" style="display:none;">
								<option value="">Select</option>
								@foreach($countries as $country)
								<option value="{{ $country->id }}"
								@if($country->id == $work->country_id){{ 'selected' }}@endif>
								{{ $country->name }}
								</option>
								@endforeach				
							</select>
                          </div>
						   <div class="col col-lg-6 edit_option edit_option_section">{!! Lang::get('instructor.startdate')!!} <span class="serialno">{!! $sectioncount !!}</span>: <label class="slqtitle sta{!! $work->id !!}">{!! $work->startdate !!}</label>
                            <input type="date" class="chcountfield su_startdate_update_section_textbox su_course_update_section_textbox"  value="{!! $work->startdate !!}" >
                           
                          </div>
						   <div class="col col-lg-6 edit_option edit_option_section">{!! Lang::get('instructor.enddate')!!} <span class="serialno">{!! $sectioncount !!}</span>: <label class="slqtitle end{!! $work->id !!}">{!! $work->enddate !!}</label>
                            <input type="date" class="chcountfield su_enddate_update_section_textbox su_course_update_section_textbox"  value="{!! $work->enddate !!}" >                           
                          </div>
												
                              <div class="col col-lg-8" id="allbar{!! $work->id !!}" style="display:none;">
									<input type="hidden" id="probar_status_{!! $work->id !!}" value="0" />
                                    <div class="luploadvideo-progressbar meter" ><div class="bar" id="probar{!! $work->id !!}" style="width:0%"></div></div>
                               </div>
								<div class="col col-lg-6 luploadvideo" id="resfiles-{!! $work->id !!}" style="display:none;">
                                        <input id="luploadres" class="resfiles luploadbtn" type="file" name="lectureres" data-url="{{ url('instructor/edudoc/save/'.$work->id) }}" data-lid="{!! $work->id !!}">
                                        <span>{!! Lang::get('instructor.updatedoc')!!}</span>
                                </div>
							 @if(!empty($work->file_name))
							<div class="col col-lg-6 edit_option edit_option_section" id="resourceblock{!! $work->id !!}" style="display:block;">	
							 <div id="resources{!! $work->id !!}" style="color:#fff;">  <i class="fa fa-download" style="color:#fff;"></i> @if(Storage::exists('education/'.$work->id.'/'.$work->file_name))<a style="color:#fff;" href="{{ Storage::url('education/'.$work->id.'/'.$work->file_name) }}" target="_blank">{!! $work->file_name !!}</a>@else {!! $work->file_name !!} @endif<div class="goright resdelete" data-lid="{!! $work->id !!}" data-rid="{!! $work->id !!}"><i class="goright fa fa-trash-o"></i></div></div>
							</div>
							@endif						   
								
			
                           		
                          <input type="hidden" value="{!! $work->id !!}" class="sectionid" name="eduids[]">            
                          <div class="deletesection" onclick="deleteedu({!! $work->id !!})"></div>
                          <div class="updatesection" onclick="updateedu({!! $work->id !!})"></div>
                        </div>
                      </div>
                    </div>
                  </li>
				   @php $sectioncount++; @endphp
				   @endforeach
			<form method="POST" action="{{ route('instructor.edu.save') }}" id="EForm" enctype="multipart/form-data">
				<div class="su_course_curriculam_default">
                <ul class="clearfix">					
                  <li class="su_gray_curr">
                    <div class="row-fluid">
                      <div class="">
                        <div class="su_course_add_section_label su_gray_curr_block" style="background-color: #4a98ff;">
                          <span> {!! Lang::get('instructor.addeducation')!!}</span>
                        </div>

                        <div class="su_course_add_section_content su_course_add_content_form" style="height:auto !important;">
                          <div class="formrow">
                            <div class="row-fluid">
                              <div class="col col-lg-3">
                                <label>{!! Lang::get('instructor.school')!!}: <span class="text-danger">*</span></label>
                              </div>
                              <div class="col col-lg-9">
                                <input type="text" name="school" value="" placeholder="{!! Lang::get('instructor.enterschool')!!}" class="form-element su_school_add_section_textbox chcountfield" maxlength="80">
                                <span id="section_title_counter" class="ch-count">80</span>
                              </div>
                            </div>
							 <div class="row-fluid">
                              <div class="col col-lg-3">
                                <label>{!! Lang::get('instructor.degree')!!}: <span class="text-danger">*</span></label>
                              </div>
                              <div class="col col-lg-9">
								<select class="form-control su_degree_add_section_textbox" name="degree">
									<option value="">Select</option>								
									<option value="Primary">Primary</option>
									<option value="Secondary">Secondary</option>
									<option value="Bachelor">Bachelor</option>
									<option value="Master">Master</option>
									<option value="Certification">Certification</option>
								</select>	
                              </div>
                            </div>
							<div class="row-fluid">
                              <div class="col col-lg-3">
                                <label>{!! Lang::get('instructor.major')!!}:</label>
                              </div>
                              <div class="col col-lg-9">
                                <input type="text"  name="major" value="" placeholder="{!! Lang::get('instructor.entermajor')!!}" class="form-element su_major_add_section_textbox chcountfield" maxlength="80">
                                
                              </div>
                            </div>
							<div class="row-fluid">
                              <div class="col col-lg-3">
                                <label>{!! Lang::get('instructor.city')!!}: <span class="text-danger">*</span></label>
                              </div>
                              <div class="col col-lg-9">
                                <input type="text" name="city" value="" placeholder="{!! Lang::get('instructor.entercity')!!}" class="form-element su_city_add_section_textbox chcountfield" maxlength="80">
                                <span id="section_title_counter" class="ch-count">80</span>
                              </div>
                            </div>
							<div class="row-fluid">
                              <div class="col col-lg-3">
                                <label>{!! Lang::get('instructor.country')!!}: <span class="text-danger">*</span></label>
                              </div>
                              <div class="col col-lg-9">
                              <select class="form-control su_country_add_section_textbox" name="country_id">
								<option value="">Select</option>
								@foreach($countries as $country)
								<option value="{{ $country->id }}">
								{{ $country->name }}
								</option>
								@endforeach				
							</select>
                              </div>
                            </div>
							<div class="row-fluid">
                              <div class="col col-lg-3">
                                <label>{!! Lang::get('instructor.startdate')!!}: <span class="text-danger">*</span></label>
                              </div>
                              <div class="col col-lg-9">
                                <input type="date"  name="start_date" value="" placeholder="{!! Lang::get('instructor.startdate')!!}" class="form-element su_start_date_add_section_textbox chcountfield" maxlength="80">                                
                              </div>
                            </div>
							<div class="row-fluid">
                              <div class="col col-lg-3">
                                <label>{!! Lang::get('instructor.enddate')!!}: <span class="text-danger">*</span></label>
                              </div>
                              <div class="col col-lg-9">
                                <input type="date"  name="end_date" value="" placeholder="{!! Lang::get('instructor.enddate')!!}" class="form-element su_end_date_add_section_textbox chcountfield" maxlength="80">                                
                              </div>
                            </div>
							<div class="row-fluid">
                              <div class="col col-lg-3">
                                <label>{!! Lang::get('instructor.uploaddoc')!!}: </label>
                              </div>
                              <div class="col col-lg-9">	
                                <input type="file" id="catagry_doc" value="" placeholder="{!! Lang::get('instructor.uploaddoc')!!}" class="form-element" accept="application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document">                                
                              </div>
                            </div>
							
                          </div>
                          <div class="formrow">
                            <div class="row-fluid">
                              <div class="col col-lg-9">
                                <input type="button" name="su_course_add_section_submit" value="{!! Lang::get('instructor.addeducation')!!}" class="btn btn-warning su_course_add_section_submit">
                                <input type="button" id="btn_section" name="su_course_add_section_cancel" value="{!! Lang::get('instructor.cancel')!!}" class="btn btn-warning su_course_add_section_cancel">
                              </div>
                            </div>
                          </div>
                        </div>

                      </div>
                    </div>
                  </li>


				</ul>
			</div>
			<!--</form>-->
		</div>
		</div>
     </div>
    </form>
  </div>
  </div>
</div>       
      <!-- End Panel Basic -->
</div>
@endsection


@section('javascript')
<script type="text/javascript" src="{{ asset('backend/curriculum/js/plugins/tinymce/jscripts/tiny_mce/tiny_mce.js') }}"></script>
<script type="text/javascript" src="{{ asset('backend/curriculum/js/plugins/fileupload/jquery.ui.widget.js') }}"></script>
<script type="text/javascript" src="{{ asset('backend/curriculum/js/plugins/fileupload/jquery.fileupload.js') }}"></script>
<script type="text/javascript" src="{{ asset('backend/curriculum/js/plugins/fileupload/jquery.fileupload-process.js') }}"></script>
<script type="text/javascript" src="{{ asset('backend/curriculum/js/plugins/fileupload/jquery.fileupload-validate.js') }}"></script>

<script type="text/javascript">
$('.curriculam-block').bind({
    dragenter: function(e) {
        $(this).addClass('highlighted');
        return false;
    },
    dragover: function(e) {
        e.stopPropagation();
        e.preventDefault();
        return false;
    },
    dragleave: function(e) {
        $(this).removeClass('highlighted');
        return false;
    },
    drop: function(e) {
        var dt = e.originalEvent.dataTransfer;
        console.log(dt.files.length);
        return false;
    }
});
// Delete Course Section
function deleteedu(id) {
	if (!confirm("Are you sure to delete?")){
      return false;
    }
  var _token=$('[name="_token"]').val();
  $('.section-'+id).css('opacity', '0.5');
 // alert($('[name="jobdelete"]').val());
  $.ajax ({
    type: "POST",
    url: $('[name="edudelete"]').val(),
    data: "&instructor_id="+$('[name="instructor_id"]').val()+"&eduid="+id+"&_token="+_token,
    success: function (msg)
    {
      
      $('.section-'+id).remove();
      $('.parent-s-'+id).remove();
      var x=1;
      $('.su_course_curriculam_sortable .su_gray_curr').each(function(){  
        $(this).find('.serialno').text(x);
        $(this).find('.sectionpos').val(x);
        x++;
      });
      //updatesorting();
      //$('.su_course_add_section_content .col.col-lg-3 span').text($('.su_course_curriculam li.parentli').length+1);
    }
  });
}

// update course section

function updateedu(id) {
	var error = false;
  $('.section-'+id).css('opacity','0.5');
  var school=$.trim($('.section-'+id+' .su_school_update_section_textbox').val());
  var degree=$.trim($('.section-'+id+' .su_degree_update_section_textbox').val());
  var major=$.trim($('.section-'+id+' .su_major_update_section_textbox').val());
  var city=$.trim($('.section-'+id+' .su_city_update_section_textbox').val());
  var country_id=$.trim($('.section-'+id+' .su_country_update_section_textbox').val());
  var country=$.trim($('.section-'+id+' .su_country_update_section_textbox option:selected').text());
  var startdate=$.trim($('.section-'+id+' .su_startdate_update_section_textbox').val());
  var enddate=$.trim($('.section-'+id+' .su_enddate_update_section_textbox').val());
  
    if(school.length < 3)
    {
      alert('Please provide atleast 3 characters for School');
	  error = true;
      //return false;
    }
	if(degree.length < 3) {
		alert('Please provide atleast 3 characters for Degree');
		error = true;
		//return false;
	}
	if(city.length < 3) {
		alert('Please provide atleast 3 characters for City');
		error = true;
		//return false;
	}
	if(country_id.length < 1) {
		alert('Please select for Country');
		error = true;
		//return false;
	}
	if(startdate.length < 10) {
		alert('Please select for Start Date');
		error = true;
		//return false;
	}
	if(enddate.length < 10) {
		alert('Please select for End Date');
		error = true;
		//return false;
	}
	var strtDt  = new Date(startdate);
	var endDt  = new Date(enddate);
	if(endDt <= strtDt){
		alert('Please check End Date should be less than start date');
		error = true;
	}
    if(!error){
		var edusave=$('[name="edusave"]').val();
		var _token=$('[name="_token"]').val();
		$.ajax ({
		  type: "POST",
		  url: edusave,
		  data: "&instructor_id="+$('[name="instructor_id"]').val()+"&school="+school+"&degree="+degree+"&major="+major+"&city="+city+"&country_id="+country_id+"&start_date="+startdate+"&end_date="+enddate+"&workid="+id+"&_token="+_token,
		  success: function (msg)
		  {
			$('.section-'+id).css('opacity','1');
			$('.section-'+id+' label.sch'+id).text(school);
			$('.section-'+id+' label.deg'+id).text(degree);
			$('.section-'+id+' label.maj'+id).text(major);
			$('.section-'+id+' label.cit'+id).text(city);
			$('.section-'+id+' label.cou'+id).text(country);
			$('.section-'+id+' label.sta'+id).text(startdate);
			$('.section-'+id+' label.end'+id).text(enddate);
			$('.section-'+id+' .su_degree_update_section_textbox').hide();
			$('.section-'+id+' .su_country_update_section_textbox').hide();
			$('#resfiles-'+id).hide();
			$('#resourceblock'+id).show();			
			$('.section-'+id).removeClass('editon');
		  }
		});
	}else{
		//$('.section-'+id).removeClass('editon');
		$('.section-'+id).css('opacity','1');
		return false;
	}
	
}

function tinyClean(value) {
  value = value.replace(/&nbsp;/ig, ' ');
  value = value.replace(/\s\s+/g, ' ');
  if(value == '<p><br></p>' || value == '<p> </p>' || value == '<p></p>') {
    value = '';
  }
  return value;
}

$(document).bind({
    dragenter: function(e) {
        e.stopPropagation();
        e.preventDefault();
        var dt = e.originalEvent.dataTransfer;
        dt.effectAllowed = dt.dropEffect = 'none';
    },
    dragover: function(e) {
        e.stopPropagation();
        e.preventDefault();
        var dt = e.originalEvent.dataTransfer;
        dt.effectAllowed = dt.dropEffect = 'none';
    }
});

    /*
     * Adding new job
     */ 
    $('.su_course_add_section_label').click(function(){
      $(this).hide();
      $('.su_course_add_section_content').show();
	  $('#section_title_counter').text('80');
    });

    $('.su_course_add_section_cancel').click(function(){
      $(this).parents('.su_course_add_section_content').hide();
      $('.su_course_add_section_label').show();
      $('.su_company_add_section_textbox').removeClass('error');
	  $('.su_position_add_section_textbox').removeClass('error');
    });
	/*
  * Update course section text
  */
  $(document).on('click','.edit_option_section',function(){
	    var id=$(this).parent().find('.sectionid').val();
		$('.section-'+id).addClass('editon');
		$('#resfiles-'+id).show();
		$('#resourceblock'+id).hide();
		$('.section-'+id+' .su_degree_update_section_textbox').show();
		$('.section-'+id+' .su_country_update_section_textbox').show();			
  });
	//Add new section for course
	
  //$('.su_course_add_section_submit').click(function(){

$(document).on("click", ".su_course_add_section_submit", function (e) {	  
	  var error = false;
	  //e.preventDefault();
	  $('.su_course_add_section_submit').prop("disabled", true);
    if($.trim($('.su_school_add_section_textbox').val()).length < 3) {
		$('.su_school_add_section_textbox').addClass('error');
        $('.su_course_add_section_submit').prop("disabled", false);
		error = true;
	}else{
		$('.su_school_add_section_textbox').removeClass('error');
	}
	if($.trim($('.su_degree_add_section_textbox').val()).length < 3) {
		$('.su_degree_add_section_textbox').addClass('error');
        $('.su_course_add_section_submit').prop("disabled", false);
		error = true;
	}else{
		$('.su_degree_add_section_textbox').removeClass('error');
	}
	if($.trim($('.su_city_add_section_textbox').val()).length < 3) {
		$('.su_city_add_section_textbox').addClass('error');
        $('.su_course_add_section_submit').prop("disabled", false);
		error = true;
	}else{
		$('.su_city_add_section_textbox').removeClass('error');
	}
	if($.trim($('.su_country_add_section_textbox').val()).length < 1) {
		$('.su_country_add_section_textbox').addClass('error');
        $('.su_course_add_section_submit').prop("disabled", false);
		error = true;
	}else{
		$('.su_country_add_section_textbox').removeClass('error');
	}
	var startdate = $('.su_start_date_add_section_textbox').val();
	var enddate = $('.su_end_date_add_section_textbox').val();
	var file_data = $('#catagry_doc').prop('files')[0];
	 // alert(file_data.type);
	 if($('#catagry_doc').get(0).files.length > 0){
		if ( !(file_data.type.match('pdf.*')) && !(file_data.type.match('msword.*')) && !(file_data.type.match('vnd.openxmlformats-officedocument.*'))) {
				$('.su_course_add_section_submit').prop("disabled", false);
				$('#catagry_doc').addClass('error');
			   alert("{!! Lang::get('instructor.file_not_allowed')!!}");
			   error = true;
		}
	 }	
	//alert(startdate+enddate);
	if(startdate.length < 10) {
		$('.su_start_date_add_section_textbox').addClass('error');
        $('.su_course_add_section_submit').prop("disabled", false);
		error = true;
	}else{
		$('.su_start_date_add_section_textbox').removeClass('error');
	}
	if(enddate.length < 10) {
		$('.su_end_date_add_section_textbox').addClass('error');
        $('.su_course_add_section_submit').prop("disabled", false);
		error = true;
	}else{
		$('.su_end_date_add_section_textbox').removeClass('error');
		$('.su_end_date_add_section_textbox').removeClass('error');
	}
	
	var strtDt  = new Date(startdate);
	var endDt  = new Date(enddate);
	
	if(endDt <= strtDt){
		$('.su_end_date_add_section_textbox').addClass('error');
		$('.su_start_date_add_section_textbox').addClass('error');
		alert('Please check End Date should be less than start date');
		error = true;
	}else{
		if(!error){
			$('.su_end_date_add_section_textbox').removeClass('error');
			$('.su_start_date_add_section_textbox').removeClass('error');
		}
	}
	//$('.su_course_add_section_submit').prop("disabled", false);
    if(!error) {      
	  /*var description = '';
	  var sno=$('.su_course_curriculam li.parentli').length+1;
      var cno=sno+1;
      var school=$('.su_school_add_section_textbox').val();
	  var degree=$('.su_degree_add_section_textbox').val();
	  var major=$('.su_major_add_section_textbox').val();
	  var city=$('.su_city_add_section_textbox').val();
	  var country_id=$('.su_country_add_section_textbox').val();
	  var startdate=$('.su_start_date_add_section_textbox').val();
	  var enddate=$('.su_end_date_add_section_textbox').val();
      var instructor_id=$('[name="instructor_id"]').val();*/
	  var instructor_id=$('[name="instructor_id"]').val()
      var edusave=$('[name="edusave"]').val();
      var _token=$('[name="_token"]').val();	   
	  var formData = new FormData(document.getElementById('EForm'));
	  formData.append('edusave', edusave);
	  formData.append('_token', _token);
	  formData.append('workid',0);
	  formData.append('instructor_id',instructor_id);	  
	  formData.append('file_name', file_data);
	 console.log(document.getElementById('EForm'));
      
      $.ajax ({
        type: "POST",
        url: edusave,
		//enctype: 'multipart/form-data',
		data:formData,
		contentType: false,
		cache: false,
        processData: false,
        //data: "&instructor_id="+instructor_id+"&school="+school+"&degree="+degree+"&major="+major+"&city="+city+"&country_id="+country_id+"&startdate="+startdate+"&enddate="+enddate+"&description="+description+"&id=0"+"&_token="+_token,
        success: function (msg)
        {          
          /*$('.su_course_curriculam_sortable ul.su_unique_add_sort').append('<li class="su_gray_curr parentli section-'+msg+'"><div class="row-fluid sorthandle"><div class="col col-lg-12"><div class="su_course_section_label su_gray_curr_block"><div class="edit_option edit_option_section">{!! Lang::get('curriculum.school')!!}<span class="serialno">'+sno+'</span>: <label class="slqtitle">'+school+'</label><input type="text" maxlength="80" class="chcountfield su_course_update_section_textbox su_school_update_section_textbox"  value="'+school+'" ><span class="ch-count">'+(80-school.length)+'</span></div><div class="edit_option edit_option_section">{!! Lang::get('curriculum.degree')!!}<span class="serialno">'+sno+'</span>: <label class="slqtitle">'+degree+'</label><select class="su_course_update_section_textbox su_degree_update_section_textbox" style="display:none;"><option value=" ">Select</option><option value="Primary" '+ (degree == 'Primary' ? 'Selected' : '') +'>Primary</option><option '+ (degree == 'Secondary' ? 'Selected' : '') +'>Secondary</option><option '+ (degree == 'Bachelor' ? 'Selected' : '') +'>Bachelor</option><option '+ (degree == 'Master' ? 'Selected' : '') +'>Master</option><option '+ (degree == 'Certification' ? 'Selected' : '') +'>Certification</option></select></div><div class="edit_option edit_option_section">{!! Lang::get('curriculum.major')!!}<span class="serialno">'+sno+'</span>: <label class="slqtitle">'+major+'</label><input type="text" maxlength="80"  class="chcountfield su_course_update_section_textbox su_major_update_section_textbox"  value="'+major+'" ></div><div class="edit_option edit_option_section">{!! Lang::get('curriculum.city')!!}<span class="serialno">'+sno+'</span>: <label class="slqtitle">'+city+'</label><input type="text" maxlength="80"  class="chcountfield su_city_update_section_textbox su_course_update_section_textbox"  value="'+city+'" ><span class="ch-count">'+(80-city.length)+'</span></div><div class="edit_option edit_option_section">{!! Lang::get('curriculum.startdate')!!}<span class="serialno">'+sno+'</span>: <label class="slqtitle">'+startdate+'</label><input type="date" class="chcountfield su_startdate_update_section_textbox su_course_update_section_textbox"  value="'+startdate+'" ></div><div class="edit_option edit_option_section">{!! Lang::get('curriculum.enddate')!!}<span class="serialno">'+sno+'</span>: <label class="slqtitle">'+enddate+'</label><input type="date" class="chcountfield su_enddate_update_section_textbox su_course_update_section_textbox"  value="'+enddate+'" ></div><input type="hidden" value="'+msg+'" class="sectionid" name="jobids[]"/><input type="hidden" value="'+sno+'" class="sectionpos" name="sectionposition[]"/><div class="deletesection" onclick="deleteedu('+msg+')"></div><div class="updatesection" onclick="updateedu('+msg+')"></div></div></div></div></li>');
		  //alert(msg);
          $('.su_school_add_section_textbox').val('');
		  $('.su_degree_add_section_textbox').val('');
		  $('.su_major_add_section_textbox').val('');
		  $('.su_city_add_section_textbox').val('');
		  $('.su_country_add_section_textbox').val('');
		  $('.su_start_date_add_section_textbox').val('');
		  $('.su_end_date_add_section_textbox').val('');		  
          $('.su_course_add_section_label').show();
          $('.su_course_add_section_content').hide();
          $('.su_course_add_section_submit').prop("disabled", false);*/
		  window.location.href = "{{ route('instructor.edu.get.edit', $instructor->id) }}"
        }
      });
    } else {
     // $('.su_company_add_section_textbox').addClass('error');
      $('.su_course_add_section_submit').prop("disabled", false);
    }
  });
  //});
    $('.resfiles').fileupload({
    autoUpload: true,
    acceptFileTypes: /(\.|\/)(pdf|doc|docx)$/i,
    maxFileSize: 1024000000, // 1 GB
    progress: function (e, data) {
      //console.log(data);
     //alert(data);
	  $('#allbar'+data.lid).show();
      $('#probar_status_'+data.lid).val(1);
      $("#resresponse"+data.lid).text("");
      var percentage = parseInt(data.loaded / data.total * 100);
      $('#probar'+data.lid).css('width',percentage+'%');
	  //alert(percentage);
      if(percentage == '100') {
        $('#probar'+data.lid).text('{!! Lang::get("instructor.file_process")!!}');
      }
    },
    processfail: function (e, data) {
      $('#probar_status_'+data.lid).val(0);
      file_name = data.files[data.index].name;
      alert("{!! Lang::get('instructor.file_not_allowed')!!}");   
  },
    done: function(e, data){
      var return_data = $.parseJSON( data.result );
      if(return_data.status='true'){
        /*$("#cccontainer"+data.lid).hide();
        $("#resresponse"+data.lid).text("");
        $('#probar'+data.lid).css('width','0%');
        $("#wholevideos"+data.lid).hide();
        $('#videoresponse'+data.lid).show();            
        $("#lecture_add_content"+data.lid).find('.adddescription').hide();
        $("#lecture_add_content"+data.lid).find('.closecontents').show();*/
		$('#probar'+data.lid).css('width','0%');
		 $('#allbar'+data.lid).hide();
        $('#resourceblock'+data.lid).show();
        $('#resourceblock'+data.lid).html('<div id="resources'+data.lid+'_'+return_data.file_id+'"><i class="fa fa-download"></i> <a target="_blank" href="storage/education/'+data.lid+'/'+return_data.file_name+'">'+ return_data.file_title +' ('+return_data.file_size+')</a> <div class="goright resdelete" data-lid="'+data.lid+'" data-rid="'+return_data.file_id+'"><i class="goright fa fa-trash-o"></i></div></div>');
        $('#probar_status_'+data.lid).val(0);
      }else{

      }

    }
  });
 
</script>
@endsection