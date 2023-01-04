@extends('layouts.customer_app')

@section('content')

@php

if(isset($email))
{
 $email=$email;
}
else {
 $email='';
}


@endphp

  <div class="container-body">
      <div>
         <h2 class="head-h1">Add Tickets</h2>
         <label class="date">{{date('d M ,Y')}} </label>
      </div>

    <form method="post" action="{{route('save_ticket')}}">
      @csrf

      <div class="form-body">

        <div class="row card">

          <div>

        	<label>User's Email ID :</label>
        	<input class="form-control" type="text" name="email" id="email" placeholder="Enter Email ID " required="required" value="{{$email!=''? $email :old('email') }}">
  	         @error('email')
               <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
             @enderror
              @if(session()->has('message'))
                <div class="alert alert-danger">
                   {{ session()->get('message') }}
                </div>
             @endif

              @if(session()->has('success'))
                <div class="alert alert-success">
                   {{ session()->get('success') }}
                </div>
             @endif
          </div>

       <div class="checkbox">
  		 <label class="header-lab">Select the Issue</label>
        </div>


   @foreach($questions as $key=>$value)
  <div class="checkboxes popcheck">

      <input type="hidden" value="0" name="issue[{{$value->question}}]">
      <input type="checkbox" value="1" name="issue[{{$value->question}}]" @if($value->published) checked @endif>{{$value->question}}

  </div>

  @endforeach

          <div class="mt-4">
             <button class="btn btn-primary rounded-pill " type="submit" name="action" value=" Update">Generate</button>
             <button class="btn rounded-pill " type="submit" name="action" value=" cancel">Cancel </button>
          </div>


        </div>


      </div>


    </form>



  </div>

  <script>
var x = document.getElementById("demo");

function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition);
  } else {
    x.innerHTML = "Geolocation is not supported by this browser.";
  }
}

function showPosition(position) {
                var lat = position.coords.latitude;
                var lng = position.coords.longitude;
 x.innerHTML = lat +"," + lng;


}
</script>





@endsection
