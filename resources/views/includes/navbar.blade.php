<nav class="navbar navbar-expand-lg navbar-light bg-light">


    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="{{ route('dashboard') }}">Home <span class="sr-only">(current)</span></a>
            </li>
        </ul>
        <div>
            @if (empty(Auth::user()->image))
                <div><img src="{{ asset('storage/avatars/default.png') }}" alt="User Image" style="width: 7%; border-radius:50%; float:right; margin-right:20px"></div>
            @else
                <div><img src="{{ asset('storage/avatars/'.Auth::user()->image ) }}" alt="user-image" style="width: 3%; border-radius:50%; float:right; margin-right:20px"></div>
            @endif
            <div class="dropdown mr-3" style="float: right">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ Auth::user()->name }}
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-dropdown-link>
                    </form>
                    </a>
                </div>
            </div>
        </div>


    </div>
</nav>
