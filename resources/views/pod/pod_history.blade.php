@extends('layouts.app')

@section('content')

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
                 <h6 class="card" style="float: left;margin-right: 10px; background: blue;  color: white;">POD ID : {{$id}}</h6>
                 
                <div id="div2">
                  <button class="open-AddBookDialog btn-primary" id="btn_export1" value="export">Export</button>
                </div>
              
               <form method="POST" action="{{route('filter_history')}}" >
                  @csrf
                    <div id="div2" style="margin-right: 10px ;">
                      <button class=" btn-primary" type="submit" name="action" value="filter">Filter</button>
                    </div>

                    <div id="div2" style="margin-right: 10px;background-color: white">
                       <input class="form-control" type="text" name="datetimes" id="datetimes" value="{{$datepicker}}" placeholder="Select Date Range" style="background-color: white" readonly/>
                    </div>

                    <div id="div2" style="margin-right: 10px">
                       <select class="form-control"  name="api_type" id="api_type">
                          <option value="none" <?php echo $api_type == 'none' ? 'selected':''  ?> >Select Data Type </option>
                          <option value="normal" <?php echo $api_type == 'normal' ? 'selected':''  ?>>Normal Data</option>
                          <option value="instant" <?php echo $api_type == 'instant' ? 'selected':''  ?>>Instant Data</option>
                      </select>
                    </div>

                    <input type="hidden" name="pod_id" value="{{$id}}">

                    <div id="div2" style="margin-right: 10px">
                       <a href="{{route('pod_history',$id)}}"><i class="fa fa-refresh"></i>  </a>
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

           <div class="row">

                   <div class="col-sm-6 col-md-3  justify-content: center; align-items: center; display: flex;" >
                        <div class="card progress">
                          <div class="card-header">Day time mean value</div>
                          <div class="barOverflow">
                            <div class="bar"></div>
                          </div>
                          @if(isset($ambian_mean_values['mean_day']))
                          <div><span>{{$ambian_mean_values['mean_day']}} </span><label> &#176;C</label></div> 
                          @else
                          <div><span>0</span><label> &#176;C</label></div>
                          @endif
                          <label style="font-weight: bolder;" >AB-T1</label>
                          <label>Ambient Temperature Sensor – 1</label>

                        </div>
                    </div> 


                    <div class="col-sm-6 col-md-3" >
                        <div class="card bg-dark text-white progress" >
                          <div class="card-header">Night time mean value</div>
                          <div class="barOverflow">
                            <div class="bar"></div>
                          </div>
                           @if(isset($ambian_mean_values['mean_night']))
                          <div><span>{{$ambian_mean_values['mean_night']}} </span><label> &#176;C</label></div> 
                          @else
                          <div><span>0</span><label> &#176;C</label></div>
                          @endif
                          <label style="font-weight: bolder;" >AB-T1</label>
                          <label>Ambient Temperature Sensor – 1</label>

                      </div>
                    
                    </div>


                    <!--  -->
                    <div class="col-sm-6 col-md-3" >
                        <div class="card progress">
                          <div class="card-header">Day time mean value</div>
                          <div class="barOverflow">
                            <div class="bar"></div>
                          </div>
                          @if(isset($pod_mean_values['mean_day']))
                          <div><span>{{$pod_mean_values['mean_day']}}</span><label> &#176;C</label></div> 
                          @else
                          <div><span>0</span><label> &#176;C</label></div>
                          @endif
                          <label style="font-weight: bolder;" >POD-T1</label>
                          <label>POD/BB Temperature Sensor – 1</label>

                        </div>
                    </div> 


                    <div class="col-sm-6 col-md-3" >
                        <div class="card bg-dark text-white progress">
                          <div class="card-header">Night time mean value</div>
                          <div class="barOverflow">
                            <div class="bar"></div>
                          </div>
                          @if(isset($pod_mean_values['mean_night']))
                          <div><span>{{$pod_mean_values['mean_night']}}</span><label> &#176;C</label></div> 
                          @else
                          <div><span>0</span><label> &#176;C</label></div>
                          @endif
                          <label style="font-weight: bolder;" >POD-T1</label>
                          <label>POD/BB Temperature Sensor – 1</label>

                      </div>
                    
                    </div>


             </div>

              


           <div class="row">
                <div class="col-md-6" style="margin-top: 20px">
                  <div class="row">
                   <div class="col-sm-6 col-md-6">
                        <div class="card progress">
                          <div class="card-header">Day time mean value</div>
                          <div class="barOverflow">
                            <div class="bar"></div>
                          </div>
                          @if(isset($nutri_mean_values['mean_day']))
                          <div><span>{{$nutri_mean_values['mean_day']}}</span><label> &#176;C</label></div> 
                          @else
                          <div><span>0</span><label> &#176;C</label></div>
                          @endif
                         
                           <label style="font-weight: bolder;">NUT-T1</label>
                          <label>Nutrition Solution Temperature Sensor – 1</label>

                        </div>
                    </div> 


                    <div class="col-sm-6 col-md-6" >
                        <div class="card bg-dark text-white progress">
                          <div class="card-header">Night time mean value</div>
                          <div class="barOverflow">
                            <div class="bar"></div>
                          </div>
                          @if(isset($nutri_mean_values['mean_night']))
                          <div><span>{{$nutri_mean_values['mean_night']}}</span><label> &#176;C</label></div> 
                          @else
                          <div><span>0</span><label> &#176;C</label></div>
                          @endif
                           <label style="font-weight: bolder;">NUT-T1</label>
                          <label>Nutrition Solution Temperature Sensor – 1</label>

                      </div>
                    
                    </div>
                  </div>

                  <div class="row" style="margin-top: 30px">
                      <div class="col-sm-6 col-md-3" >
                        <div class="card">

                          <label class="switch">
                          <input type="checkbox" <?php echo ($tanks->WL1H == 'ON')?'checked':''  ?>  disabled><span class="slider round" ></span></label>
                          
                          <h3>WL1H</h3>

                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3" >
                        <div class="card">

                          <label class="switch">
                          <input type="checkbox" <?php echo ($tanks->WL1L == 'ON')?'checked':''  ?> disabled><span class="slider round"></span></label>
                          
                          <h3>WL1L</h3>

                        </div>
                    </div> 

                    <div class="col-sm-6 col-md-3" >
                        <div class="card">

                          <label class="switch">
                          <input type="checkbox" <?php echo ($tanks->WL2H == 'ON')?'checked':''  ?>  disabled><span class="slider round"></span></label>
                          
                          <h3>WL2H</h3>

                        </div>
                    </div>

                    <div class="col-sm-6 col-md-3" >
                        <div class="card">

                          <label class="switch">
                          <input type="checkbox" <?php echo ($tanks->WL2L == 'ON')?'checked':''  ?>  disabled><span class="slider round"></span></label>
                          
                          <h3>WL2L</h3>

                        </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-6">
                  <div  class="card card-shadow">
                    <label>Temperature Graph</label>
                    <canvas id="temp_chart"></canvas>
                  </div>     
                </div>

                   
            </div>

             <div class="row">

               <div class="col-md-6">
                  <div  class="card card-shadow">
                    <label>TDS Graph</label>
                    <canvas id="tds_chart"></canvas>
                  </div>     
                </div> 
                
                <div class="col-md-6">
                  <div  class="card card-shadow">
                    <label>PH Graph</label>
                    <canvas id="ph_chart"></canvas>
                  </div>     
                </div>
 
            </div>

              <div class="card">
                 
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
 
<script>

   
   var temparature = [];
   Chart.defaults.global.defaultFontStyle = 'bold';

   
    new Chart("temp_chart", {
      type: "bar",
      title:{
        text:"Chart Title",
       },
      
      data: {
       // labels: ['POD1' , 'POD2' , 'POD3' , 'POD4' , 'POD5' , 'POD1' , 'POD2' , 'POD3' , 'POD4' , 'POD5'],
         labels: <?php echo $sensorsArray['time'] ;  ?>,


        datasets: [
        {
          label: 'Ambian Temperature',  
          fill: false,
         
          backgroundColor: "<?php echo 'red' ;  ?>",
          borderColor: "<?php echo 'red' ;  ?>",
          data: <?php echo $sensorsArray['ambian'] ;  ?>,

        },
        {
          label: 'POD Temaperature',  
          fill: false,
         
          backgroundColor: "<?php echo '#FF90BB';  ?>",
          borderColor: "<?php echo '#FF90BB';  ?>",
          data: <?php echo $sensorsArray['pod'] ;  ?>,
        },
       {
          label: 'Nutrition Temaperature',  
          fill: false,
          
          backgroundColor: "<?php echo '#FFE4A7';  ?>",
          borderColor: "<?php echo '#FFE4A7';  ?>",
          data: <?php echo $sensorsArray['nut'] ;  ?>,
        },
       
        ]
      },
      options: {
         tooltips: {
                  mode: 'index'
                },
        legend: {display: true},
        scales: {
          pointLabels :{
           fontStyle: "bold",
            },
          yAxes: [{
            gridLines: {
             drawOnChartArea: false },
             ticks: {min:0 } ,
           
            scaleLabel: {
                    display: true,
                    labelString: 'Temperature in \xB0C',
                    fontColor: '#000',   }
                }],
          xAxes: [{
            barPercentage: 1,
             gridLines: {
             drawOnChartArea: false },
          
            scaleLabel: {
                    display: true,
                    labelString: 'Time',
                    fontColor: '#000', }
                }],
        }
      }
    });
</script>

<!-- TDS -->
<script>

   
   var temparature = [];
   Chart.defaults.global.defaultFontStyle = 'bold';

   
    new Chart("tds_chart", {
      type: "line",
      title:{
        text:"Chart Title",
       },
      
      data: {
       // labels: ['POD1' , 'POD2' , 'POD3' , 'POD4' , 'POD5' , 'POD1' , 'POD2' , 'POD3' , 'POD4' , 'POD5'],
         labels: <?php echo $tdsArray['time'] ;  ?>,


        datasets: [
        {
          label: 'TDS value',  
          fill: false,
         
          backgroundColor: "<?php echo 'red' ;  ?>",
          borderColor: "<?php echo 'red' ;  ?>",
          data: <?php echo $tdsArray['tds'] ;  ?>,

        }
        ]
      },
      options: {
         tooltips: {
                  mode: 'index'
                },
        legend: {display: true},
        scales: {
          pointLabels :{
           fontStyle: "bold",
            },
          yAxes: [{
            gridLines: {
             drawOnChartArea: false },

            ticks: {min: 0} ,
            scaleLabel: {
                    display: true,
                    labelString: 'TDS Value in mg/L',
                    fontColor: '#000',   }
                }],
          xAxes: [{
            barPercentage: 1,
             gridLines: {
             drawOnChartArea: false },

          
            scaleLabel: {
                    display: true,
                    labelString: 'Time',
                    fontColor: '#000', }
                }],
        }
      }
    });
</script>

<!-- TDS -->
<!-- ph -->

<!-- <script>

   
   var temparature = [];
   Chart.defaults.global.defaultFontStyle = 'bold';

   
    new Chart("ph_chart", {
      type: "bar",
      title:{
        text:"Chart Title",
       },
      
      data: {
         labels: <?php echo $phArray['time'] ;  ?>,


        datasets: [
        {
          label: 'PH value',  
          fill: false,
         
          backgroundColor: "<?php echo 'green' ;  ?>",
          borderColor: "<?php echo 'green' ;  ?>",
          data: <?php echo $phArray['ph'] ;  ?>,

        }
        ]
      },
      options: {
         tooltips: {
                  mode: 'index'
                },
        legend: {display: true},
        scales: {
          pointLabels :{
           fontStyle: "bold",
            },
          yAxes: [{
            gridLines: {
             drawOnChartArea: false },

            ticks: {min:0 , max:14} ,
            scaleLabel: {
                    display: true,
                    labelString: 'PH Value',
                    fontColor: '#000',   }
                }],
          xAxes: [{
            barPercentage: 0.5,
             gridLines: {
             drawOnChartArea: false },
           
            scaleLabel: {
                    display: true,
                    labelString: 'Time',
                    fontColor: '#000', }
                }],
        }
      }
    });
</script> -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.6.2/chart.js"></script>
<script type="text/javascript">

  const options = {
  type: 'bar',
  data: {
    labels: <?php echo $phArray['time'] ;  ?>,
    datasets: [{
      label: 'PH value',
      data: <?php echo $phArray['ph'] ;  ?>,
      backgroundColor: (ctx) => {
        if (ctx.raw <= 1) {return 'red';}
        if (ctx.raw <= 2) { return 'pink';}
        if (ctx.raw <= 3) { return 'orange';}
        if (ctx.raw <= 4) { return 'beige';}
        if (ctx.raw <= 5) { return 'yellow';}
        if (ctx.raw <= 6) { return 'limegreen';}
        if (ctx.raw <= 7) { return 'green';}
        if (ctx.raw <= 8) { return 'darkgreen';}
        if (ctx.raw <= 9) { return 'turquoise';}
        if (ctx.raw <= 10) { return 'paleblue';}
        if (ctx.raw <= 11) { return 'blue';}
        if (ctx.raw <= 12) { return 'darkblue';}
        if (ctx.raw <= 13) { return 'violet';}
        if (ctx.raw <= 14) { return 'purple';}


         if (ctx.raw <= 60) {
          return 'blue';
        }

        return 'green';
      }
    }]
  },
  options: {
     plugins: {
            legend: {
                display: false
            },
        }
  }
}

const ctx = document.getElementById('ph_chart').getContext('2d');
new Chart(ctx, options);
</script>

<!-- ph -->



<script>
    var coll = document.getElementsByClassName("collapsible");
    var i;

    for (i = 0; i < coll.length; i++) {
      coll[i].addEventListener("click", function() {
        this.classList.toggle("active");
        var content = this.nextElementSibling;
        if (content.style.display === "block") {
          content.style.display = "none";
      } else {
          content.style.display = "block";
      }
  });
  }

</script>

<script>
  $(".progress").each(function(){
  
  var $bar = $(this).find(".bar");
  var $val = $(this).find("span");
  var perc = parseInt( $val.text(), 10);

  $({p:0}).animate({p:perc}, {
    duration: 3000,
    easing: "swing",
    step: function(p) {
      $bar.css({
        transform: "rotate("+ (45+(p*1.8)) +"deg)", // 100%=180° so: ° = % * 1.8
        // 45 is to add the needed rotation to have the green borders at the bottom
      });
      $val.text(p|0);
    }
  });
});
</script>


@endsection