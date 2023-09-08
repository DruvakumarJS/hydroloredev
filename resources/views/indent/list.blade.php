@extends('layouts.app')

@section('content')

<div class="container-body">
    <div class="container-header">
      
      <div >
        <label class="label-bold">Indents </label>

      </div>
      <label class="date">{{date('d M ,Y')}} </label>

      <div id="div2">
        <a data-bs-toggle="modal" data-bs-target="#mymodal" href=""><button class="btn btn-sm btn-outline-primary">Export Indent</button></a>
      </div>

      <div class="modal" id="mymodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Export Indent</h5>
             <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               
            </div>
            <div class="modal-body">
                 
             <div class="form-build">
              <div class="row">
                
                <form method="post" action="" >
                 @csrf
                  
                  <div class="row">
                     <div class="col-md-3">
                      <div class="mb-3">
                        <label for="message-text" class="col-form-label">User*</label>
                         <input class="form-control" type="text" name="user" id="user">
                      </div>
                     </div>
                   </div>

                   <div class="row">
                    <div class="col-md-3">
                      <div class="mb-3">
                        <label for="message-text" class="col-form-label">Category*</label>
                         <select class="form-control form-select" name="category" id="category" onchange="myFunction()">
                           <option value="">Select Category</option>
                          @foreach($category as $key=>$val)
                           <option value="{{$val->category}}">{{$val->category}}</option>
                           @endforeach
                         </select>
                      </div>
                     </div> 
                   </div>

                   <div class="row">
                    <div class="col-md-3">
                      <div class="mb-3" >
                        <label for="message-text" class="col-form-label">Product Name *</label>
                        <div id="product">
                           <input class="form-control" type="text" name="product" id="product">
                        </div>
                        
                      </div>
                     </div>
                   </div>

                    <div class="row">
                     <div class="col-md-3">
                      <div class="mb-3">
                        <label for="message-text" class="col-form-label">Quantity in kg *</label>
                         <input class="form-control" type="number" name="qty">
                      </div>
                     </div>
                   </div>

                    <div class="row">
                      <div class="col-md-3">
                      <div class="mb-3">
                        <label for="message-text" class="col-form-label">Date *</label>
                         <input class="form-control" type="date" name="date" max="<?php echo date('Y-m-d'); ?>">
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

                    
                    
                  </table>
                   
                 
      
    </div>
  
     
   </div>
  </div>
<script type="text/javascript">

 $( document ).ready(function() {
   /*category dropdown*/ 
   /* $('select').on('change', function() {
    
      var category = $('#category').val();
      var path = "{{ route('getstocks') }}";

      $.ajax({
            url: path,
            type: 'GET',
            dataType: "json",
            data: {
               search: category
            },
            success: function( data ) {
              console.log(data);
              var response = data ;
              //var crops = $('#crop');

               var product = '<select class="form-control form-select" name="product"  required="required"> <option value=""> Select Product</option>'
          response.forEach(function(item) {
              
               //alert(item.name);
            product +=" <option value='"+item.id+"'>"+ item.product +" </option>";
           });
           product += '</select>'; 

           $('#product').html(product);
              
            }
          });

     });*/


    var path2 = "{{ route('getuser') }}";
   let text = "";
    $( "#user" ).autocomplete({
        source: function( request, response ) {
          $.ajax({
            url: path2,
            type: 'GET',
            dataType: "json",
            data: {
               search: request.term
            },
            success: function( data ) {
            
                 response( data );
   
             
            }
          });
        },
       
      });

  });


</script>




@endsection