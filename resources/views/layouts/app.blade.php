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
  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="noreferrer"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/mycustomestyle.css') }}" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">
    
    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script> -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js"></script>
<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>


<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
<script src="@@path/vendor/sweetalert2/dist/sweetalert2.all.min.js"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" crossorigin="anonymous"></script> -->

<link type="text/css" href="@@path/vendor/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">
</head>
<body class="body">
    <div id="app">

<header>
 <!-- Side Bar starts -->
 @if(Auth::user()->role_id == '1')
        <nav>
 <div class="sidebar navbar-collapse">
    <!-- list-group-item list-group-item-action py-2 ripple -->
 <a

           href="{{route('home')}}"
           class="ripple "
           aria-current="true"
           >
          <h2 class="card-text-color" style="height: 130px;">H</h2>
        </a>


        <a
           href="{{route('home')}}"
           class="list-group-item  py-2 ripple {{ request()->routeIs('home') ||request()->routeIs('hub_detail') || request()->routeIs('pods')
           || request()->routeIs('alerts')
           || request()->routeIs('pod_history')
           || request()->routeIs('exportdata')
           || request()->routeIs('hub_serach')
           || request()->routeIs('filter_history')
           || request()->routeIs('sensor_status')
           || request()->routeIs('search_alert')? 'active' : '' }}"

           >
          <img class="imagesize" src="{{asset('images/menu.svg')}}" >
        </a>

        @if(Auth::user()->role_id == '1')
        <a
           href="{{route('show_users')}}"
           class="list-group-item  py-2 ripple {{ request()->routeIs('show_users')||request()->routeIs('edituser') ||request()->routeIs('view_pod')||
           request()->routeIs('show_add_user_form') ||request()->routeIs('view_user_details') || request()->routeIs('add_crops') || request()->routeIs('channel_details') || request()->routeIs('view_crop_images')? 'active' : ''
            }} "

           >
           <img class="imagesize" data-bs-toggle="tooltip" data-bs-placement="right"
           data-bs-title="Users"
           src="{{asset('images/users.svg')}}" >
        </a>
        @endif

        <a
           href="{{route('show_tickets')}}"
           class="list-group-item  py-2 ripple {{ request()->routeIs('show_tickets') || request()->routeIs('add_tickets') ||request()->routeIs('redirect_add_tickets')
           || request()->routeIs('search_ticket')
           || request()->routeIs('view_ticket')
           || request()->routeIs('raise_tickets')? 'active' : '' }}"

           >
          <img class="imagesize" src="{{asset('images/ticket.svg')}}" >
        </a>

        <a
           href="{{route('show_settings')}}"
           class="list-group-item  py-2 ripple {{ request()->routeIs('show_settings')
           ||request()->routeIs('admins')
           ||request()->routeIs('add_admin')
           ||request()->routeIs('locations')
           ||request()->routeIs('location')
           ||request()->routeIs('add-location')
           ||request()->routeIs('resetpassword')
           ||request()->routeIs('questions')
           ||request()->routeIs('add_question')
           ||request()->routeIs('edit_question')
           ||request()->routeIs('add-locations')
           ||request()->routeIs('edit-location')
           ||request()->routeIs('Category_master')
           ||request()->routeIs('Crop_master')
           ||request()->routeIs('search_crop')
           ||request()->routeIs('sensor_master')
           ||request()->routeIs('update_sensor_solution')
           ||request()->routeIs('reports')
           ||request()->routeIs('stocks')
           ||request()->routeIs('crop_details')
           ||request()->routeIs('stock_history')
           ||request()->routeIs('indents')
           ||request()->routeIs('enquiry')
           ||request()->routeIs('convert_enquiry')
           ||request()->routeIs('edit_enquiry')
           ? 'active' : '' }}"

           >
           <img class="imagesize" src="{{asset('images/settings.svg')}}" >
        </a>

        <a
           class="list-group-item  py-2 ripple "
           id="MylogoutbtnModal"
           
           >
           <img class="imagesize" src="{{asset('images/power.svg')}}" >
        </a>

</div>

</nav>
<!-- Side  Bar ends -->
@endif
 @if(Auth::user()->role_id == '3')

 <nav>
     <div class="sidebar navbar-collapse">

        <a
           href="{{route('customer-dashboard')}}"
           class="list-group-item  py-2 ripple {{ request()->routeIs('customer-dashboard')
           ? 'active' : '' }}"

           >
          <img class="imagesize" src="{{asset('images/widge.png')}}" >
        </a>

         <a
           href="{{ route('reset_password') }}"
           class="list-group-item  py-2 ripple "

           >
           <img class="imagesize" src="{{asset('images/reset.png')}}" >
        </a>

         <a
           href="{{ route('logout') }}"
           class="list-group-item  py-2 ripple "
           
           >
           <img class="imagesize" src="{{asset('images/shutdown.jpeg')}}" >
        </a>

     </div>
 </nav>

 @endif



<!-- Top Bar starts -->
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


                         <img class="rounded-circle" src="{{asset('images/person.png')}}" style="width:20px;height: 20px; margin: auto; " >
                            <li class="nav-item dropdown fa-fa-user">

                                <a  style="color: black;" id="navbarDropdown" class="nav-link dropdown-toggle1" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>


                                <!-- <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>

                                </div> -->

                            </li>

                    </ul>
                </div>
  </nav>

<!-- Top Bar ends -->

</header>

  <main class="py-4">
            <div class="main-container">
                @yield('content')
            </div>
  </main>

</body>
</html>

<!-- Modal -->

                <div class="modal" id="modal_logout" >
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header" style="background-color:white;">
                         <img class="imagesize" src="{{asset('images/logo1.png')}}" >
                        <h5 class="modal-title" >Hydrolore</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <p>Are you sure to exit ?</p>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn " data-bs-dismiss="modal">No</button>
                         <a href="{{ route('logout') }}"> <input class="btn btn-primary" type="button"  value="Yes" style="padding-left:20px;padding-right:20px"> </a>
                      </div>
                    </div>
                  </div>
                </div>

<!--  end Modal -->

               

<script>
$(document).ready(function(){
  $('#MylogoutbtnModal').click(function(){
    $('#modal_logout').modal('show')
  });
});
  
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://www.gstatic.com/firebasejs/7.23.0/firebase.js"></script>
    <script>
      
    var firebaseConfig = {
          apiKey:'{{ env('API_KEY') }}' ,
          authDomain: '{{ env('AUTH_DOMAIN') }}',
          projectId: '{{ env('PROJECT_ID') }}',
          storageBucket: '{{ env('STORAGE_BUCKET') }}',
          messagingSenderId: '{{ env('SENDER_ID') }}',
          appId: '{{ env('APP_ID') }}',
          measurementId: '{{ env('MEASUREMENT_ID') }}'
    };

    firebase.initializeApp(firebaseConfig);
    const messaging = firebase.messaging();

    function initFirebaseMessagingRegistration() {
        messaging
            .requestPermission()
            .then(function() {
                return messaging.getToken()
            })
            .then(function(token) {
                console.log(token);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    }
                });

                $.ajax({
                    url: '{{ route("save-token") }}',
                    type: 'POST',
                    data: {
                        token: token
                    },
                    dataType: 'JSON',
                    success: function(response) {
                        alert('Token saved successfully.');
                    },
                    error: function(err) {
                        console.log('User Chat Token Error' + err);
                    },
                });

            }).catch(function(err) {
                console.log('User Chat Token Error' + err);
            });
    }

    messaging.onMessage(function(payload) {
        const noteTitle = payload.notification.title;
        const noteOptions = {
            body: payload.notification.body,
            icon: payload.notification.icon,
        };
        new Notification(noteTitle, noteOptions);
    });
    </script> 