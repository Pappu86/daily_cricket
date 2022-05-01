<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Daily Cricket | Scores</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="url" content="{{ url('') }}">

    <!-- Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Barlow+Semi+Condensed:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet" />
    <!-- <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet"> -->

    <!-- Styles -->
    <link rel="stylesheet" href="{{asset('css/bootstrap.css')}}" />
    <link rel="stylesheet" href="{{asset('css/app.css')}}" />
</head>

<body>
    <div id="overlayer"></div>
    <span class="loader"></span>
    <div>
        <nav class="navbar-expand-lg navbar navbar-dark bg-primary">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{asset('live-upcoming')}}">Daily Cricket</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" href="{{asset('')}}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="{{asset('live-upcoming')}}">Live & upcoming</a>
                        </li>
                    </ul>
                    <div class="d-flex">
                        <button class="btn btn-outline-success" type="button">
                            Reset token
                        </button>
                    </div>
                </div>
            </div>
        </nav>
        <div id="app">
            @yield('content')
        </div>
    </div>

    <script src="{{asset('js/app.js')}}"></script>
    <script src="{{asset('js/jquery-3.4.1.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.js')}}"></script>
</body>

</html>