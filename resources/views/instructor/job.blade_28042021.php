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
    <form method="POST" action="{{ route('instructor.job.save') }}" id="profileForm" enctype="multipart/form-data">
      {{ csrf_field() }}
      <input type="hidden" name="instructor_id" value="{{ $instructor->id }}">
      <input type="hidden" name="old_course_image" value="{{ $instructor->instructor_image }}">
	  <input name="jobsave" type="hidden" value="{{ url('instructor/job/save') }}">
	  <input name="jobdelete" type="hidden" value="{{ url('instructor/job/delete') }}">
      <div class="row">  
		<div class="container">	  
		 <div class="su_course_curriculam">
			<div class="su_course_curriculam_sortable">
                <ul class="clearfix ui-sortable su_unique_add_sort">
                  @php $sectioncount = '1'; @endphp
                  @foreach($jobs as $job)

                  <li class="su_gray_curr parentli section-{!! $job->id !!}">
                    <div class="row-fluid sorthandle">
                      <div class="col col-lg-12">
                        <div class="su_course_section_label su_gray_curr_block">
                          <div class="col col-lg-6 edit_option edit_option_section">{!! Lang::get('instructor.position')!!} <span class="serialno">{!! $sectioncount !!}</span>: <label class="slqtitle pos{!! $job->id !!}">{!! $job->position !!}</label>
                            <input type="text" maxlength="80" class="chcountfield su_position_update_section_textbox su_course_update_section_textbox"  value="{!! $job->position !!}" >
                            <span class="ch-count">{!! 80-strlen($job->position) !!}</span>
                          </div>
						   <div class="col col-lg-6 edit_option edit_option_section">{!! Lang::get('instructor.company')!!} <span class="serialno">{!! $sectioncount !!}</span>: <label class="slqtitle com{!! $job->id !!}">{!! $job->company !!}</label>
                            <input type="text" maxlength="80" class="chcountfield su_company_update_section_textbox su_course_update_section_textbox"  value="{!! $job->company !!}" >
                            <span class="ch-count">{!! 80-strlen($job->company) !!}</span>
                          </div>
						   <div class="col col-lg-6 edit_option edit_option_section">{!! Lang::get('instructor.startdate')!!} <span class="serialno">{!! $sectioncount !!}</span>: <label class="slqtitle sta{!! $job->id !!}">{!! $job->startdate !!}</label>
                            <input type="date" class="chcountfield su_startdate_update_section_textbox su_course_update_section_textbox"  value="{!! $job->startdate !!}" >
                           
                          </div>
						   <div class="col col-lg-6 edit_option edit_option_section">{!! Lang::get('instructor.enddate')!!} <span class="serialno">{!! $sectioncount !!}</span>: <label class="slqtitle end{!! $job->id !!}">{!! $job->enddate !!}</label>
                            <input type="date" class="chcountfield su_enddate_update_section_textbox su_course_update_section_textbox"  value="{!! $job->enddate !!}" >
                           
                          </div>
						   <div class="col col-lg-12 edit_option edit_option_section">{!! Lang::get('instructor.description')!!} <span class="serialno">{!! $sectioncount !!}</span>: <label class="slqtitle des{!! $job->id !!}" style="max-width:75%;text-align:left;">{!! $job->description !!}</label>                            
							<textarea id="su_description_update{!! $job->id !!}" class="chcountfield  su_description_add_section_textbox su_course_update_section_textbox" style="display:none !important;">{!! $job->description !!}</textarea>
                           
                          </div>					
                          <input type="hidden" value="{!! $job->id !!}" class="sectionid" name="jobids[]">            
                          <div class="deletesection" onclick="deletejob({!! $job->id !!})"></div>
                          <div class="updatesection" onclick="updatejob({!! $job->id !!})"></div>
                        </div>
                      </div>
                    </div>
                  </li>
				   @php $sectioncount++; @endphp
				   @endforeach
			<div class="su_course_curriculam_default">
                <ul class="clearfix">					
                  <li class="su_gray_curr">
                    <div class="row-fluid">
                      <div class="col col-lg-12">
                        <div class="su_course_add_section_label su_gray_curr_block">
                          <span> {!! Lang::get('instructor.addjob')!!}</span>
                        </div>

                        <div class="su_course_add_section_content su_course_add_content_form" style="height:auto !important;">
                          <div class="formrow">
                            <div class="row-fluid">
                              <div class="col col-lg-3">
                                <label>{!! Lang::get('instructor.company')!!}: <span class="text-danger">*</span></label>
                              </div>
                              <div class="col col-lg-9">
                                <input type="text"  name="su_company_add_section_textbox" value="" placeholder="{!! Lang::get('instructor.entercompany')!!}" class="form-element su_company_add_section_textbox chcountfield" maxlength="80">
                                <span id="section_title_counter" class="ch-count">80</span>
                              </div>
                            </div>
							<div class="row-fluid">
                              <div class="col col-lg-3">
                                <label>{!! Lang::get('instructor.position')!!}: <span class="text-danger">*</span></label>
                              </div>
                              <div class="col col-lg-9">
                                <input type="text"  name="su_position_add_section_textbox" value="" placeholder="{!! Lang::get('instructor.enterposition')!!}" class="form-element su_position_add_section_textbox chcountfield" maxlength="80">
                                <span id="section_title_counter" class="ch-count">80</span>
                              </div>
                            </div>
							<div class="row-fluid">
                              <div class="col col-lg-3">
                                <label>{!! Lang::get('instructor.startdate')!!}: <span class="text-danger">*</span></label>
                              </div>
                              <div class="col col-lg-9">
                                <input type="date"  name="su_start_date_add_section_textbox" value="" placeholder="{!! Lang::get('instructor.enterstartdate')!!}" class="form-element su_start_date_add_section_textbox chcountfield" maxlength="80">                                
                              </div>
                            </div>
							<div class="row-fluid">
                              <div class="col col-lg-3">
                                <label>{!! Lang::get('instructor.enddate')!!}: <span class="text-danger">*</span></label>
                              </div>
                              <div class="col col-lg-9">
                                <input type="date"  name="su_end_date_add_section_textbox" value="" placeholder="{!! Lang::get('instructor.enterenddate')!!}" class="form-element su_end_date_add_section_textbox chcountfield" maxlength="80">                                
                              </div>
                            </div>
							<div class="row-fluid">
                              <div class="col col-lg-3">
                                <label>{!! Lang::get('instructor.description')!!}: <span class="text-danger">*</span></label>
                              </div>
                              <div class="col col-lg-9">
                                <textarea id="su_description_add" name="su_description_add_section_textbox" class="form-element su_description_add_section_textbox chcountfield"></textarea>
                 
                              </div>
                            </div>
                          </div>
                          <div class="formrow">
                            <div class="row-fluid">
                              <div class="col col-lg-9">
                                <input type="button" name="su_course_add_section_submit" value="{!! Lang::get('instructor.addjob')!!}" class="btn btn-warning su_course_add_section_submit">
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
  //Tinymice initiation
  tinymce.init({  
    mode : "specific_textareas",
    editor_selector : "su_description_add_section_textbox",
    theme : "advanced",
    theme_advanced_buttons1 : "bold,italic,underline",
    theme_advanced_toolbar_location : "top",
    theme_advanced_toolbar_align : "left",
    theme_advanced_statusbar_location : "bottom",
    width : "100%",
    plugins : "paste",
    paste_text_sticky : true,
    setup : function(ed) {
      ed.onInit.add(function(ed) {
        ed.pasteAsPlainText = true;
      });
    }
  });
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
function deletejob(id) {
	if (!confirm("Are you sure to delete?")){
      return false;
    }
  var _token=$('[name="_token"]').val();
  $('.section-'+id).css('opacity', '0.5');
 // alert($('[name="jobdelete"]').val());
  $.ajax ({
    type: "POST",
    url: $('[name="jobdelete"]').val(),
    data: "&instructor_id="+$('[name="instructor_id"]').val()+"&jobid="+id+"&_token="+_token,
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

function updatejob(id) {
	var error = false;
  $('.section-'+id).css('opacity','0.5');
  var company=$.trim($('.section-'+id+' .su_company_update_section_textbox').val());
  var position=$.trim($('.section-'+id+' .su_position_update_section_textbox').val());
  var startdate=$.trim($('.section-'+id+' .su_startdate_update_section_textbox').val());
  var enddate=$.trim($('.section-'+id+' .su_enddate_update_section_textbox').val());
  //alert($.trim(tinyClean(tinyMCE.get('su_description_update'+id).getContent())));
  var description=$.trim(tinyClean(tinyMCE.get('su_description_update'+id).getContent()));
  //if(company != ''){
    if(company.length < 2)
    {
      alert('Please provide atleast 2 characters for Company');
      error=true;
    }
	if(position.length < 3) {
		alert('Please provide atleast 2 characters for Position');
		error=true;
	}
	if(startdate.length < 10) {
		alert('Please select for Start Date');
		error=true;
	}
	if(enddate.length < 10) {
		alert('Please select for End Date');
		error=true;
	}
	var strtDt  = new Date(startdate);
	var endDt  = new Date(enddate);
	if(endDt <= strtDt){
		alert('Please check End Date should be less than start date');
		error = true;
	}
     if(!error){
		var jobsave=$('[name="jobsave"]').val();
		var _token=$('[name="_token"]').val();
		$.ajax ({
		  type: "POST",
		  url: jobsave,
		  data: "&instructor_id="+$('[name="instructor_id"]').val()+"&company="+company+"&position="+position+"&startdate="+startdate+"&enddate="+enddate+"&description="+description+"&jobid="+id+"&_token="+_token,
		  success: function (msg)
		  {
			$('.section-'+id).css('opacity','1');
			$('.section-'+id+' label.com'+id).text(company);
			$('.section-'+id+' label.pos'+id).text(position);
			$('.section-'+id+' label.sta'+id).text(startdate);
			$('.section-'+id+' label.end'+id).text(enddate);
			$('.section-'+id+' label.des'+id).text(description);
			$('.section-'+id+' .mceEditor').hide();	
			$('.section-'+id).removeClass('editon');
		  }
		});
	}else{
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
		//console.log($(this).parent().find('.sectionid').val());
		//alert($(this).parent().find('.sectionid').val());
    $('.section-'+id).addClass('editon');
	$('.section-'+id+' .mceEditor').show();	
  });
	//Add new section for course
	
  $('.su_course_add_section_submit').click(function(){
	  var error = false;
	  $('.su_course_add_section_submit').prop("disabled", true);
	  if($.trim($('.su_company_add_section_textbox').val()).length < 3) {
		$('.su_company_add_section_textbox').addClass('error');
        $('.su_course_add_section_submit').prop("disabled", false);
		error = true;
	}else{
		$('.su_company_add_section_textbox').removeClass('error');
	}
	if($.trim($('.su_position_add_section_textbox').val()).length < 3) {
		$('.su_position_add_section_textbox').addClass('error');
        $('.su_course_add_section_submit').prop("disabled", false);
		error = true;
	}else{
		$('.su_position_add_section_textbox').removeClass('error');
	}
	var startdate = $('.su_start_date_add_section_textbox').val();
	var enddate = $('.su_end_date_add_section_textbox').val();
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
	  var description = '';
	  var sno=$('.su_course_curriculam li.parentli').length+1;
      var cno=sno+1;
      var company=$('.su_company_add_section_textbox').val();
	  var position=$('.su_position_add_section_textbox').val();
	  var startdate=$('.su_start_date_add_section_textbox').val();
	  var enddate=$('.su_end_date_add_section_textbox').val();
	  description= $.trim(tinyClean(tinyMCE.get('su_description_add').getContent()));
	 // description=$('[name="su_description_add_section_textbox"]').val();
      var instructor_id=$('[name="instructor_id"]').val();
      var jobsave=$('[name="jobsave"]').val();
      var _token=$('[name="_token"]').val();
      
      $.ajax ({
        type: "POST",
        url: jobsave,
        data: "&instructor_id="+instructor_id+"&company="+company+"&position="+position+"&startdate="+startdate+"&enddate="+enddate+"&description="+description+"&id=0"+"&_token="+_token,
        success: function (msg)
        {          
          /*$('.su_course_curriculam_sortable ul.su_unique_add_sort').append('<li class="su_gray_curr parentli section-'+msg+'"><div class="row-fluid sorthandle"><div class="col col-lg-12"><div class="su_course_section_label su_gray_curr_block"><div class="edit_option edit_option_section">{!! Lang::get('curriculum.position')!!}<span class="serialno">'+sno+'</span>: <label class="slqtitle">'+position+'</label><input type="text" maxlength="80" id="su_position_update_section_textbox" class="chcountfield su_course_update_section_textbox"  value="'+position+'" ><span class="ch-count">'+(80-position.length)+'</span></div><div class="edit_option edit_option_section">{!! Lang::get('curriculum.company')!!}<span class="serialno">'+sno+'</span>: <label class="slqtitle">'+company+'</label><input type="text" maxlength="80" id="su_company_update_section_textbox" class="chcountfield su_course_update_section_textbox"  value="'+company+'" ><span class="ch-count">'+(80-company.length)+'</span></div><div class="edit_option edit_option_section">{!! Lang::get('curriculum.startdate')!!}<span class="serialno">'+sno+'</span>: <label class="slqtitle">'+startdate+'</label><input type="date"  id="su_startdate_update_section_textbox" class="chcountfield su_course_update_section_textbox"  value="'+startdate+'" ></div><div class="edit_option edit_option_section">{!! Lang::get('curriculum.enddate')!!}<span class="serialno">'+sno+'</span>: <label class="slqtitle">'+enddate+'</label><input type="date"  id="su_enddate_update_section_textbox" class="chcountfield su_course_update_section_textbox"  value="'+enddate+'" ></div><div class="edit_option edit_option_section">{!! Lang::get('curriculum.description')!!}<span class="serialno">'+sno+'</span>: <label class="slqtitle">'+description+'</label><textarea  id="su_enddate_update_section_textbox" class="chcountfield su_course_update_section_textbox su_description_add_section_textbox">'+description+'</textarea></div><input type="hidden" value="'+msg+'" class="sectionid" name="jobids[]"/><input type="hidden" value="'+sno+'" class="sectionpos" name="sectionposition[]"/><div class="deletesection" onclick="deletejob('+msg+')"></div><div class="updatesection" onclick="updatejob('+msg+')"></div></div></div></div></li>');
		  //alert(msg);
          $('.su_company_add_section_textbox').val('');
		  $('.su_position_add_section_textbox').val('');
		  $('.su_start_date_add_section_textbox').val('');
		  $('.su_end_date_add_section_textbox').val('');
		  $('.su_company_add_section_textbox').val('');
          $('.su_course_add_section_label').show();
          $('.su_course_add_section_content').hide();
          $('.su_course_add_section_submit').prop("disabled", false);*/
		   window.location.href = "{{ route('instructor.job.get.edit', $instructor->id) }}";
        }
      });
    } else {
     // $('.su_company_add_section_textbox').addClass('error');
      $('.su_course_add_section_submit').prop("disabled", false);
    }
  });
 
</script>
@endsection