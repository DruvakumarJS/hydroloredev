@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script> 
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script> 
<style type="text/css">
        .dropdown-toggle{
            height: 40px;
            width: 300px !important;
        }
    </style>  

<div class="container-body">
  <div class="container-header">
    <label>Enquiry List</label>
    <div id="div2">
      <a data-bs-toggle="modal" data-bs-target="#mymodal" href=""><button class="btn btn-sm btn-outline-primary">New Enquiry</button></a>
    </div> 
    
  </div>

  <div class="page-container div-margin">
    <div class="card">
      <table class="table">
        <thead>
          <tr>
            <th>Date</th>
            <th>Name</th>
            <th>Mobile</th>
            <th>Email</th>
            <th>Address</th>
            <th>Building type</th>
            <th>Installation Date</th>
            <th>Channels</th>
            <th>Crops</th>
            <th>Require Monitoring</th>
            <th>Comments</th>
          </tr>
        </thead>

        <tbody>
          @foreach($data as $key=>$value)
          <tr>
            <td>{{date('d M Y',strtotime($value->created_at))}}</td>
            <td>{{$value->firstname}} {{$value->lastname}}</td>
            <td>{{$value->mobile}}</td>
            <td>{{$value->email}}</td>
            <td>{{$value->address}}</td>
            <td>{{$value->type_of_building}}</td>
            <td>{{date('d M Y',strtotime($value->installation_date))}}</td>
            <td>{{$value->no_of_channels}}</td>
            <td>{{$value->crops_name}}</td>
            <td>{{$value->require_monitoring}}</td>
            <td>{{$value->comments}}</td>
            <td>
               <a id="updateModal_{{$key}}" href="#"><button class="btn btn-sm btn-outline-success">Edit</button></a>
            </td>
            <td>
              <a  href="{{route('convert_enquiry',$value->id)}}"><button class="btn btn-sm btn-outline-danger">Convert</button></a>
            </td>

          </tr>

                <div class="modal" id="updatemodal_{{$key}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                      <div class="modal-header"style="background-color: #00cc88">
              <h5 class="modal-title text-white">Edit Enquiry</h5>
                       <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                         
                      </div>
                      <div class="modal-body">
                           
                       <div class="form-build">
                        <div class="row">
                          <div class="col-6">
                            <form method="post" action="{{ route('update_enquiry',$value->id)}}" enctype="multipart/form-data" >
                              @method('PUT')
                              @csrf
                              
                              <div class="form-group row">
                                <label for="" class="col-4 col-form-label">First Name*</label>
                                <div class="col-7">
                                    <input class="form-control" name="firstname" type="text" placeholder="Enter First Name" value="{{$value->firstname}}" required>
                                </div>
                              </div>

                              <div class="form-group row">
                                <label for="" class="col-4 col-form-label">Last Name *</label>
                                <div class="col-7">
                                    <input class="form-control" name="lastname" type="text" placeholder="Enter Last Name"  value="{{$value->lastname}}" required>
                                </div>
                              </div>

                              <div class="form-group row">
                                <label for="" class="col-4 col-form-label">Email* </label>
                                <div class="col-7">
                                    <input class="form-control" name="email" type="text" placeholder="Enter Email ID" value="{{$value->email}}" required>
                                </div>
                              </div>

                              <div class="form-group row">
                                  <label for="" class="col-4 col-form-label">Mobile *</label>
                                  <div class="col-7">
                                      <input class="form-control" name="mobile" type="text" value="{{$value->mobile}}" placeholder="Enter Mobile Number" required>
                                  </div>
                                </div>

                              <div class="form-group row">
                                <label for="" class="col-4 col-form-label">Address * </label>
                                <div class="col-7">
                                  <textarea class="form-control" placeholder="address here..." name="address" required>{{$value->address}}</textarea>
                                </div>
                              </div>

                              <div class="form-group row">
                                <label for="" class="col-4 col-form-label">Building type *</label>
                                <div class="col-7">
                                 <select class="form-control form-select" name="type" required>
                                     <option value="">Select type </option>
                                     <option <?php echo($value->type_of_building == 'Single Floor')?'selected':'' ?> value="Single Floor">Single Floor</option>
                                     <option <?php echo($value->type_of_building == 'Duplex')?'selected':'' ?> value="Duplex">Duplex</option>
                                     <option <?php echo($value->type_of_building == 'Apartment')?'selected':'' ?> value="Apartment">Apartment</option>
                                     <option <?php echo($value->type_of_building == 'Other')?'selected':'' ?> value="Other">Other</option>
                                  </select>
                                </div>
                              </div>

                              <div class="form-group row">
                                  <label for="" class="col-4 col-form-label">No of Channels required</label>
                                  <div class="col-7">
                                      <input class="form-control" name="channels" type="text" placeholder="Enter no. of channels" value="{{$value->no_of_channels}}" >
                                  </div>
                              </div>
                              
                             <!--  <div class="form-group row">
                                  <label for="" class="col-4 col-form-label">Crops </label>
                                  <div class="col-7">
                                      <input class="form-control" name="crops" type="text" placeholder="Enter crop names" value="{{$value->crops}}"  >
                                  </div>
                              </div> -->

                               <div class="form-group row">
                                  <label for="" class="col-4 col-form-label">Crops </label>
                                  <div class="col-7">
                                    <select class="col-7 selectpicker" multiple name="crop[]">
                                      @php $crops_list = explode(',',$value->crops_id); @endphp
                                    @foreach($crops as $crop)
                                       
                                            <option <?php echo (in_array($crop->id, $crops_list))?'selected':'' ?> value="{{$crop->id}}">{{$crop->name}}</option>
                                       
                                    @endforeach
                                    </select>
                                    </div>
                                  
                                </div>

                               <!-- <div class="form-group row">
                                  <label for="" class="col-4 col-form-label">Crops </label>
                                  <div class="col-7">
                                    @php
                                      $crops3 = explode(',',$value->crops);
                                    @endphp
                                    @foreach($crops as $crop)
                                      <option >{{$crop->name}}</option>
                                    @endforeach   
                                  </div>
                                </div> -->

                             
                               <div class="form-group row">
                                  <label for="" class="col-4 col-form-label">Installation Date </label>
                                  <div class="col-7">
                                      <input class="form-control" name="date" type="date"  value="{{$value->installation_date}}">
                                  </div>
                                </div>

                              <div class="form-group row">
                                <label for="" class="col-4 col-form-label">Require Monitoring *</label>
                                <div class="col-7">
                                 <select class="form-control form-select" name="monitor" required>
                                     <option value="">Select type </option>
                                     <option <?php echo($value->require_monitoring == 'YES')?'selected':'' ?> value="YES">YES</option>
                                     <option <?php echo($value->require_monitoring == 'NO')?'selected':'' ?> value="NO">NO</option>
                                     
                                  </select>
                                </div>
                              </div>  
                              
                              <div class="form-group row">
                                <label for="" class="col-4 col-form-label">Comments * </label>
                                <div class="col-7">
                                  <textarea class="form-control" placeholder="address here..." name="comments" required>{{$value->comments}}</textarea>
                                </div>
                              </div>

                               <div class="modal-footer">
                                  <button type="submit" class="btn btn-sm btn-outline-success">Update </button>
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

          <script>
            $(document).ready(function(){
              $('#updateModal_{{$key}}').click(function(){

                $('#updatemodal_{{$key}}').modal('show');
              });
             
            });  
          </script> 

          
          @endforeach
        </tbody>
      </table>
      
    </div>
    
  </div>
  
</div>


<div class="modal" id="mymodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
          <div class="modal-content">
            <div class="modal-header" style="background-color: #00cc88">
              <h5 class="modal-title text-white">Enquiry</h5>
             <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               
            </div>
            <div class="modal-body">
                 
             <div class="form-build">
              <div class="row">
                <div class="col-6">
                  <form method="post" action="{{ route('save_enquiry')}}" enctype="multipart/form-data" >
                    @csrf
                    
                    <div class="form-group row">
                      <label for="" class="col-4 col-form-label">First Name*</label>
                      <div class="col-7">
                          <input class="form-control" name="firstname" type="text" placeholder="Enter First Name" required>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="" class="col-4 col-form-label">Last Name *</label>
                      <div class="col-7">
                          <input class="form-control" name="lastname" type="text" placeholder="Enter Last Name"  required>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="" class="col-4 col-form-label">Email* </label>
                      <div class="col-7">
                          <input class="form-control" name="email" type="text" placeholder="Enter Email ID" required>
                      </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-4 col-form-label">Mobile *</label>
                        <div class="col-7">
                            <input class="form-control" name="mobile" type="text" placeholder="Enter Mobile Number" required>
                        </div>
                      </div>

                    <div class="form-group row">
                      <label for="" class="col-4 col-form-label">Address * </label>
                      <div class="col-7">
                        <textarea class="form-control" placeholder="address here..." name="address" required></textarea>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="" class="col-4 col-form-label">Building type *</label>
                      <div class="col-7">
                       <select class="form-control form-select" name="type" required>
                           <option value="">Select type </option>
                           <option value="Single Floor">Single Floor</option>
                           <option value="Duplex">Duplex</option>
                           <option value="Apartment">Apartment</option>
                           <option value="Other">Other</option>
                        </select>
                      </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-4 col-form-label">No of Channels required</label>
                        <div class="col-7">
                            <input class="form-control" name="channels" type="text" placeholder="Enter no. of channels"  >
                        </div>
                    </div>
                    
                  
                    <div class="form-group row">
                      <label for="" class="col-4 col-form-label">Crops </label>
                      <div class="col-7">
                        <select class="col-7 selectpicker" multiple name="crop[]">
                        @foreach($crops as $crop)
                           
                                <option value="{{$crop->id}}">{{$crop->name}}</option>
                           
                        @endforeach
                        </select>
                        </div>
                      
                    </div>


                     <div class="form-group row">
                        <label for="" class="col-4 col-form-label">Installation Date </label>
                        <div class="col-7">
                            <input class="form-control" name="date" type="date"  >
                        </div>
                      </div>

                    <div class="form-group row">
                      <label for="" class="col-4 col-form-label">Require Monitoring *</label>
                      <div class="col-7">
                       <select class="form-control form-select" name="monitor" required>
                           <option value="">Select type </option>
                           <option value="YES">YES</option>
                           <option value="NO">NO</option>
                           
                        </select>
                      </div>
                    </div>  
                    
                    <div class="form-group row">
                      <label for="" class="col-4 col-form-label">Comments * </label>
                      <div class="col-7">
                        <textarea class="form-control" placeholder="address here..." name="comments" required></textarea>
                      </div>
                    </div>

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

<script>
  $(document).ready(function(){
    $('#updateModal').click(function(){

      $('#updatemodal').modal('show');
    });
  }); 


</script>   
<script>
 $(document).ready(function() {
        $('select').selectpicker();
    });
</script>   
@endsection