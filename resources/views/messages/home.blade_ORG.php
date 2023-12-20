@if(Auth::user()->hasRole('student'))
    @extends('layouts.frontend.index')
@endif

@section('content')
    <div class="container-fluid">
        <div class="row message_main_wrapper">
            <div class="col-md-4">
                <div class="user-wrapper">
                    <ul class="users">
                        @foreach($users as $user)
                            <li class="user" id="{{ $user->id }}">
                                {{--will show unread count notification--}}
                                @if($user->unread)
                                    <span class="pending">{{ $user->unread }}</span>
                                @endif

                                <div class="media">
                                    <div class="media-left">
                                        <img src="@if(isset($user->instructor_image)) @if(Storage::exists($user->instructor_image)){{ Storage::url($user->instructor_image) }}@else{{ asset('backend/assets/images/user.png') }}@endif @else{{ asset('backend/assets/images/user.png') }}@endif" alt="" class="media-object">
                                    </div>

                                    <div class="media-body">
                                        <p class="name">{{ $user->first_name }} {{ $user->last_name }}</p>
                                        <p class="email">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="col-md-8" id="messages">

            </div>

            <div class="input-text">
                <input type="text" name="message" class="submit">
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
        }, 3000);

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
    </script>
@endsection