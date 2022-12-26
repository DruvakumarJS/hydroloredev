@extends('layouts.app')

@section('content')

<body >

  <div class="container-body">

      <div>
          <a style="float:right;margin-right: 30px" class="btn btn-primary" href="{{route('admins')}}">View Admins</a>
         <h2 class="head-h1">Add Admin</h2>
         <label class="date">{{date('d M ,Y')}} </label>
      </div>

    <form method="post" action="{{route('create_new_admin')}}">
      @csrf

      <div class="form-body">

        <div class="row mb-2">

          <div class="col-md-3">
            <label for="name" class="label-title">Name *</label>
            <input type="text" id="name" name="name" class="form-input"  required="required" value="{{ old('name') }}" />
              @error('name')
               <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
             @enderror
          </div>


        </div>


        <div class="row mb-2">

          <div class="col-md-3">
             <label for="email" class="label-title">Email ID * </label>
            <input type="text" id="email" name="email" class="form-input"  required="required" value="{{ old('email') }}"/>
             @error('email')
               <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
             @enderror
          </div>

          <div class="col-md-3">
            <label for="role" class="label-title">Role * </label>
            <input type="text"  class="form-input" required="required" value="Admin"/>
             @error('role')
               <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
             @enderror
          </div>


        </div>




        <div>

          <div>
             <button class=" btn-primary " type="submit" name="action" value="save">Save </button>

          </div>


        </div>


      </div>


    </form>




  </div>




</body>




@endsection
