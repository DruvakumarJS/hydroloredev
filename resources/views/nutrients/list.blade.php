@extends('layouts.app')

@section('content')

<div class="container-body">
    <div class="container-header">
      
      <div >
        <label class="label-bold">Nutrients Master</label>
        
      </div>
      <label class="date">{{date('d M ,Y')}} </label>

    </div>

  <div class="page-container" style="margin-top: 20px">
   
   <div class="card div-margin">
    <table class="table">
       <tr>
          <th>User Name</th>
          <th>Mobile </th>
          <th>Email </th>
          <th>Nutritions</th>
          <th>Quantity</th>
          <th>Date</th>
          
       </tr>
       <tbody>
         @foreach($data as $key=>$value)
          <tr>
            <td>{{$value->user->firstname}} {{$value->user->lastname}}</td>
            <td>{{$value->user->mobile}}</td>
            <td>{{$value->user->email}}</td>
            <td>{{$value->nutrients}}</td>
            <td>{{$value->quantity}}kg</td>
            <td>{{date("d M Y", strtotime($value->issue_date))}}</td>
          </tr>

         @endforeach
       </tbody>

       

    </table> 
     
       
      
      
    </div>
     
   </div>
  </div>

</div>

@endsection