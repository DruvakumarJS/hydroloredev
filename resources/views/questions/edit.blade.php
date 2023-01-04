
@extends('layouts.app')
@section('content')

<div class="container-body ">
       <div class="row">
               
                <div class="row">
                    <div class="col-md-6">
                         <h2>Edit Question</h2>
                    </div>
                    <div class="col-md-6 text-end">
                          <a class="btn btn-primary " href="{{route('questions')}}">View Question</a>
                    </div>
                </div>
                <div class="card">
             
                      
                        <form method="POST" action="{{route('question.update',$question->id)}}">
                        @csrf

                        <div class="form-body">
                                <label>Question :</label><br>
                                <textarea name="question" id="question" cols="70" rows="5">
                                    {{$question->question}}
                                </textarea>
                               
                                @error('question')
                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                @enderror
                                <div>
                                    <button class=" btn-primary rounded-pill " type="submit" name="action" value=" Update">update</button>
                                </div>

                        </form>

                </div>
        <div>
</div>


@endsection
