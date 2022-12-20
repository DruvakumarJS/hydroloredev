@extends('layouts.app')

@section('content')

<body>

<div class="container-body">

    <div class="row justify-content-center">

              

            <h2 class="head-h1">Alerts</h2>
            <label class="date"> {{date('d M ,Y')}} </label>
            
            <div>
               <a style="float:right;margin-right: 30px; "href="{{route('alerts')}}"><i class="fa fa-refresh" aria-hidden="true"></i></a>  
        
            </div>

           
           
    </div>  

    <div class="card table-responsive" >
       <table class="table" >
             
         <tr style="background-color:black;color: white;">
           <th>Sl.No</th>
          <th>Alert ID</th>
          <th>Issue</th>
          <th>Hub ID</th>
          <th>POD ID</th>
          <th>Customer Name</th>
          <th>Mobile</th>
          <th>Threshold Value</th>
          <th>Current Value</th>
          <th>Status</th>
          <th>Date</th>
           <th></th>
         </tr>

         

         @foreach ($alert_data as $key => $value) 
          
           @php     
           $statusvalue=$value->status;
            
          
            if($statusvalue=='2'){$data='pending';$colourcode='#e6b00e';}
            else if($statusvalue=='1'){$data='open';$colourcode='#e86413';}
            else if($statusvalue=='0'){$data='closed';$colourcode='#0ee6c9';}
            else {$data='undefined';$colourcode='#FF0000';}

           @endphp

          <tr>
         <td>{{$key + $alert_data->firstItem()}}</td>
          <td>{{$value->sr_no}}</td>
          <td>{{$value->issue}}</td>
          <td>{{$value->hub_id}}</td>
          <td>{{$value->pod_id}}</td>
          <td>{{$value->user->firstname}}</td>
          <td>{{$value->user->mobile}}</td>
          <td>{{$value->threshold_value}}</td>
          <td>{{$value->current_value}}</td>
          <td> <label >{{$data}}</label></td>
          <td>{{$value->updated_at}}</td>
          <td><label id="modal" data-id="{{$value->sr_no}}"  class="curved-text">Action</label></td>
         
        </tr>

       @endforeach
  



        </table>

       @if($alert_data->count()) 
     
          <label>Showing {{ $alert_data->firstItem() }} to {{ $alert_data->lastItem() }} of {{$alert_data->total()}} results</label>
         
          {!! $alert_data->links() !!}

          @else

         
              <tr>
                    <td colspan="10">There are no data.</td>
                </tr>
           @endif   

       </div> 

       <div class="modal fade" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
      
        <h4 class="modal-title">Modify Status</h4>
      </div>
     
      <form method="post" action="{{route('modify_alert_status')}}">
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
  
  $('table tbody tr  td').on('click',function(){
    $("#myModal").modal("show");
    $("#sr_no").val($(this).closest('tr').children()[1].textContent);
   

    
});
</script> 


@endsection