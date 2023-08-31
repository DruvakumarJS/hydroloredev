@extends('layouts.app')
 
@section('content')

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
                    <div class="card card-section text-center ">
                        <a href="resetpassword">
                            <img src="{{ asset('images/person.png') }}" alt="questions" width="50"/>
                            <h3>Reset Password </h3> 
                        </a> 
                    </div>

               </div>
                 

                
            </div>

            <div class="row settings-container ">
                <div class="col-md-3">
                    <div class="card card-section text-center">
                        <a href="{{route('Category_master')}}">
                                
                                <h3>Category Master</h3>
                        </a> 
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card card-section text-center">
                        <a href="{{route('Crop_master')}}">
                               
                                <h3>Crop Master</h3>
                        </a> 
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card card-section text-center">
                        <a href="{{route('sensor_master')}}">
                               
                                <h3>Sensor Notification</h3>
                        </a> 
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card card-section text-center">
                        <a href="{{route('reports')}}">
                               
                                <h3>Report</h3>
                        </a> 
                    </div>
                </div>
                

                
            </div>

           
              
           
    </div>    
</div>  


@endsection