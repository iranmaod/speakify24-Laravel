@extends('layouts.backend.index')
@section('content')
<style type="text/css">
label.cabinet{
    display: block;
    cursor: pointer;
}

.cabinet.center-block{
    margin-bottom: -1rem;
}

#upload-demo{
    width: 825px;
    height: 325px;
  padding-bottom:25px;
}

.course-image-container{
    width: 435px;
    height: 246px;
    border: 1px solid #e4eaec;;
    position: relative;
}

.custom-blockquote{
  margin-top: 85px;
}
</style>
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
    

    <form  action="{{ route('admin.course.video.save') }}" id="courseForm" name="frmupload" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
      <input type="hidden" name="course_id" value="{{ $course->id }}">
      <div class="row">
      <?php //echo'<pre>';print_r($video);exit;?>
        <div class="col-md-6">
            <label class="cabinet center-block">
                <figure class="course-image-container">
                    <?php if($video) {
                        $file_name = $video->video_name;
                        $name = explode("?v=", $file_name);
                        // var_dump($name);exit;
                        if(count($name) <= 1) {
                          $name = explode("/", $file_name);
                          $youtubeName = $name[3];
                        } else {
                          $youtubeName = $name[1];
                        }
                    ?>
                      <iframe height="100%" width="100%" src="https://www.youtube.com/embed/{{$youtubeName}} "></iframe>
                    <?php } else { ?>
                    <div class="video-preview">
                        <blockquote class="blockquote custom-blockquote blockquote-success">
                        <p class="mb-0">Promo video not yet uploaded</p>
                        </blockquote>
                      </div>
                    <?php } ?>
                    
                </figure>
            </label>
        </div>
        
        <div class="col-md-6">
            <!-- <span style="font-size: 10px;">
                Supported File Formats: mp4
                <br>Duration: 5-10 Mins
                <br> Max File Size: 300MB
            </span>
            <hr class="my-4"> -->


            <!-- <div class="progress" id="progress_div" style="display:none;">
              <div class="progress-bar progress-bar-success" id="bar" role="progressbar" style="width:0%">
                <span id="percent">0%</span>
              </div>
            </div>

            <div id='output_image'></div> -->

            <div class="row">
                <div class="col-md-6">
                    <div class="input-group input-group-file" data-plugin="inputGroupFile">
                        <input id="course_video" type="url" name="url" class="form-control" placeholder="https://www.youtube.com/watch?v=9xwazD5SyVg">
                        <!-- <span class="input-group-btn">
                          <span class="btn btn-success btn-file">
                            <i class="icon wb-upload" aria-hidden="true"></i>
                            <input type="file" class="file center-block" name="course_video" id="course_video" />
                          </span>
                        </span> -->
                    </div>
                </div>

                <div class="col-md-6">
                    <input type="submit" class="btn btn-primary" value="Upload"/>
                </div>
            </div>

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
function upload_video() 
{
  var bar = $('#bar');
  var percent = $('#percent');
  $('#courseForm').ajaxForm({
    beforeSubmit: function() {
      document.getElementById("progress_div").style.display="block";
      var percentVal = '0%';
      bar.width(percentVal)
      percent.html(percentVal);
    },

    uploadProgress: function(event, position, total, percentComplete) {
      var percentVal = percentComplete + '%';
      bar.width(percentVal)
      percent.html(percentVal);
    },
    
    success: function() {

      var percentVal = '100%';
      bar.width(percentVal);
      percent.html(percentVal);

    },

    complete: function(xhr) {
      if(xhr.responseText)
      {
        $('#progress_div').hide();
        var data = JSON.parse(xhr.responseText);
        var output_video = '<video width="100%" height="100%" controls preload="auto"><source src="'+data.file_link+'" type="video/mp4"></video>';
        $('.video-preview').html(output_video);
      }
    }
  }); 
}

function readFile(input, id) {    
            
    var file_name = input.files[0].name;
    var extension = (input.files[0].name).split('.').pop();
    var allowed_extensions = ["mp4"];
    var fsize = input.files[0].size;
    
    if (input.files && input.files[0]) {

        if ($.inArray(extension, allowed_extensions) == -1) {
            toastr.error("Video format mismatch");
            return false;
        } else if(fsize > 1048576*300) {
            toastr.error("Video size exceeds");
            return false;
        } 
        $('.input-group-file input').attr('value', file_name);
        
    }
}

function readYouTube(youvalue) {
    var youId = youvalue.split("?v=");
    console.log(youId);
    var youtube_id = youId[1];
    if (!youId[1]) {
      youId = youvalue.split("/");
      youtube_id = youId[3];
    }

    console.log(youId);
    $(".course-image-container").html('<iframe height="100%" width="100%" src="https://www.youtube.com/embed/' + youtube_id + '"></iframe>');
}

$(document).ready(function()
{ 
    $('#course_video').on('keyup', function () { 
        // imageId = $(this).data('id'); 
        // tempFilename = $(this).val();
        // readFile(this, $(this).attr('id')); 
        readYouTube($(this).val());
    });
});
</script>
@endsection