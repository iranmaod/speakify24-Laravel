@extends($layout)

<style type="text/css">
    ::-webkit-scrollbar {
        width: 7px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    ::-webkit-scrollbar-thumb {
        background: #a7a7a7;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #929292;
    }

    ul {
        margin: 0;
        padding: 0;
    }

    li {
        list-style: none;
    }
    body{
        background-color: #fdfdfd !important;
    }

    .user-wrapper, .message-wrapper {
        border: 1px solid #dddddd;
        overflow-y: auto;
    }

    .user-wrapper {
        height: 600px;
    }

    .user {
        cursor: pointer;
        padding: 10px 0;
        position: relative;
        border-bottom: 1px solid #eee;
    }

    .user:hover {
        background: #f3f3f3;
    }

    .user:last-child {
        margin-bottom: 0;
    }

    .pending {
        position: absolute;
        left: 13px;
        top: 9px;
        background: #c02e2e;
        margin: 0;
        border-radius: 50%;
        width: 18px;
        height: 18px;
        line-height: 18px;
        padding-left: 5px;
        color: #ffffff;
        font-size: 12px;
    }

    .media-left {
        margin: 0 10px;
    }

    .media-left img {
        width: 64px;
        border-radius: 64px;
    }

    .media-body p {
        margin: 6px 0;
    }

    .message-wrapper {
        padding: 10px;
        height: 536px;
        border:none;
        /*background: #eeeeee;*/
    }

    .messages .message {
        margin-bottom: 15px;
    }

    .messages .message:last-child {
        margin-bottom: 0;
    }

    .received, .sent {
        width: 45%;
        padding: 3px 10px;
        border-radius: 10px;
    }

    .received {
        background: #eeeeee;
    }

    .sent {
        background: #182f75;
        float: right;
        text-align: right;
        color:#fff;
    }

    .message p {
        margin: 5px 0;
    }

    .date {
        color: #eee;    
        font-size: 12px;
    }
    .received .date  {
        color: #777;
    }

    .user.active {
        background: #eeeeee;
    }

    input[type=text] {
        width: 100%;
        padding: 12px 20px;
        margin: 15px 0 0 0;
        display: inline-block;
        border-radius: 4px;
        box-sizing: border-box;
        outline: none;
        border: 1px solid #eee;
    }

    input[type=text]:focus {
        border: 1px solid #aaaaaa;
    }
    .messageBoxMain{
        clear: both;
        background-color: #fff;
        box-shadow: 0 2px 4px rgb(0 0 0 / 8%);
        border-radius: 5px;
    }
    #messages{
        height: 89%;
        position: relative;
    }
    #messages img{
        position: absolute;
        top: 0px;
        bottom: 0px;
        margin: auto;
        left: 0px;
        right: 0px;
        width: 130px;
        opacity: 0.3;
    }
    .col-md-4 > .user-wrapper{
        border:none;
        border-right:1px solid #eee;
    }
    .userchatimg{
        width: 60px;
        height: 60px;
        background-position: center center;
        background-size: cover;
        border-radius: 100px;
        border: 1px solid #182f75;
    }

    .chatsearch input{
        padding-left: 50px;
        background-image: url(frontend/img/loupe.png);
        background-position: 10px center;
        background-repeat: no-repeat;
    }
    .chatsearch{
        padding: 0px 20px 25px 0px;
        border-bottom: 1px solid #eee;
    }
</style>
@section('content')
    <div class="container-fluid p-0 pt-5 home-content">
        <div class="container messageBoxMain p-4">
            <div class="row message_main_wrapper">
                <div class="col-md-4">
                    <div class="user-wrapper">
                        <div class="chatsearch">
                            <input id="messageSearch" type="text" name="" placeholder="Search by name" onkeyup="myFunction()" />
                        </div>
                        <ul class="users" id="usermessages">
                            @foreach($users as $user)
                                <li class="user" id="{{ $user->id }}">
                                    {{--will show unread count notification--}}
                                    @if($user->unread)
                                        <span class="pending">{{ $user->unread }}</span>
                                    @endif

                                    <div class="media">
                                        <div class="media-left userchatimg" style="background-image:url(@if(isset($user->instructor_image)) @if(Storage::exists($user->instructor_image)){{ Storage::url($user->instructor_image) }}@else{{ asset('backend/assets/images/user.png') }}@endif @else{{ asset('backend/assets/images/user.png') }}@endif);">
                                            <!-- <img src="@if(isset($user->instructor_image)) @if(Storage::exists($user->instructor_image)){{ Storage::url($user->instructor_image) }}@else{{ asset('backend/assets/images/user.png') }}@endif @else{{ asset('backend/assets/images/user.png') }}@endif" alt="" class="media-object"> -->
                                        </div>

                                        <div class="media-body">
                                            <p class="name">{{ $user->first_name }} {{ $user->last_name }}</p>
                                            @if(\Auth::user()->hasRole('admin'))<p class="email">{{ $user->email }}</p>@endif
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="col-md-8" >
                    <div id="messages">
                        <img src="frontend/img/chat.png">
                    </div>
                     <div class="input-text">
                    <input type="text" name="message" placeholder="Enter Message..." class="submit">
                </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script type="text/javascript">
        var receiver_id = '';
        var my_id = "{{ Auth::id() }}";
        $(document).ready(function () {
            // ajax setup form csrf token
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('.user').click(function () {
                $('.user').removeClass('active');
                $(this).addClass('active');
                $(this).find('.pending').remove();

                receiver_id = $(this).attr('id');
                $.ajax({
                    type: "get",
                    url: "message/" + receiver_id,
                    data: "",
                    cache: false,
                    success: function (data) {
                        $('#messages').html(data);
                        scrollToBottomFunc();
                    }
                });
            });

            $(document).on('keyup', '.input-text input', function (e) {
                var message = $(this).val();

                if (e.keyCode == 13 && message != '' && receiver_id != '') {
                    $(this).val('');

                    var datastr = "receiver_id=" + receiver_id + "&message=" + message +"&_token={{ csrf_token() }}";
                    $.ajax({
                        type: "post",
                        url: "message",
                        data: datastr,
                        cache: false,
                        success: function (data) {

                        },
                        error: function (jqXHR, status, err) {
                        },
                        complete: function () {
                            scrollToBottomFunc();
                        }
                    })
                }
            });
        });

        // make a function to scroll down auto
        function scrollToBottomFunc() {
            $('.message-wrapper').animate({
                scrollTop: $('.message-wrapper').get(0).scrollHeight
            }, 50);
        }

        setInterval(function() {
            const activeUser = $('.message_main_wrapper .user.active');
            if (activeUser.length > 0) {
                const user_id = $(activeUser[0]).attr('id');
                loadUserMessage(user_id);
            }
        }, 1500);

        function loadUserMessage(user_id) {
            $.ajax({
                type: "get",
                url: "message/" + user_id,
                data: "",
                cache: false,
                success: function (data) {
                    $('#messages').html(data);
                    scrollToBottomFunc();
                }
            });
        }

        function myFunction() {
            var input, filter, ul, li, a, i, txtValue;
            input = document.getElementById("messageSearch");
            filter = input.value.toUpperCase();
            ul = document.getElementById("usermessages");
            li = ul.getElementsByTagName("li");
            for (i = 0; i < li.length; i++) {
                console.log(li[i]);
                a = li[i].getElementsByTagName("p")[0];
                txtValue = a.textContent || a.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    li[i].style.display = "";
                } else {
                    li[i].style.display = "none";
                }
            }
        }
    </script>
@endsection