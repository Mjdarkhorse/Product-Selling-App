<!doctype html>
<html lang="en">

<head>
    <title>{{config('app.name')}}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="{{asset('https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900')}}" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/admin-style.css')}}">
</head>

<body>

    <div class="wrapper d-flex align-items-stretch">
        @include('layouts.admin-nav-layout')

        <!-- Page Content  -->
        <div id="content" class="p-4 p-md-5 pt-5">
            @yield('content')
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script src="{{asset('assets/js/admin-main.js')}}"></script>
</body>

</html>