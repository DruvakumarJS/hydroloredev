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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">

   
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">




<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" crossorigin="anonymous"></script>
    

</head>
<body class="body">
    <div id="app">

<header>
 <!-- Side Bar starts -->  
 



<!-- Top Bar starts -->
<nav class="navbar navbar-expand-md  navbar-dark " style="margin-left: 10px;">
  <div class="container-fluid">
    <!-- <a class="navbar-brand" href="{{route('home')}}" style="color: blue; font-weight: bolder; margin-left: 20px;" >H</a> -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">

        <a href="{{route('customer-dashboard')}}">
            <img  src="{{asset('images/hydrolore.svg')}}" style="width:100px;height: 40px; margin: auto; " >
            </a>

      </ul>

    </div>
  </div>

  <div class="collapse navbar-collapse" id="navbarSupportedContent" style="margin-right: 40px;">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">


                    </ul>


                    <ul class="navbar-nav ms-auto">

                   

<div class="dropdown">
    <button class="btn btn-default dropdown-toggle" type="button" id="menu1" data-toggle="dropdown">
     <img src="{{asset('images/menu.png')}}" style="width:20px;height: 20px; margin: auto; " >
       <span class=""></span>
    </button>
    <ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
      <li role="presentation"><a role="menuitem" tabindex="-1" href="{{route('customer-dashboard')}}">Dashboard</a></li>
      <li role="presentation"><a role="menuitem" tabindex="-1" href="{{route('reset_password')}}">Reset Password</a></li>
      <li role="presentation"><a role="menuitem" tabindex="-1" href="{{route('logout')}}">Logout</a></li>
      <li role="presentation" class="divider"></li>
      
    </ul>
  </div>    

                            <li class="nav-item dropdown fa-fa-user">

                               

                               <!--  <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>

                                </div>
 -->
                            </li>
                      
                    </ul>
                </div>
  </nav>
 
<!-- Top Bar ends -->  

</header>    



  <main class="py-4">
            <div style="padding-left: 50px;">
                @yield('content')
            </div>

        </main>

</body>
</html>
