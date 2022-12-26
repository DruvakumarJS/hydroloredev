@extends('layouts.customer_app')

@section('content')

<body>

<div class="container-body">
    <div class="row justify-content-center">
            <h2 class="head-h1">Tickets</h2>
            <label class="date"> {{date('d M ,Y')}} </label>
            <div>
                <a style="float:right;margin-right: 30px; " href="{{route('my_tickets')}}"><i class="fa fa-refresh" aria-hidden="true"></i></a>
                <a style="float:right;margin-right: 30px" class="btn btn-primary" href="{{route('raise_ticket')}}">Generate Ticket</a>
                <a style="float:right;margin-right: 30px" class="btn btn-primary" href="{{route('customer-dashboard')}}">Dashboard</a>
            </div>
    </div>

    <div class="card table-responsive" >
     <table class="table">
        <tr>
          <th>Sl.No</th>
          <th>Ticket ID</th>
          <th>Subject</th>
          <th>Current Value</th>
          <th>Hub ID</th>

          <th>User Name</th>
          <th>Location</th>
          <th>Mobile </th>


          <th>Status</th>
          <th>Updated</th>
          <th></th>
          <th></th>

         </tr>



         @foreach ($tickets as $key => $value)
         @php
            $statusvalue=$value->status;
            $t_id=$value->sr_no;

            if($statusvalue=='2'){$data='pending';$colourcode='#e6b00e';}
            else if($statusvalue=='1'){$data='open';$colourcode='#e86413';}
            else if($statusvalue=='0'){$data='closed';$colourcode='#0ee6c9';}
            else {$data='undefined';$colourcode='#FF0000';}


            $issue=$value->subject;
            $array=explode('$', $issue);

          @endphp

          <tr>
          <td>{{$key + $tickets->firstItem()}}</td>
          <td> <label>{{$value->sr_no}}</label> </td>
          <td>
            <table>
            @foreach($array as $key => $val)
            @if($val!="") <tr><td>* {{$val}}</td></tr>@endif @endforeach
          </table>
        </td>
         <td>{{$value->current_value}}</td>
        <td>{{$value->hub_id}}</td>

         <td>{{$value->user->firstname}}</td>
          <td>{{$value->user->location}}</td>
           <td>{{$value->user->mobile}}</td>


          <td> <label >{{$data}}</label></td>
          <td>{{$value->updated_at}}</td>

           @if(Auth::user()->role_id == '1')
           <td class="openModal" ><label id="modal" data-id="{{$value->sr_no}}"  class="curved-text">Action</label></td>
           @endif
          <!--  <td><a  href="{{route('view_ticket',$value->sr_no)}}">View</a></td> -->


        </tr>


      @endforeach


     </table>

        @if($tickets->count())

          <label>Showing {{ $tickets->firstItem() }} to {{ $tickets->lastItem() }} of {{$tickets->total()}} results</label>

          {!! $tickets->links() !!}

          @else


              <tr>
                    <td colspan="10">There are no data.</td>
                </tr>
           @endif


    </div>
</div>

<!-- kgkgkggk -->



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
        <button class=" btn-primary rounded-pill " type="submit" name="action" value=" save"> Save Changes </button>
        <button class=" rounded-pill " type="submit" name="action" value=" cancel">Cancel </button>
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




@endsection
