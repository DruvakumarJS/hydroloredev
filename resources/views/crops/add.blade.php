@extends('layouts.app')

@section('content')

<div class="container-body">
    <div class="container-header">
      
      <div >
        <label>POD ID : </label>
        <label class="label-bold">{{$id}}</label>
      </div>
      <label class="date">{{date('d M ,Y')}} </label>

    </div>

  <div class="page-container" style="margin-top: 20px">
      <div class="card">
         <h2 class="label-bold">Add Crops</h2>
       
        <div class="form-build">
          <div class="row">
            <div class="col-6">
            <form method="post" action="{{route('save_crop')}}">
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
                  <label for="" class="col-4 col-form-label">Plantion date *</label>
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
              
          </div>
            
        </div>
          
      </div>

      <div class="row">
        <label class="label-bold">My Crops</label>

       

      <div class="row justify-content-centre">
        @foreach($crops as $key=>$value)

       
        <div class="col-md-3 ">
          
          <div class="card">
            <div class="card-header text-align-centre">Channel - {{$value['channel_no']}}</div>
            @if($value['name']!='')
             <div class="row no-gutters" >
              <div class="col-md-5">
                <div class="" style="padding: 10px;">
                   <img src="{{ URL::to('/') }}/crops/{{$value['image']}}" style="width: 100px;height: 120px;">
                </div>
                
              </div>

              <div class="col-md-7">
                <div class="" style="padding-top: 10px">
                   <label style="font-size: 17px;font-weight: bolder;">{{$value['name']}}</label>
                   <div>
                     <img src="{{ URL::to('/') }}/crops/stage.svg" style="width: 10px;height: 10px;">
                     <label>{{$value['current_stage']}}</label>
                   </div>

                   <div>
                     <img src="{{ URL::to('/') }}/crops/calendar.svg" style="width: 10px;height: 10px;">
                     <label>Planted</label>
                     <label>{{date('d M Y', strtotime($value['planted_date']))}}</label>
                   </div>

                   <div style="margin-top: 30px;" >
                     <img src="{{ URL::to('/') }}/crops/info.svg" style="width: 10px;height: 10px;">
                     <label style="font-size: 10px">Harvesting season in {{$value['harvesting_date']}} days</label>
                     
                   </div>
                </div>
                
              </div>
               
             </div>
             @endif
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


@endsection