<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Hydrolore') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/mycustomestyle.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">


    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" crossorigin="anonymous"></script>


</head>
<body class="body">

<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasExampleLabel">Menu</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <ul >
            <li role="presentation"><a role="menuitem" tabindex="-1"
                                       href="{{route('customer-dashboard')}}">Dashboard</a></li>
            <li role="presentation"><a role="menuitem" tabindex="-1" href="{{route('reset_password')}}">Reset
                    Password</a></li>
            <li role="presentation"><a role="menuitem" tabindex="-1"
                                       href="{{route('logout')}}">Logout</a></li>

        </ul>
    </div>
</div>
<div id="app">

    <header class="mobileMenu">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-6">
                    <a href="{{route('customer-dashboard')}}">
                        <img src="{{asset('images/hydrolore.svg')}}"
                             style="width:150px;height: 40px; margin: auto; ">
                    </a>
                </div>
                <div class="col-6 text-end">
                    <a type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
                        <img class="mobMenu" src="{{asset('images/list.svg')}}">
                    </a>
                </div>
            </div>
        </div>
    </header>

    <main class="py-4">
        @yield('content')
    </main>
</div>
</body>
</html>
