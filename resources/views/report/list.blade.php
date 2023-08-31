@extends('layouts.app')

@section('content')

<div class="container-body">
    <div class="container-header">
      
      <div >
        <label class="label-bold">Reports </label> 
      </div>
      <label class="date">{{date('d M ,Y')}} </label>

      @if(Session::has('message'))
         <p id="mydiv" class="text-danger text-center">{{ Session::get('message') }}</p>  
      @endif


    </div>

  <div class="page-container" style="margin-top: 20px">
    
      <table class="table">
        <tbody>
          <tr>
            <th>User Name</th>
            <th>Mobile</th>
            <th>Crop Category</th>
            <th>Crop Name</th>
            <th>Duration</th>
            <th>Channel Used</th>
            <th>Seeds Planted</th>
            <th>Planted Date</th>
            <th>Expected Quantity</th>
            <th>Produced Quantity</th>
            <th>Yield Status</th>
           
          </tr>
        </tbody> 
        <tbody>
          @foreach($data as $key=>$value)
              <tr>
                <td>{{$value['user_name']}}</td>
                <td>{{$value['mobile']}}</td>
                <td>{{$value['category']}}</td>
                <td>{{$value['crop_name']}}</td>
                <td>{{$value['duration']}} days</td>
                <td>{{$value['channel']}}/3 of a Channel</td>
                <td>{{$value['seeds_quantity']}}</td>
                <td>{{date("d M Y", strtotime($value['planted_date']))}}</td>
                <td>{{$value['expected_quantitiy']}}kg</td>
                <td>{{$value['actual_quantity']}}kg</td>
                <td>{{$value['status']}}</td>
                <td>
                  <a href="#" id="MybtnModal_{{$key}}"><button class="btn btn-sm btn-outline-success">View More</button></a>
                </td>
              </tr>

               <!-- Modal -->
                <div class="modal" id="modal_{{$key}}" >
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">REPORT</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                          <div><label>User Name : </label> <label style="font-weight: bold;">{{$value->user_name}}</label></div>
                          <div><label>Mobile Number : </label> <label style="font-weight: bold;">{{$value->mobile}}</label></div>
                          <div><label>Email ID : </label> <label style="font-weight: bold;">{{$value->email}}</label></div>
                          <div><label>Crop Category : </label> <label style="font-weight: bold;">{{$value->category}}</label></div>
                          <div><label>Crop Name : </label> <label style="font-weight: bold;">{{$value->crop_name}}</label></div>
                          <div><label>Crop Duration : </label> <label style="font-weight: bold;">{{$value->duration}} days</label></div>
                          <div><label>Channels used : </label> <label style="font-weight: bold;">{{$value->channel}}/3 of a Channel</label></div>
                          <div><label>Seeds Planted : </label> <label style="font-weight: bold;">{{$value->seeds_quantity}}</label></div>
                          <div><label>Planted Date : </label> <label style="font-weight: bold;">{{date("d M Y", strtotime($value['planted_date']))}}</label></div>
                          <div><label>Pruning Date : </label> <label style="font-weight: bold;">{{date("d M Y", strtotime($value['pruning_date']))}}</label></div>
                          <div><label>Staking Date : </label> <label style="font-weight: bold;">{{date("d M Y", strtotime($value['staking_date']))}}</label></div>
                          <div><label>Nutrition Addition Date : </label > <label style="font-weight: bold;">{{date("d M Y", strtotime($value['nutrition_date']))}}</label></div>
                          <div><label>Spray 1 Date : </label> <label style="font-weight: bold;">{{date("d M Y", strtotime($value['spray1_date']))}}</label></div>
                          <div><label>Spray 2 Date : </label> <label style="font-weight: bold;">{{date("d M Y", strtotime($value['spray2_date']))}}</label></div>
                          <div><label>Spray 3 Date : </label> <label style="font-weight: bold;">{{date("d M Y", strtotime($value['spray3_date']))}}</label></div>
                          <div><label>Nutritions Used : </label> <label style="font-weight: bold;">{{$value->nutritions}}</label></div>
                          <div><label>Pesticides Used : </label> <label style="font-weight: bold;">{{$value->pesticides}}</label></div>
                          <div><label>Avg Ambian Temperature : </label> <label style="font-weight: bold;">{{$value->avg_ab}}</label><span> &#176;C</span></div>
                          <div><label>Avg POD Temperature : </label> <label style="font-weight: bold;">{{$value->avg_pod}}</label><span> &#176;C</span></div>
                          <div><label>Avg TDS Value : </label> <label style="font-weight: bold;">{{$value->avg_tds}}</label><span> mg/L</span></div>
                          <div><label>Avg pH value : </label> <label style="font-weight: bold;">{{$value->avg_ph}}</label></div>
                          <div><label>Avg Nutrition Temperature : </label> <label style="font-weight: bold;">{{$value->avg_nut}}</label><span> &#176;C</span></div>
                          <div><label>Harvesting Ddate : </label> <label style="font-weight: bold;">{{$value->harvesting_date}}</label></div>
                          <div><label>Expected Yield Quantitiy : </label> <label style="font-weight: bold;">{{$value->expected_quantitiy}}kg</label></div>
                          <div><label>Produced Quantity : </label> <label style="font-weight: bold;">{{$value->actual_quantity}}kg</label></div>
                          <div><label>Grade 1 Yield : </label> <label style="font-weight: bold;">{{$value->grade1}}kg</label></div>
                          <div><label>Grade 2 Yield : </label> <label style="font-weight: bold;">{{$value->grade2}}kg</label></div>
                          <div><label>Grade 3 Yield : </label> <label style="font-weight: bold;">{{$value->grade3}}kg</label></div>
                          <div><label>Status : </label> <label style="font-weight: bold;">{{$value->status}}</label></div>
                          <div><label>Comments : </label> <label style="font-weight: bold;">{{$value->comments}}</label></div>
                          <div><label>Harvest Completion Date : </label> <label style="font-weight: bold;">{{date("d M Y", strtotime($value['created_at']))}}</label></div>
                          
                          <div class="modal-footer">
                            <a href="{{route('download',$value->id)}}"><button type="button" class="btn btn-sm btn-light btn-outline-success" data-bs-dismiss="modal">Download</button></a>
                            <button type="button" class="btn btn-sm btn-light btn-outline-primary" data-bs-dismiss="modal">Close</button>
                            
                          </div>
                       
                      </div>
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
      
    </div>
    
  </div>
  

</div>




@endsection