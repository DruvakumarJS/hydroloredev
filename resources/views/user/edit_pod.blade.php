@extends('layouts.app')

@section('content')

<div class="container-body">

  <div>
   <h2 class="head-h1">Edit POD</h2>
   <label class="date">{{date('d M ,Y')}} </label>
 </div>


 <div class="row mt">
  <div class="">
   <div class=" ">
    
    <div class="card-body">


      <div class="row align-items-center">

       @foreach($users_details as $keys=> $data)

       <form method="post" action="{{route('update_pods',$data->pod_id)}}">
         @csrf

         <div class="form-body">
           <div class="row ">
             
            <div class="col-md-4">
              <label for="hub_id" class="label-title">HUBUID</label>
              <input type="text" id="hub_id" name="hub_id" class="form-control" disabled required="required" value="{{$data->hub_id}}" />
              @error('hub_id')
              <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
              @enderror
            </div> 
            
            <div class="col-md-4">
              <label for="pod_id" class="label-title">PODUID</label>
              <input type="text" id="pod_id" name="pod_id" class="form-control" disabled required="required" value="{{ $data->pod_id }}" />
              @error('pod_id')
              <script type="text/javascript">  
                $(document).ready(function(){ 
                  $('#Mymodal').modal('show');   
                });   
              </script> 
              <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
              @enderror
            </div>

          </div>
        </div>

        <div class="form-body">
         <div class="row ">

          <div class="col-md-4">
            <label for="dimention" class="label-title">Dimention</label>
            <input type="text" id="dimention" name="dimention" class="form-control"  value="{{ $data->dimention }}" />
            @error('dimention')
            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
            @enderror
          </div>

          <div class="col-md-4">
            <label for="polyhouses" class="label-title">No of Channels</label>
            <input type="text" id="polyhouses" name="polyhouses" class="form-control"  value="{{ $data->polyhouses }}" />
            @error('polyhouses')
            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
            @enderror
          </div>

        </div>
      </div>

      <!-- podmaster -->
      <div class="form-body">
       <div class="row ">

         
        <div class="col-md-4">
              <label for="location" class="label-title">Location</label>
              <input type="text" id="location" name="location" class="form-control"  required="required" value="{{ $data->location }}" />
              @error('location')
              <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
              @enderror
            </div>

      <!--   <div class="col-md-4">
            <label for="polyhouses" class="label-title">Status</label>
            <select class="form-control" name="status">
              <option value="Active">Active</option>
              <option value="Inactive">Inactive</option>
            </select> 
          </div>
 -->
        
        <input type="hidden" name="pod_id" id="pod_id" value="{{$data->pod_id}}"/> 
        <input type="hidden" name="hub_id" id="hub_id" value="{{$data->hub_id}}"/> 
        <input type="hidden" name="user_id" id="user_id" value="{{$data->user_id}}"/> 

        <input type="hidden" name="status" id="status" value="active"/> 
        <input type="hidden" name="Date" id="Date" value="{{date('Y-m-d')}}"/> 
        <input type="hidden" name="Time" id="Time" value="{{date('H:i:s')}}"/> 

      </div>
    </div>
    @endforeach

    @php
    $t1 = "";
    $t2 = "";
    $t3 = "";
    @endphp
    
    

<div class="row">
  <div class="card table-responsive ">
      <table class="table">

        <tr>
          <th>Data Frame</th>
          <th>Device</th>
          
          <th>Default Trigger Conditions </th>
          
          
        </tr>

        <tr>
         <td>CUR</td>
         <td>Cloud Update Rate</td>
         <td>
          <label>Time interval (minutes)</label>
          <br>
          <input class="form-control" style="background-color: white" type="text" name="CUR" value="{{$threshold->CUR}}" placeholder="Time interval">
        </td>
        <td></td>
        

        <tr>
         <td>AB_T1</td>
         <td>Ambient Temperature Sensor – 1</td>
         

         <td>
          <label>max temparature</label>
          <br>
          <input class="form-control" style="background-color: white"  value="{{$threshold->AB_T1}}" type="text" name="AB_T1" placeholder="max temparature"></td>
          <td></td>
        </tr>


        <tr>
         <td>AB_H1</td>
         <td>Ambient Humidity Sensor – 1</td>
         
         <td>
          <label>x value</label>
          <br>
          <input class="form-control" style="background-color: white" value="{{$threshold->AB_H1}}" type="text" name="AB_H1" placeholder="x value" disabled></td>
          <td></td>
        </tr>

        <tr>
         <td>POD_T1</td>
         <td>POD/BB Temperature Sensor – 1</td>
         
         <td>
          <label>x value</label>
          <br>
          <input class="form-control" style="background-color: white" value="{{$threshold->POD_T1}}" type="text" name="POD_T1" placeholder="x vlaue"></td>
          <td></td>
        </tr>


        <tr>
         <td>POD_H1</td>
         <td>POD/BB Humidity Sensor – 1</td>
         
         <td>
          <label>x value</label>
          <br>
          <input class="form-control" style="background-color: white" value="{{$threshold->POD_H1}}" type="text" name="POD_H1" placeholder="x vlaue" disabled></td>
          <td></td>
        </tr>

        <tr>
         <td>TDS_V1</td>
         <td>Total Dissolved Salt Sensor Value</td>
         
         <td>
          <label>threshold max value</label>
          <br>
          <input class="form-control" style="background-color: white" type="text" value="{{$threshold->TDS_V1}}" name="TDS_V1" placeholder="max value"></td>
          <td></td>
        </tr>


        <tr>
         <td>PH_V1</td>
         <td>pH Sensor Value</td>
         
         <td>
          <label>threshold max value</label> <br> 
          <input class="form-control" style="background-color: white" value="{{$threshold->PH_V1}}" type="text" name="PH_V1" placeholder="max value"></td>
          <td></td>
        </tr>

        <tr>
         <td>NUT_T1</td>
         <td>Nutrient Solution Temperature Sensor Value – 1</td>
         
         <td>
          <label>x value</label> <br> 
          <input class="form-control" style="background-color: white" value="{{$threshold->NUT_T1}}"  type="text" name="NUT_T1" placeholder="x vlaue"></td>
          <td></td>
        </tr>

        @php

        $thresholdValue=$threshold->NP_I1;
        $outputArr= preg_split("/[-:]/", $thresholdValue);

        $t1=trim($outputArr[0]);
        $t2=trim($outputArr[1]);

        @endphp

        <tr>
         <td>NP_I1</td>
         <td>Current (consumed) – Nutrient Pump 1</td>
         
         <td>
          <label>minimum mA </label> <br> 
          <input class="form-control" style="background-color: white" value="{{$t1}}"  type="text" name="min_NP_I1" placeholder="minimum mA "></td>
          <td>
            <label>maximum mA </label> <br> <input class="form-control" style="background-color: white" value="{{$t2}}"  type="text" name="max_NP_I1" placeholder="maximum mA "></td>
          </tr>



          @php

          $thresholdValue=$threshold->SV_I1;
          $outputArr= preg_split("/[-:]/", $thresholdValue);

          $t1=trim($outputArr[0]);
          $t2=trim($outputArr[1]);


          @endphp

          <tr>
           <td>SV_I1</td>
           <td>Current (consumed) – Solenoid Valve 1</td>
           
           <td>
            <label>minimum mA </label>
            <br>
            <input class="form-control" style="background-color: white" value="{{$t1}}"  type="text" name="min_SV_I1" placeholder="minimum mA "></td>
            <td>
              <label>maximum mA </label>
              <br>
              <input class="form-control" style="background-color: white" value="{{$t2}}"  type="text" name="max_SV_I1" placeholder="maximum mA "></td>
            </tr>

            <tr>
             <td>FLO_UT</td>
             <td>Flow Meter value (ppm) at the inlet of SourceTank</td>
             
             <td>
              <label>max temparature</label> <br> <input class="form-control" style="background-color: white" value="{{$threshold->FLO_UT}}"  type="text" name="FLO_UT" placeholder="max temparature"></td>
              <td></td>
            </tr>


            <tr>
             <td>FLO_BT</td>
             <td>Flow Meter value (ppm) at the inlet of Reservoir Tank</td>
             
             <td>
              <label>max temparature</label> <br> <input class="form-control" style="background-color: white" value="{{$threshold->FLO_BT}}" type="text" name="FLO_BT" placeholder="max temparature"></td>
              <td></td>
            </tr>


            @php

            $thresholdValue=$threshold->STS_NP1;
            $outputArr= preg_split("/[-:]/", $thresholdValue);

            $t1=trim($outputArr[0]);
            $t2=trim($outputArr[1]);

            @endphp


            <tr>
             <td>STS_NP1</td>
             <td>"Nutrient Pump Health Status – 1"</td>
             
             <td>
              <label>max time in minutes</label> <br> <input class="form-control" style="background-color: white" value="{{$t2}}"  type="text" name="max_time_STS_NP1" placeholder="max time in minutes"></td>
              <td></td>
            </tr>

            @php

            $thresholdValue=$threshold->STS_NP2;
            $outputArr= preg_split("/[-:]/", $thresholdValue);

            $t1=trim($outputArr[0]);
            $t2=trim($outputArr[1]);

            @endphp

            <tr>
             <td>STS_NP2</td>
             <td>Nutrient Pump Health Status – 2</td>
             
             <td>
              <label>max time in minutes</label> <br> <input class="form-control" style="background-color: white" value="{{$t2}}"  type="text" name="max_time_STS_NP2" placeholder="max time in minutes"></td>
              <td></td>
            </tr>

            @php

            $thresholdValue=$threshold->STS_SV1;
            $outputArr= preg_split("/[-:]/", $thresholdValue);

            $t1=trim($outputArr[0]);
            $t2=trim($outputArr[1]);

            @endphp


            <tr>
             <td>STS_SV1</td>
             <td>Fresh Water Solenoid Valve Health Status – 1</td>
             
             <td>
              <label>max time in minutes</label> <br> <input class="form-control" style="background-color: white" value="{{$t2}}"  type="text" name="max_time_STS_SV1" placeholder="max time in minutes"></td>
              <td></td>
            </tr>

            @php

            $thresholdValue=$threshold->STS_SV2;
            $outputArr= preg_split("/[-:]/", $thresholdValue);

            $t1=trim($outputArr[0]);
            $t2=trim($outputArr[1]);

            @endphp

            <tr>
             <td>STS_SV2</td>
             <td>Fresh Water Solenoid Valve Health Status – 2</td>
             
             <td>
              <label>max time in minutes</label> <br> <input class="form-control" style="background-color: white" value="{{$t2}}"  type="text" name="max_time_STS_SV2" placeholder="max time in minutes"></td>
              <td></td>
            </tr>

            @php

            $thresholdValue=$threshold->WL1H;
            $outputArr= preg_split("/[-:]/", $thresholdValue);

            $t1=trim($outputArr[0]);
            
            @endphp

            @php

            $thresholdValue=$threshold->WL1L;
            $outputArr= preg_split("/[-:]/", $thresholdValue);

            $t1=trim($outputArr[0]);
            $t2=trim($outputArr[1]);

            @endphp

            <tr>
             <td>WL1L</td>
             <td>Source Tank Water Level Sensor-1 – Low Level Status</td>
             
             <td>
              <label>max time in minutes</label> <br> <input class="form-control" style="background-color: white" value="{{$t2}}"  type="text" name="max_time_WL1L" placeholder="max time in minutes"></td>
              <td></td>
            </tr>

            @php

            $thresholdValue=$threshold->WL2H;
            $outputArr= preg_split("/[-:]/", $thresholdValue);

            $t1=trim($outputArr[0]);
            

            @endphp


          </tr>

          @php

          $thresholdValue=$threshold->WL2L;
          $outputArr= preg_split("/[-:]/", $thresholdValue);

          $t1=trim($outputArr[0]);
          $t2=trim($outputArr[1]);

          @endphp

          <tr>
           <td>WL2L</td>
           <td>Reservoir Tank Water Level Sensor-2 – Low Level Status</td>
           
           <td>
            <label>max time in minutes</label> <br> <input class="form-control" style="background-color: white" type="text" value="{{$t2}}" name="max_time_WL2L" placeholder="max time in minutes"></td>
            <td></td>
          </tr>

          @php

          $thresholdValue=$threshold->WL3H;
          $outputArr= preg_split("/[-:]/", $thresholdValue);

          $t1=trim($outputArr[0]);

          

          @endphp

          @php

          $thresholdValue=$threshold->WL3L;
          $outputArr= preg_split("/[-:]/", $thresholdValue);

          $t1=trim($outputArr[0]);
          

          @endphp

          <tr>
           <td>WL3L</td>
           <td>BackUP Tank Water Level Sensor-3 – Low Level Status</td>
           
           <td>
             <div>
               <label>max time in minutes</label> <br> <input class="form-control" style="background-color: white" type="text" value="{{$t2}}" name="max_time_WL3L" placeholder="max time in minutes">
             </div>
           </td>
           <td></td>
         </tr>

         @php

         $thresholdValue=$threshold->RL1;
         $outputArr= preg_split("/[-:]/", $thresholdValue);

         $t1=trim($outputArr[0]);
         $t2=trim($outputArr[1]);
         $t3=trim($outputArr[2]);
         

         @endphp



         <tr>
           <td>RL1</td>
           <td>Relay 1 Status – Controls Nutrient Pump – 1</td>
           <td>
            <label>Max minute for ON</label> <br> <input class="form-control" style="background-color: white"  type="text" value="{{$t2}}"  name="min_time_RL1" placeholder="Max minute for ON "></td>
            <td>
              <label>Max minute for OFF</label> <br> <input class="form-control" style="background-color: white" type="text"  value="{{$t3}}"  name="max_time_RL1" placeholder="max minutes for OFF"></td>
            </tr>

            
            @php

            $thresholdValue=$threshold->RL2;
            $outputArr= preg_split("/[-:]/", $thresholdValue);

            $t1=trim($outputArr[0]);
            $t2=trim($outputArr[1]);
            $t3=trim($outputArr[2]);
            

            @endphp

            <tr>
             <td>RL2</td>
             <td>Relay 2 Status – Controls Nutrient Pump – 2</td>
             
             <td>
              <label>Max minute for ON</label> <br> <input class="form-control" style="background-color: white" type="text" value="{{$t2}}"  name="min_time_RL2" placeholder="Max minute for ON "disabled></td>
              <td>
                <label>Max minute for OFF</label> <br> <input class="form-control" style="background-color: white" type="text" value="{{$t3}}"  name="max_time_RL2" placeholder="max minutes for OFF"disabled ></td>
              </tr>

              
              @php

              $thresholdValue=$threshold->RL3;
              $outputArr= preg_split("/[-:]/", $thresholdValue);

              $t1=trim($outputArr[0]);
              $t2=trim($outputArr[1]);
              $t3=trim($outputArr[2]);
              

              @endphp

              <tr>
               <td>RL3</td>
               <td>Relay 3 Status – Controls Fresh Water  Valve – 1</td>
               
               <td>
                <label>Max minute for ON</label> <br> <input class="form-control" style="background-color: white" value="{{$t2}}"  type="text" name="min_time_RL3" placeholder="Max minute for ON "></td>
                <td>
                  <label>Max minute for OFF</label> <br> <input class="form-control" style="background-color: white" value="{{$t3}}"  type="text" name="max_time_RL3" placeholder="max minutes for OFF"></td>
                </tr>

                @php

                $thresholdValue=$threshold->RL4;
                $outputArr= preg_split("/[-:]/", $thresholdValue);

                $t1=trim($outputArr[0]);
                $t2=trim($outputArr[1]);
                $t3=trim($outputArr[2]);
                

                @endphp


                <tr>
                 <td>RL4</td>
                 <td>"Relay 4 Status – Controls Fresh Water  Valve – 2 TO BE USED AS SPARE"</td>
                 
                 <td>
                  <label>Max minute for ON</label>
                  <br>
                  <input class="form-control" style="background-color: white" value="{{$t2}}"  type="text" name="min_time_RL4" placeholder="Max minute for ON "></td>
                  <td>
                    <label>Max minute for OFF</label>
                    <br>
                    <input class="form-control" style="background-color: white" value="{{$t3}}"  type="text" name="max_time_RL4" placeholder="max minutes for OFF"></td>
                  </tr>

                  @php

                  $thresholdValue=$threshold->RL5;
                  $outputArr= preg_split("/[-:]/", $thresholdValue);

                  $t1=trim($outputArr[0]);
                  $t2=trim($outputArr[1]);
                  $t3=trim($outputArr[2]);
                  

                  @endphp

                  

                  <tr>
                   <td>RL8</td>
                   <td>Relay 8 Status – Controls RO Plant AC VOltage Supply </td>
                   
                   <td>
                    <label>max temparature</label> <br> <input class="form-control" style="background-color: white" type="text" value="{{$t2}}"  name="min_time_RL8" placeholder="Max minute for ON "disabled></td>
                    <td>
                      <label>max temparature</label> <br> <input class="form-control" style="background-color: white" type="text" value="{{$t3}}"  name="max_time_RL8" placeholder="max minutes for OFF" disabled></td>
                    </tr>

                    

                    <tr>
                     <td>PMODE</td>
                     <td>Pod Mode </td>
                     
                     <td>
                      <label>Mode</label> <br> <input class="form-control" style="background-color: white" type="" name="" placeholder="Mode" value="{{$threshold->PMODE}}" disabled></td>
                      <td></td>
                    </tr>

                    
                  </table>
                  
                </div>

                
                <div style="float:right;">
                  <button class="btn btn-sm btn-danger" type="submit" name="action" value=" save">Save Changes</button>
                  <button class="btn btn-sm btn-light btn-outline-primary" type="submit" name="action" value=" cancel">Cancel </button>
                </div>
                
                

              </form>

              
            </div>
            
          </div>
        </div>   
      </div>
</div>
    


      

    </div>
  </div>

  <script>
    
    function addValue(val, pod, field){

     // alert(pod);

      
      min=($('#min_'+pod).val() =='')?'0':$('#min_'+pod).val();
      max=($('#max_'+pod).val()=='')?'0':$('#max_'+pod).val();
      x=($('#x_value_'+pod).val()=='')?'0':$('#x_value_'+pod).val();



      $("#hide_"+pod).val(min + " - "+max +" - "+x); 
    }


  </script>



  @endsection
