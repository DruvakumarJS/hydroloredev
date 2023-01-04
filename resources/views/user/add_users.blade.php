@extends('layouts.app')

@section('content')

  <div class="container-body">

      <div >

        
          <a style="float:right;margin-right: 30px" class="btn btn-primary" href="{{route('show_users')}}">View Users</a>

      

         <h2 class="head-h1">Add Users</h2>
         <label class="date">{{date('d M ,Y')}} </label>


      </div>

    <form method="post" action="{{route('create_new_users')}}">
      @csrf

      <div class="form-body">

        <div class="row mb-2">

          <div class="col-md-3">
            <label for="firstname" class="label-title">First name *</label>
            <input type="text" id="firstname" name="firstname" class="form-input"  required="required" value="{{ old('firstname') }}" />
              @error('firstname')
               <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
             @enderror
          </div>

          <div class="col-md-3">
            <label for="lastname" class="label-title">Last name </label>
            <input type="text" id="lastname" name="lastname" class="form-input"   value="{{ old('lastname') }}" />
             @error('lastname')
               <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
             @enderror
          </div>

        </div>


        <div class="row mb-2">

          <div class="col-md-3">
            <label for="mobile" class="label-title">Mobile *</label>
            <input type="text" id="mobile" name="mobile" class="form-input"  required="required" value="{{ old('mobile') }}"/>
             @error('mobile')
               <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
             @enderror
          </div>

          <div class="col-md-3">
            <label for="email" class="label-title">Email ID * </label>
            <input type="text" id="email" name="email" class="form-input"  required="required" value="{{ old('email') }}"/>
             @error('email')
               <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
             @enderror
          </div>

        </div>


        <div class="row mb-2">
          <div class="col-md-6">

            <label for="location" class="label-title">Location *</label>
            <input type="text" id="location" name="location" class="form-input"  required="required"  value="{{ old('address') }}" onclick="getLocation()" />
             @error('location')
               <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
             @enderror
            <p id="demo" ></p>
          </div>
        </div>

        

        <div class="row mb-2">
          <div class="col-md-6">
            <label for="address" class="label-title">Address *</label>
            <input type="text" id="address" name="address" class="form-input"  required="required" value="{{ old('address') }}"/>
             @error('address')
               <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
             @enderror

          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-6">
            <label for="hub_id" class="label-title">Hub ID *</label>
            <input type="text" id="hub_id" name="hub_id" class="form-input"  required="required" value="{{ old('hub_id') }}"/>
             @error('hub_id')
               <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
             @enderror

          </div>
        </div>

        <div>

          <div>
             <button class=" btn-primary rounded-pill " type="submit" name="action" value=" Update">Create User </button>
             <button class=" rounded-pill " type="submit" name="action" value=" cancel">Cancel </button>
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

}
</script>
<script src="https://maps.google.com/maps/api/js?key=&libraries=places&callback=initAutocomplete" type="text/javascript"></script>
<script>
$(document).ready(function() {
$("#lat_area").addClass("d-none");
$("#long_area").addClass("d-none");
});
</script>
<script>
google.maps.event.addDomListener(window, 'load', initialize);

function initialize() {
var input = document.getElementById('location');
var autocomplete = new google.maps.places.Autocomplete(input);

autocomplete.addListener('place_changed', function() {
var place = autocomplete.getPlace();
$('#latitude').val(place.geometry['location'].lat());
$('#longitude').val(place.geometry['location'].lng());

// --------- show lat and long ---------------

$("#lat_area").removeClass("d-none");
$("#long_area").removeClass("d-none");
});
}
</script>

@endsection
