
@extends('layouts.app')
@section('content')

<div class="container-body ">
       <div class="row justify-content-center p-10">
                
                <div class="row">
                    <div class="col-md-6">
                         <h2>Locations</h2>
                    </div>
                    <div class="col-md-6 text-end">
                          <a class="btn btn-primary " href="{{route('add-location')}}">Add New Location</a>
                    </div>
                </div>
                <div class="row">

                    <div class="card">                    
                        <table class="table table-responsive">
                                    
                                    <tr>
                                    <th>Sl.No</th>
                                    <th>Locations</th>
                                    <th>Actin</th>
                                    </tr>
                                    @php
                                       $index = $locations->firstItem()
                                    @endphp
                                    @foreach($locations as $location)
                                    <tr>
                                        <td>{{ $index++ }}</td>
                                        <td>{{ $location->location }}</td>
                                        <td>
                                            <a href="{{ route('edit-location', $location->id)}}">Edit</a>
                                        </td>
                                         <td >
                                            <!-- <a id="MybtnModal_{{$location->id}}"> <i class='fa fa-trash' style='font-size:24px;color:red;'></i></a> -->
                                        </td>
                                    </tr>

                                    <!-- Modal -->

                                            <div class="modal" id="modal_{{$location->id}}" >
                                              <div class="modal-dialog">
                                                <div class="modal-content">
                                                  <div class="modal-header" style="background-color:white;">
                                                     <img class="imagesize" src="{{asset('images/logo1.png')}}" >
                                                    <h5 class="modal-title" >Hydrolore</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                  </div>
                                                  <div class="modal-body">
                                                    <p>Are you sure to delete below Question ?<br/> {{$location->location}}</p>
                                                  </div>
                                                  <div class="modal-footer">
                                                    <button type="button" class="btn " data-bs-dismiss="modal">No</button>
                                                     <a href="{{route('deletelocation',$location->id)}}"> <input class="btn btn-primary" type="button"  data-bs-dismiss="modal"  value="Yes" style="padding-left:20px;padding-right:20px"> </a>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>

                            <!--  end Modal -->

                                            <script>
                                                $(document).ready(function(){
                                                  $('#MybtnModal_{{$location->id}}').click(function(){
                                                    $('#modal_{{$location->id}}').modal('show')
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
