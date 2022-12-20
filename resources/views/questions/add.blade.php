
@extends('layouts.app')
@section('content')
<body >
<div class="container-body ">
       <div class="row justify-content-center">
               

                    <div class="row">
                        <div class="col-md-6">
                            <h2>Add New Question</h2>
                        </div>
                        <div class="col-md-6 text-end">
                            <a class="btn btn-primary " href="{{route('questions')}}">View Question</a>
                        </div>
                    </div>
                    <div class="row">
                    <div class="card">
                        <form method="post" action="{{route('save_question')}}">
                        @csrf

                        <div class="form-body">
                                <label>Question :</label><br>
                                <textarea name="question" id="" cols="70" rows="5"></textarea>
                                @error('question')
                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                                <div>
                                    <button class=" btn-primary rounded-pill " type="submit" name="action" value=" Update">Add</button>
                                    
                                </div>

                        </form>
                        </div>
                </div>
        <div>
</div>
</body>

@endsection
