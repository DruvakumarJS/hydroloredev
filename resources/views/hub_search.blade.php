@extends('layouts.app')

@section('content')
<style>
	.row2{
  align-items: stretch;
  display: flex;
  flex-direction: row;
  flex-wrap: nowrap;
  overflow-x: auto;
  overflow-y: hidden;
}
.card{
  /*float: left;*/
  max-width: 33.333%;
  padding: .75rem;
  margin-bottom: 2rem;
  border: 0;
  flex-basis: 33.333%;
  flex-grow: 0;
  flex-shrink: 0;
}

.card > img {
  margin-bottom: .75rem;
  width: 100%;
}

.card-text {
  font-size: 85%;
}
/* Position the "next button" to the right */
.next {
  right: 0;
  border-radius: 3px 0 0 3px;
}

/* On hover, add a black background color with a little bit see-through */
.prev:hover, .next:hover {
  background-color: rgba(0,0,0,0.8);
}
</style>
<body>
<div class="container-body">
    <div class="row justify-content-center">
 
        <div>
            <h2 class="head-h1">Hub</h2>
            <label class="date"> {{date('d M ,Y')}} </label>     
        </div>

     <div class="card-body" style="background-color:white; margin: 20px;">
     	 <h3 class="card head-h1" style="float: right;margin-right: 10px; background: black;  color: white;">HUB ID : {{$hubid}} </h3>

     	@foreach($userdetails as $key=>$value)

     	<div>
     		<label class="header-lab">User Name : </label>
     		<label>{{$value->firstname}}</label>
         
     		<label class="header-lab" style="margin-left:30px" >Contact No : </label>
     		<label>{{$value->mobile}}</label>

     		<label class="header-lab" style="margin-left:30px">Registered On : </label>
     		<label>{{$value->created_at}}</label>
     	</div>
     	
     	<div>
     		
     		<label class="header-lab">No. of PODS : </label>
     		<label>{{sizeof($hubdata)}}</label>

     		<label class="header-lab" style="margin-left:30px" >Address : </label>
     		<label>{{$value->address}}</label>
     	</div>
     	@endforeach
     </div>

     <div class="card2-body" >

     	<div class="container">
		  <div class="row2">

		  	@foreach($hubdata as $key=>$value)
		    <div class="card" style="background-color:cadetblue;">
		      <label class="header-lab">{{$value->pod_id}}</label>	
		      
		      <div class="card-body" style="background-color:white;">

		      	   <div>
		      	   	<label>Location : </label>
		      	   	<label>{{$value->location}}</label>
		      	   </div>

		      	   <div>
		      	   	<label>Polyhouses : </label>
		      	   	<label>{{$value->polyhouses}}</label>
		      	   </div>

		      	   <div>
		      	   	<label>Created On : </label>
		      	   	<label>{{$value->Date}}</label>
		      	   </div>

		      	   <div>
		      	   	<label>Staus : </label>
		      	   	<label>{{$value->status}}</label>
		      	   </div>

		      	   <div>
		      	   	<label>CUR value : </label>
		      	   	<label>{{$value->CUR}}</label>
		      	   </div>

		      	    <div>
		      	   	<label>No of Tickets: </label>

		      	   	@php
		      	   	$tickets_counts=\App\Models\Ticket::where('pod_id',$value->pod_id)->get();
		      	   	$tickets_active=\App\Models\Ticket::where('pod_id',$value->pod_id)->where('status',1)->get();
		      	   	@endphp
		      	   	<label>{{sizeof($tickets_counts)}}</label>
		      	   </div>

		      	   <div>
		      	   	<label>Active Tickets : </label>
		      	   	<label>{{sizeof($tickets_active)}}</label>
		      	   </div>

		      	   <!-- <div>
		      	   	<label>Issue : </label>
		      	   	@php
		      	   	$tickets_active=\App\Models\Ticket::where('pod_id',$value->pod_id)->get();

		      	   	@endphp

		      	   	<label>{{sizeof($tickets_active)}}</label>
		      	   </div> -->

		      	    
 
		      </div>
		    </div>

		    @endforeach

		  </div>
		  
		</div>

     	
     </div>
      
       

      
         
    
 



</div>

<script>
var slideIndex = 1;
showDivs(slideIndex);

function plusDivs(n) {
  showDivs(slideIndex += n);
}

function showDivs(n) {
  var i;
  var x = document.getElementsByClassName("mySlides");
  if (n > x.length) {slideIndex = 1}
  if (n < 1) {slideIndex = x.length}
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";  
  }
  x[slideIndex-1].style.display = "block";  
}
</script>

 
      
   </body> 

  


@endsection
