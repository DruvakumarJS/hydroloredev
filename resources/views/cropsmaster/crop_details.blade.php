@extends('layouts.app')

@section('content')

<div class="container-body">
    <div class="container-header">
      
      <div >
        <label class="label-bold">{{$data->name}}</label>
        
      </div>
      <label class="date">{{date('d M ,Y')}} </label>

      <div id="div2">
         <a data-bs-toggle="modal" data-bs-target="#exampleModal"  href="#"><button class="btn btn-sm btn-outline-success">Edit Crop</button></a>
      </div>

      <div id="div2" style="margin-right: 30px">
         <a href="{{route('Crop_master')}}"><button class="btn btn-sm btn-gray btn-outline-primary">View Crops</button></a>
      </div>

      <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-xl">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Crop</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form method="post" action="{{route('update_crop',$data->id)}}" enctype="multipart/form-data" >
                 @method('PUT') 
                 @csrf
               <div class="row">
                  <div class="col-md-4">
                   <div class="mb-3">
                    <label for="recipient-name" class="col-form-label">Category *</label>
                      <select class="form-control form-select" name="category" id="category" required onChange="check(this);">
                        <option value="">Select Category</option>
                        @foreach($category as $key=>$value)
                         <option <?php echo($value->id == $data->category_id)?'selected':'' ?> value="{{$value->id}}">{{$value->category_name}}</option>
                        @endforeach
                      </select>

                   </div>
                  </div>

                  <div class="col-md-4">
                   <div class="mb-3">
                    <label for="message-text" class="col-form-label">Crop Name *</label>
                     <input type="text" class="form-control" id="crop" name="crop" required placeholder="Enter Crop Name" value="{{$data->name}}">
                   </div>
                  </div>
                 
               </div>

               <div class="row">
                  <div class="col-md-4">
                  <div class="mb-3">
                    <label for="message-text" class="col-form-label">Season *</label>
                     <input type="text" class="form-control" id="season" name="season" placeholder="Enter Season" required value="{{$data->season}}">
                  </div>
                  </div>

                  <div class="col-md-4">
                  <div class="mb-3">
                    <label for="message-text" class="col-form-label">Crop Duration *</label>
                     <input type="text" class="form-control" id="duration" name="duration" placeholder="Enter Crop Duration " value="{{$data->duration}}" onkeypress="return isNumberKey(event)" required >
                  </div>

                  </div>
                 
               </div>

               <div class="row">
                  <div class="col-md-4">
                    <div class="mb-3">
                     <label for="message-text" class="col-form-label">Crop image *</label>
                     <input class="form-control" type="file" name="crops_img" accept="image/*" onchange="previewcropimage(event);" >
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="mb-3">

                     <img src="{{ URL::to('/') }}/crops/{{$data->image}}" id="crop_img" style="width: 70px;height: 70px;">
                      
                    </div>

                  </div>
                 
               </div>

                <div class="row" style="margin-top: 20px">
                  <div class="col-md-8">
                       
                        <textarea class="form-control" name="desc" placeholder="Enter Crop description here ...."  required >{{$data->description}}</textarea> 
                  </div>
               </div>

               <!-- <div class="row">
                  <div class="col-md-4">
                    <div class="mb-3">
                     <label for="message-text" class="col-form-label">Crop Icon *</label>
                     <input class="form-control" type="file" name="crops_icon" accept="image/*" onchange="previewcropicon(event);" required>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="mb-3">

                     <img src="" id="crop_icon" style="width: 70px;height: 70px;">
                      
                    </div>

                  </div>
                 
               </div> -->

               <label for="message-text" class="col-form-label label-bold ">Crop Cycle</label>

               <div class="row">
                  <div class="col-md-4">
                        <label>Seedling</label>
                        <input class="form-control" type="text" name="seedings" placeholder="approx. days range" value="{{$growth->seedling}}" onkeypress="return isNumberKey(event)" required>
                  </div>

                  <div class="col-md-4">
                  <div class="mb-3">
                    <label></label>
                   <input class="form-control" type="file" name="seedings_img"  accept="image/*" onchange="previewcropimage1(event);">
                  </div>

                  </div>
                  <img src="{{ URL::to('/') }}/growth/{{$growth->seeding_image}}" id="image1" style="width: 100px;height: 70px;">
                 
               </div>

               <div class="row">
                  <div class="col-md-4">
                        <label>Young Plants</label>
                        <input class="form-control" type="text" name="young_plant" placeholder="approx. days range" value="{{$growth->young_plants}}" onkeypress="return isNumberKey(event)" required>
                  </div>

                  <div class="col-md-4">
                  <div class="mb-3">
                    <label></label>
                   <input class="form-control" type="file" name="young_plant_img" accept="image/*" onchange="previewcropimage2(event);">
                  </div>
                    
                  </div>
                  <img src="{{ URL::to('/') }}/growth/{{$growth->young_image}}" id="image2"  style="width: 100px;height: 70px;">
               </div>
              
              <div id="matured">
                 <div class="row" >
                  <div class="col-md-4">
                        <label>Matured</label>
                        <input class="form-control" type="text"  id="mature" name="matured" placeholder="approx. days range" value="{{$growth->matured}}" onkeypress="return isNumberKey(event)">
                  </div>

                  <div class="col-md-4">
                  <div class="mb-3">
                    <label></label>
                   <input class="form-control" type="file" name="matured_img" accept="image/*" onchange="previewcropimage3(event);" >
                  </div>

                  </div>
                 <img src="{{ URL::to('/') }}/growth/{{$growth->matured_image}}" id="image3"  style="width: 100px;height: 70px;">
               </div>

              </div>
              
               <!-- vegetable -->
               <div id="vegetables" style="display: none">
               <div class="row" id="vegetative" >
                  <div class="col-md-4">
                        <label>Vegetative Phase</label>
                        <input class="form-control" type="text" name="vegetative" id="veget" placeholder="approx. days range" value="{{$growth->vegetative_phase}}" onkeypress="return isNumberKey(event)">
                  </div>

                  <div class="col-md-4">
                  <div class="mb-3">
                    <label></label>
                   <input class="form-control" type="file" name="vegetative_img" accept="image/*" onchange="previewcropimage4(event);" >
                  </div>

                  </div>
                 <img src="{{ URL::to('/') }}/growth/{{$growth->vegetative_image}}" id="image4"style="width: 100px;height: 70px;">
               </div>

               <div class="row" id="flowering" >
                  <div class="col-md-4">
                        <label>Flowering Stage</label>
                        <input class="form-control" type="text"  id="flower" name="flowering" placeholder="approx. days range" value="{{$growth->flowering_stage}}" onkeypress="return isNumberKey(event)">
                  </div>

                  <div class="col-md-4">
                  <div class="mb-3">
                    <label></label>
                   <input class="form-control" type="file" name="flowering_img" accept="image/*" onchange="previewcropimage5(event);">
                  </div>

                  </div>
                 <img src="{{ URL::to('/') }}/growth/{{$growth->flowering_image}}" id="image5"  style="width: 100px;height: 70px;">
               </div>

               <div class="row" id="fruit">
                  <div class="col-md-4">          
                        <label>Fruiting Stage</label>
                        <input class="form-control" type="text" id="fru" name="fruit" placeholder="approx. days range" value="{{$growth->fruiting_stage}}" onkeypress="return isNumberKey(event)">     
                  </div>

                  <div class="col-md-4">
                  <div class="mb-3">
                    <label></label>
                   <input class="form-control" type="file" name="fruit_img" accept="image/*" onchange="previewcropimage6(event);">
                  </div>

                  </div>
                 <img src="{{ URL::to('/') }}/growth/{{$growth->fruiting_image}}" id="image6"  style="width: 100px;height: 70px;">
               </div>
              </div>
               <!-- vegetable -->


               <div class="row">
                  <div class="col-md-4">
                        <label>Harvesting</label>
                        <input class="form-control" type="text" name="harvesting" placeholder="approx. days range" value="{{$growth->harvesting}}" onkeypress="return isNumberKey(event)" required>   
                  </div>

                  <div class="col-md-4">
                  <div class="mb-3">
                    <label></label>
                   <input class="form-control" type="file" name="harvesting_img" accept="image/*" onchange="previewcropimage7(event);">
                  </div>

                  </div >
                 <img src="{{ URL::to('/') }}/growth/{{$growth->harvesting_image}}" id="image7"  style="width: 100px;height: 70px;">
               </div>

               <label for="message-text" class="col-form-label label-bold ">Nutrition & Spray</label>

                 <div class="row">
                    <div class="col-md-4">
                          <label>Pruning (Day after planting)*</label>
                          <input class="form-control" type="number" min="1" name="pruning" placeholder="nth day after plantation" value="{{$data->pruning}}" required>   
                    </div>

                    <div class="col-md-4">
                     <label>Staking (Day after planting)*</label>
                          <input class="form-control" type="number" min="1" name="staking" placeholder="nth day after plantation" value="{{$data->staking}}" required>

                    </div>
                 
                 </div>

                  <div class="row" style="margin-top: 20px">
                    <div class="col-md-8">
                          <label>Pruning Steps *</label>
                          <textarea class="form-control" name="steps_pruning" placeholder="Enter Steps to be followed while Pruning"  required >{{$data->pruning_steps}}</textarea> 
                    </div>
                  </div>

                  <div class="row" style="margin-top: 20px">
                    <div class="col-md-8">
                          <label>Staking Steps *</label>
                          <textarea class="form-control" name="steps_staking" placeholder="Enter Steps to be followed while Staking"   required >{{$data->staking_steps}}</textarea> 
                    </div>
                  </div>

                  <div class="row" style="margin-top: 20px">
                    <div class="col-md-8">
                          <label>Nutrition Addition Steps *</label>
                          <textarea class="form-control" name="steps_nutrients" placeholder="Enter Steps to be followed while adding Nutrients"  required >{{$data->nutrients_addition_steps}}</textarea> 
                    </div>
                  </div>

                  <div class="row" style="margin-top: 20px">
                    <div class="col-md-8">
                          <label>Plant Protection Spray Steps</label>
                          <textarea class="form-control" name="steps_spray1" placeholder="Enter Steps to be followed while Spray 1" required >{{$data->spray1_steps}}</textarea> 
                    </div>
                  </div>

                  <div class="row" style="margin-top: 20px">
                    <div class="col-md-8">
                          <label>Crop Fertigation -1 Steps</label>
                          <textarea class="form-control" name="steps_spray2" placeholder="Enter Steps to be followed while Spray 2" required >{{$data->spray2_steps}}</textarea> 
                    </div>
                  </div>

                  <div class="row" style="margin-top: 20px">
                    <div class="col-md-8">
                          <label>Crop Fertigation -2 Steps</label>
                          <textarea class="form-control" name="steps_spray3" placeholder="Enter Steps to be followed while Spray 3" required >{{$data->spray3_steps}}</textarea> 
                    </div>
                  </div>

                <div class="modal-footer div-margin">
                    
                    <button type="submit" class="btn btn-success">Update</button>
                  </div>

              </form>

               
              </div>
              
            </div>
          </div>
        </div>
<!-- Modal -->

    </div>

    <div class="page-container" style="margin-top: 20px">
      
       <div class="row">
        <div class="col-md-4">
          <div class="card">
            <div class="card-header text-white" style="background-color: #00cc88; padding: 10px;font-weight: bolder;">Crop Detail</div>
            <div>
              <label>Category : </label> <label class="label-bold">{{$data->category->category_name}}</label>
            </div>

            <div>
              <label>Crop  : </label> <label class="label-bold">{{$data->name}}</label>
            </div>

            <div>
              <label>Season  : </label> <label class="label-bold">{{$data->season}}</label>
            </div>

            <div>
              <label>Duration  : </label> <label class="label-bold">{{$data->duration}} days</label>
            </div>

            <div>
              <label>Description  : </label>
            </div>
            <div>
              {{$data->description}}
            </div>
            
          </div>
          
        </div>

        <div class="col-md-4">
          <div class="card">
             <div class="card-header text-white" style="background-color: #00cc88; padding: 10px;font-weight: bolder;">Crop Growth Duration</div>
             <div>
               <label>Seeding : </label> <label class="label-bold">{{ $growth->seedling}} days</label>
             </div>

             <div>
               <label>Young Plant : </label> <label class="label-bold">{{ $growth->young_plants}} days</label>
             </div>

             <div>
               <label>Matured : </label> <label class="label-bold"><?php echo ($growth->matured!='0')?$growth->matured.' days':'--'  ?> </label>
             </div>

             <div>
               <label>Vegetative Phase : </label> <label class="label-bold"><?php echo ($growth->vegetative_phase!='0')?$growth->vegetative_phase.' days':'--'  ?> </label>
             </div>

             <div>
               <label>Flowering Stage : </label> <label class="label-bold"><?php echo ($growth->flowering_stage!='0')?$growth->flowering_stage.' days':'--'  ?> </label>
             </div>

             <div>
               <label>Fruiting Stage : </label> <label class="label-bold"><?php echo ($growth->fruiting_stage!='0')?$growth->fruiting_stage.' days':'--'  ?> </label>
             </div>

             <div>
               <label>Harvesting : </label> <label class="label-bold">{{ $growth->harvesting}} days</label>
             </div>

            
          </div>
          
        </div>

        <div class="col-md-4">
          <div class="card">
             <div class="card-header text-white " style="background-color: #00cc88; padding: 10px;font-weight: bolder;">Nutrients & Spray</div>

             <div>
               <label>Pruning : </label> <label class="label-bold">{{$data->pruning}}rd day after plantation</label>
             </div>

              <div>
               <label>Staking : </label> <label class="label-bold">{{$data->staking}}th day after plantation</label>
             </div>

              <div>
               <label>Nutrition Addition : </label> <label class="label-bold">10th day after plantation</label>
             </div>

              <div>
               <label>Spray 1 : </label> <label class="label-bold">30th day after plantation</label>
             </div>

              <div>
               <label>Spray 2 : </label> <label class="label-bold">10th day after Spray 1</label>
             </div>

              <div>
               <label>Spray 3 : </label> <label class="label-bold">10th day after Spray 2</label>
             </div>
          </div>
          
        </div>
         
       </div>

     
       
    </div>
 

</div>

<script type="text/javascript">


  document.getElementById("mature").required = true;

  function previewcropimage(event){
   
    var input = event.target;
     var image = document.getElementById('crop_img');
     if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
           image.src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
     }
  }

  function previewcropicon(event){
   
    var input = event.target;
     var image = document.getElementById('crop_icon');
     if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
           image.src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
     }
  }

  function previewcropimage1(event){
   
    var input = event.target;
     var image = document.getElementById('image1');
     if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
           image.src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
     }
  }

  function previewcropimage2(){
   
    var input = event.target;
     var image = document.getElementById('image2');
     if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
           image.src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
     }
  }

  function previewcropimage3(){
   
    var input = event.target;
     var image = document.getElementById('image3');
     if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
           image.src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
     }
  }

  function previewcropimage4(){
   
    var input = event.target;
     var image = document.getElementById('image4');
     if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
           image.src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
     }
  }

  function previewcropimage5(){
   
    var input = event.target;
     var image = document.getElementById('image5');
     if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
           image.src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
     }
  }

  function previewcropimage6(){
   
    var input = event.target;
     var image = document.getElementById('image6');
     if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
           image.src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
     }
  }

  function previewcropimage7(){
   
    var input = event.target;
     var image = document.getElementById('image7');
     if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
           image.src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
     }
  }

  

  function check(elem) {
   var cat = document.getElementById('category').value ;

   if(cat == 5){
    document.getElementById("matured").style.display = "none"
    document.getElementById("vegetables").style.display = "block"

    document.getElementById("mature").required = false;
    document.getElementById("veget").required = true;
    document.getElementById("flower").required = true;
    document.getElementById("fru").required = true;
    
   
   }
   else {
    document.getElementById("matured").style.display = "block"
    document.getElementById("vegetables").style.display = "none"

    document.getElementById("mature").required = true;
    document.getElementById("veget").required = false;
    document.getElementById("flower").required = false;
    document.getElementById("fru").required = false;
    
   }

   
}

function isNumberKey(evt)
  {
     var charCode = (evt.which) ? evt.which : event.keyCode
     if (charCode != 45  && charCode > 31 && (charCode < 48 || charCode > 57))
        return false;

     return true;
  }

</script>



@endsection