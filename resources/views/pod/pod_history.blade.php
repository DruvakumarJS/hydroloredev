@extends('layouts.app')

@section('content')


<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js"></script>
<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>
 <style>
    table th {
      background-color:gray;
      color:#000;
    }
    table td {
      text-align:center;
      color:#000;
    }
    table{
        background: white;
    }
    .tHead{
        position: -webkit-sticky; 
        position: sticky; 
        top: 0;
    }
    .tHead th{
        background-color:white;
    }
    tr:hover {background-color: grey;}

</style>


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

                  <!--    <input  type="search" name="search" id="search" placeholder="search"> -->

                   <select id="api_type" name="api_type" id="api_type" >
                      <option value="none">Select Data Type </option>
                      <option value="normal">Normal Data</option>
                      <option value="instant">Instant Data</option>
                  </select>


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
                        <input type="hidden"  name="api_type" id="api_type">
            
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


<div class="card">
   
<table class="table">
<tr class="tHead">
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

<tbody id="myTable">


 @if(!empty($pods) && $pods->count())
       

         @foreach ($pods as $key => $value) 

         @php
            $statusvalue=$value->status;
            $time=date('Y-m-d h:i:s A', strtotime($value->created_at))
         @endphp   
 
        <tr>
          <td nowrap="nowrap">{{$key + $pods->firstItem()}}</td>
          <td nowrap="nowrap">{{$time}}</td>
          <td nowrap="nowrap">{{$value->AB_T1}} <span> &#176;C</span> </td>   
            <td nowrap="nowrap">{{$value->AB_H1}}<span> %RH</span> </td>   
            <td nowrap="nowrap">{{$value->POD_T1}}<span> &#176;C</span> </td>   
            <td nowrap="nowrap">{{$value->POD_H1}}<span> %RH</span> </td>   
            <td nowrap="nowrap">{{$value->TDS_V1}}<span> mg/L</span> </td>   
            <td nowrap="nowrap">{{$value->PH_V1}} </td>   
            <td nowrap="nowrap">{{$value->NUT_T1}}<span> &#176;C</span> </td>   
            <td nowrap="nowrap">{{$value->NP_I1}}<span> mA</span> </td>   
            <td nowrap="nowrap">{{$value->SV_I1}}<span> mA</span> </td>   
            <td nowrap="nowrap">{{$value->BAT_V1}} <span> %</span></td>   
            <td nowrap="nowrap">{{$value->FLO_V1}}</td>   
            <td nowrap="nowrap">{{$value->FLO_V2}} </td>   
            <td nowrap="nowrap">{{$value->STS_PSU}}</td>   
            <td nowrap="nowrap">{{$value->STS_NP1}}</td>   
            <td nowrap="nowrap">{{$value->STS_NP2}}</td>   
            <td nowrap="nowrap">{{$value->STS_SV1}}</td>   
            <td nowrap="nowrap">{{$value->STS_SV2}}</td>   
            <td nowrap="nowrap">{{$value->WL1H}}</td>   
            <td nowrap="nowrap">{{$value->WL1L}}</td>   
            <td nowrap="nowrap">{{$value->WL2H}}</td>   
            <td nowrap="nowrap">{{$value->WL2L}}</td>   
            <td nowrap="nowrap">{{$value->WL3H}}</td>   
            <td nowrap="nowrap">{{$value->WL3L}}</td>   
            <td nowrap="nowrap">{{$value->RL1}}</td>   
            <td nowrap="nowrap">{{$value->RL2}}</td>   
            <td nowrap="nowrap">{{$value->RL3}}</td>   
            <td nowrap="nowrap">{{$value->RL4}}</td>   
            <td nowrap="nowrap">{{$value->RL5}}</td>   
            <td nowrap="nowrap">{{$value->PMODE}}</td> 
            <td nowrap="nowrap">{{$value->api_type}}</td>     

        
        </tr>

        @endforeach

        <tbody/>

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

$(document).on("click", ".open-AddBookDialog", function () {

    var mydate=$('#datetimes').val();
    var myType=$('#api_type').val();
     
     $(".modal-body #dateselected").val(mydate);
     $(".modal-body #api_type").val(myType);
     $('#modal_export1').modal('show')
     
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

$(".dropdown-menu li a").click(function() {
  $(this).parents(".dropdown").find('.btn').html($(this).text() + ' <span class="caret"></span>');
  $(this).parents(".dropdown").find('.btn').val($(this).data('value'));
});

</script>


@endsection