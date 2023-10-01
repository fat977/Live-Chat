@extends('layouts.app')
@php
    use Carbon\Carbon;
@endphp
@section('content')
<div class="container">
    <div class="row clearfix">
        <div class="col-lg-12">
            <div class="card chat-app">
                <div id="plist" class="people-list">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-search"></i></span>
                        </div>
                        <input type="text" class="form-control" placeholder="Search...">
                    </div>
                    <ul class="list-unstyled chat-list mt-2 mb-0">
                        @foreach ($users as $user)
                        <a href="{{ route('chat',$user->id) }}">
                            <li class="clearfix">
                                <img src="{{ asset('storage/avatars/'.$user->image)}}" alt="avatar">
                                <div class="about">
                                    <div class="name">{{ $user->name }}</div>
                                    <div class="status">
                                        @if(Cache::has('user-is-online-' . $user->id))
                                            <i class="fa fa-circle online"></i> online
                                        @else
                                            {{ Carbon::parse($user->last_seen)->diffForHumans() }}
                                        @endif
                                    </div>
                                </div>
                            </li>
                        </a>
                        @endforeach
                    </ul>
                </div>
                @yield('chat')
            </div>
        </div>
    </div>
</div>
@endsection

