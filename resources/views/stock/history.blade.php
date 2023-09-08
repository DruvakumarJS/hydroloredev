@extends('layouts.app')

@section('content')

<div class="container-body">
    <div class="container-header">
      
      <div >
        <label class="label-bold">Stocks Import Details </label>
        
      </div>
      <label class="date">{{date('d M ,Y')}} </label>

      <div id="div2">
        <a href="{{route('stocks')}}"><button class="btn btn-sm btn-outline-primary">Back to Stocks</button></a>
      </div>

      <div class="modal" id="mymodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Add Stock</h5>
             <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               
            </div>
            <div class="modal-body">
                 
             <div class="form-build">
              <div class="row">
                <div class="col-6">
                  <form method="post" action="{{route('save_stock')}}" enctype="multipart/form-data" >
                    @csrf
                    

                    <div class="form-group row">
                      <label for="" class="col-4 col-form-label">Nutrient Category*</label>
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
    
    <div class="card">
      <table class="table">
                    <tbody>
                      <tr>
                     
                        <th>Date</th>
                        <th>Category</th>
                        <th>Product</th>
                        <th>Brand</th>
                        <th>Weight</th>
                        <th>Expiry Date</th>
                        <th>Imported From</th>
                      </tr>
                    </tbody>

                    <tbody>
                      @foreach($history as $key=>$value)
                      <tr>
                        
                        <td>{{date('d M Y', strtotime($value->created_at))}}</td>
                        <td>{{$value->stockMaster->category}}</td>
                        <td>{{$value->stockMaster->product}}</td>
                        <td>{{$value->stockMaster->brand}}</td>
                        <td>{{$value->total_weight}} {{$value->measurement}}</td>
                        <td><?php echo ($value->expiry_date !='')?date('d M Y', strtotime($value->expiry_date)):'No Expiry'  ?></td>
                        <td>{{$value->source_of_import}}</td>
                      </tr>

                      @endforeach
                    </tbody>
                    
                  </table>
                   <label>Showing {{ $history->firstItem() }} to {{ $history->lastItem() }}
                                    of {{$history->total()}} results</label>

                                {!! $history->links('pagination::bootstrap-4') !!}
               
                 
      
    </div>
  
     
   </div>
  </div>




@endsection