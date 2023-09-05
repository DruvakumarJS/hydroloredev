@extends('layouts.app')

@section('content')
<style type="text/css">
  img[src=""] {
    display: none;
}
</style>

<div class="container-body">
    <div class="container-header">
      
      <div >
        <label class="label-bold">Crop Master</label>
        
      </div>
      <label class="date">{{date('d M ,Y')}} </label>
       

      <div id="div2">
         <a data-bs-toggle="modal" data-bs-target="#exampleModal"  href=""><button class="btn btn-sm btn-outline-success">Add New Crop</button></a>
      </div>

      <div id="div2">
         <form method="post" action="{{route('search_crop')}}" style="float:right; margin-right: 30px;">
          @csrf
              <div class="input-group">
                  <input class="form-control" type="text" placeholder="Search " name="search">
                  <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>
              </div>                  
          </form>
      </div> 
    <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-xl">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add New Crop</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form method="post" action="{{route('save_crop')}}" enctype="multipart/form-data" >
                 @csrf
               <div class="row">
                  <div class="col-md-4">
                   <div class="mb-3">
                    <label for="recipient-name" class="col-form-label">Category *</label>
                    <select class="form-control form-select" name="category" id="category" required onChange="check(this);">
                      <option value="">Select Category</option>
                      @foreach($category as $key=>$value)
                       <option value="{{$value->id}}">{{$value->category_name}}</option>
                      @endforeach
                    </select>

                   </div>
                  </div>

                  <div class="col-md-4">
                   <div class="mb-3">
                    <label for="message-text" class="col-form-label">Crop Name *</label>
                     <input type="text" class="form-control" id="crop" name="crop" required placeholder="Enter Crop Name">
                   </div>
                  </div>
                 
               </div>

               <div class="row">
                  <div class="col-md-4">
                  <div class="mb-3">
                    <label for="message-text" class="col-form-label">Season *</label>
                     <input type="text" class="form-control" id="season" name="season" placeholder="Enter Season" required>
                  </div>
                  </div>

                  <div class="col-md-4">
                  <div class="mb-3">
                    <label for="message-text" class="col-form-label">Crop Duration *</label>
                     <input type="text" class="form-control" id="duration" name="duration" placeholder="Enter Crop Duration "required>
                  </div>

                  </div>
                 
               </div>

               <div class="row">
                  <div class="col-md-4">
                    <div class="mb-3">
                     <label for="message-text" class="col-form-label">Crop image *</label>
                     <input class="form-control" type="file" name="crops_img" accept="image/*" onchange="previewcropimage(event);" required>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="mb-3">

                     <img src="" id="crop_img" style="width: 70px;height: 70px;">
                      
                    </div>

                  </div>
                 
               </div>

                <div class="row" style="margin-top: 20px">
                  <div class="col-md-8">
                       
                        <textarea class="form-control" name="desc" placeholder="Enter Crop description here ...." required ></textarea> 
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
                        <input class="form-control" type="text" name="seedings" placeholder="approx. days range" required>
                  </div>

                  <div class="col-md-4">
                  <div class="mb-3">
                    <label></label>
                   <input class="form-control" type="file" name="seedings_img"  accept="image/*" onchange="previewcropimage1(event);">
                  </div>

                  </div>
                  <img src="" id="image1" style="width: 100px;height: 70px;">
                 
               </div>

               <div class="row">
                  <div class="col-md-4">
                        <label>Young Plants</label>
                        <input class="form-control" type="text" name="young_plant" placeholder="approx. days range" required>
                  </div>

                  <div class="col-md-4">
                  <div class="mb-3">
                    <label></label>
                   <input class="form-control" type="file" name="young_plant_img" accept="image/*" onchange="previewcropimage2(event);">
                  </div>
                    
                  </div>
                  <img src="" id="image2"  style="width: 100px;height: 70px;">
               </div>
              
              <div id="matured">
                 <div class="row" >
                  <div class="col-md-4">
                        <label>Matured</label>
                        <input class="form-control" type="text"  id="mature" name="matured" placeholder="approx. days range" >
                  </div>

                  <div class="col-md-4">
                  <div class="mb-3">
                    <label></label>
                   <input class="form-control" type="file" name="matured_img" accept="image/*" onchange="previewcropimage3(event);" >
                  </div>

                  </div>
                 <img src="" id="image3"  style="width: 100px;height: 70px;">
               </div>

              </div>
              
               <!-- vegetable -->
               <div id="vegetables" style="display: none">
               <div class="row" id="vegetative" >
                  <div class="col-md-4">
                        <label>Vegetative Phase</label>
                        <input class="form-control" type="text" name="vegetative" id="veget" placeholder="approx. days range" >
                  </div>

                  <div class="col-md-4">
                  <div class="mb-3">
                    <label></label>
                   <input class="form-control" type="file" name="vegetative_img" accept="image/*" onchange="previewcropimage4(event);" >
                  </div>

                  </div>
                 <img src="" id="image4"style="width: 100px;height: 70px;">
               </div>

               <div class="row" id="flowering" >
                  <div class="col-md-4">
                        <label>Flowering Stage</label>
                        <input class="form-control" type="text"  id="flower" name="flowering" placeholder="approx. days range" >
                  </div>

                  <div class="col-md-4">
                  <div class="mb-3">
                    <label></label>
                   <input class="form-control" type="file" name="flowering_img" accept="image/*" onchange="previewcropimage5(event);">
                  </div>

                  </div>
                 <img src="" id="image5"  style="width: 100px;height: 70px;">
               </div>

               <div class="row" id="fruit">
                  <div class="col-md-4">          
                        <label>Fruiting Stage</label>
                        <input class="form-control" type="text" id="fru" name="fruit" placeholder="approx. days range" >     
                  </div>

                  <div class="col-md-4">
                  <div class="mb-3">
                    <label></label>
                   <input class="form-control" type="file" name="fruit_img" accept="image/*" onchange="previewcropimage6(event);">
                  </div>

                  </div>
                 <img src="" id="image6"  style="width: 100px;height: 70px;">
               </div>
              </div>
               <!-- vegetable -->


               <div class="row">
                  <div class="col-md-4">
                        <label>Harvesting</label>
                        <input class="form-control" type="text" name="harvesting" placeholder="approx. days range" required>   
                  </div>

                  <div class="col-md-4">
                  <div class="mb-3">
                    <label></label>
                   <input class="form-control" type="file" name="harvesting_img" accept="image/*" onchange="previewcropimage7(event);">
                  </div>

                  </div >
                 <img src="" id="image7"  style="width: 100px;height: 70px;">
               </div>

               <label for="message-text" class="col-form-label label-bold ">Nutrition & Spray</label>

                 <div class="row">
                    <div class="col-md-4">
                          <label>Pruning (Day after planting)*</label>
                          <input class="form-control" type="number" min="1" name="pruning" placeholder="nth day after plantation" required>   
                    </div>

                    <div class="col-md-4">
                     <label>Staking (Day after planting)*</label>
                          <input class="form-control" type="number" min="1" name="staking" placeholder="nth day after plantation" required>

                    </div>
                 
                 </div>

                  <div class="row" style="margin-top: 20px">
                    <div class="col-md-8">
                          <label>Pruning Steps *</label>
                          <textarea class="form-control" name="steps_pruning" placeholder="Enter Steps to be followed while Pruning" required ></textarea> 
                    </div>
                  </div>

                  <div class="row" style="margin-top: 20px">
                    <div class="col-md-8">
                          <label>Staking Steps *</label>
                          <textarea class="form-control" name="steps_staking" placeholder="Enter Steps to be followed while Staking" required ></textarea> 
                    </div>
                  </div>

                  <div class="row" style="margin-top: 20px">
                    <div class="col-md-8">
                          <label>Nutrition Addition Steps *</label>
                          <textarea class="form-control" name="steps_nutrients" placeholder="Enter Steps to be followed while adding Nutrients" required ></textarea> 
                    </div>
                  </div>

                  <div class="row" style="margin-top: 20px">
                    <div class="col-md-8">
                          <label>Plant Protection Spray Steps</label>
                          <textarea class="form-control" name="steps_spray1" placeholder="Enter Steps to be followed while Spray 1" required ></textarea> 
                    </div>
                  </div>

                  <div class="row" style="margin-top: 20px">
                    <div class="col-md-8">
                          <label>Crop Fertigation -1 Steps</label>
                          <textarea class="form-control" name="steps_spray2" placeholder="Enter Steps to be followed while Spray 2" required ></textarea> 
                    </div>
                  </div>

                  <div class="row" style="margin-top: 20px">
                    <div class="col-md-8">
                          <label>Crop Fertigation -2 Steps</label>
                          <textarea class="form-control" name="steps_spray3" placeholder="Enter Steps to be followed while Spray 3" required ></textarea> 
                    </div>
                  </div>

                
                <div class="modal-footer div-margin">
                    
                    <button type="submit" class="btn btn-success">Submit</button>
                  </div>

              </form>

               
              </div>
              
            </div>
          </div>
        </div>
<!-- Modal -->

    </div>

  <div class="page-container" style="margin-top: 20px">
    <form method="post" action="{{route('save_category')}}">
      @csrf
     
   </form> 

   <div class="card div-margin">
    <table class="table">
       <tr>
         
          <th>Crop</th>
          <th>Category</th>
          <th>Season</th>
          <th>Duration</th>
          <th>Description</th>
       </tr>

       <tbody>
         @foreach($data as $key=>$value)
           <tr>
            
             <td width="200px">{{$value->name}} </td>
             <td width="200px">{{$value->category->category_name}}</td>
             <td width="250px">{{$value->season}}</td>
             <td width="150px">{{$value->duration}} days</td>
             <td>{{$value->description}}</td>
             <td>
               <a href="{{route('crop_details',$value->id)}}"><button class="btn btn-sm btn-outline-primary">Details</button></a>
             </td>
             <td>
               <a onclick="return confirm('Are you sure to delete?')" href="{{route('delete_crop',$value->id)}}"><button class="btn btn-sm btn-outline-danger">Delete</button></a>
             </td>
           </tr>

           <!-- Modal -->
            <div class="modal" id="modal_{{$key}}" >
              <div class="modal-dialog modal-xl">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Crop</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                <form method="post" action="{{route('update_crop',$value->id)}}" enctype="multipart/form-data" >
                 @csrf
               <div class="row">
                  <div class="col-md-4">
                   <div class="mb-3">
                    <label for="recipient-name" class="col-form-label">Category *</label>
                    <select class="form-control form-select" name="category" id="category" required onChange="check(this);">
                      <option value="">Select Category</option>
                        @foreach($category as $key2=>$value2)
                          <option value="{{$value2->id}}" <?php echo ($value2->id == $value->category_id) ? 'selected':''  ?> >{{$value2->category_name}}</option>
                        @endforeach
                    </select>

                   </div>
                  </div>

                  <div class="col-md-4">
                   <div class="mb-3">
                    <label for="message-text" class="col-form-label">Crop Name *</label>
                     <input type="text" class="form-control" id="crop" name="crop" required placeholder="Enter Crop Name" value="{{$value->name}}">
                   </div>
                  </div>
                 
               </div>

               <div class="row">
                  <div class="col-md-4">
                  <div class="mb-3">
                    <label for="message-text" class="col-form-label">Season *</label>
                     <input type="text" class="form-control" id="season" name="season" placeholder="Enter Season" required value="{{$value->season}}">
                  </div>
                  </div>

                  <div class="col-md-4">
                  <div class="mb-3">
                    <label for="message-text" class="col-form-label">Crop Duration *</label>
                     <input type="text" class="form-control" id="duration" name="duration" placeholder="Enter Crop Duration "required value="{{$value->duration}}">
                  </div>

                  </div>
                 
               </div>

               <div class="row">
                  <div class="col-md-4">
                    <div class="mb-3">
                     <label for="message-text" class="col-form-label">Crop image *</label>
                     <input class="form-control" type="file" name="crops_img" accept="image/*" onchange="previewcropimage(event);" required>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <div class="mb-3">

                     <img src="{{ URL::to('/') }}/crops/{{$value2}}" id="crop_img" style="width: 70px;height: 70px;">
                      
                    </div>

                  </div>
                 
               </div>

               <label for="message-text" class="col-form-label label-bold ">Crop Cycle</label>

               <div class="row">
                  <div class="col-md-4">
                        <label>Seedling</label>
                        <input class="form-control" type="text" name="seedings" placeholder="approx. days range" required value=<?php echo (isset($value->growth->seedling)?$value->growth->seedling:'') ?> >
                  </div>

                  <div class="col-md-4">
                  <div class="mb-3">
                    <label></label>
                   <input class="form-control" type="file" name="seedings_img"  accept="image/*" onchange="previewcropimage1(event);">
                  </div>

                  </div>
                  <img src="" id="image1" style="width: 100px;height: 70px;">
                 
               </div>

               <div class="row">
                  <div class="col-md-4">
                        <label>Young Plants</label>
                        <input class="form-control" type="text" name="young_plant" placeholder="approx. days range" required value=<?php echo (isset($value->growth->young_plants)?$value->growth->young_plants:'') ?>>
                  </div>

                  <div class="col-md-4">
                  <div class="mb-3">
                    <label></label>
                   <input class="form-control" type="file" name="young_plant_img" accept="image/*" onchange="previewcropimage2(event);">
                  </div>
                    
                  </div>
                  <img src="" id="image2"  style="width: 100px;height: 70px;">
               </div>
              
              <div id="matured">
                 <div class="row" >
                  <div class="col-md-4">
                        <label>Matured</label>
                        <input class="form-control" type="text"  id="mature" name="matured" placeholder="approx. days range" value=<?php echo (isset($value->growth->matured)?$value->growth->matured:'') ?> >
                  </div>

                  <div class="col-md-4">
                  <div class="mb-3">
                    <label></label>
                   <input class="form-control" type="file" name="matured_img" accept="image/*" onchange="previewcropimage3(event);" >
                  </div>

                  </div>
                 <img src="" id="image3"  style="width: 100px;height: 70px;">
               </div>

              </div>
              
               <!-- vegetable -->
               <div id="vegetables" style="display: none">
               <div class="row" id="vegetative" >
                  <div class="col-md-4">
                        <label>Vegetative Phase</label>
                        <input class="form-control" type="text" name="vegetative" id="veget" placeholder="approx. days range" value=<?php echo (isset($value->growth->vegetative_phase)?$value->growth->vegetative_phase:'') ?> >
                  </div>

                  <div class="col-md-4">
                  <div class="mb-3">
                    <label></label>
                   <input class="form-control" type="file" name="vegetative_img" accept="image/*" onchange="previewcropimage4(event);" >
                  </div>

                  </div>
                 <img src="" id="image4"style="width: 100px;height: 70px;">
               </div>

               <div class="row" id="flowering" >
                  <div class="col-md-4">
                        <label>Flowering Stage</label>
                        <input class="form-control" type="text"  id="flower" name="flowering" placeholder="approx. days range" value=<?php echo (isset($value->growth->flowering_stage)?$value->growth->flowering_stage:'') ?> >
                  </div>

                  <div class="col-md-4">
                  <div class="mb-3">
                    <label></label>
                   <input class="form-control" type="file" name="flowering_img" accept="image/*" onchange="previewcropimage5(event);">
                  </div>

                  </div>
                 <img src="" id="image5"  style="width: 100px;height: 70px;">
               </div>

               <div class="row" id="fruit">
                  <div class="col-md-4">          
                        <label>Fruiting Stage</label>
                        <input class="form-control" type="text" id="fru" name="fruit" placeholder="approx. days range" value=<?php echo (isset($value->growth->fruiting_stage)?$value->growth->fruiting_stage:'') ?> >     
                  </div>

                  <div class="col-md-4">
                  <div class="mb-3">
                    <label></label>
                   <input class="form-control" type="file" name="fruit_img" accept="image/*" onchange="previewcropimage6(event);">
                  </div>

                  </div>
                 <img src="" id="image6"  style="width: 100px;height: 70px;">
               </div>
              </div>
               <!-- vegetable -->


               <div class="row">
                  <div class="col-md-4">
                        <label>Harvesting</label>
                        <input class="form-control" type="text" name="harvesting" placeholder="approx. days range" required value=<?php echo (isset($value->growth->harvesting)?$value->growth->harvesting:'') ?> >   
                  </div>

                  <div class="col-md-4">
                  <div class="mb-3">
                    <label></label>
                   <input class="form-control" type="file" name="harvesting_img" accept="image/*" onchange="previewcropimage7(event);">
                  </div>

                  </div >
                 <img src="" id="image7"  style="width: 100px;height: 70px;">
               </div>

               <div class="row">
                  <div class="col-md-8">
                       
                        <textarea class="form-control" name="desc" placeholder="Enter Crop description here ...." required >{{$value->description}}</textarea> 
                  </div>

                  
                 
               </div>

                <div class="modal-footer div-margin">
                    
                    <button type="submit" class="btn btn-success">Submit</button>
                  </div>

              </form>

               
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
       </tbody>


    </table> 
     <label>Showing {{ $data->firstItem() }} to {{ $data->lastItem() }}
                                    of {{$data->total()}} results</label>

                                {!! $data->links('pagination::bootstrap-4') !!}
       
      
      
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

</script>

@endsection