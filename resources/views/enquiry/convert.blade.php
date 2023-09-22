@extends('layouts.app')

@section('content')

<div class="container-body">
	<div class="container-header">
		<label>Convert Enquiry</label>
		<div id="div2">
			<a href="{{route('enquiry')}}"><button class="btn btn-sm btn-outline-primary">View Enquiry</button></a>
		</div> 
		
	</div>

	<div class="page-container div-margin">
		<form method="post" action="{{route('enquiry_to_user')}}">
      @csrf

      <div class="form-body">

        <div class="row mb-2">

          <div class="col-md-3">
            <label for="firstname" class="label-title">First name *</label>
            <input type="text" id="firstname" name="firstname" class="form-control"  required="required" value="{{ $value->firstname }}"  />
              @error('firstname')
               <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
             @enderror
          </div>

          <div class="col-md-3">
            <label for="lastname" class="label-title">Last name </label>
            <input type="text" id="lastname" name="lastname" class="form-control"   value="{{ $value->lastname }}" />
             @error('lastname')
               <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
             @enderror
          </div>

        </div>


        <div class="row mb-2">

          <div class="col-md-3">
            <label for="mobile" class="label-title">Mobile *</label>
            <input type="text" id="mobile" name="mobile" class="form-control"  required="required" value="{{ $value->mobile }}"  />
             @error('mobile')
               <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
             @enderror
          </div>

          <div class="col-md-3">
            <label for="email" class="label-title">Email ID * </label>
            <input type="text" id="email" name="email" class="form-control"  required="required" value="{{ $value->email }}" />
             @error('email')
               <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
             @enderror
          </div>

        </div>


        <div class="row mb-2">
          <div class="col-md-6">

            <label for="location" class="label-title">Location *</label>
            <input type="text" id="location" name="location" class="form-control"  required="required"  value="{{ $value->location }}"/>
             @error('location')
               <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
             @enderror
             
          </div>
        </div>

        

        <div class="row mb-2">
          <div class="col-md-6">
            <label for="address" class="label-title">Address *</label>
            <input type="text" id="address" name="address" class="form-control"  required="required" value="{{ $value->address }}" />
             @error('address')
               <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
             @enderror

          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-6">
            <label for="hub_id" class="label-title">Hub ID *</label>
            <input type="text" id="hub_id" name="hub_id" class="form-control"  required="required" value="{{ old('hub_id') }}"/>
             @error('hub_id')
               <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
             @enderror

          </div>
        </div>

        <input type="hidden" name="enquiry_id" value="{{$value->id}}">

        <div>

          <div>
             <button class="btn btn-sm btn-outline-success" type="submit">Convert to User </button>
            
          </div>


        </div>


      </div>


    </form>

  </div>	
	</div>
	
</div>

     
@endsection