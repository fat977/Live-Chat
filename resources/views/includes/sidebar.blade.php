<?php
    use Carbon\Carbon;
    use App\Models\User;
    $users = User::getUsers();
?>
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
                @if (empty($user->image))
                    <img src="{{ asset('storage/avatars/default.png') }}" alt="User Image">
                @else
                    <img src="{{ asset('storage/avatars/'.$user->image ) }}" alt="user-image">
                @endif
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