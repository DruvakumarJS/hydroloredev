@extends('layouts.customer_app')

@section('content')
<body style="background-color: white;" >
<div class="container-body">
    <div class="row justify-content-center">
 
        <div>
            <h2 class="head-h1">Welcome {{ Auth::user()->name }}</h2>
              
        </div>


 
          
    <div class="row mt" >

          @foreach($pods as $key=>$value)

        <div class="col-sm-6 col-md-4">

           
             <div class="card bg-secondary text-white">

             
               <div class="card-body">
                                    
               
                <div>
                    <lable class="label_while_bold" style="float:left;">HUB ID  </lable>
                    <lable class="label-title" style="float:left;margin-left: 45px">{{$value->hub_id}}</lable>
                   
                </div> 
                <br></br>

                 <div>
                    <lable class="label_while_bold" style="float:left;">POD ID</lable>
                    <lable class="label-title" style="float:left;margin-left: 45px">{{$value->pod_id}}</lable>
                   
                 </div>

                <br></br>
                 <div>
                    <lable class="label_while_bold" style="float:left;">LOCATION</lable>
                    <lable class="label-title" style="float:left;margin-left: 20px">{{$value->location}}</lable>
                   
                 </div>
             </div>   
                                       
        
     </div>
        
    </div>
         @endforeach    

         <a href="{{route('my_tickets')}}"> 
    <div style="width: 150px;padding: 10px; border-radius: 15px 15px; background: green;" class="floatingbutton" id="mybutton">
    <img src="{{asset('images/chat.png')}}">
    <label style="color:white;">Chat Support</label> 
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

    $(window).ready(function() 
        { 
            initFirebaseMessagingRegistration();
        });



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
                        //alert('Token saved successfully.');
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
      
   </body> 

  


@endsection
