@extends('layouts.app')
 
@section('content')

<div class="container-body">
    <div class="row justify-content-center">
 
       
            <h2 class="head-h1">Settings</h2>
            <label class="date"> {{date('d M ,Y')}} </label>

            <div class="row settings-container ">
                <div class="col">
                    
                    <a class="card1" href="{{route('admins')}}">
                        <h3>Admins Master</h3>
                        <div class="go-corner" href="">
                          <div class="go-arrow">
                            →
                          </div>
                        </div>
                    </a>
                </div>
                <div class="col">
                   
                    <a class="card1" href="{{route('questions')}}">
                        <h3>Questions Master</h3>
                        <div class="go-corner" href="">
                          <div class="go-arrow">
                            →
                          </div>
                        </div>
                    </a>
                </div>
                <div class="col">
                        
                        <a class="card1" href="{{route('locations')}}">
                        <h3>Location Master</h3>
                        <div class="go-corner" href="">
                          <div class="go-arrow">
                            →
                          </div>
                        </div>
                    </a>

                </div>
                <div class="col">
                    
                    <a class="card1" href="{{route('resetpassword')}}">
                        <h3>Reset Password </h3>
                        <div class="go-corner" href="">
                          <div class="go-arrow">
                            →
                          </div>
                        </div>
                    </a>

               </div>
                 

                
            </div>

            <div class="row settings-container ">
                <div class="col-md-3">
                    
                    <a class="card1" href="{{route('Category_master')}}">
                        <h3>Category Master</h3>
                        <div class="go-corner" href="">
                          <div class="go-arrow">
                            →
                          </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-3">
                   
                    <a class="card1" href="{{route('Crop_master')}}">
                        <h3>Crop Master</h3>
                        <div class="go-corner" href="">
                          <div class="go-arrow">
                            →
                          </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-3">
                   
                    <a class="card1" href="{{route('sensor_master')}}">
                        <h3>Sensor Notification</h3>
                        <div class="go-corner" href="">
                          <div class="go-arrow">
                            →
                          </div>
                        </div>
                    </a>
                </div>

                <div class="col-md-3">
                    
                    <a class="card1" href="{{route('reports')}}">
                        <h3>Crop Yield Reports</h3>
                        <div class="go-corner" href="">
                          <div class="go-arrow">
                            →
                          </div>
                        </div>
                    </a>
                </div>
                
            </div>

            <div class="row settings-container" >
                <div class="col-md-3">
                   
                    <a class="card1" href="{{route('stocks')}}">
                        <h3>Stocks Management</h3>
                        <div class="go-corner" href="">
                          <div class="go-arrow">
                            →
                          </div>
                        </div>
                    </a>
                    
                </div>

                <div class="col-md-3">
                   
                    <a class="card1" href="{{route('indents')}}">
                        <h3>Indent Management</h3>
                        <div class="go-corner" href="">
                          <div class="go-arrow">
                            →
                          </div>
                        </div>
                    </a>
                    
                </div>
                
            </div>

 

           
              
           
    </div>    
</div>  


@endsection