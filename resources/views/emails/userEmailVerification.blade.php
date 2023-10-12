<x-mail::message>

<p>Hello {{ $name }}</p>
<p>Your code is : <b>{{ $code }}</b></p>
<p>Your attach is : <b>{{ $message->embed($attachements) }}</b></p>
{{-- Here is an image: --}}
 
{{-- <img src="{{ asset('storage/avatars/default.png') }}"> --}}
{{-- <img src="{{ $message->embed($attachements) }}"> --}}

{{-- <x-mail::button :url="''">
Button Text
</x-mail::button> --}}

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
