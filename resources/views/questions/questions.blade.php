
@extends('layouts.app')
@section('content')

<div class="container-body ">
       <div class="row justify-content-center p-10">
                
                <div class="row">
                    <div class="col-md-6">
                         <h2>Questions</h2>
                    </div>
                    <div class="col-md-6 text-end">
                          <a class="btn btn-primary " href="{{route('add_question')}}">Add New Question</a>
                    </div>
                </div>
                <div class="row">

                    <div class="card">                    
                        <table class="table table-responsive">
                                    
                                    <tr>
                                    <th>Sl.No</th>
                                    <th>Questoins</th>
                                    <th>Actin</th>
                                    </tr>
                                    @php
                                       $index = $questions->firstItem()
                                    @endphp
                                    @foreach($questions as $question)
                                    <tr>
                                        <td>{{ $index++ }}</td>
                                        <td>{{ $question->question }}</td>
                                        <td>
                                            <a href="{{ route('edit_question', $question->id)}}">Edit</a>
                                        </td>
                                    </tr>
                                    @endforeach
                            </table>
                    </div>

                </div>
        <div>
</div>


@endsection
