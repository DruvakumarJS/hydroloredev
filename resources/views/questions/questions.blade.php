
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
                                        <td >
                                            <!-- <a id="MybtnModal_{{$question->id}}"> <i class='fa fa-trash' style='font-size:24px;color:red;'></i></a> -->
                                        </td>
                                    </tr>

                                    <!-- Modal -->

                                            <div class="modal" id="modal_{{$question->id}}" >
                                              <div class="modal-dialog">
                                                <div class="modal-content">
                                                  <div class="modal-header" style="background-color:white;">
                                                     <img class="imagesize" src="{{asset('images/logo1.png')}}" >
                                                    <h5 class="modal-title" >Hydrolore</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                  </div>
                                                  <div class="modal-body">
                                                    <p>Are you sure to delete below Question ?<br/> {{$question->question}}</p>
                                                  </div>
                                                  <div class="modal-footer">
                                                    <button type="button" class="btn " data-bs-dismiss="modal">No</button>
                                                     <a href="{{route('deleteQuestion',$question->id)}}"> <input class="btn btn-primary" type="button"  data-bs-dismiss="modal"  value="Yes" style="padding-left:20px;padding-right:20px"> </a>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>

                            <!--  end Modal -->

                                            <script>
                                                $(document).ready(function(){
                                                  $('#MybtnModal_{{$question->id}}').click(function(){
                                                    $('#modal_{{$question->id}}').modal('show')
                                                  });
                                                });  
                                            </script>
                                    
                                    @endforeach
                            </table>
                    </div>

                </div>
        <div>
</div>


@endsection
