@extends('layouts.app')

@section('content')

    <div class="container-body">
        <div class="row justify-content-center">
            <div>
                <h2 class="head-h1">Dashboard</h2>
                <label class="date"> {{date('d M ,Y')}} </label>

                <form method="get" action="{{route('hub_serach')}}" style="float:right; ">
                    <div class="input-group">

                        <input class="form-control" type="text" placeholder="Search Hub ID" name="search">
                        <button class="btn btn-primary">Search</button>
                    </div>
                    @if(Session::has('message'))
                        <div id="mydiv" class="alert-box success">
                            {{ Session::get('message') }}
                        </div>
                    @endif
                </form>
            </div>


            <div class="row">
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
                    <div class="card border-white">

                        <div class="card-body">
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
            </div>
            <div class="row">

            <label>Current Month </label> 
               
                    <div class="col-md-6">
                        <div class="card">
                            <canvas id="users_chart"></canvas>
                        </div>
                    </div>
               
                
                
                    <div class="col-md-6">
                        <div class="card">
                            <canvas id="tickets_chart" ></canvas>
                        </div>
                    </div>
               
                  
            </div>

           


                @if(!empty($tickets) && $tickets->count())

                    <div>
                        <label class="header-lab p-10">Tickets</label>
                        <label style="float: right;margin-top: 10px;margin-right: 10px;"></label>
                        <div>
                            <div class="card table-responsive">
                                <table class="table table-hover">
                                    <tr>
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
                                                        @if($val!="")
                                                            <tr>
                                                                <td> {{$val}}</td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                </table>
                                            </td>

                                            <td>
                                                <table>
                                                    @foreach($threshold_array as $key => $val2)
                                                        @if($val2!="")
                                                            <tr>
                                                                <td> {{$val2}}</td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                </table>
                                            </td>
                                            <td>{{$value->user->firstname}}</td>
                                            <td>{{$value->user->mobile}}</td>
                                            <!--  <td>{{$value->threshold_value}}</td> -->

                                            <td><label class="curved-text"
                                                       style="background-color: {{$colourcode}}">{{$data}}</label></td>
                                            <td>{{$value->updated_at}}</td>
                                            <td><a href="{{route('view_ticket',$value->sr_no)}}">View</a></td>

                                        </tr>

                                    @endforeach

                                </table>

                                <label>Showing {{ $tickets->firstItem() }} to {{ $tickets->lastItem() }}
                                    of {{$tickets->total()}} results</label>

                                {!! $tickets->links() !!}


                            </div>

                        </div>
                    </div>

                @endif

        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://www.gstatic.com/firebasejs/7.23.0/firebase.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>

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

        <script type="text/javascript">

           var x_users_Values = <?php echo $users_xValue; ?>;
           var y_users_Values = <?php echo $users_yValue; ?>;
           
            new Chart("users_chart", {
              type: "line",
              data: {
                labels: x_users_Values,
                datasets: [{
                  label: 'Users',
                  fill: false,
                  lineTension: 0,
                  backgroundColor: "rgba(11 , 156 , 49 ,1)",
                  borderColor: "rgba(11 , 156 , 49 ,0.4)",
                  data: y_users_Values
                }]
              },
              options: {
                legend: {display: true},
                scales: {
                  yAxes: [{
                    ticks: {min: 0, max:10} ,
                    scaleLabel: {
                            display: true,
                            labelString: '----- Number of Users -----',
                            fontColor: '#000', }
                        }],
                  xAxes: [{
                    ticks: {min: 0, max:31} ,
                    scaleLabel: {
                            display: true,
                            labelString: '----- Date ----- ',
                             fontColor: '#000', }
                        }],
                }
              }
            });
        </script>
        

        <script>

           var xValues = <?php echo $tickets_xValue; ?>;
           var yValues = <?php echo $tickets_yValue; ?>;
           var tickets_closed_yValue= <?php echo $tickets_closed_yValue; ?>;
           
           
            new Chart("tickets_chart", {
              type: "bar",
              data: {
                labels: xValues,
                datasets: [
                {
                  label: 'Tickets raised',  
                  fill: false,
                  lineTension: 0,
                  backgroundColor: "rgba(0,0,255,1.0)",
                  borderColor: "rgba(0,0,255,0.1)",
                  data: yValues
                },
               
                ]
              },
              options: {
                legend: {display: true},
                scales: {
                  yAxes: [{
                    ticks: {min: 0, max:50} ,
                    scaleLabel: {
                            display: true,
                            labelString: '----- Number of Tickets -----',
                            fontColor: '#000',   }
                        }],
                  xAxes: [{
                    ticks: {min: 0, max:31} ,
                    scaleLabel: {
                            display: true,
                            labelString: '----- Date ----- ',
                            fontColor: '#000', }
                        }],
                }
              }
            });
        </script>


        
       
        <script type="text/javascript">
            setTimeout(function () {
                $("#mydiv").fadeOut().empty();
            }, 3000);
        </script>

   

@endsection
