<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>chat app - Bootdey.com</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

</head>
<body>
    
    <div class="col-12">
        @if (session()->has('success'))
        <div class="alert alert-success text-center">{{session()->get('success')}}</div>
        @elseif(session()->has('error'))
        <div class="alert alert-danger text-center">{{session()->get('error')}}</div>
        @endif
    </div>
    <div class="row">
        <div class="mx-auto col-10 col-md-8 col-lg-6 my-5">
            <h4>Enter your code</h4>
            <form action="{{ route('auth.check.code') }}" method="post">
                @csrf
                <div class="row mb-3">
                    <div class="col-sm-10">
                        <input type="number" name="code" class="form-control">
                        <button type="submit" class="btn btn-primary my-2">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
</body>
</html>


