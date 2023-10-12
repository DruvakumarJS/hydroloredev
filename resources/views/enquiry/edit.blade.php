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
    <label class="label-bold">Edit Enquiry </label>
    <div id="div2">
      <a  href="{{route('enquiry')}}"><button class="btn btn-sm btn-outline-primary">View Enquiry</button></a>
    </div> 
    
  </div>

  <div class="page-container div-margin">
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
<script>
 $(document).ready(function() {
        $('select').selectpicker();
    });
</script> 

  
@endsection