@extends('layouts.app')

@section('content')

<div class="container-body">
    <div class="container-header">
      
      <div >
        <label>POD ID : </label>
        <label class="label-bold">{{$id}}</label>
      </div>
      <label class="date">{{date('d M ,Y')}} </label>

      @if(Session::has('message'))
            <p id="mydiv" class="text-danger text-center">{{ Session::get('message') }}</p>
        @endif

    </div>

  <div class="page-container" style="margin-top: 20px">
      <div class="card">
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
                  <div class="col-7">
                      <select class="form-select" name="sub_channel" id="channel_no" required>
                         <option value="">select</option>
                         <option value="A">A</option>
                         <option value="B">B</option>
                         <option value="C">C</option>
                         
                        
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
              
          </div>
            
        </div>
          
      </div>

      <div class="row">
        <label class="label-bold">My Crops</label>

        <div class="row">
           @foreach($crops as $key=>$value)
           <div class="col">
              <label>Chan{{$value['channel_no']}}</label>
            @foreach($value['sub_chanel'] as $key2=>$value2)
              @if($value2['id'] != '')
               <label>{{$value2['name']}}</label>
              @else
               <label>No Crop</label>
              @endif 
            @endforeach 
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