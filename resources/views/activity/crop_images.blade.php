@extends('layouts.app')

@section('content')

<div class="container-body">
	<div class="container-header">
		<label>Crop Images</label>
		<div id="div2">
			<a href="{{route('channel_details', $id)}}"><button class="btn btn-sm btn-outline-primary">View Channel Details</button></a>
		</div> 
		
	</div>

	<div class="page-container div-margin">

    <div class="row no-gutters">
      @foreach($imagearray as $img)

      <div class="col-md-3 p-0 m-0" >
        <div class="card p-0 m-1"  >
          <img style="max-height: 300px" src="{{ URL::to('/') }}/activity/{{$img['imagename']}}" title="{{$img['comment']}}">
          
        </div>
       
      </div>

      @endforeach
      
    </div>
		
		
	</div>
	
</div>


  
@endsection