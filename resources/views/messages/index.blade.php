{{-- <div class="message-wrapper">
    <ul class="messages"> --}}
        @foreach($messages as $message)
            <li class="message clearfix">
                {{--if message from id is equal to auth id then it is sent by logged in user --}}
                <div class="{{ ($message->from == Auth::id()) ? 'sent' : 'received' }}">
                    <p>{{ $message->message }}</p>
                    @php
                        $tm_df = isset($_COOKIE['offset'])?$_COOKIE['offset']:'00';
                    @endphp
                    <p class="date">{{ date('d M y, h:i a', strtotime("+" .$tm_df. " minutes", strtotime($message->created_at))) }}</p>
                </div>
            </li>
        @endforeach
    {{-- </ul>
</div> --}}