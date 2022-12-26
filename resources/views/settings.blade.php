@extends('layouts.app')
 
@section('content')

<body>
<div class="container-body">
    <div class="row justify-content-center">
 
       
            <h2 class="head-h1">Settings</h2>
            <label class="date"> {{date('d M ,Y')}} </label>

            <div class="row settings-container ">
                <div class="col">
                    <div class="card card-section text-center">
                        <a href="admins">
                                <img src="{{ asset('images/person.png') }}" alt="questions" width="50"/>
                                <h3>Admins</h3>
                        </a> 
                    </div>
                </div>
                <div class="col">
                    <div class="card card-section text-center">
                        <a href="questions">
                                <img src="{{ asset('images/questions.png') }}" alt="questions" width="50"/>
                                <h3>Questions</h3>
                        </a> 
                    </div>
                </div>
                <div class="col">
                        <div class="card card-section text-center">
                            <a href="locations">
                                <img src="{{ asset('images/location.png') }}" alt="questions" width="50"/>
                                <h3>Locations </h3>
                            </a> 
                        </div>

                </div>
                <div class="col">
                    <div class="card card-section">
                        <a href="">
                            <img src="{{ asset('images/person.png') }}" alt="questions" width="50"/>
                            <h3>Reset Password </h3>
                        </a> 
                    </div>

               </div>
                 

                
            </div>

           
              
           
    </div>    
</div>  


@endsection