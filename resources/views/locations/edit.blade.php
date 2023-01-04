
@extends('layouts.app')
@section('content')

<div class="container-body ">
       <div class="row">
               
                <div class="row">
                    <div class="col-md-6">
                         <h2>Edit Location</h2>
                    </div>
                    <div class="col-md-6 text-end">
                          <a class="btn btn-primary " href="{{route('locations')}}">View Lccations</a>
                    </div>
                </div>
                <div class="card">
             
                      
                        <form method="POST" action="{{route('location.update',$location->id)}}">
                        @csrf

                        <div class="form-body">
                                <label>Location :</label><br>
                                <input type="text" name="location" id="" value="{{$location->location}}" />
                                @error('question')
                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                                <div>
                                    <button class=" btn-primary mt-4" type="submit" name="action" value=" Update">update</button>
                                </div>

                        </form>

                </div>
        <div>
</div>


@endsection
