@extends('layouts.app')

@section('content')

<?php

foreach ($userdetail as $key => $value) {
   // code...

 ?>

  
  <div class="container-body">

    @if(session()->has('message'))
    <div class="alert alert-danger">
        {{ session()->get('message') }}
    </div>
    @endif

   
      <div>

    
         <h2 class="head-h1">Edit User {{$value->firstname}}</h2>
         <label class="date">{{date('d M ,Y')}} </label>


      </div>

    <form method="post" action="{{route('updateuser',$value->id)}}">
      @csrf

      <div class="form-body">
        
        <div class="row mb-2">
            
          <div class="col-md-3">
            <label for="firstname" class="label-title">First name </label>
            <input type="text" id="firstname" name="firstname" class="form-input"  required="required" value="{{ $value->firstname }}" />
              @error('firstname')
               <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
             @enderror
          </div>

          <div class="col-md-3">
            <label for="lastname" class="label-title">Last name </label>
            <input type="text" id="lastname" name="lastname" class="form-input" value="{{ $value->lastname }}" />
             @error('lastname')
               <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
             @enderror
          </div>  

        </div>


        <div class="row mb-2">
            
          <div class="col-md-3">
            <label for="mobile" class="label-title">Mobile</label>
            <input type="text" id="mobile" name="mobile" class="form-input"  required="required" value="{{ $value->mobile }}"/>
             @error('mobile')
               <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
             @enderror
          </div>

          <div class="col-md-3">
            <label for="email" class="label-title">Email ID </label>
            <input type="text" id="email" name="email" class="form-input"  required="required" value="{{ $value->email }}"/>
             @error('email')
               <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
             @enderror
          </div>  

        </div>


        <div class="row mb-2">  
          <div class="col-md-6">
            <label for="location" class="label-title">Location</label>
            <input type="text" id="location" name="location" class="form-input"  required="required" value="{{ $value->location }}"/>
             @error('location')
               <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
             @enderror
             
          </div>
        </div>

        <div class="row mb-2">  
          <div class="col-md-6">
            <label for="address" class="label-title">Address</label>
            <input type="text" id="address" name="address" class="form-input"  required="required" value="{{$value->address }}"/>
             @error('address')
               <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
             @enderror
             
          </div>
        </div>

        <div class="row mb-3">  
          <div class="col-md-6">
            <label for="hubid" class="label-title">Hub ID</label>
            <input type="text" id="hub_id" name="hub_id" class="form-input"  required="required" value="{{ $value->hub_id }}" disabled  />
             @error('hubid')
               <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
             @enderror
             
          </div>
        </div>

        <input type="hidden" name="hub_id" id="hub_id" value="{{ $value->hub_id }}">

        <div>
          
          <div > 
            <button class=" btn-primary rounded-pill" type="submit" name="action" value=" Update">Update </button> 
             <button class=" rounded-pill " type="submit" name="action" value=" cancel">Cancel </button> 
            
          </div>

        </div>


      </div>
         
      
    </form> 

    <?php
    if(sizeof($pods)>0)
    {
     ?>

    <div style="margin: 20px;">
     <div>
           <label class="header-lab">PODs</label>
        </div> 

       
        <div class="card table-responsive" >
       <table class="table" >
  
         <tr >
          <th>Sl.No</th>
          <th>POD ID </th>
          <th>POD location </th>
          <th>Status</th>
          <th></th>
         </tr>

         <?php
         if(!empty($pods) && $pods->count())
         {
         foreach ($pods as $key => $pod) {
              
         
          ?>

          <tr>
          <td>{{$key+1}}</td>
          <td>{{$pod->pod_id}}</label></td>
          <td>{{$pod->location}}</td>
          <td>{{$pod->status}}</td>
         <td>
            
            <a id="MybtnModal_{{$key}}"> <i class='fa fa-trash' style='font-size:24px;color:red;'></i></a>
          </td>
        </tr>

        <!-- Modal -->

                <div class="modal" id="modal_{{$key}}" >
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header" style="background-color:white;">
                         <img class="imagesize" src="{{asset('images/logo1.png')}}" >
                        <h5 class="modal-title" >Hydrolore</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <p>Are you sure to delete the POD {{$pod->pod_id}} ?</p>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn " data-bs-dismiss="modal">No</button>
                         <a href="{{route('deletepod',$pod->pod_id)}}"> <input class="btn btn-primary" type="button"  value="Yes" style="padding-left:20px;padding-right:20px"> </a>
                      </div>
                    </div>
                  </div>
                </div>

<!--  end Modal -->

 <script>
$(document).ready(function(){
  $('#MybtnModal_{{$key}}').click(function(){
    $('#modal_{{$key}}').modal('show')
  });
});  
</script>


        <?php } }?>


  


        </table>
        </div>

  </div>
  <?php
  } 
   ?>
  </div> 
  


<?php

 } 
 ?>

@endsection