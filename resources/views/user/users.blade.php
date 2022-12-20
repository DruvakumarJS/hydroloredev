
@extends('layouts.app')

@section('content')
<head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
</head>
<body >

      <div class="container-body ">
       <div class="row justify-content-center">

        <div>

    

        <a style="float:right;" class="btn btn-primary" href="{{route('show_add_user_form')}}">Add User</a>

    
          <input class="search button-right mr:10 rounded mr" type="search" name="search" id="search" placeholder="search users">


       
          <h2 class="head-h1">Users</h2>
          <label class="date"> {{date('d M ,Y')}} </label>

        </form> 
        </div>  
       </div>

       <div class="card table-responsive">

        <table class="table ">
             
         <tr>
           <th>Sl.No</th>
          <th>Name</th>
          <th>Email Address</th>
          <th>Phone Number</th>
          <th>Address</th>
          <th>Hub ID</th>
         </tr>
  <tbody class="alldata">
         
        @foreach ($userData as $key => $value) 
          
    
        <tr>
          <td>{{$key + $userData->firstItem()}}</td>
          <td>{{$value->firstname}} {{$value->lastname}}</td>
          <td>{{$value->email}}</td>
          <td>{{$value->mobile}}</td>
          <td>{{$value->address}}</td>
          <td>{{$value->hub_id}}</td>
          <td>
             <a href="{{route('view_user_details',$value->id)}}"> 
              <link rel="stylesheet" type="text/css" href="" >view details</links>
             </a>
          </td>
          <td>
             <a href="{{route('raise_tickets',$value->email)}}"> 
              <link rel="stylesheet" type="text/css"  >raise ticket</links>
             </a>
          </td>
          <td>
             <a href="{{route('edituser',$value->id)}}"  > 
                <i class='fa fa-edit' style='font-size:24px;'></i>
             </a>
          </td>
          <td>
             <a href="{{route('deleteuser',$value->id)}}" onclick="return confirm('Are you sure to delete the user {{$value->firstname}}?')"> <i class='fa fa-trash' style='font-size:24px;color:red;'></i>
             </a> 
          </td>
        </tr>

      @endforeach
            </tbody>

  
         <tbody id="Content" class="searchdata"> </tbody>

        </table>

        <script type="text/javascript">
          
         $('#search').on('keyup',function(){

          $value=$(this).val();
           if($value)
           {
            $('.alldata').hide();
            $('.searchdata').show();
           }
           else
           {
            $('.alldata').show();
            $('.searchdata').hide();
           }

          

          $.ajax({
             type:'get',
             url:'{{URL::to('search')}}',
             data:{'search':$value},

             success:function(data)
             {
             
              console.log(data);
              $('#Content').html(data);
             }
 
          });

         });

        </script>

       
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
</body>
@endsection
