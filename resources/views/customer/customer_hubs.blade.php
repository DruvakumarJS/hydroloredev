@extends('layouts.app')

@section('content')

<body>
<div class="container-body">
    <div class="row justify-content-center">

        <h2 class="head-h1">HUBs</h2>
        <label class="date"> {{date('d M ,Y')}} </label>

     <div class="row">

        <div class="col-sm-6 col-md-4 ">
             <div class="input-group">

                <input class="form-control border-end-0 border" type="search" placeholder="HUB ID" id="example-search-input">
                <span class="input-group-append">
                    <button class="btn bg-white border-start-0 border-bottom-0 border ms-n5" type="button">
                        <i class="fa fa-search"></i>
                    </button>
                </span>
            </div>
                
        </div>

        <div class="col-sm-6 col-md-4 ">
            
        
            <div class="input-group">

                <input class="form-control border-end-0 border" type="search" placeholder="Choose POD ID" id="example-search-input">
                <span class="input-group-append">
                    <button class="btn bg-white border-start-0 border-bottom-0 border ms-n5" type="button">
                        <i class="fa fa-caret-down"></i>
                    </button>
                </span>
            </div>
                
        </div>
        
        
        <div class="col-sm-6 col-md-4 ">
            <div class="input-group">

                <input class="form-control border-end-0 border" type="search" placeholder="Current Date" id="example-search-input">
                
            </div>
                
        </div>
           
      </div>

   <div style="padding: 40px;">
    <!-- <div >
      <div class="row">
        <div class="col-sm-2">
             <h6 >Hub Dashboard</h6>
        </div>
        <div class="col-sm-2">
             <h6>Hub Dashboard</h6>
        </div>
       </div>
    </div> -->

      @foreach ($hubs_details as $key => $value) 
     
       <button type="button" class="collapsible"><i class="fa fa-plus" aria-hidden="true"></i>  {{$value->hub_name}} </button>

     

        <div class="collapsecontent">
        <label>PODs </label>
    
        <div class="card table-responsive" >
          
        
             @foreach($value->getpods as $pod => $pods_details) 
             <button type="button" class="collapsible"><i class="fa fa-plus" aria-hidden="true"></i> {{$pods_details->pod_id}} </button>

               <div class="collapsecontent">
               <label>{{$value->pod_id}}</label>
              

                  <div>
                    <div class="card table-responsive">
                        <table class="table">

                            <tr style="background-color:seagreen;color: white;">
                              <th>Device</th>
                              <th>Current Status</th>
                              <th>Status/Range</th>
                              <th>Trigger</th>
                             
                             
                        </tr>
                         @foreach($podMaster as $pod => $value) 

                          @php

                          $data_frame=$value->data_frame;

                          @endphp


                        <tr>
                         
                          <td>{{$value->description}}</td>
                          <td>{{$pods_details->$data_frame}}</td>
                          <td>{{$value->range}}</td>
                          
                          <td><input class="btn-success rounded-pill" type="button"  id="range" value="Update"></td>
                          
                        <!--   <td><input type="text" name="{{$value->data_frame}}" id="threshold" value="{{$value->threshold}}"></td>
                        -->
                        </tr> 
                       
                          @endforeach   
                            
                        </table>
                       
                    </div>   
                  </div>

                 
               </div>
          
         
            </tr>

        @endforeach    

         
          
        </div>
          </div>
     


      @endforeach  





 </div>    
     
</div> 
 


  

   </div>  

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
</body>  





@endsection