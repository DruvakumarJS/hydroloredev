@extends('layouts.customer_app')

@section('content')
    <div class="container-body">
        <div class="row justify-content-center align-items-center">
            <div class="col-12 text-center">
                <h2 class="head-h1">Welcome {{ Auth::user()->name }}</h2>
            </div>
            <div class="row justify-content-center align-items-center">
                @foreach($pods as $key=>$value)
                    <div class="col-sm-6 col-md-4">
                        <div class="cardnew">
                            <div class="card-body">
                                <div class="row">
                                    <lable class="label-title col-4">HUB ID</lable>
                                    <lable class="label-title col">{{$value->hub_id}}</lable>
                                </div>
                                <div class="row">
                                    <lable class="label-title col-4">POD ID</lable>
                                    <lable class="label-title col">{{$value->pod_id}}</lable>

                                </div>
                                <div class="row">
                                    <lable class="label-title col-4">LOCATION</lable>
                                    <lable class="label-title col">{{$value->location}}</lable>

                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <a href="{{route('my_tickets')}}">
                    <div class="floatingbutton" id="mybutton">
                        <img src="{{asset('images/chat.png')}}">
                        <label>Chat Support</label>
                    </div>
                </a>
            </div>
        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://www.gstatic.com/firebasejs/7.23.0/firebase.js"></script>
        <script>
            var firebaseConfig = {
                apiKey: "AIzaSyBQnwQHe97LTq0PyA-6EkEJxfhY8itQxug",
                authDomain: "hydrolore.firebaseapp.com",
                projectId: "hydrolore",
                storageBucket: "hydrolore.appspot.com",
                messagingSenderId: "245060607925",
                appId: "1:245060607925:web:0c42822440b8e83121c3fc",
                measurementId: "G-HHQYLZSJNB"
            };

            firebase.initializeApp(firebaseConfig);
            const messaging = firebase.messaging();

            $(window).ready(function () {
                initFirebaseMessagingRegistration();
            });


            function initFirebaseMessagingRegistration() {


                messaging
                    .requestPermission()
                    .then(function () {
                        return messaging.getToken()
                    })
                    .then(function (token) {
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

                            success: function (response) {
                                //alert('Token saved successfully.');
                            },
                            error: function (err) {
                                console.log('User Chat Token Error' + err);
                            },
                        });

                    }).catch(function (err) {
                    console.log('User Chat Token Error' + err);
                });
            }

            messaging.onMessage(function (payload) {
                const noteTitle = payload.notification.title;
                const noteOptions = {
                    body: payload.notification.body,
                    icon: payload.notification.icon,
                };
                new Notification(noteTitle, noteOptions);
            });
        </script>

@endsection
