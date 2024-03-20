@extends('layouts.app')

@section('content')

<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

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
       <div class="container-header">
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

            <div style="left: right;margin-right: 10px;">
                 <div id="div1">
                  <h6 style="font-weight: bolder;font-size: 20px">{{$id}}</h6>
                </div>
                <div id="div2">
                  <button class="open-AddBookDialog btn btn-light btn-outline-danger" id="btn_export1" value="export">Export</button>

                    <a href="{{route('pod_history',$id)}}"><i class="fa fa-refresh"></i></a>
             

                    <a href="{{route('pods')}}"><button class="btn btn-outline-primary" style="margin-left: 20px">View PODs</button></a>
                </div>

              
               <form method="POST" action="{{route('filter_history')}}" >
                  @csrf
                    <div id="div2" style="margin-right: 5px ;">
                      <button class="btn btn-success" type="submit" name="action" value="filter">Filter</button>
                    </div>

                    <!-- <div id="div2" style="margin-right: 5px;background-color: white">
                       <input class="form-control" type="text" name="datetimes" id="datetimes" value="{{$datepicker}}" placeholder="Select Date Range" style="background-color: white" readonly/>
                    </div> -->

                    <div id="div2" style="margin-right: 30px">
                      <div style="width: 200px">
                       
                           <input class="form-control" type="text" name="datetimes"  id="datetimes" placeholder="Select Range" autocomplete="off" value="{{$range}}" />

                      </div>
                    </div>

                    <div id="div2" style="margin-right: 5px">
                       <select class="form-control form-select"  name="api_type" id="api_type">
                          <option value="none" <?php echo $api_type == 'none' ? 'selected':''  ?> >Select Data Type </option>
                          <option value="normal" <?php echo $api_type == 'normal' ? 'selected':''  ?>>Normal Data</option>
                          <option value="instant" <?php echo $api_type == 'instant' ? 'selected':''  ?>>Instant Data</option>
                      </select>
                    </div>

                    <input type="hidden" name="pod_id" value="{{$id}}">

                    
                 
               </form>


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



          </div> 
         </div> 
        </div>
         

          <div class="card">
                 <label>Normal API Data</label>
              <table class="table">
              <tr class="tHead">
            
             <th nowrap="nowrap">Time</th>
             <th title="<?php echo "Ambient Temperature Sensor – 1" ?>" nowrap="nowrap">AB-T1</th>
             <th title="<?php echo "POD/BB Temperature Sensor – 1" ?>" nowrap="nowrap">POD-T1</th>
             <th title="<?php echo "Total Dissolved Salt Sensor Value" ?>" nowrap="nowrap">TDS-V1</th>
             <th title="<?php echo "pH Sensor Value" ?>" nowrap="nowrap">PH-V1</th>
              <th title="<?php echo "Nutrient Solution Temperature Sensor Value – 1" ?>" nowrap="nowrap">NUT-T1</th>
             <th title="<?php echo "Current (consumed) – Nutrient Pump 1" ?>" nowrap="nowrap">NP-I1</th>
            
             <th title="<?php echo "Nutrient Pump Health Status – 1" ?>" nowrap="nowrap">STS-NP1</th>
            
           
             <th title="<?php echo "Source Tank Water Level Sensor-1 - High Level Status" ?>" nowrap="nowrap">WL1H</th>
             <th title="<?php echo "Source Tank Water Level Sensor-1 – Low Level Status" ?>" nowrap="nowrap">WL1L</th>
             <th title="<?php echo "Reservoir Tank Water Level Sensor-2 - High Level Status" ?>" nowrap="nowrap">WL2H</th>
             <th title="<?php echo "Reservoir Tank Water Level Sensor-2 – Low Level Status" ?>" nowrap="nowrap">WL2L</th>
             
             <th title="<?php echo "Pod Mode " ?>" nowrap="nowrap">PMODE</th>
             <th nowrap="nowrap">API_type</th>
             <th></th>
</tr>

<tbody id="myTable">


 @if(!empty($pods) && $pods->count())
       

         @foreach ($pods as $key => $value) 

         @php
            $statusvalue=$value->status;
            $time=date('Y-m-d h:i:s A', strtotime($value->created_at))
         @endphp   
 
        <tr>
          <!-- <td nowrap="nowrap">{{$key + $pods->firstItem()}}</td> -->
          <td nowrap="nowrap">{{$time}}</td>
          <td title="<?php echo "Ambient Temperature Sensor – 1" ?>" nowrap="nowrap">{{$value->AB_T1}} <span> &#176;C</span> </td>   
            <td title="<?php echo "POD/BB Temperature Sensor – 1" ?>" nowrap="nowrap">{{$value->POD_T1}}<span> &#176;C</span> </td>
            <td title="<?php echo "Total Dissolved Salt Sensor Value" ?>" nowrap="nowrap">{{$value->TDS_V1}}<span> mg/L</span> </td>   
            <td title="<?php echo "pH Sensor Value" ?>" nowrap="nowrap">{{$value->PH_V1}} </td>   
            <td title="<?php echo "Nutrient Solution Temperature Sensor Value – 1" ?>" nowrap="nowrap">{{$value->NUT_T1}}<span> &#176;C</span> </td>   
            <td title="<?php echo "Current (consumed) – Nutrient Pump 1" ?>" nowrap="nowrap">{{$value->NP_I1}}<span> mA</span> </td>     
            <td title="<?php echo "Nutrient Pump Health Status – 1" ?>" nowrap="nowrap">{{$value->STS_NP1}}</td>   
             
            <td title="<?php echo "Source Tank Water Level Sensor-1 - High Level Status" ?>" nowrap="nowrap">{{$value->WL1H}}</td>    
            <td title="<?php echo "Source Tank Water Level Sensor-1 – Low Level Status" ?>" nowrap="nowrap">{{$value->WL1L}}</td>   
            <td title="<?php echo "Reservoir Tank Water Level Sensor-2 - High Level Status" ?>" nowrap="nowrap">{{$value->WL2H}}</td>   
            <td title="<?php echo "Reservoir Tank Water Level Sensor-2 – Low Level Status" ?>" nowrap="nowrap">{{$value->WL2L}}</td>   
          
           
            <td title="<?php echo "Pod Mode " ?>" nowrap="nowrap">{{$value->PMODE}}</td> 
            <td nowrap="nowrap">{{$value->api_type}}</td> 
            <td nowrap="nowrap"><a id="MybtnModal_{{$key}}"><button class="btn btn-sm btn-light">View more</button></a></td>    

        
        </tr>

        <!-- Modal -->
                              <div class="modal" id="modal_{{$key}}" >
                                <div class="modal-dialog modal-xl">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="exampleModalLabel">POD History</h5>

                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                      <div>
                                        <label>Date & time  : </label> <label class="label-bold btn">{{$time}}</label>
                                      </div>

                                      <div>
                                        <label>Ambient Temperature Sensor – 1 : </label> <label class="label-bold btn">{{$value->AB_T1}}</label><span> &#176;C</span>
                                      </div>

                                      <div>
                                        <label>Ambient Humidity Sensor – 1 : </label> <label class="label-bold btn">{{$value->AB_H1}}</label><span> %RH</span>
                                      </div>

                                      <div>
                                        <label>POD/BB Temperature Sensor – 1 : </label> <label class="label-bold btn">{{$value->POD_T1}}</label><span> &#176;C</span>
                                      </div>

                                      <div>
                                        <label>POD/BB Humidity Sensor – 1 : </label> <label class="label-bold btn">{{$value->POD_H1}}</label><span> %RH</span>
                                      </div>

                                      <div>
                                        <label>Total Dissolved Salt Sensor Value : </label> <label class="label-bold btn">{{$value->TDS_V1}}</label><span> mg/L</span>
                                      </div>

                                      <div>
                                        <label>pH Sensor Value : </label> <label class="label-bold btn">{{$value->PH_V1}}</label>
                                      </div>

                                      <div>
                                        <label>Nutrient Solution Temperature Sensor Value – 1 : </label> <label class="label-bold btn">{{$value->NUT_T1}}</label><span> &#176;C</span>
                                      </div>

                                      <div>
                                        <label>Current (consumed) – Nutrient Pump 1 : </label> <label class="label-bold btn">{{$value->NP_I1}}</label><span> mA</span>
                                      </div>

                                      <div>
                                        <label>Current (consumed) – Solenoid Valve 1 : </label> <label class="label-bold btn">{{$value->SV_I1}}</label><span> mA</span>
                                      </div>

                                      <div>
                                        <label>Battery Power in milli volts : </label> <label class="label-bold btn">{{$value->BAT_V1}}</label><span> %</span>
                                      </div>

                                      <div>
                                        <label>Fresh Water Solenoid Valve Health Status – 1 : </label> <label class="label-bold btn">{{$value->STS_NP1}}</label>
                                      </div>

                                      <div>
                                        <label>Source Tank Water Level Sensor-1 - High Level Status : </label> <label class="label-bold btn">{{$value->WL1H}}</label>
                                      </div>

                                      <div>
                                        <label>Source Tank Water Level Sensor-1 – Low Level Status : </label> <label class="label-bold btn">{{$value->WL1L}}</label>
                                      </div>

                                      <div>
                                        <label>Reservoir Tank Water Level Sensor-2 - High Level Status : </label> <label class="label-bold btn">{{$value->WL2H}}</label>
                                      </div>

                                      <div>
                                        <label>Reservoir Tank Water Level Sensor-2 – Low Level Status : </label> <label class="label-bold btn">{{$value->WL2L}}</label>
                                      </div>

                                      <div>
                                        <label>BackUP Tank Water Level Sensor-3 - High Level Status : </label> <label class="label-bold btn">{{$value->WL3H}}</label>
                                      </div>

                                      <div>
                                        <label>BackUP Tank Water Level Sensor-3 – Low Level Status : </label> <label class="label-bold btn">{{$value->WL3L}}</label>
                                      </div>

                                      <div>
                                        <label>Relay 1 Status – Controls Nutrient Pump – 1 : </label> <label class="label-bold btn">{{$value->RL1}}</label>
                                      </div>

                                      <div>
                                        <label>Relay 3 Status – Controls Fresh Water  Valve – 1 : </label> <label class="label-bold btn">{{$value->RL3}}</label>
                                      </div>

                                       <div>
                                        <label>Relay 4 Status – Controls Fresh Water  Valve – 2 : </label> <label class="label-bold btn">{{$value->RL4}}</label>
                                      </div>

                                       <div>
                                        <label>Relay 8 Status – Controls RO Plant AC VOltage Supply : </label> <label class="label-bold btn">{{$value->RL8}}</label>
                                      </div>

                                       <div>
                                        <label>Pod Mode : </label> <label class="label-bold btn">{{$value->PMODE}}</label>
                                      </div>

                                      <div>
                                        <label>API Type : </label> <label class="label-bold btn">{{$value->api_type}}</label>
                                      </div>

                                      <div>
                                        <label>Critical Data : </label> <label class="label-bold btn">{{$value->critical_data}}</label>
                                      </div>
                                     
                                    </div>
                    </div>
                  </div>
                </div>

<!--  end Modal -->

 <script>
$(document).ready(function(){
  $('#MybtnModal_{{$key}}').click(function(){
    $('#modal_{{$key}}').modal('show');
  });
});  
</script>

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

$(document).on("click", ".open-AddBookDialog", function () {

    var mydate=$('#datetimes').val();
    var myType=$('#api_type').val();
   // alert(mydate);
     
     $(".modal-body #dateselected").val(mydate);
     $(".modal-body #api_type").val(myType);
     $('#modal_export1').modal('show')
     
});

</script>

<script type="text/javascript">
 
$('input[name="datetimes"]').daterangepicker({
    locale: {
        format: 'YYYY/MM/DD'
    },
    autoUpdateInput: false,
}).on('apply.daterangepicker', function(ev, picker) {
    // This function will be executed when a new date range is applied

    var startDate = picker.startDate.format('YYYY/MM/DD');
    var endDate = picker.endDate.format('YYYY/MM/DD');
     var datess = startDate+" - "+endDate;
    
   // alert(datess)
    console.log('Start Date: ' + startDate);
    console.log('End Date: ' + endDate);
    // Perform any other actions you want here
     $(this).val(startDate + ' - ' + endDate);
    
    // Re-enable autoUpdateInput after date selection
    $(this).daterangepicker('autoUpdateInput', true);
});

</script>




@endsection