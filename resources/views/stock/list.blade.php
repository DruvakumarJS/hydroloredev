@extends('layouts.app')

@section('content')
<style type="text/css">
 .image_placeholder{
   background: url('placeholder.jpg') no-repeat;
   background-position: center;
   
</style>


<div class="container-body">
    <div class="container-header">
      
      <div >
        <label class="label-bold">Stocks Management </label>
        
      </div>
      <label class="date">{{date('d M ,Y')}} </label>

      <div id="div2">
        <a data-bs-toggle="modal" data-bs-target="#mymodal" href=""><button class="btn btn-sm btn-outline-success">Add New Stock</button></a>

        <a  href="{{route('stock_history')}}"><button class="btn btn-sm btn-outline-primary">Stock Details</button></a>
      </div>

      <div class="modal" id="mymodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
          <div class="modal-content">
            <div class="modal-header"style="background-color: #00cc88">
              <h5 class="modal-title text-white">Add Stock</h5>
             <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               
            </div>
            <div class="modal-body">
                 
             <div class="form-build">
              <div class="row">
                <div class="col-6">
                  <form method="post" action="{{route('save_stock')}}" enctype="multipart/form-data" >
                    @csrf
                    

                    <div class="form-group row">
                      <label for="" class="col-4 col-form-label">Category*</label>
                      <div class="col-7">
                         <select class="form-control form-select" name="category" required>
                           <option value="">Select Category </option>
                           <option value="Spray">Spray</option>
                           <option value="Nutrition">Nutrition</option>
                           <option value="Seeds">Seeds</option>
                           <option value="others">others</option>
                         </select>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="" class="col-4 col-form-label">Product Name*</label>
                      <div class="col-7">
                          <input class="form-control" name="name" type="text" placeholder="Enter Product Name" required>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="" class="col-4 col-form-label">Product Brand *</label>
                      <div class="col-7">
                          <input class="form-control" name="brand" type="text" placeholder="Enter Brand Name"  required>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="" class="col-4 col-form-label">Weight/Volume/Count* </label>
                      <div class="col-7">
                          <input class="form-control" name="weight" type="number" placeholder="Enter Product Weight/Volume" required>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="" class="col-4 col-form-label">Measurement* </label>
                      <div class="col-7">
                         <select class="form-control form-select" name="measurement">
                           <option value="">Select</option>
                           <option value="kg">kg</option>
                           <option value="grams">grams</option>
                           <option value="liter">liter</option>
                           <option value="ml">ml</option>
                           <option value="numbers">numbers</option>
                         </select>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="" class="col-4 col-form-label">Expiry Date </label>
                      <div class="col-7">
                          <input class="form-control" name="expiry" type="date"  >
                      </div>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-4 col-form-label">Source of Import </label>
                        <div class="col-7">
                            <input class="form-control" name="source" type="text" placeholder="Enter Address of the Source"  >
                        </div>
                      </div>


                    <div class="form-group row">
                      <label for="" class="col-4 col-form-label">Product Comments * </label>
                      <div class="col-7">
                        <textarea class="form-control" placeholder="Comments here..." name="comments" required></textarea>
                      </div>
                    </div>



                    <div class="form-group row">
                      <label for="" class="col-4 col-form-label">Product Image </label>
                      <div class="col-7">
                        <input class="form-control" type="file" name="image">
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

    </div>


  <div class="page-container" style="margin-top: 20px">

  <div class="row">
   
      @foreach($stock as $key=>$value)
       <label class="label-bold">{{$value['category']}}</label>
       @foreach($value['prod'] as $key2=>$product )
       <div class="col-md-2">
       <div class="card" style="padding: 0px 0px 0px 0px">
        <img class="image_placeholder" src="<?php echo ($product['image']!='')? url('/').'/stockimages/'.$product['image'] :'' ?>" id="picture" class="card-img-top" style="height: 120px">
        <div class="card-body">
          <label class="label-bold">{{$product['product']}}</label>
          <div>
            <label style="font-size: 12px">{{$product['comments']}}</label>
          </div>
          <div>
            <label>Brand : {{$product['brand']}}</label>
          </div>
          
         <div>
            <label style="font-weight: bold">In Stocks : {{$product['available_weight']}} {{$product['measurement']}}</label>
          
         </div>
         <div id="div2" style="margin-top: 10px">

           <a id="MybtnModal_{{$key}}_{{$key2}}" href="#"><button class="btn btn-sm btn-outline-success">Edit</button></a>
           <a id="updateModal_{{$key}}_{{$key2}}" href="#"><button class="btn btn-sm btn-outline-primary">Update Stock</button></a>
           
         </div>
          
        </div>
      </div>
      </div>

      <div class="modal" id="modal_{{$key}}_{{$key2}}" >
              <div class="modal-dialog modal-xl">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit -{{$product['product']}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <div class="form-build">
                      <div class="row">
                        <div class="col-6">
                        <form method="post" action="{{route('update_stock',$product['id'])}}" enctype="multipart/form-data" >
                          @method('PUT')
                          @csrf
                            <div class="form-group row">
                              <label for="" class="col-4 col-form-label">Category*</label>
                              <div class="col-7">
                                 <select class="form-control form-select" name="category" required>
                                   <option value="">Select Category </option>
                                   <option <?php echo($value['category'] == 'Spray')?'selected':'' ?> value="Spray">Spray</option>
                                   <option <?php echo($value['category'] == 'Nutrition')?'selected':'' ?> value="Nutrition">Nutrition</option>
                                   <option <?php echo($value['category'] == 'Seeds')?'selected':'' ?> value="Seeds">Seeds</option>
                                   <option <?php echo($value['category'] == 'others')?'selected':'' ?> value="others">others</option>
                                 </select>
                              </div>
                            </div>

                            <div class="form-group row">
                              <label for="" class="col-4 col-form-label">Product Name*</label>
                              <div class="col-7">
                                  <input class="form-control" name="name" type="text" placeholder="Enter Product Name" value="{{$product['product']}}" required>
                              </div>
                            </div>

                            <div class="form-group row">
                              <label for="" class="col-4 col-form-label">Product Brand *</label>
                              <div class="col-7">
                                  <input class="form-control" name="brand" type="text" placeholder="Enter Brand Name" value="{{$product['brand']}}"  required>
                              </div>
                            </div>

                            <!-- <div class="form-group row">
                              <label for="" class="col-4 col-form-label">Weight/Volume/Count* </label>
                              <div class="col-7">
                                  <input class="form-control" name="weight" type="number" placeholder="Enter Product Weight/Volume" value="{{$product['weight']}}" disabled>
                              </div>
                            </div>

                            <div class="form-group row">
                              <label for="" class="col-4 col-form-label">Measurement* </label>
                              <div class="col-7">
                                 <select class="form-control form-select" name="measurement" disabled>
                                   <option value="">Select</option>
                                   <option <?php echo($product['measurement'] == 'kg')?'selected':''  ?> value="kg">kg</option>
                                   <option <?php echo($product['measurement'] == 'grams')?'selected':''  ?> value="grams">grams</option>
                                   <option <?php echo($product['measurement'] == 'liter')?'selected':''  ?> value="liter">liter</option>
                                   <option <?php echo($product['measurement'] == 'ml')?'selected':''  ?> value="ml">ml</option>
                                   <option <?php echo($product['measurement'] == 'numbers')?'selected':''  ?> value="numbers">numbers</option>
                                 </select>
                              </div>
                            </div>

                            <div class="form-group row">
                              <label for="" class="col-4 col-form-label">Expiry Date </label>
                              <div class="col-7">
                                  <input class="form-control" name="expiry" type="date" value="{{$product['expiry_date']}}" >
                              </div>
                            </div> -->

                            <div class="form-group row">
                              <label for="" class="col-4 col-form-label">Product Comments * </label>
                              <div class="col-7">
                                <textarea class="form-control" placeholder="Comments here..." name="comments" required>{{$product['comments']}}</textarea>
                              </div>
                            </div>

                            <div class="form-group row">
                              <label for="" class="col-4 col-form-label">Product Image </label>
                              <div class="col-7">
                                <input class="form-control" type="file" name="image">
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
            $('#MybtnModal_{{$key}}_{{$key2}}').click(function(){

              $('#modal_{{$key}}_{{$key2}}').modal('show');
            });
          });  
          </script>

          <script>
          $(document).ready(function(){
            $('#updateModal_{{$key}}_{{$key2}}').click(function(){

              $('#updatemodal_{{$key}}_{{$key2}}').modal('show');
            });
          });  
          </script>

         <div class="modal" id="updatemodal_{{$key}}_{{$key2}}" >
              <div class="modal-dialog modal-xl">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{$product['product']}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <div class="form-build">
                      <div class="row">
                        <div class="col-6">
                        <form method="post" action="{{route('update_stock_quantity',$product['id'])}}">
                          @method('PUT')
                          @csrf
                            
                            <div class="form-group row">
                              <label for="" class="col-4 col-form-label">Product Name*</label>
                              <div class="col-7">
                                  <input class="form-control" name="name" type="text" placeholder="Enter Product Name" value="{{$product['product']}}" disabled required>
                              </div>
                            </div>

                            <div class="form-group row">
                              <label for="" class="col-4 col-form-label">Product Brand *</label>
                              <div class="col-7">
                                  <input class="form-control" name="brand" type="text" placeholder="Enter Brand Name" value="{{$product['brand']}}" disabled required>
                              </div>
                            </div>

                            <div class="form-group row">
                              <label for="" class="col-4 col-form-label">Weight/Volume/Count* </label>
                              <div class="col-7">
                                  <input class="form-control" name="weight" type="number" placeholder="Enter Product Weight/Volume" required>
                              </div>
                            </div>

                            <div class="form-group row">
                              <label for="" class="col-4 col-form-label">Measurement* </label>
                              <div class="col-7">
                                 <select class="form-control form-select" name="measurement">
                                   <option value="">Select</option>
                                   <option value="kg">kg</option>
                                   <option value="grams">grams</option>
                                   <option value="liter">liter</option>
                                   <option value="ml">ml</option>
                                   <option value="numbers">numbers</option>
                                 </select>
                              </div>
                            </div>

                            <div class="form-group row">
                              <label for="" class="col-4 col-form-label">Expiry Date </label>
                              <div class="col-7">
                                  <input class="form-control" name="expiry" type="date"  >
                              </div>
                            </div>

                            <div class="form-group row">
                              <label for="" class="col-4 col-form-label">Source of Import </label>
                              <div class="col-7">
                                  <input class="form-control" name="Source" type="text" placeholder="Enter Address of the Source"  >
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


       @endforeach 
      @endforeach 
    
    
  </div>
     
   </div>
  </div>

@endsection