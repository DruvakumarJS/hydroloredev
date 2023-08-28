@extends('layouts.app')

@section('content')

<div class="container-body">
    <div class="container-header">
      
      <div >
        <label class="label-bold">Sensor Notification Master</label>
        
      </div>
      <label class="date">{{date('d M ,Y')}} </label>

      <div id="div2">
        <a data-bs-toggle="modal" data-bs-target="#add_modal" href=""><button class="btn btn-sm btn-outline-primary">Add New Solution</button></a>
      </div>

      <!-- Modal -->
        <div class="modal fade" id="add_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog ">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Sensor Solution</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form method="post" action="{{route('save_sensor_solution')}}" enctype="multipart/form-data" >
                 @csrf
                
               <div class="row">
                <div class="col">
                  <div class="mb-3">
                    <label for="message-text" class="col-form-label">Tittle *</label>
                     <input type="text" class="form-control"  name="tittle" placeholder="Enter Tittle" required>
                  </div>
                 </div>

               </div>

               <div class="row">
                <div class="col">
                  <div class="mb-3">
                    <label for="message-text" class="col-form-label">Issue *</label>
                     <input type="text" class="form-control"name="issue" placeholder="Enter Issue" required>
                  </div>
                 </div>

               </div>

               <div class="row">
                <div class="col">
                  <div class="mb-3">
                    <label for="message-text" class="col-form-label">Description *</label>
                    <input type="text" class="form-control" name="desc" placeholder="Enter Description for the Issue" required>
                  </div>
                 </div>

               </div>

               
               <div class="row">
                <div class="col">
                  <div class="mb-3">
                    <label for="message-text" class="col-form-label">Solution *</label>
                     
                      <textarea class="form-control" name="solution" placeholder="Enter Solution for the issue" required></textarea>
                  </div>
                 </div>

               </div>

               @php
                $sensors = ['AB_T1','POD_T1','TDS_V1','PH_V1','NUT_T1','NP_I1','SV_I1','STS_NP1','STS_SV1',
                'WL1L','WL2H','WL2L','WL3L','RL1','RL3','RL4'];
               @endphp
              
              <div class="row">
                <div class="col">
                  <div class="mb-3">
                    <label for="message-text" class="col-form-label">Sensor Parameter </label>
                     <select class="form-select form-control" name="param">
                      <option value="">Select Sensor Parameter</option>
                      @foreach($sensors as $value)
                      <option value="{{$value}}">{{$value}}</option> 
                      @endforeach
                     </select>
                  </div>
                 </div>

               </div>


               <div class="row">
                <div class="col">
                  <div class="mb-3">
                    <label for="message-text" class="col-form-label">Type *</label>
                     <select class="form-control form-select" name="type" required>
                      <option value="">Select alert type</option>
                       <option value="Alert">Alert</option>
                       <option value="Reminder">Reminder</option>
                       <option value="Notification">Notification</option>
                     </select>
                  </div>
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
   
   <div class="card div-margin">
    <table class="table">
       <tr>
          <th>Tittle</th>
          <th>Sensor Issue</th>
          <th>Description</th>
          <th>Solution</th>
          <th>Type</th>
          
       </tr>

       <tbody>
         @foreach($data as $key=>$value)
           <tr>
             <td width="150px">{{$value->tittle}}</td>
             <td width="250px">{{$value->issue}}</td>
             <td width="250px">{{$value->description}}</td>
             <td> <table>
                  <tbody>
                   @php
                      $sloution = $value->solution;
                      $data1 = explode('.',$sloution);

                     @endphp
                    @foreach($data1 as $sol)
                      
                            <tr>
                                <td>{{$sol}}.</td>
                            </tr>
                       
                    @endforeach
                  </tbody>
                </table>
              </td>
             
             <td>{{$value->type}}</td>
             <td>
               <a href="#" id="MybtnModal_{{$key}}"><button class="btn btn-sm btn-outline-primary">Edit</button></a>

             </td>
             <td><a onclick="return confirm('Are you sure to delete?')" href="{{route('delete_solution',$value->id)}}"><button class="btn btn-sm btn-outline-danger">Delete</button></a></td>
           </tr>

           <!-- Modal -->
            <div class="modal" id="modal_{{$key}}" >
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                <form method="post" action="{{route('update_sensor_solution',$value->id)}}" enctype="multipart/form-data" >
                 @method('PUT') 
                 @csrf
                
               <div class="row">
                <div class="col">
                  <div class="mb-3">
                    <label for="message-text" class="col-form-label">Tittle *</label>
                     <input type="text" class="form-control"  name="tittle" placeholder="Enter Tittle" value="{{$value->tittle}}" required>
                  </div>
                 </div>

               </div>

               <div class="row">
                <div class="col">
                  <div class="mb-3">
                    <label for="message-text" class="col-form-label">Issue *</label>
                     <input type="text" class="form-control"name="issue" placeholder="Enter Issue" value="{{$value->issue}}" required>
                  </div>
                 </div>

               </div>

               <div class="row">
                <div class="col">
                  <div class="mb-3">
                    <label for="message-text" class="col-form-label">Description *</label>
                    <input type="text" class="form-control" name="desc" placeholder="Enter Description for the Issue" value="{{$value->description}}" required>
                  </div>
                 </div>

               </div>

               <div class="row">
                <div class="col">
                  <div class="mb-3">
                    <label for="message-text" class="col-form-label">Solution *</label>
                     
                      <textarea class="form-control" name="solution" placeholder="Enter Solution for the issue"  required>{{$value->solution}}</textarea>
                  </div>
                 </div>

               </div>
                @php
                $sensors = ['AB_T1','POD_T1','TDS_V1','PH_V1','NUT_T1','NP_I1','SV_I1','STS_NP1','STS_SV1',
                'WL1L','WL2H','WL2L','WL3L','RL1','RL3','RL4'];
               @endphp

               <div class="row">
                <div class="col">
                  <div class="mb-3">
                    <label for="message-text" class="col-form-label">Type *</label>
                      <select class="form-select form-control" name="param">
                        <option value="">Select Sensor Parameter</option>
                        @foreach($sensors as $value2)
                        <option <?php echo ($value2 == $value->sensor_key)?'selected':'' ?> value="{{$value2}}">{{$value2}}</option> 
                        @endforeach
                     </select>
                  </div>
                 </div>

               </div>

               <div class="row">
                <div class="col">
                  <div class="mb-3">
                    <label for="message-text" class="col-form-label">Type *</label>
                     <select class="form-control form-select" name="type" required>
                      <option value="">Select alert type</option>
                       <option <?php echo($value->type == 'Alert')?'selected':'' ?> value="Alert">Alert</option>
                       <option <?php echo($value->type == 'Reminder')?'selected':'' ?> value="Reminder">Reminder</option>
                       <option <?php echo($value->type == 'Notification')?'selected':'' ?> value="Notification">Notification</option>
                     </select>
                  </div>
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

</div>

@endsection