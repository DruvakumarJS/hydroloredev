@extends('layouts.app')

@section('content')

<div class="container-body">

  @if(session()->has('message'))
  <div class="alert alert-danger">
    {{ session()->get('message') }}
  </div>
  @endif

  <div>

   <h2 class="head-h1">Ticket ID : {{$id}}</h2>
   <label class="date">{{date('d M ,Y')}} </label>


 </div>



 <div class="form-body card-new">


   <div class="row mb-2">

     <div class="card col-md-3">
      <label class="label-head" for="hub_id" class="label-title">Hub ID</label>

      <h4 class="header-lab">{{$tickets->hub_id}}</h4>

    </div>

    @if(($tickets->pod_id)!=0)

    <div class="card col-md-3">
      <label class="label-head" for="subject" class="label-title">pod_id</label>
      <h4 class="header-lab">{{$tickets->pod_id}}</h4>

    </div>

    @endif


  </div>


  <div class="row mb-8">

    <div class="card col-md-6">
      <label class="label-head" for="subject" class="label-title">Subject</label>
      @php

      $issue=$tickets->subject;
      $array=explode('$', $issue);

      @endphp
      @foreach($array as $key => $val)
      <h4 class="header-lab">{{$val}}</h4>
      @endforeach
    </div>


  </div>

  @if(($tickets->current_value)!="")
  <div class="row mb-2">

    <div class="card col-md-3">
      <label class="label-head" for="hub_id" class="label-title">current_value</label>
      <h4 class="header-lab">{{$tickets->current_value}}</h4>

    </div>

  </div>
  @endif


  <div class="row  mb-2">

    <div class="card col-md-3">
      <label class="lable-head" for="subject" class="label-title">User Name</label>
      <h4 class="header-lab">{{$tickets->user->firstname}}</h4>
    </div>

    <div class="card col-md-3">
      <label class="label-head"for="hub_id" class="label-title">Phone number</label>
      <h4 class="header-lab">{{$tickets->user->mobile}}</h4>

    </div>

  </div>



  <div class="row mb-2">
    <div class="card col-md-6">
      <label class="lable-head" for="location" class="label-title">Location</label>
      <h4 class="header-lab">{{$tickets->user->location}}</h4>
    </div>

  </div>





  @if(Auth::user()->role_id == '1')
  <p class="header-lab">Modify Ticket Status</p>

  <form method="post" action="{{route('update_status')}}">
    @csrf

    <input type="radio" id="open" name="status" {{ $tickets->status == "0"  ? 'disabled' : '' }} {{ $tickets->status == "1"  ? 'checked' : '' }} value="1">
    <label for="open" >Open</label><br>

    <input type="radio" id="pending" name="status" {{ $tickets->status == "0"  ? 'disabled' : '' }} {{ $tickets->status == "2"  ? 'checked' : '' }}  value="2">
    <label for="pending">Pending</label><br>

    <input type="radio" id="close" name="status" {{ $tickets->status == "0"  ? 'disabled' : '' }} {{ $tickets->status == "0"  ? 'checked' : '' }}  value="0">
    <label for="close">Close</label>

    <input type="hidden" name="id" value="{{$id}}">



    <div>

      <div class="mt-3">
        <button class="btn btn-primary rounded-pill" type="submit" name="action" value=" Update" {{ $tickets->status == "0"  ? 'disabled' : '' }}>Update</button>
        <button class="btn rounded-pill " type="" name="action" value=" cancel">Cancel</button>
      </div>



    </div>

  </form>
  @endif

</div>





</div>


@endsection
