@extends('layouts.master')
@php use Carbon\Carbon; @endphp
@section('chat')
<div class="chat">
    <div class="chat-header clearfix">
        <div class="row">
            <div class="col-lg-6">
                <a href="javascript:void(0);" data-toggle="modal" data-target="#view_info">
                    @if (empty($user->image))
                        <img src="{{ asset('storage/avatars/default.png') }}"alt="User Image">
                    @else
                        <img src="{{ asset('storage/avatars/'.$user->image) }}" alt="avatar">
                    @endif
                </a>
                <div class="chat-about">
                    <h6 class="m-b-0">{{ $user->name }}</h6>
                    <small>
                        @if(Cache::has('user-is-online-' . $user->id))
                            <i class="fa fa-circle online"></i> online
                        @else
                            {{ Carbon::parse($user->last_seen)->diffForHumans() }}
                        @endif
                        
                    </small>
                </div>
            </div>
            <div class="col-lg-6 hidden-sm text-right">
                <a href="javascript:void(0);" class="btn btn-outline-secondary"><i class="fa fa-camera"></i></a>
                <a href="javascript:void(0);" class="btn btn-outline-primary"><i class="fa fa-image" id="image"></i><input type="file" name="image" id="file" class="d-none"></a>
                <a href="javascript:void(0);" class="btn btn-outline-info"><i class="fa fa-cogs"></i></a>
                <a href="javascript:void(0);" class="btn btn-outline-warning"><i class="fa fa-question"></i></a>
            </div>
        </div>
    </div>
    <div class="chat-history">
        <ul class="m-b-0">
            @foreach ($sentMessages as $message)

            @if ($message->sender === Auth::user()->id)
            <li class="clearfix">
                <div class="message-data text-right">
                    <span class="message-data-time">{{ date('l h:ia',strtotime($message->created_at)) }}</span>
                </div>
                <div class="message other-message float-right">{{ $message->message}}</div>
                @if ($message->message !== 'This message is deleted')
                    <a href="{{ route('delete.message',$message->id) }}"><i class="fa-solid fa-trash-can float-right my-4 mx-2 text-danger"></i></a>
                @endif
            </li>
            @endif
            @if ($message->sender === $user->id)
            <li class="clearfix">
                <div class="message-data">
                    <span class="message-data-time">{{ date('l h:ia',strtotime($message->created_at)) }}</span>
                </div>
                <div class="message my-message">{{ $message->message}}</div>
            </li>
            @endif

            @endforeach


            <div id="chat-area">

            </div>
        </ul>
    </div>
    <div class="chat-message clearfix">
        <div class="input-group mb-0">
            <div class="input-group-prepend">
                <button id="send" class="input-group-text"><i class="fa fa-send"></i></button>
            </div>
            <input type="text" id="message" class="form-control" placeholder="Enter text here...">
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script>
    $("#send").click(function() {
        $.post("/send/{{$user->id}}", {
                message: $("#message").val()
            , }
            , function(data, status) {
                console.log("Data :" + data + "\nStatus: " + status);
                let senderMessage = '' +
                    '<li class="clearfix">' +
                    '<div class="message-data text-right">' +
                    '<span class="message-data-time">about minute ago</span>' +
                    '</div>' +
                    '<div class="message other-message float-right">' + $("#message").val() + '</div>' +
                    '</li>';

                $("#chat-area").append(senderMessage);
            });
    });
    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('f7896cc985accf743135', {
        cluster: 'eu'
    });
    var channel = pusher.subscribe('chat{{auth()->user()->id}}');
    channel.bind('chat-message', function(data) {
        let receiverMessage = '' +
            '<li class="clearfix">' +
            '<div class="message-data">' +
            '<span class="message-data-time">about minute ago</span>' +
            '</div>' +
            '<div class="message my-message">' + JSON.stringify(data['message']) + '</div>' +
            '</li>';

        $("#chat-area").append(receiverMessage);

    });
</script>
@endsection