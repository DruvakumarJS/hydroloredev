@extends('layouts.app')

@section('content')

<div class="container-body">

  @if(session()->has('message'))
  <div class="alert alert-danger">
    {{ session()->get('message') }}
  </div>
  @endif

  <div>


  <div>
    <label class="date">{{date('d M ,Y')}} </label>
  </div>
  <label>Ticket ID : {{$id}}</label>
  
  

 </div> 



 <div class="form-build" style="margin-top: 10px">
  <div class="row"> 
     <div class="col-6">
      
      <div class="form-group row div-margin">
            <label for="text" class="col-3 col-form-label">HUB ID</label>
            <div class="col-7">
             
                <input id="text" name="pcn" type="text" class="form-control"  value="{{$tickets->hub_id}}" readonly="readonly">
                    
            </div>
        </div>
      
      @if(($tickets->pod_id)!=0)
        <div class="form-group row div-margin">
            <label for="text" class="col-3 col-form-label">POD ID</label>
            <div class="col-7">
             
                <input id="text" name="pcn" type="text" class="form-control"  value="{{$tickets->pod_id}}" readonly="readonly">
                    
            </div>
        </div>
        @endif

          <div class="form-group row div-margin">
            <label for="text" class="col-3 col-form-label">Subject</label>
            <div class="col-7">
                 @php
                  $issue=$tickets->subject;
                  $array=explode('$', $issue);

                  @endphp
                  @foreach($array as $key => $val)
                 
                  <input id="text" name="pcn" type="text" class="form-control"  value="{{$val}}" readonly="readonly">
                  @endforeach
                
                    
            </div>
        </div>

        @if(($tickets->current_value)!="")
        <div class="form-group row div-margin">
            <label for="text" class="col-3 col-form-label">Current Value</label>
            <div class="col-7">
             
                <input id="text" name="pcn" type="text" class="form-control"  value="{{$tickets->current_value}}" readonly="readonly">
                    
            </div>
        </div>
        @endif

        <div class="form-group row div-margin">
            <label for="text" class="col-3 col-form-label">Username</label>
            <div class="col-7">
             
                <input id="text" name="pcn" type="text" class="form-control"  value="{{$tickets->user->firstname}}" readonly="readonly">
                    
            </div>
        </div>

        <div class="form-group row div-margin">
            <label for="text" class="col-3 col-form-label">Mobile Number</label>
            <div class="col-7">
             
                <input id="text" name="pcn" type="text" class="form-control"  value="{{$tickets->user->mobile}}" readonly="readonly">
                    
            </div>
        </div>

        <div class="form-group row div-margin">
            <label for="text" class="col-3 col-form-label">Location</label>
            <div class="col-7">
             
                <input id="text" name="pcn" type="text" class="form-control"  value="{{$tickets->user->location}}" readonly="readonly">
                    
            </div>
        </div>

        <form method="post" action="{{route('update_status')}}">
        @csrf

        <div class="form-group row div-margin">
            <label for="text" class="col-3 col-form-label">Status</label>
            <div class="col-7">
             
                <select class="form-control" name="status" required>
                  <option value="" >Select status</option>
                  <option value="1" {{ $tickets->status == "0"  ? 'disabled' : '' }} {{ $tickets->status == "1"  ? 'selected' : '' }} >Open</option>
                  <option value="2" {{ $tickets->status == "0"  ? 'disabled' : '' }} {{ $tickets->status == "2"  ? 'selected' : '' }} >Pending</option>
                  <option value="0" {{ $tickets->status == "0"  ? 'disabled' : '' }} {{ $tickets->status == "0"  ? 'selected' : '' }} >Close</option>
                </select>
                    
            </div>
        </div>
         <input type="hidden" name="id" value="{{$id}}">

       <div class="form-group row div-margin">
            <label for="text" class="col-3 col-form-label"></label>
            <div class="col-7">
             
               <button class="btn btn-sm btn-danger" name="action" value="Update" >Update</button>
               <button class="btn btn-sm btn-light btn-outline-primary" name="action" value="cancel" >Cancel</button>
                    
            </div>
        </div>
       
          
        </form>

     </div>
    
    
   
  </div>


</div>





</div>


@endsection
