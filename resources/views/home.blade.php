@extends('layouts.app')

@section('content')
<body>
<div class="container-body">
    <div class="row justify-content-center">
 
        <div>
            <h2 class="head-h1">Dashboard</h2>
            <label class="date"> {{date('d M ,Y')}} </label>


            <form method="get" action="{{route('hub_serach')}}" style="float:right; "> 
                
                <input style="border-radius: 7px;" type="text" placeholder="  search Hub ID" name="search">
            <button class="btn-primary">serach</button>
            @if(Session::has('message'))
            <div id="mydiv" class="alert-box success" style="color:red">
                {{ Session::get('message') }}
            </div>
            @endif
           </form>


            
        </div>


      
         
    <div class="row mt" >

        <div class="col-sm-6 col-md-4 ">
             <div class="card border-white">

                
                <div class="card-body">
                    <img src="{{ asset('images/hub1.png') }}" alt="hub" style="width:20px;height: 20px;">
                    <h2 class="card-text card-text-color" style="float:right;">{{$hub_count}}</h2>

                    </div>
                     <div>
                    <h4 class="card-text-black" style="float:left;">HUB</h4>
                    <a style="float:right;" class="btn btn-primary" href="{{route('hub_detail')}}">Explore</a>
                     </div> 
                   
                         <label class="card-text-label">Total number of hub</label>
                         
                   
                   
                </div>
            <!--</div>-->
        </div>

         <div class="col-sm-6 col-md-4">
            <div class="card border-white" >
                
                    <div class="card-body" >
                        <img src="{{ asset('images/hub1.png') }}" alt="hub" style="width:20px;height: 20px; ">
                        <h2 class="card-text card-text-color" style="float:right;">{{$pods_count}}</h2>

                    </div>
                    <div>
                    <h4 class="card-text-black" style="float:left;">POD</h4>
                    <a style="float:right;" class="btn btn-primary" href="{{route('pods')}}">View</a>
                    </div>
                    <label class="card-text-label">Total number of POD</label>

                </div>
            <!--</div>-->
        </div>

         <div class="col-sm-6 col-md-4">
            <div class="card border-white">
               
                    <div class="card-body">
                        <img src="{{ asset('images/hub1.png') }}" alt="hub" style="width:20px;height: 20px;">
                        <h2 class="card-text card-text-color" style="float:right;">{{$tickets_count}}</h2>

                    </div>
                    <div>
                    <h4 class="card-text-black" style="float:left;">Ticket</h4>
                    <a style="float:right;" class="btn btn-primary" href="{{route('show_tickets')}}">Manage</a>
                    </div>
                    <label class="card-text-label">Total number of tickets</label>
                </div>
            <!--</div>-->
        </div>
        
        <div>
            
        </div>

       
            
        <!--  <div class="col-sm-6 col-md-3">
            <div class="card border-white">
               
                    <div class="card-body">
                        <img src="{{ asset('images/hub1.png') }}" alt="hub" style="width:20px;height: 20px;">
                        <h2 class="card-text card-text-color" style="float:right;">{{$alert_count}}</h2>

                    </div>
                    <div>
                    <h4 class="card-text-black" style="float:left;">Alerts</h4>
                     <a style="float:right;" class="btn btn-primary" href="{{route('alerts')}}">View</a>
                    </div>

                    <label class="card-text-label">Total number of alerts</label>
                </div>
           
        </div>
    -->

       
        <div id="users_chart" style="width: 40%; height: 250px ;margin:20px;  "></div>
        <div id="tickets_chart" style="width: 40%; height: 250px ;margin:20px "></div>
    

  @if(!empty($tickets) && $tickets->count())
                      

    <div>

       <label class="header-lab p-10">Tickets</label>
       <label style="float: right;margin-top: 10px;margin-right: 10px;"></label>
       <div>
           
     <div class="card table-responsive" >
       <table class="table" >
             
         <tr style="background-color:black;color: white;">
          <th>Sl.No</th>
          <th>Ticket ID</th>
          <th>Issue</th>
           <th>Current Value</th>
          <th>Customer Name</th>
          <th>Mobile</th>
         <!--  <th>Threshold Value</th> -->
         
          <th>Status</th>
          <th>Date</th>
          
           <th></th>
         </tr>

        
         @foreach ($tickets as $key => $value) 
          
          @php    
          $statusvalue=$value->status;

            if($statusvalue=='2'){$data='pending';$colourcode='#e6b00e';}
            else if($statusvalue=='1'){$data='open';$colourcode='#e86413';}
            else if($statusvalue=='0'){$data='closed';$colourcode='#0ee6c9';}
            else {$data='undefined';$colourcode='#FF0000';}

            $issue=$value->subject;
             if(str_contains($issue , "$"))
             {
                $array=explode('$', $issue);
             }
             else 
             {
                 $array=explode(',', $issue);
             }
             
            

             $thresold=$value->current_value;
             
             if(str_contains($thresold , "$"))
             {
               $threshold_array=explode('$', $thresold);
             }
             else 
             {
                 $threshold_array=explode(',', $thresold);
             }




          @endphp

          <tr>
          <td>{{$key + $tickets->firstItem()}}</td>
          <td>{{$value->sr_no}}</td>
          <td>
            <table>
            @foreach($array as $key => $val) 
            @if($val!="") <tr><td> {{$val}}</td></tr>@endif @endforeach
          </table>
        </td>
        
         <td>
            <table>
            @foreach($threshold_array as $key => $val2) 
            @if($val2!="") <tr><td> {{$val2}}</td></tr>@endif @endforeach
          </table>
        </td>
          <td>{{$value->user->firstname}}</td>
          <td>{{$value->user->mobile}}</td>
         <!--  <td>{{$value->threshold_value}}</td> -->
          
          <td> <label class="curved-text" style="background-color: {{$colourcode}}">{{$data}}</label></td>
          <td>{{$value->updated_at}}</td>
          <td><a  href="{{route('view_ticket',$value->sr_no)}}">View</a></td>
         
        </tr>
        
        @endforeach

        </table>

         <label>Showing {{ $tickets->firstItem() }} to {{ $tickets->lastItem() }} of  {{$tickets->total()}} results</label>
         
          {!! $tickets->links() !!}


       </div>

       </div>
  </div>

 
@endif





 <!-- @if(!empty($tickets) && $tickets->count())
       

  <div>

       <label class="header-lab">Tickets</label>
       <label style="float: right;margin-top: 10px;margin-right: 10px;">Today</label>
       <div>
           
     <div class="card table-responsive" >
       <table class="table" >
             
         <tr style="background-color:grey;color: white;" >
          <th>Sl.No</th>
          <th>Ticket ID</th>
          <th>Subject</th>
          <th>Customer Name</th>
          <th>Mobile</th>
          <th>Status</th>
          <th>Updated</th>
          <th></th>
         </tr>
   

         @foreach ($tickets as $key => $value) 
           
        @php   
          $statusvalue=$value->status;

            if($statusvalue=='2'){$data='pending';$colourcode='#e6b00e';}
            else if($statusvalue=='1'){$data='open';$colourcode='#e86413';}
            else if($statusvalue=='0'){$data='closed';$colourcode='#0ee6c9';}
            else {$data='undefined';$colourcode='#FF0000';}

            $issue=$value->subject;
            $array=explode('$', $issue);

        @endphp

          <tr>
          <td>{{$key + $tickets->firstItem()}}</td>
          <td>{{$value->sr_no}}</td>
        
           <td>
            <table>
            @foreach($array as $key => $val) 
            @if($val!="") <tr><td>{{$val}}</td></tr>@endif @endforeach
          </table>
        </td>
         <td>{{$value->user->firstname}}</td>
          <td>{{$value->user->mobile}}</td>
          <td> <label class="curved-text" style="background-color: {{$colourcode}}">{{$data}}</label></td>
        
          <td>{{$value->updated_at}}</td>
          <td><a  href="{{route('search_ticket',$value->sr_no)}}">View</a></td>
        </tr>

       @endforeach

        </table>

       
         <label>Showing {{ $tickets->firstItem() }} to {{ $tickets->lastItem() }} of  {{$tickets->total()}} results</label>
         
          {!! $tickets->links() !!}

       
       </div>

       </div>
  </div>


@endif -->

</div>
 

<!--  <div style="padding:30px;">
     
 <form action="{{ route('send.notification') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Message Title</label>
                            <input type="text" class="form-control" name="title">
                        </div>
                        <div class="form-group">
                            <label>Message Body</label>
                            <textarea class="form-control" name="body"></textarea>
                        </div>
                        <button type="submit" class="btn btn-success btn-block">Send Notification</button>
                    </form>

 </div>
 -->

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

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);
 
        function drawChart() {  
                  
 
        var data = google.visualization.arrayToDataTable([
            ['Month Name', 'Register Users Count'],
 
                @php
                foreach($chart as $d) {
                    echo "['".$d->day."', ".$d->count."],";
                }
                @endphp
        ]);
 
        var options = {
          title: 'Registered Users',
          curveType: 'function',
          legend: { position: 'bottom' }
        };
 
          var chart = new google.visualization.LineChart(document.getElementById('users_chart'));
 
          chart.draw(data, options);
        }
    </script>

    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);
 
        function drawChart() {
 
        var data = google.visualization.arrayToDataTable([
            ['Month Name', 'tickets'],
 
                @php
                foreach($ticketschart as $d) {
                    echo "['".$d->day."', ".$d->count."],";
                }
                @endphp
        ]);
 
        var options = { 
          title: 'tickets traffic',
          curveType: 'function',
          legend: { position: 'bottom'}

        };
 
          var chart = new google.visualization.LineChart(document.getElementById('tickets_chart'));
 
          chart.draw(data, options);
        }
    </script>

    <script type="text/javascript">
            setTimeout(function() {
      $("#mydiv").fadeOut().empty();
    }, 3000);
    </script>
      
   </body> 

  


@endsection
