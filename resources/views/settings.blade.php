@extends('layouts.app')

@section('content')

<body>
<div class="container-body">
    <div class="row justify-content-center">
 
       
            <h2 class="head-h1">Settings</h2>
            <label class="date"> {{date('d M ,Y')}} </label>

            <div class="row settings-container ">
                <div class="card card-section col-md-4">
                <a href="admins">
                    <img src="{{ asset('images/person.png') }}" alt="questions" width="50"/>
                </a>    
                 <a href="admins">
                     <h3>Admins</h3>
                 </a> 
                </div>

                <div class="card card-section col-md-4">
                <a href="questions">
                    <img src="{{ asset('images/questions.png') }}" alt="questions" width="50"/>
                </a>    
                 <a href="questions">
                     <h3>Questions </h3>
                 </a> 
                </div>

                <div class="card card-section col-md-4">
                <a href="locations">
                    <img src="{{ asset('images/location.png') }}" alt="questions" width="50"/>
                </a>    
                 <a href="locations">
                     <h3>Locations </h3>
                 </a> 
                </div>

               <!--  <div class="card card-section col-md-4">
                <a href="">
                    <img src="{{ asset('images/threshold.png') }}" alt="questions" width="50"/>
                </a>    
                 <a href="">
                     <h3>Threshold </h3>
                 </a> 
                </div>
 -->
                 <div class="card card-section col-md-4">
                <a href="">
                    <img src="{{ asset('images/person.png') }}" alt="questions" width="50"/>
                </a>    
                 <a href="resetpassword">
                     <h3>Reset Password </h3>
                 </a> 
                </div>

                
            </div>

           
              
           
    </div>    
</div>  


@endsection