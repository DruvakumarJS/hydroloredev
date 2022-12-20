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
</head>
<body class="body">
    <div id="app">


<!--Main Navigation-->
<header>
  <!-- Sidebar -->
  <nav>

 <div class="sidebar navbar-collapse">
 <a
       
           href="{{route('home')}}"
           class="list-group-item list-group-item-action py-2 ripple "
           aria-current="true"
           >
          <h2 class="card-text-color" style="height: 130px;">H</h2>
        </a>

     
        <a
           href="{{route('home')}}"
           class="list-group-item list-group-item-action py-2 ripple {{ request()->routeIs('home') ? 'active' : '' }}"
           aria-current="true"
           >
          <img class="imagesize" src="{{asset('images/widge.png')}}" >
        </a>



        <a
           href="{{route('show_users')}}"
           class="list-group-item list-group-item-action py-2 ripple {{ request()->routeIs('show_users') ? 'active' : '' }}"
           aria-current="true"
           >
           <img class="imagesize" src="{{asset('images/person.png')}}" >
        </a>

        <a
           href="{{route('show_tickets')}}"
           class="list-group-item list-group-item-action py-2 ripple {{ request()->routeIs('show_tickets') ? 'active' : '' }}"
           aria-current="true"
           >
          <img class="imagesize" src="{{asset('images/tickets.png')}}" >
        </a>

        <a
           href="{{route('show_settings')}}"
           class="list-group-item list-group-item-action py-2 ripple {{ request()->routeIs('show_settings') ? 'active' : '' }}"
           aria-current="true"
           >
           <img class="imagesize" src="{{asset('images/setting.png')}}" >
        </a>

        <a
           href="#"
           class="list-group-item list-group-item-action py-2 ripple "
           aria-current="true"
           >
           <img class="imagesize" src="{{asset('images/shutdown.jpeg')}}" >
        </a>
</div>
</div>
</nav>
 <!--  <nav
       id="sidebarMenu"
       class="collapse d-lg-block sidebar collapse bg-white "
       >
    <div class="position-sticky">

      <div class="list-group list-group-flush ">


       <a
       
           href="{{route('home')}}"
           class="list-group-item list-group-item-action py-2 ripple"
           aria-current="true"
           >
          <h2 class="card-text-color" style="height: 130px;">H</h2>
        </a>

     
        <a
           href="{{route('home')}}"
           class="list-group-item list-group-item-action py-2 ripple"
           aria-current="true"
           >
          <img class="imagesize" src="{{asset('images/widge.png')}}" >
        </a>



        <a
           href="{{route('show_users')}}"
           class="list-group-item list-group-item-action py-2 ripple"
           aria-current="true"
           >
           <img class="imagesize" src="{{asset('images/person.png')}}" >
        </a>

        <a
           href="{{route('show_tickets')}}"
           class="list-group-item list-group-item-action py-2 ripple"
           aria-current="true"
           >
          <img class="imagesize" src="{{asset('images/tickets.png')}}" >
        </a>

        <a
           href="{{route('show_settings')}}"
           class="list-group-item list-group-item-action py-2 ripple"
           aria-current="true"
           >
           <img class="imagesize" src="{{asset('images/setting.png')}}" >
        </a>

        <a
           href="#"
           class="list-group-item list-group-item-action py-2 ripple"
           aria-current="true"
           >
           <img class="imagesize" src="{{asset('images/shutdown.jpeg')}}" >
        </a>
        
      </div>
    </div>
  </nav> -->
  <!-- Sidebar -->

  <!-- Navbar -->
  <nav class="navbar navbar-expand-md  navbar-dark " style="margin-left: 50px;">
  <div class="container-fluid">
    <!-- <a class="navbar-brand" href="{{route('home')}}" style="color: blue; font-weight: bolder; margin-left: 20px;" >H</a> -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">

      </ul>


     
    </div>
  </div>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">


                    </ul>

                   
                    <ul class="navbar-nav ms-auto">
                        
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                         <img class="rounded-circle" src="{{asset('images/person.png')}}" style="width:20px;height: 20px; margin: auto; " >
                            <li class="nav-item dropdown">

                                <a style="color: black;" id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
</nav>
  
  <!-- Navbar -->
</header>
<!--Main Navigation-->

<!--Main layout-->
  <main class="py-4">
            <div >
                @yield('content')
            </div>
            
        </main>
<!--Main layout-->
</body>
</html>
