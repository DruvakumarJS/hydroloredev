@extends('layouts.app')

@section('content')

<div class="container-body">
    <div class="container-header">
      
      <div >
        <label class="label-bold">Channel Details </label>
        
      </div>
      <label class="date">{{date('d M ,Y')}} </label>
      <div>
        
      </div>

    </div>

  <div class="page-container" style="margin-top: 20px">
    
    <div class="row">
      <div class="col-md-4">
        <div class="card">
          <div>
             <label>User Name : </label> <label>{{$user->firstname}} {{$user->lastname}}</label>
          </div>

          <div>
             <label>Contact No. : </label> <label>{{$user->mobile}} </label>
          </div>

          <div>
             <label>Email ID : </label> <label>{{$user->email}} </label>
          </div>
          <div>
             <label>HUBl ID : </label> <label>{{$user->hub_id}} </label>
          </div>
        
          
        </div>
        
      </div>

      <div class="col-md-4">
        <div class="card">

          <div>
            <label>POD ID : </label> <label>{{$cultivation->pod_id}}</label>
          </div>

          <div>
            <label>Channel No : </label> <label>{{$cultivation->channel_no}}{{$cultivation->sub_channel}}</label>
          </div>

          <div>
            <label>Crop Name : </label> <label>{{$cultivation->crop->name}}</label>
          </div>

           <div>
            <label>Planted date : </label> <label>{{$cultivation->planted_on}}</label>
          </div>

        </div>
        
      </div>

      <label class="label-bold">Activities</label>

      <!-- <div class="row flex-nowrap scrollmenu">
        @foreach($data as $key=>$value)
        <div class="col-lg-3 mb-3 d-flex align-items-stretch" >
          <div class="card" style="<?php echo  ($value['date']!='')?'background-color: #ECECEC':''; ?>;width: 18rem;">
             <div class="card-header">{{$value['activity']}}</div>
             <div>
               <label>Expected Date: </label><label style="font-size: 13px;font-weight: bold;">{{date("d M Y", strtotime($value['expected_date']))}}</label>
             </div>

              <div>
               <label>Execution Date: </label><label style="font-size: 13px;font-weight: bold;"><?php echo ($value['date']!='')?date("d M Y", strtotime($value['date'])):''  ?></label>
             </div>

             <div>
               <label>Feedback: </label>
             </div>
             <label style="font-size: 13px;font-weight: bold;white-space: pre-line;">{{$value['feedback']}}</label>
              @php
                 $docx = explode(',',$value['documents']) ;
              @endphp

              <div class="row">
               
               @foreach ($docx as $image)
                  @if($image != '')
                  <div class="col-md-6" style="padding: 10px">
                    <a target="_blank" href="{{ URL::to('/') }}/activity/{{$image}}"><img src="{{ URL::to('/') }}/activity/{{$image}}" style="width: 120px ; height: 120px;"></a>
                  </div>
                   
                  @endif
              @endforeach
             </div>
            
          </div>
          
        </div>
       @endforeach 
      </div> -->
    
      <table class="table">
        <tbody>
          <tr>
            <th>Actitivity</th>
            <th>Expected Date</th>
            <th>Execution Date</th>
            <th>Feedback</th>
            <th>Documents</th>
          </tr>
        </tbody> 
        <tbody>
          @foreach($data as $key=>$value)
              <tr>
                <td>{{$value['activity']}}</td>
                <td>{{date("d M Y", strtotime($value['expected_date']))}}</td>
                <td> <?php echo ($value['date']!='')?date("d M Y", strtotime($value['date'])):''  ?></td>
                <td>{{$value['feedback']}}</td>
                @php
                 $docx = explode(',',$value['documents']) ;
                @endphp
                <td>
                  @foreach ($docx as $image)
                  @if($image != '')
                   <a target="_blank" href="{{ URL::to('/') }}/activity/{{$image}}"><img src="{{ URL::to('/') }}/activity/{{$image}}" style="width: 50px ; height: 50px;"></a>
                   @endif
                  @endforeach
                </td>
                
              </tr>
          @endforeach
        </tbody>
      </table>
      
    </div>
    
  </div>
  

</div>

@endsection