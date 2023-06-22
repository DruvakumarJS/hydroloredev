@extends('layouts.app')

@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>




<div class="container-body">

    <div class="row justify-content-center">



            <h2 class="head-h1">Tickets</h2>
            <label class="date"> {{date('d M ,Y')}} </label>

            <div>

               <a style="float:right;margin-right: 30px; "href="{{route('show_tickets')}}"><i class="fa fa-refresh" aria-hidden="true"></i></a>
             
              <a style="float:right;margin-right: 30px" class="btn btn-primary" href="{{route('add_tickets')}}">Generate Ticket</a>

            
            <form method="get" action="{{route('show_tickets')}}" style="float:right; margin-right: 30px;">
               
                                  <div class="input-group">

                                      <input class="form-control" type="text" placeholder="Search " name="search">
                                      <button class="btn btn-primary"><i class="fa fa-search"></i></button>
                                  </div>
                                  
                </form>

            </div>
           

    </div>

    <div class="card table-responsive">
     <table class="table table-hover" >
        <tr >
          <th>Sl.No</th>
          <th>Ticket ID</th>
          <th>Subject</th>
          <th>Current Value</th>
          <th>HUB ID</th>
          <th>POD ID</th>
          <th>User Name</th>
          <th>Location</th>
          <th>Mobile </th>
          
          <th>Status</th>
          <th>Created On</th>
          <th></th>
          <th></th>

         </tr>

          <tbody id="myTable">



         @foreach ($tickets as $key => $value)
         @php
            $statusvalue=$value->status;
            $t_id=$value->sr_no;

            if($statusvalue=='2'){$data='pending';$colourcode='#e79d29';}
            else if($statusvalue=='1'){$data='open';$colourcode='#FF0000';}
            else if($statusvalue=='0'){$data='closed';$colourcode='#38761d';}
            else {$data='undefined';$colourcode='#4e9a2c';}


            if (strpos($t_id, 'A') === 0) {
                  $bg="#F5F5F5";
                  $tittle = "Customer Issue";
              }
              else {
              $bg="#ffffff";
               $tittle = "System generated Issue";
            }


            $issue=$value->subject;
             if(str_contains($issue , "$"))
             {
                $array=explode('$', $issue);
             }
             else
             {
                 $array=explode(',', $issue);
             }



             $thresold=$value->current_value;

             if(str_contains($thresold , "$"))
             {
               $threshold_array=explode('$', $thresold);
             }
             else
             {
                 $threshold_array=explode(',', $thresold);
             }

             $podid=$value->pod_id;
             if($podid=='0'){$podid="";}


          @endphp

          <tr title="<?php echo $tittle ?>"> 
          <td  style="background-color: <?php echo  $bg ?>" >{{$key + $tickets->firstItem()}}</td> 
          
          <td> <label>{{$value->sr_no}}</label> </td>
          <td>
            
            @foreach($array as $key => $val)
            @if($val!="") {{$val}}<br>@endif 
            @endforeach
          
        </td>
         <td>
           
            @foreach($threshold_array as $key => $val2)
            @if($val2!="")  {{$val2}}<br>@endif @endforeach
          
         </td>
        <td>{{$value->hub_id}}</td>
        <td>{{$podid}}</td>
         <td>{{$value->user->firstname}}</td>
          <td>{{$value->user->location}}</td>
           <td>{{$value->user->mobile}}</td>
           <!--  <td>{{$value->threshold_value}}</td> -->

         <td> <label  style="color:<?php echo $colourcode; ?>" >{{$data}}</label></td>
         
          <td>{{$value->created_at}}</td>

           @if(Auth::user()->role_id == '1')
           
            @if($data=='closed')
            <td>
              
               <label  class="curved-text-disabled">Action</label>
              </td>
            @else
            <td class="openModal" >
            <label id="modal" data-id="{{$value->sr_no}}" class="curved-text">Action</label>
             </td>
            @endif

        
           @endif
           <td>
            <!-- <a  href="{{route('view_ticket',$value->sr_no)}}" style="color:<?php echo $colourcode; ?>">View</a> -->
            <a  href="{{route('view_ticket',$value->sr_no)}}">View</a>
          </td>


        </tr>

      @endforeach

    </tbody>

     </table>

        @if($tickets->count())

          <label>Showing {{ $tickets->firstItem() }} to {{ $tickets->lastItem() }} of {{$tickets->total()}} results</label>

          {!! $tickets->appends($_GET)->links() !!}

          @else


              <tr>
                    <td colspan="10">There are no data.</td>
                </tr>
           @endif


    </div>
</div>

<div class="modal fade" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">

        <h4 class="modal-title">Modify Status</h4>
      </div>

      <form method="post" action="{{route('modify_status')}}">
        @csrf
      <div style="margin:20px">

        <input type="radio" id="html" name="status" value="1" style="height:30px; width:30px; vertical-align: middle;">
           <label class="header-lab" for="open">Open</label><br>

          <input type="radio" id="css" name="status" value="2" style="height:30px; width:30px; vertical-align: middle;">
           <label class="header-lab"  for="pending">Pending</label><br>

           <input type="radio" id="javascript" name="status" value="0"style="height:30px; width:30px; vertical-align: middle;">
            <label class="header-lab"  for="close">Close</label>

        <input type="hidden" name="sr_no" value="sr_no" id="sr_no">
      </div>

      <div style="margin:20px;float:right;">
        <button class="btn  btn-primary rounded-pill " type="submit" name="action" value=" save"> Save Changes </button>
        <button class=" btn rounded-pill " type="submit" name="action" value=" cancel">Cancel </button>
      </div>

      </form>

    </div>
  </div>
</div>


<script type="text/javascript">

  $('.openModal').on('click',function(){
  
    $("#myModal").modal("show");
    $("#sr_no").val($(this).closest('tr').children()[1].textContent);

});
</script>

<script>
$(document).ready(function(){
  $("#search").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>




@endsection
