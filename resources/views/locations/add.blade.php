
@extends('layouts.app')
@section('content')
<body >
<div class="container-body ">
       <div class="row justify-content-center">
               

                    <div class="row">
                        <div class="col-md-6">
                            <h2>Add New Location</h2>
                        </div>
                        <div class="col-md-6 text-end">
                            <a class="btn btn-primary " href="{{route('locations')}}">View Locations</a>
                        </div>
                    </div>
                    <div class="row">
                    <div class="card">
                        <form method="post" action="{{route('save-location')}}">
                        @csrf

                        <div class="form-body">
                                <label>Location :</label><br>
                                <input type="text" name="location" id="" />
                                @error('question')
                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                               
                                <div>
                                    <button class=" btn-primary mt-4 " type="submit" name="action" value=" Update">Add</button>
                                    
                                </div>

                        </form>
                        </div>
                </div>
        <div>
</div>
</body>

@endsection
