@extends('layouts.app')

@section('content')

<body>
  <div class="container-body">

      <div>
         <h2 class="head-h1">Users</h2>
         <label class="date">{{date('d M ,Y')}} </label>
      </div>


      <div class="row mt">
        <div class="col-sm-6 col-md-4 ">
             <div class="card ">
                
                <div class="card-body">
                  <div class="row align-items-center">

                    @foreach ($user_detail as $key => $value)
                     
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
                                        <input type="text" id="pod_id" name="pod_id" class="form-input"  required="required" value="{{ old('pod_id') }}" />
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
                                          
                                        <select id="location" name="location" style="width:200px;height: 30px">
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
                                        <input type="text" id="dimention" name="dimention" class="form-input"  required="required" value="{{ old('dimention') }}" />
                                          @error('dimention')
                                           <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                         @enderror
                                      </div>

                                      <div class="col-md-3">
                                        <label for="polyhouses" class="label-title">Polyhouses</label>
                                        <input type="text" id="polyhouses" name="polyhouses" class="form-input"  required="required" value="{{ old('polyhouses') }}" />
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
                                        <input type="text" id="hub_id" name="hub_id" class="form-input"  required="required" value="{{ $value->hub_id }}" />
                                         @error('hub_id')
                                           <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                                         @enderror
                                      </div>

                                      

                                       <input type="hidden" name="user_id" id="user_id" value="{{$value->id}}"> 

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
                              <th>Range</th>
                              <th>Threshold</th>
                              <th>Min</th>
                              <th>Max</th>
                              <th>X-value</th>
                             
                        </tr>
                         @foreach($podMaster as $pod => $value) 

                        <tr>
                          <td>{{$value->data_frame}}</td>
                          <td>{{$value->description}}</td>
                          <td><input type="text"  id="range" value="{{$value->range}} "></td>
                          
                          <td><input type="text" name="{{$value->data_frame}}" id="threshold" value="{{$value->threshold}}"></td>

                          <td ><input type="Number" name="min_{{$pod}}" id="min_{{$pod}}" value="{{($value->min)=='0'?'':$value->min}}"  style="width: 70px"; onchange="addValue(this.value, '{{$pod}}', 'min')"></td>

                          <td><input type="Number" name="max_{{$pod}}" id="max_{{$pod}}" value="{{($value->max)=='0'?'':$value->max}}" style="width: 70px"; onchange="addValue(this.value, '{{$pod}}', 'max')"></td>

                          <td><input type="Number" name="x_value_{{$pod}}" id="x_value_{{$pod}}" value="{{($value->x_value)=='0'?'':$value->x_value}}" style="width: 70px"; onchange="addValue(this.value, '{{$pod}}', 'x_value')"> </td>

                           <!-- <input type="text" name="test" value="" id="hide_{{$pod}}"/> -->
                            <td>
                           <input type="hidden" name="{{$value->data_frame}}" value="{{$value->min}} - {{$value->max}} - {{$value->x_value}}" id="hide_{{$pod}}"/>
                          </td>


                        </tr>
                       

                          @endforeach   
                            
                        </table>
                       
                    </div> 

                   
                    <div>
                      <button class=" btn-primary rounded-pill " type="submit" name="action" value=" Add">Add POD </button>
                      <button class=" rounded-pill " type="submit" name="action" value=" cancel">Cancel </button>
                    </div>
               
                

               </form>

              </div>
            


                            </div>
                          </div>
                        </div>
                      </div>

                      
  
                     
                     @endforeach
                      
                  </div>
                   
                </div>
             </div>   
        </div>


        <div class="col-sm-6 col-md-8 ">
             <div class="card table-responsive">
                
              <table class="table"> 

                  <tr >
                    <th>Sl.no</th>
                    <th>POD ID</th>
                    <th>POD Location</th>
                    <th>Number of Ployhouses</th>

                  </tr>
                    
                 
                   @foreach ($pods_list as $key => $value)
                  
                  <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$value->pod_id}}</td>
                    <td>{{$value->location}}</td>
                    <td>{{$value->polyhouses}}</td>
                    <td></td>
                    <td>
                       <a href="{{route('view_pod',$value->pod_id)}}"> 
                        <label class="curved-text">view</label>
                       </a>
                    </td>

                  </tr>

                @endforeach
              </table>   
        </div>


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

    /*if(field == 'min'){
     
     
     min=($('#min_'+pod).val());

     $("#hide_"+pod).val(val);  
    }

     if(field == 'max'){

      min=($('#min_'+pod).val());
      max=($('#max_'+pod).val());

     $("#hide_"+pod).val(min + " - "+max);  
    }

    if(field == 'x_value'){

    
      min=($('#min_'+pod).val());
      max=($('#max_'+pod).val());
      x=($('#x_value_'+pod).val());

      $("#hide_"+pod).val(min + " - "+max +" - "+x); 
    }
*/

  }


    /* $(function () {
        $("#btnCopy").click(function () {
            //Reference the TextBox.
            var txtName = $("#pod_name");
 
            //Reference the Label.
            var lblName = $("#pods");

            var label = $("#pods")
            var text = label.text();

           // alert(text);

            if(text==''){
               lblName.html(txtName.val());
               document.getElementById("podnames").value = txtName.val();
            }
            else
            {
               lblName.html(text+" , "+txtName.val());
               document.getElementById("podnames").value = text+" , "+txtName.val();
            }
          
           
           
             document.getElementById("pod_name").value = "";
        });
    });*/
</script>
</body>


@endsection
