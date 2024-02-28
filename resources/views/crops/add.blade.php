@extends('layouts.app')

@section('content')

<style type="text/css">
  .card {
   
    border-radius: 20px;
    background-color: #FFFFFF;

    &:hover {
        box-shadow: 0 10px 20px rgba(0,0,0,.12), 0 4px 8px rgba(0,0,0,.06);
        .glyphicon {
            color: #48B0F7;
            background-color: #d4d7da;
        }
    }
}
</style>

<div class="container-body">
    <div class="container-header">
      
      <div >
        <label>POD ID : </label>
        <label class="label-bold">{{$id}}</label>
      </div>
      <label class="date">{{date('d M ,Y')}} </label>

    
    </div>

  <div class="page-container" style="margin-top: 20px">
      <div class="card" style="box-shadow: none">
         <h2 class="label-bold">Add Crops</h2>
       
        <div class="form-build">
          <div class="row">
            <div class="col-6">
            <form method="post" action="{{route('save_channel')}}">
              @csrf

              <div class="form-group row">
                  <label for="" class="col-4 col-form-label">Channel no *</label>
                  <div class="col-7">
                      <select class="form-select" name="channel_no" id="channel_no" required>
                         <option value="">select</option>
                         @foreach($channel as $i)
                      
                         <option value="{{$i}}">Channel - {{$i}}</option>

                         @endforeach
                        
                      </select>
                  </div>
              </div>

              <div class="form-group row">
                  <label for="" class="col-4 col-form-label">Sub Channel *</label>
                  <div class="col-7" >
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="A" name="sub_channel_a" >
                      <label class="form-check-label" for="flexCheckDefault">
                        Sub Channel A
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="B" name="sub_channel_b" >
                      <label class="form-check-label" for="flexCheckChecked">
                        Sub Channel B
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="C" name="sub_channel_c">
                      <label class="form-check-label" for="flexCheckChecked">
                        Sub Channel C
                      </label>
                    </div>

                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="D" name="sub_channel_d" >
                      <label class="form-check-label" for="flexCheckDefault">
                        Sub Channel D
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="E" name="sub_channel_e" >
                      <label class="form-check-label" for="flexCheckChecked">
                        Sub Channel E
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="F" name="sub_channel_f">
                      <label class="form-check-label" for="flexCheckChecked">
                        Sub Channel F
                      </label>
                    </div>
                    
                  </div>
              </div>

              <div class="form-group row">
                  <label for="" class="col-4 col-form-label">Crop Category *</label>
                  <div class="col-7">
                      <select class="form-select" name="category" id="category" required>
                         <option value="">select</option>
                        @foreach($category as $key=> $value)

                         <option value="{{$value->id}}">{{$value->category_name}}</option>
                        
                        @endforeach
                      </select>
                  </div>
              </div>

              <div class="form-group row">
                  <label for="" class="col-4 col-form-label">Crop Name *</label>
                  <div class="col-7" id="crop">
                      <input name="crop" id="crop" type="text" class="typeahead form-control" required="required"  placeholder="Select Crop">
                  </div>
              </div>

              <div class="form-group row">
                  <label for="" class="col-4 col-form-label">Planted date *</label>
                  <div class="col-7">
                       <input name="planted_on" id="planted_on" type="date" class="typeahead form-control" required="required" >
                  </div>
              </div>

              <input type="hidden" name="pod_id" value="{{$id}}">
              
              <div class="form-group row">
                  <label for="" class="col-4 col-form-label"></label>
                  <div class="col-7">
                      <button class="btn btn-sm btn-outline-success" type="Submit">Submit</button>
                  </div>
              </div>

            </form>

            </div>
            <div class="col-md-6">
               @if(Session::has('message'))
        @php
          $messages = Session::get('message') ;
        @endphp
          @foreach($messages as $value)
            <p id="mydiv" class="text-danger text-center">{{ $value }}</p>
          @endforeach  
        @endif

            </div>
              
          </div>
            
        </div>
          
      </div>

      <div class="row">
        <label class="label-bold">My Crops</label>
        
       
        <div class="row flex-nowrap scrollmenu">
          @foreach($crops as $key=>$value)
          <div class="col-md-3">
            <div class="card">
               <div class="card-header text-center">Channel - {{$value['channel_no']}}</div>
               
                @foreach($value['sub_chanel'] as $key2=>$value2)
                 
               
            <label style="font-size: 15px;font-weight: bold;">Channel - {{$value['channel_no']}}{{$value2['sub_channel']}}</label>
            @if($value2['name']!='')
             <div class="row no-gutters" >
              <div class="col-md-5">
                <div class="" style="padding: 10px;">
                   <img src="{{ URL::to('/') }}/crops/{{$value2['image']}}" style="width: 100px;height: 100px;">
                </div>
                
              </div>

              <div class="col-md-7">
                <div class="" style="padding-top: 10px; white-space: nowrap;overflow: hidden;text-overflow: ellipsis;">
                   <label style="font-size: 17px;font-weight: bolder;">{{$value2['name']}}</label>
                   <div>
                     <img src="{{ URL::to('/') }}/crops/stage.svg" style="width: 10px;height: 10px;">
                     <label>{{$value2['current_stage']}}</label>
                   </div>

                   <div>
                     <img src="{{ URL::to('/') }}/crops/calendar.svg" style="width: 10px;height: 10px;">
                     <label>Planted</label>
                     <label>{{date('d M Y', strtotime($value2['planted_date']))}}</label>
                   </div>

                   <div style="margin-top: 10px;margin-left: 2px" >
                     <img src="{{ URL::to('/') }}/crops/info.svg" style="width: 10px;height: 10px;">
                     <label style="font-size: 10px">Harvesting season <?php echo (str_starts_with($value2['harvesting_date'], '-'))?'': 'in '. $value2['harvesting_date'] .' days' ?> </label>
                     
                   </div>
                </div>
                
              </div>
               
             </div>

             <div class="row">
              <div class="col-md-4">
                <a href="#"  id="MybtnModal_{{$key}}_{{$key2}}" data-id="{{$value2['id']}}"><button class="btn btn-sm btn-outline-success" style="width: 100%">Edit</button></a>
              </div>
               <div class="col-md-4">
                <a href="{{route('channel_details',$value2['id'])}}" ><button class="btn btn-sm btn-outline-primary" style="width: 100%">Details</button></a>
              </div>
              <div class="col-md-4">
                <a onclick="return confirm('The crop will be removed from this channel.')" href="{{route('remove_channel',$value2['id'])}}"><button class="btn btn-sm btn-outline-danger" style="width: 100%">Remove</button></a>
              </div>
               
               
             </div>

             @else 
             <div style="height: 150px;">
               
             </div>
             @endif
             <hr style="height: 10px; background-color: green">

              <div class="modal" id="modal_{{$key}}_{{$key2}}" >
              <div class="modal-dialog modal-xl">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Channel - {{$value2['channel_no']}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <div class="form-build">
                      <div class="row">
                        <div class="col-6">
                        <form method="post" action="{{route('update_channel',$value2['id'])}}">
                          @method('PUT')
                          @csrf

                           <div class="form-group row">
                              <label for="" class="col-4 col-form-label">Channel no *</label>
                              <div class="col-7">
                                  <select class="form-select" name="channel_no" id="channel_no" required>
                                     <option value="{{$value['channel_no']}}">Channel - {{$value2['channel_no']}}</option>
                                     @foreach($channel as $j)
                                  
                                     <option value="{{$j}}" >Channel - {{$j}}</option>

                                     @endforeach
                                    
                                  </select>
                              </div>
                          </div>

                          <div class="form-group row">
                              <label for="" class="col-4 col-form-label">Sub Channel *</label>
                              <div class="col-7" >
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" value="A" name="sub_channel" <?php echo ($value2['sub_channel'] == 'A')?'checked':''  ?> onclick="onlyOne(this)">
                                  <label class="form-check-label" for="flexCheckDefault">
                                    Sub Channel A
                                  </label>
                                </div>
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" value="B" name="sub_channel" <?php echo ($value2['sub_channel'] == 'B')?'checked':''  ?> onclick="onlyOne(this)">
                                  <label class="form-check-label" for="flexCheckChecked">
                                    Sub Channel B
                                  </label>
                                </div>
                                <div class="form-check">
                                  <input class="form-check-input" type="checkbox" value="C" name="sub_channel" <?php echo ($value2['sub_channel'] == 'C')?'checked':''  ?> onclick="onlyOne(this)">
                                  <label class="form-check-label" for="flexCheckChecked">
                                    Sub Channel C
                                  </label>
                                </div>
                                
                              </div>
                          </div>

                          <script type="text/javascript">
                            function onlyOne(checkbox) {
                              var checkboxes = document.getElementsByName('sub_channel')
                              checkboxes.forEach((item) => {
                                  if (item !== checkbox) item.checked = false
                              })
                            }
                          </script>

                          <div class="form-group row">
                              <label for="" class="col-4 col-form-label">Crop Category *</label>
                              <div class="col-7">
                                  <select class="form-select" name="category" id="category_{{$key}}_{{$key2}}" required onchange="myFunction('{{$key}}_{{$key2}}')">
                                    
                                    @foreach($category as $key3=> $value3)

                                     <option <?php echo ($value3->id == $value2['category_id'])?'selected':''  ?> value="{{$value3->id}}">{{$value3->category_name}}</option>
                                    
                                    @endforeach
                                  </select>
                              </div>
                          </div>

                          <div class="form-group row">
                              <label for="" class="col-4 col-form-label">Crop Name *</label>
                              <div class="col-7" id="crop_{{$key}}_{{$key2}}">
                                  <select class="form-control" name="crop">
                                    <option  value="{{$value2['crop_id']}}" >{{$value2['name']}}</option> 
                                  </select>
                                  
                              </div>
                          </div>

                          <div class="form-group row">
                              <label for="" class="col-4 col-form-label">Planted date *</label>
                              <div class="col-7">
                                   <input name="planted_on" id="planted_on" type="date" class="typeahead form-control" required="required" value="{{$value2['planted_date']}}">
                              </div>
                          </div>

                          <input type="hidden" name="pod_id" value="{{$id}}">
                          
                          <div class="form-group row">
                              <label for="" class="col-4 col-form-label"></label>
                              <div class="col-7">
                                  <button class="btn btn-sm btn-outline-success" type="Submit">Submit</button>
                              </div>
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
          $(document).ready(function(){
            $('#MybtnModal_{{$key}}_{{$key2}}').click(function(){

              $('#modal_{{$key}}_{{$key2}}').modal('show');
            });
          });  
          </script>

                @endforeach 
                   
            </div>
            
          </div>



          @endforeach
          
        </div>
        
    </div>
        
  </div>

</div>

<script type="text/javascript">

 $( document ).ready(function() {
    
    $('select').on('change', function() {
    
      var category = $('#category').val();
      var path = "{{ route('getcrops') }}";
      
      $.ajax({
            url: path,
            type: 'GET',
            dataType: "json",
            data: {
               search: category
            },
            success: function( data ) {
              var response = data ;
              //var crops = $('#crop');

               var crops = '<select class="form-control form-select" name="crop"  required="required"> <option value=""> Select Crop</option>'
          response.forEach(function(item) {
              
               //alert(item.name);
            crops +=" <option value='"+item.id+"'>"+ item.name +" </option>";
           });
           crops += '</select>'; 

           $('#crop').html(crops);
              
            }
          });

     });

  });

  
  
</script>

<script>
function myFunction(id) {
 
    
      var category = $('#category_'+id).val();
      var path = "{{ route('getcrops') }}";
      
      $.ajax({
            url: path,
            type: 'GET',
            dataType: "json",
            data: {
               search: category
            },
            success: function( data ) {
            // alert("lll");
              var response = data ;
              //var crops = $('#crop');

               var crops = '<select class="form-control form-select" name="crop"  required="required"> <option value=""> Select Crop</option>'
          response.forEach(function(item) {
              
               //alert(item.name);
            crops +=" <option value='"+item.id+"'>"+ item.name +" </option>";
           });
           crops += '</select>'; 

           $('#crop_'+id).html(crops);
              
            }
          });

   
}
</script>


@endsection