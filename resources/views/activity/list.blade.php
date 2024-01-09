@extends('layouts.app')

@section('content')

<div class="container-body">
    <div class="container-header">
      
      <div >
        <label class="label-bold">Channel Details </label>
        
      </div>
      <label class="date">{{date('d M ,Y')}} </label>

      @if(Session::has('message'))
         <p id="mydiv" class="text-danger text-center">{{ Session::get('message') }}</p>  
      @endif

      <div id="div2">
          <a data-bs-toggle="modal" data-bs-target="#mymodal" href=""><button class="btn btn-sm btn-danger">Mark as Completed</button></a>
      </div>

       <div id="div2" style="margin-right: 30px">
          <a href="{{route('view_crop_images',$cultivation->id)}}"><button class="btn btn-sm btn-outline-primary">View crop Images</button></a>
      </div>

      <div class="modal" id="mymodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Harvesting Details</h5>
             <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               
            </div>
            <div class="modal-body">
                 
             <div class="form-build">
              <div class="row">
                <div class="col-6">
                  <form method="post" action="{{route('save_harvesting_data')}}">
                    @csrf
                    <label class="label-bold">{{$cultivation->crop->name}} - </label>
                    <label >Channel {{$cultivation->channel_no}}{{$cultivation->sub_channel}} </label>
                    <div class="form-group row">
                      <label for="" class="col-4 col-form-label">Seeds / Sapling (weight / numbers)*</label>
                      <div class="col-5">
                          <input class="form-control" name="seeds" type="text" placeholder="Enter weight / numbers " required >
                      </div>
                      <div class="col-3">
                          <select class="form-control" name="uom" required>
                            <option value="">Select unit</option>
                            <option value="grams">Grams</option>
                            <option value="numbers">Numbers</option>
                          </select>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="" class="col-4 col-form-label">Channels used*</label>
                      <div class="col-8">
                         <select class="form-control form-select" name="channel" required>
                           <option value="">Select Channels usage</option>
                           <option value="3">Entire Channel</option>
                           <option value="1">1/3 of Channel</option>
                           <option value="2">2/3 of Channel</option>
                         </select>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="" class="col-4 col-form-label">Estimated Yield Quantity(in kgs) *</label>
                      <div class="col-8">
                          <input class="form-control" name="estimated_yield" type="number" placeholder="Enter Total Yield (in kgs)" required>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="" class="col-4 col-form-label">Total Yield Quantity(in kgs) *</label>
                      <div class="col-8">
                          <input class="form-control" name="total_yield" type="number" placeholder="Enter Total Yield (in kgs)"  required>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="" class="col-4 col-form-label">Grade 1(in kgs) </label>
                      <div class="col-8">
                          <input class="form-control" name="grade1" type="number" placeholder="Enter Grade 1 Yield (in kgs)" >
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="" class="col-4 col-form-label">Grade 2(in kgs) </label>
                      <div class="col-8">
                          <input class="form-control" name="grade2" type="number" placeholder="Enter Grade 2 Yield (in kgs)" >
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="" class="col-4 col-form-label">Grade 3(in kgs) </label>
                      <div class="col-8">
                          <input class="form-control" name="grade3" type="number" placeholder="Enter Grade 3 Yield (in kgs)">
                      </div>
                    </div>

                     <div class="form-group row">
                      <label for="" class="col-4 col-form-label">Nutrients used*</label>
                      <div class="col-8">
                          <textarea class="form-control" placeholder="Mention Nutrients name with quantity used" 
                          name="nutritions" required></textarea>
                      </div>
                    </div>

                     <div class="form-group row">
                      <label for="" class="col-4 col-form-label">Pesticides used*</label>
                      <div class="col-8">
                          <textarea class="form-control" placeholder="Mention Pesticides name with quantity used" name="pesticides" required></textarea>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="" class="col-4 col-form-label">Yield Status </label>
                      <div class="col-8">
                         <select class="form-control form-select" name="Status" required>
                            <option value="">Select Yield Status</option>
                            <option value="Excellent">Excellent</option>
                            <option value="Average">Average</option>
                            <option value="Poor">Poor</option>
                         </select>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="" class="col-4 col-form-label">Comments * </label>
                      <div class="col-8">
                        <textarea class="form-control" placeholder="Comments here..." name="comments" required></textarea>
                      </div>
                    </div>
                    <input type="hidden" name="user_id" value="{{$user->id}}">
                    <input type="hidden" name="c_id" value="{{$cultivation->id}}">

                     <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-outline-success">Save </button>
                        <button type="button" class="btn btn-sm btn-outline-primary"data-bs-dismiss="modal" aria-label="Close">Close</button>
                      </div>
                  </form>
                  
                </div>
                
              </div>
               
             </div>

            </div>

           
          </div>
        </div>
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