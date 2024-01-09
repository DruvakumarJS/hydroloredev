
@extends('layouts.app')

@section('content')
<head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
</head>


      <div class="container-body ">
       <div class="row justify-content-center">

        <div>



            <div class="row align-items-center">
                <div class="col-9">
                    <h2 class="head-h1">Users</h2>
                    <label class="date"> {{date('d M ,Y')}} </label>
                </div>
                <div class="col">
                    <div class="d-flex align-items-center justify-content-center">
                       <!--  <input class="form-control w-auto mr-2" type="search" name="search" id="search" placeholder="Search Users"> -->

                       <input  class="form-control w-auto mr-2" id="myInput" type="text" placeholder="Search..">

                        <a class="btn btn-primary" href="{{route('show_add_user_form')}}" style="margin-left: 20px">Add User</a>
                    </div>
                </div>
            </div>

        </form>
        </div>
       </div>

       <div class="card table-responsive">

        <table class="table table-hover ">

         <tr>
          <th>Date</th>
          <th>Name</th>
          <th>Email Address</th>
          <th>Phone Number</th>
          <th>Address</th>
          <th>Hub ID</th>
         </tr>
  <tbody class="alldata" id="myTable">

        @foreach ($userData as $key => $value)


        <tr>
          <td>{{date('d-m-Y', strtotime($value->created_at))}}</td>
          <td>{{$value->firstname}} {{$value->lastname}}</td>
          <td>{{$value->email}}</td>
          <td>{{$value->mobile}}</td>
          <td width="250px">{{$value->address}}</td>
          <td>{{$value->hub_id}}</td>
           <td>
             <a href="{{route('raise_tickets',$value->email)}}"><button class="btn btn-light btn-outline-dark btn-sm ">Raise Ticket</button></a>
          </td>
          <td>
             <a href="{{route('view_user_details',$value->id)}}"><button class="btn btn-light btn-outline-primary btn-sm">PODs </button></a>
          </td>
         
          <td>
             <a href="{{route('edituser',$value->id)}}"><button class="btn  btn-outline-success btn-sm">Edit </button></a>
          </td>
          <td >
              <a id="MybtnModal_{{$key}}"><button class="btn  btn-outline-danger btn-sm">Delete </button></a>
            
          </td>
        </tr>

        <!-- Modal -->

                <div class="modal" id="modal_{{$key}}" >
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header" style="background-color:white;">
                         <img class="imagesize" src="{{asset('images/logo1.png')}}" >
                        <h5 class="modal-title" >Hydrolore</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <p>Are you sure to delete the user {{$value->firstname}}?</p>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn " data-bs-dismiss="modal">No</button>
                         <a href="{{route('deleteuser',$value->id)}}"> <input class="btn btn-primary" type="button"  data-bs-dismiss="modal"  value="Yes" style="padding-left:20px;padding-right:20px"> </a>
                      </div>
                    </div>
                  </div>
                </div>

<!--  end Modal -->

<script>
$(document).ready(function(){
  $('#MybtnModal_{{$key}}').click(function(){
    $('#modal_{{$key}}').modal('show')
  });
});  
</script>

      @endforeach
            </tbody>

         <tbody id="Content" class="searchdata"> </tbody>

        </table>

        


    @if($userData->count())

        <label>Showing {{ $userData->firstItem() }} to {{ $userData->lastItem() }} of  {{$userData->total()}} results</label>

      {!! $userData->links() !!}

    @else
              <tr>
                    <td colspan="10">There are no data.</td>
                </tr>

    @endif


       </div>



      </div>
</div>


<script>
$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>



@endsection
