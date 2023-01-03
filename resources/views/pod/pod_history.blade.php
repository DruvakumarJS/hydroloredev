@extends('layouts.app')

@section('content')


<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js"></script>
<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>


<body>


<div class="container-body">

    <div class="row justify-content-center">

        @php

        if($startdate=="")
        {
            $datepicker="";
            
        }
        else
        {
            $datepicker=$startdate."to".$enddate;
        }

        @endphp

                

            <h2 class="head-h1">POD History</h2>
            <label class="date"> {{date('d M ,Y')}} </label>

            <div style="left: right;margin-right: 10px;">
                 <h3 class="card head-h1" style="float: left;margin-right: 10px; background: blue;  color: white;">POD ID : {{$id}}</h3>

                  <button style="float:right; margin-top:20px" class="open-AddBookDialog btn-primary" id="btn_export1" value="export">Export</button>

                 
                 <form method="POST" action="{{route('filter_history')}}" >
                     @csrf

                    <div style="float:right;margin-right: 10px ; margin-top:20px">

                    <a class="fa fa-refresh" href="{{route('pod_history',$id)}}">  </a>

                    <input type="text" name="datetimes" id="datetimes" value="{{$datepicker}}" placeholder="Select Date Range" readonly/>
                    <input type="hidden" name="pod_id" value="{{$id}}">
                    <button class=" btn-primary" type="submit" name="action" value="filter">Filter</button>

                 
                    </div>
                </form>
                 
                     <!-- Modal -->

                <div class="modal" id="modal_export1" >
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header" style="background-color:white;">
                         <img class="imagesize" src="{{asset('images/logo1.png')}}" >
                        <h5 class="modal-title" >Hydrolore</h5>

                        
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <p>The requested data will be Exported to CSV format, would you like to continue ?</p>

                       

                      </div>
                      <div class="modal-footer">

                        <form method="post" action="{{route('exportdata')}}">
                            @csrf
                        <div class="modal-body">
                        
                       
                        <input type="hidden" name="pod_id" value="{{$id}}">
                        <input type="hidden"  name="dateselected" id="dateselected">
            
                        <button type="button" class="btn " data-bs-dismiss="modal">No</button>
                      

                         <button class="btn btn-primary" data-bs-dismiss="modal" type="submit" id="btn_export_data" >Export</button>

                         </div>

                         </form>
                      </div>
                    </div>
                  </div>
                </div>

<!--  end Modal -->


                 
                
            
                 

           
            </div>

           

        
              
    </div>  

   <div>

       
   </div>

    <div class="card table-responsive" >
     <table class="table" >
        <tr >
             <th>Sl.No</th>
             <th nowrap="nowrap">Time</th>
             <th nowrap="nowrap">AB-T1</th>
             <th nowrap="nowrap">AB-H1</th>
             <th nowrap="nowrap">POD-T1</th>
             <th nowrap="nowrap">POD-H1</th>
             <th nowrap="nowrap">TDS-V1</th>
             <th nowrap="nowrap">PH-V1</th>
             <th nowrap="nowrap">NUT-T1</th>
             <th nowrap="nowrap">NP-I1</th>
             <th nowrap="nowrap">SV-I1</th>
             <th nowrap="nowrap">BAT-V1</th>
             <th nowrap="nowrap">FLO-V1</th>
             <th nowrap="nowrap">FLO-V2</th>
             <th nowrap="nowrap">STS-PSU</th>
             <th nowrap="nowrap">STS-NP1</th>
             <th nowrap="nowrap">STS-NP2</th>
             <th nowrap="nowrap">STS-SV1</th>
             <th nowrap="nowrap">STS-SV2</th>
             <th nowrap="nowrap">WL1H</th>
             <th nowrap="nowrap">WL1L</th>
             <th nowrap="nowrap">WL2H</th>
             <th nowrap="nowrap">WL2L</th>
             <th nowrap="nowrap">WL3H</th>
             <th nowrap="nowrap">WL3L</th>
             <th nowrap="nowrap">RL1</th>
             <th nowrap="nowrap">RL2</th>
             <th nowrap="nowrap">RL3</th>
             <th nowrap="nowrap">RL4</th>
             <th nowrap="nowrap">RL5</th>
             <th nowrap="nowrap">PMODE</th>
             <th nowrap="nowrap">API_type</th>
         </tr>

   

         @if(!empty($pods) && $pods->count())
       

         @foreach ($pods as $key => $value) 

         @php
            $statusvalue=$value->status;
         @endphp   
 
                     
          

          <tr>
          <td>{{$key + $pods->firstItem()}}</td>
          <td>{{$value->created_at}}</td>
          <td>{{$value->AB_T1}}</td>   
            <td>{{$value->AB_H1}}</td>   
            <td>{{$value->POD_T1}}</td>   
            <td>{{$value->POD_H1}}</td>   
            <td>{{$value->TDS_V1}}</td>   
            <td>{{$value->PH_V1}}</td>   
            <td>{{$value->NUT_T1}}</td>   
            <td>{{$value->NP_I1}}</td>   
            <td>{{$value->SV_I1}}</td>   
            <td>{{$value->BAT_V1}}</td>   
            <td>{{$value->FLO_V1}}</td>   
            <td>{{$value->FLO_V2}}</td>   
            <td>{{$value->STS_PSU}}</td>   
            <td>{{$value->STS_NP1}}</td>   
            <td>{{$value->STS_NP2}}</td>   
            <td>{{$value->STS_SV1}}</td>   
            <td>{{$value->STS_SV2}}</td>   
            <td>{{$value->WL1H}}</td>   
            <td>{{$value->WL1L}}</td>   
            <td>{{$value->WL2H}}</td>   
            <td>{{$value->WL2L}}</td>   
            <td>{{$value->WL3H}}</td>   
            <td>{{$value->WL3L}}</td>   
            <td>{{$value->RL1}}</td>   
            <td>{{$value->RL2}}</td>   
            <td>{{$value->RL3}}</td>   
            <td>{{$value->RL4}}</td>   
            <td>{{$value->RL5}}</td>   
            <td>{{$value->PMODE}}</td> 
            <td>{{$value->api_type}}</td>   

        
        </tr>

        @endforeach
        

     </table>  
    

          <label>Showing {{ $pods->firstItem() }} to {{ $pods->lastItem() }} of {{$pods->total()}} results</label>
         
          {!! $pods->links() !!}
    

    @else
         
              <tr>
                    <td colspan="10">There are no data.</td>
                </tr>
    @endif      

    </div>  
</div>  


<script>
$(function() {
  $('input[name="datetimes"]').daterangepicker({

     autoUpdateInput: false,

    timePicker: true,
    startDate: moment().startOf('hour'),
    endDate: moment().startOf('hour').add(32, 'hour'),
    locale: {
        
      format: 'YYYY-MM-DD'
    }
  });

  $('input[name="datetimes"]').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('YYYY-MM-DD') + ' to ' + picker.endDate.format('YYYY-MM-DD'));
  });

  $('input[name="datetimes"]').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
  });
});

</script>

<script>
/*$(document).ready(function(){
  $('#btn_export1').click(function(){
    $('#modal_export1').modal('show')
   
  });
});*/

$(document).on("click", ".open-AddBookDialog", function () {

    var myBookId=$('#datetimes').val();
     

     $(".modal-body #dateselected").val(myBookId);
     $('#modal_export1').modal('show')
     
});

</script>

<!-- <script>
    $(function(){
       $('#btn_export_data').click(function() {

        var pod_id = "<?php echo"$id"?>";
        var daterange=$('#datetimes').val();

        window.open(url, '_blank');



            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: '{{route('exportdata')}}',
                type: 'GET',
                data: { 'id': pod_id, 'daterange':daterange },
                success: function(response)
                {
                     
                }
            });
       });
    });    
</script> -->


@endsection