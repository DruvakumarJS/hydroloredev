@extends('layouts.app')

@section('content')

<body>
  
  <div class="container-body">
     <div class="container-header">
       <div>
         <h2 class="head-h1">PODs</h2>
         <label class="date">{{date('d M ,Y')}} </label>

       </div>

      
    </div> 

     <div class="page-container" style="margin-top: 20px">
     <div class="row mt">
        <div class="col-sm-6 col-md-4 ">
             <div class="card ">

                <div class="card-body">
                  <div class="row align-items-center">

                   

                     <h4 class="head-h1">{{$value->firstname}} {{$value->lastname}}</h4>
                     <label class="label_black">{{$value->email}}</label>
                     <label class="label_black">{{$value->mobile}}</label>


                      <div style="margin-top: 20px;">
                        <label class="label_black" style="width:100px">{{$value->address}}</label>
                        <label class="btn btn-primary button-right" >View location</label>
                      </div>

                      <div>
                        <div class="margin_top">

                         <!--  <label style="float:right; border-color:white;" class="curved-text">Edit</label> -->
                           <label class="label_black">HUB ID</label>
                            <h6 class="label_bold">{{$value->hub_id}}</h6>

                        </div>

                      </div>

                     <!--  <div>
                        <div class="margin_top">
                          <i class='fa fa-angle-down' style='font-size:24px;float: right;'></i>
                           <label class="label_black">POD ID</label>
                            <h6 class="label_bold">A0939393738</h6>

                        </div>

                      </div>
 -->


                       <button type="button" id="MybtnModal" class="btn btn-primary rounded-pill">Add POD</button>


                      <div class="modal fade " id="Mymodal" >
                        <div class="modal-dialog modal-xl" >
                          <div class="modal-content " style="background-color: aliceblue;">
                            <div class="modal-header">

                              <div class="align-items-center" >
                              <h1 class="head-h1">Add POD</h1>

                              <form method="post" action="{{route('add_pods')}}">
                               @csrf

                               <div class="form-body">
                                 <div class="row row mb-2">

                                      <div class="col-md-3">
                                        <label for="pod_id" class="label-title">PODUID</label>
                                        <input type="text" id="pod_id" name="pod_id" class="form-control"  required="required" value="{{ old('pod_id') }}" />
                                         @error('pod_id')
                                        <script type="text/javascript">
                                              $(document).ready(function(){
                                              $('#Mymodal').modal('show');
                                              });
                                       </script>
                                         <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                         @enderror
                                      </div>

                                      <div class="col-md-3">
                                        <label for="location" class="label-title">POD Location</label>
                                        <div>

                                        <select class="form-control" id="location" name="location" >
                                          @foreach ($locations as $key => $values)

                                           <option value="{{$values->location}}">{{$values->location}}</option>

                                          @endforeach
                                        </select>


                                        </div>

                                      </div>

                                    </div>
                               </div>

                               <div class="form-body">
                                 <div class="row row mb-2">

                                      <div class="col-md-3">
                                        <label for="dimention" class="label-title">Dimention</label>
                                        <input type="text" id="dimention" name="dimention" class="form-control"   value="{{ old('dimention') }}" />
                                          @error('dimention')
                                           <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                         @enderror
                                      </div>

                                      <div class="col-md-3">
                                        <label for="polyhouses" class="label-title">No. of Channels</label>
                                        <input type="text" id="polyhouses" name="polyhouses" class="form-control"   value="{{ old('polyhouses') }}" />
                                         @error('polyhouses')
                                           <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                         @enderror
                                      </div>

                                    </div>
                               </div>

<!-- podmaster -->
                                <div class="form-body">
                                 <div class="row row mb-2">


                                      <div class="col-md-3">
                                        <label for="hub_id" class="label-title">HUBUID</label>
                                        <input type="text" id="hub_id" name="hub_id" class="form-control"  required="required" value="{{ $value->hub_id }}" disabled />
                                         @error('hub_id')
                                           <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                         @enderror
                                      </div>

                                       <input type="hidden" name="user_id" id="user_id" value="{{$value->id}}">
                                       <input type="hidden" name="hub_id" id="hub_id" value="{{$value->hub_id}}">

                                       <input type="hidden" name="status" id="status" value="active">
                                       <input type="hidden" name="Date" id="Date" value="{{date('Y-m-d')}}">
                                       <input type="hidden" name="Time" id="Time" value="{{date('H:i:s')}}">

                                        <input type="hidden" name="" id="Time" value="{{date('H:i:s')}}">

                                    </div>
                               </div>


                      <div class="card table-responsive">
                        <table class="table">

                            <tr>
                              <th>Data Frame</th>
                              <th>Device</th>
                              <th>Default Trigger Conditions </th>
                              <th></th>


                        </tr>
                       

                           <tr>
                             <td>CUR</td>
                             <td>Cloud Update Rate</td>

                             <td>
                              <label>Time interval (minutes)</label>
                              <input class="form-control" type="number" name="CUR" value="120" min="1" placeholder="Time interval">
                            </td>
                            <td></td>

                           </tr>
                           <tr>
                             <td>AB_T1</td>
                             <td>Ambient Temperature Sensor – 1</td>


                             <td>
                              <label>max temparature</label>
                              <br>
                              <input class="form-control" value="37" type="number" min="0" name="AB_T1" placeholder="max temparature"></td>
                              <td></td>
                           </tr>


                           <!--  <tr>
                             <td>AB_H1</td>
                             <td>Ambient Humidity Sensor – 1</td>

                              <td>
                              <label>x value</label>
                              <br>
                              <input class="form-control" type="text" name="AB_H1" placeholder="x value" disabled>
                              </td>
                              <td></td>
                           </tr> -->

                            <tr>
                             <td>POD_T1</td>
                             <td>POD/BB Temperature Sensor – 1</td>

                              <td>
                              <label>x value</label>
                              <br>
                              <input class="form-control" value="4" type="number" min="0" name="POD_T1" placeholder="x vlaue"></td>
                              <td></td>
                           </tr>


                            <!-- <tr>
                             <td>POD_H1</td>
                             <td>POD/BB Humidity Sensor – 1</td>

                              <td>
                              <label>max value</label>
                              <br>
                              <input class="form-control" type="text" name="POD_H1" placeholder="threshold max value" disabled></td>
                              <td></td>
                           </tr> -->

                            <tr>
                             <td>TDS_V1</td>
                             <td>Total Dissolved Salt Sensor Value</td>
                              <td>
                                <label>min value</label>
                              <br>
                              <input class="form-control" type="number" min="0" value="150" name="min_TDS_V1" placeholder="threshold min value" >
                              </td>
                              <td>
                              <label>max value</label>
                              <br>
                              <input class="form-control" type="number" min="0" value="750" name="max_TDS_V1" placeholder="threshold max value" ></td>
                              
                           </tr>


                            <tr>
                             <td>PH_V1</td>
                             <td>pH Sensor Value</td>
                              <td>
                                <label>min value</label>
                              <br>
                              <input class="form-control" type="number" min="0" value="2" name="min_PH_V1" placeholder="threshold min value" >
                              </td>
                                <td>
                                 <label>max value</label>
                                <br>
                              <input class="form-control" type="number" min="0" value="6" name="max_PH_V1" placeholder="threshold max value"></td>
                              
                           </tr>

                            <tr>
                             <td>NUT_T1</td>
                             <td>Nutrient Solution Temperature Sensor Value – 1</td>

                              <td>
                              <label>x value</label>
                              <br>
                              <input class="form-control" value="4" type="number" min="0" name="NUT_T1" placeholder="x value"></td>
                              <td></td>
                           </tr>


                            <tr>
                             <td>NP_I1</td>
                             <td>Current (consumed) – Nutrient Pump 1</td>

                              <td>
                              <label>minimum mA </label>
                              <br>
                              <input class="form-control" value="1800" type="number" min="0" name="min_NP_I1" placeholder="minimum mA "></td>
                              <td>
                              <label>maximum mA </label>
                              <br>
                              <input class="form-control" value="5000" type="number" min="0" name="max_NP_I1" placeholder="maximum mA "></td>
                           </tr>

                            <!-- <tr>
                             <td>NP_I2</td>
                             <td>Current (consumed) – Nutrient Pump 2</td>

                              <td>
                              <label>minimum mA </label>
                              <br>
                              <input class="form-control" value="800" type="text" name="min_NP_I2" placeholder="minimum mA "></td>
                              <td>
                              <label>maximum mA </label>
                              <br>
                              <input class="form-control" value="5000" type="text" name="max_NP_I2" placeholder="maximum mA "></td>

                           </tr> -->

                            <tr>
                             <td>SV_I1</td>
                             <td>Current (consumed) – Solenoid Valve 1</td>

                              <td>
                              <label>minimum mA </label>
                              <br>
                              <input class="form-control" value="200" type="number" min="0" name="min_SV_I1" placeholder="minimum mA "></td>
                              <td>
                              <label>maximum mA </label>
                              <br>
                              <input  class="form-control" value="800" type="number" min="0" name="max_SV_I1" placeholder="maximum mA "></td>
                           </tr>

                            <!-- <tr>
                             <td>FLO_UT</td>
                             <td>Flow Meter value (ppm) at the inlet of SourceTank</td>

                              <td>
                              <label>max temparature</label>
                              <br>
                              <input class="form-control" type="text" name="FLO_UT" placeholder="max temparature"></td>
                              <td></td>
                           </tr>


                            <tr>
                             <td>FLO_BT</td>
                             <td>Flow Meter value (ppm) at the inlet of Reservoir Tank</td>

                              <td>
                              <label>max temparature</label>
                              <br>
                              <input class="form-control" type="text" name="FLO_BT" placeholder="max temparture"></td>
                              <td></td>
                           </tr> -->

                            <tr>
                             <td>STS_NP1</td>
                             <td>"Nutrient Pump Health Status – 1"</td>

                              <td>
                              <label>max time in minutes</label>
                              <br><input class="form-control" value="60" type="number" min="0" name="max_time_STS_NP1" placeholder="max time in minutes"></td>

                              <td></td>
                           </tr>

                           <!--  <tr>
                             <td>STS_NP2</td>
                             <td>Nutrient Pump Health Status – 2</td>
                               <td>
                              <label>max time in minutes</label>
                              <br>
                              <input class="form-control" value="60" type="text" name="max_time_STS_NP2" placeholder="max time in minutes"></td>
                              <td></td>
                           </tr> -->


                            <tr>
                             <td>STS_SV1</td>
                             <td>Fresh Water Solenoid Valve Health Status – 1</td>
                              <td>
                              <label>max time in minutes</label>
                              <br>
                              <input class="form-control" value="60" type="number" min="0" name="max_time_STS_SV1" placeholder="max time in minutes"></td>
                              <td></td>
                           </tr>  

                           <!--  <tr>
                             <td>STS_SV2</td>
                             <td>Fresh Water Solenoid Valve Health Status – 2</td>
                              <td>
                              <label>max time in minutes</label>
                              <br>
                              <input class="form-control" value="60" type="text" name="max_time_STS_SV2" placeholder="max time in minutes"></td>
                              <td></td>
                           </tr> -->


                            <tr>
                             <td>WL1L</td>
                             <td>Source Tank Water Level Sensor-1 – Low Level Status</td>
                              <td>
                              <label>max time in minutes</label>
                              <br>
                              <input class="form-control" value="30" type="number" min="0" name="max_time_WL1L" placeholder="max time in minutes" ></td>
                              <td></td>
                           </tr>


                            <tr>
                             <td>WL2L</td>
                             <td>Reservoir Tank Water Level Sensor-2 – Low Level Status</td>
                              <td>
                              <label>max time in minutes</label>
                              <br>
                              <input class="form-control" type="number" value="30" min="0" name="max_time_WL2L" placeholder="max time in minutes"></td>
                              <td></td>
                           </tr>


                        
                            <tr>
                             <td>WL3L</td>
                             <td>BackUP Tank Water Level Sensor-3 – Low Level Status</td>

                             <td>
                                 <label>max time in minutes</label>
                                 <br>
                                 <input class="form-control" value="30" type="number" min="0" name="max_time_WL3L" placeholder="max time in minutes" >

                             </td>
                             <td></td>
                           </tr>


                            <tr>
                             <td>RL1</td>
                             <td>Relay 1 Status – Controls Nutrient Pump – 1</td>
                             <td>
                              <label>Max minute for ON</label>
                              <br>
                              <input class="form-control" type="number" value="10" min="0" name="min_time_RL1" placeholder="Max minute for ON "></td>
                              <td>
                              <label>Max minute for OFF</label>
                              <br>
                              <input class="form-control" type="number"  value="30" min="0" name="max_time_RL1" placeholder="max minutes for OFF"></td>
                           </tr>

                            <!-- <tr>
                             <td>RL2</td>
                             <td>Relay 2 Status – Controls Nutrient Pump – 2</td>
                              <td>
                              <label>Max minute for ON</label>
                              <br>
                              <input class="form-control" type="text" value="10" name="min_time_RL2" placeholder="Max minute for ON "></td>
                              <td>
                              <label>Max minute for OFF</label>
                              <br>
                              <input class="form-control" type="text" value="30" name="max_time_RL2" placeholder="max minutes for OFF"></td>
                           </tr> -->


                            <tr>
                             <td>RL3</td>
                             <td>Relay 3 Status – Controls Fresh Water  Valve – 1</td>
                              <td>
                              <label>Max minute for ON</label>
                              <br>
                              <input class="form-control" value="30" type="number" min="0" name="min_time_RL3" placeholder="Max minute for ON "></td>
                              <td>
                              <label>Max minute for OFF</label>
                              <br>
                              <input class="form-control" value="1080" type="number" min="0" name="max_time_RL3" placeholder="max minutes for OFF"></td>
                           </tr>

                            <tr>
                             <td>RL4</td>
                             <td>"Relay 4 Status – Controls Fresh Water  Valve – 2 TO BE USED AS SPARE"</td>
                              <td><label>Max minute for ON</label>
                                <br>
                                <input class="form-control" value="10" type="number" min="0" name="min_time_RL4" placeholder="Max minute for ON "></td>
                              <td><label>Max minute for OFF</label>
                                <br>
                                <input class="form-control" value="1080" type="number" min="0" name="max_time_RL4" placeholder="max minutes for OFF"></td>
                           </tr>


                           <!--  <tr>
                             <td>RL8</td>
                             <td>Relay 8 Status – Controls RO Plant AC VOltage Supply </td>
                              <td>
                              <label>max temparature</label>
                              <br>
                              <input class="form-control" type="text" name="min_time_RL8" placeholder="Max minute for ON "></td>
                              <td>
                              <label>max temparature</label>
                              <br>
                              <input class="form-control" type="text" name="max_time_RL8" placeholder="max minutes for OFF"></td>
                           </tr> -->

                           <tr>
                             <td>PMODE</td>
                             <td>Pod Mode </td>

                              <td>
                              <label>Mode</label>
                              <br>
                              <input class="form-control" type="text" name="PMODE" placeholder="Mode"></td>
                              <td></td>
                           </tr>


                        </table>

                    </div>


                    <div>
                      <button class="btn btn-success btn-sm" type="submit" name="action" value=" Add">Add POD</button>
                     
                    </div>


               </form>

              </div>



                            </div>
                          </div>
                        </div>
                      </div>



                   

                  </div>

                </div>
             </div>
        </div>


        <div class="col-sm-6 col-md-8 ">
             <div class="card table-responsive">
              <table class="table">
                  <tr>
                    <th>Sl.no</th>
                    <th>POD ID</th>
                    <th>POD Location</th>
                    <th>Number of Channels</th>
                    <th>Action</th>
                  </tr>


                   @foreach ($pods_list as $key => $value)

                  <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$value->pod_id}}</td>
                    <td>{{$value->location}}</td>
                    <td>{{$value->polyhouses}}</td>
                    
                    <td>
                       <a href="{{route('add_crops',$value->pod_id)}}">
                        <button class="btn btn-sm btn-light btn-outline-success">Crops</button>
                       </a>

                       <a href="{{route('view_pod',$value->pod_id)}}">
                        <button class="btn btn-sm btn-light btn-outline-primary">Update Threshold</button>
                       </a>

                       <a onclick="return confirm('Are you sure to delete?')" href="{{route('deletepod',$value->pod_id)}}">
                        <button class="btn btn-sm btn-outline-danger">Delete</button>
                       </a>
                    </td>
                  </tr>

                @endforeach
              </table>
        </div>
          @if(session()->has('message'))
                          <div class="alert alert-danger">
                             {{ session()->get('message') }}
                          </div>
                       @endif
      </div>


  
  </div>

  <script>
$(document).ready(function(){
  $('#MybtnModal').click(function(){
    $('#Mymodal').modal('show')
  });
});

function addValue(val, pod, field){

      min=($('#min_'+pod).val() =='')?'0':$('#min_'+pod).val();
      max=($('#max_'+pod).val()=='')?'0':$('#max_'+pod).val();
      x=($('#x_value_'+pod).val()=='')?'0':$('#x_value_'+pod).val();
      $("#hide_"+pod).val(min + " - "+max +" - "+x);
 }

</script>

 </div>
  </div>

</body>
<script type="text/javascript">

 $( document ).ready(function() {
    
    $('select').on('change', function() {
    
      var category = $('#category').val();
      var path = "{{ route('getstocks') }}";

      $.ajax({
            url: path,
            type: 'GET',
            dataType: "json",
            data: {
               search: category
            },
            success: function( data ) {
              console.log(data);
              var response = data ;
              //var crops = $('#crop');

               var product = '<select class="form-control form-select" name="product"  required="required"> <option value=""> Select Product</option>'
          response.forEach(function(item) {
              
               //alert(item.name);
            product +=" <option value='"+item.id+"'>"+ item.product +" </option>";
           });
           product += '</select>'; 

           $('#product').html(product);
              
            }
          });

     });

  });

  
  
</script>


@endsection
