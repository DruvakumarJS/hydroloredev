@extends('layouts.app')

@section('content')

<div class="container-body">
	<div class="container-header">
		<label>Header</label>
		<div id="div2">
			<a data-bs-toggle="modal" data-bs-target="#mymodal" href=""><button class="btn btn-sm btn-outline-primary">Modal</button></a>
		</div> 
		
	</div>

	<div class="page-container div-margin">
		<div class="card">
			<table>
				<thead>
					<tr>
						<th>Date</th>
						<th>Name</th>
					</tr>
				</thead>

				<tbody>
					<tr>
						<td></td>
						<td></td>
					</tr>
				</tbody>
			</table>
			
		</div>
		
	</div>
	
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
                  <form method="post" action="" enctype="multipart/form-data" >
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

<script>
	$(document).ready(function(){
		$('#updateModal').click(function(){

		  $('#updatemodal').modal('show');
		});
	});  
</script>      
@endsection