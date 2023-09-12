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

      <div id="div2" style="margin-right: 30px">
        <a  href="{{ route('stocks')}}"><button class="btn btn-sm btn-outline-primary">View Stock</button></a>
      </div>

      @if(Session::has('message'))
       <script type="text/javascript">
         $(document).ready(function(){
           
              $('#mymodal').modal('show');
          
          }); 
       </script>
      @endif 

      @if(Session::has('msg'))
       @php
          $messages = Session::get('msg') ;
       @endphp
          @foreach($messages as $value)
            <p id="mydiv" class="text-danger text-center">{{ $value }}</p>
          @endforeach  
      @endif

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
                
                <form method="post" action="{{route('save_indent')}}" >
                 @csrf
                  @if(Session::has('message'))
                    <p id="mydiv2" class="text-danger text-center">{{ Session::get('message') }}</p>
                  @endif

                  <div class="row">
                     <div class="col-md-3">
                      <div class="mb-3">
                         <input class="form-control" type="number" name="user" id="user" value="{{ old('user')}}" placeholder="Enter Mobile Number" required>
                      </div>   
                     </div>

                     <div class="col-md-3">
                      <div class="mb-3">
                        <a class="btn btn-sm btn-success" href="#" onclick="getuserdetails()">Get User Info</a>
                      </div>   
                     </div>
                   </div>
                   <span class="label-bold" id="user_info"></span>
                  
                  <div class="row">
                      <div class="col-md-3">
                      <div class="mb-3">
                        <label for="message-text" class="col-form-label">Date of Export*</label>
                         <input class="form-control" type="date" name="date" value="{{ old('date')}}" max="<?php echo date('Y-m-d'); ?>" required>
                      </div>
                     </div>
                    </div>
                  
                
                   <div class="row">
                    <div class="col-md-3">
                      <div class="mb-3">
                        <label for="message-text" class="col-form-label">Category*</label>
                          <select class="form-select" name="category" id="category" >
                           <option value="">Select Category</option>
                          @foreach($category as $key=>$val)
                           <option value="{{$val->category}}">{{$val->category}}</option>
                           @endforeach
                         </select>
                      </div>
                     </div> 

                    <div class="col-md-3">
                      <div class="mb-3" >
                        <label for="message-text" class="col-form-label">Product Name *</label>
                        <div id="products">
                           <input class="form-control" type="text" name="product_id" id="product_id" placeholder="Product name">
                        </div>
                        
                      </div>
                     </div>

                     <input type="hidden" name="product_name" id="product_name">

                     <div class="col-md-2">
                      <div class="mb-3">
                        <label for="message-text" class="col-form-label">.</label>
                        <input class="btn btn-outline-danger form-control" type= "button" value= "Check Stock" onclick= "saveInput()">

                      </div>
                     </div>

                   </div>
                   <label class="label-bold">Indents List </label>
                   <div id="cloneview">
                     
                   </div>

                    <input type="hidden" name="user_id" id="user_id" value="{{ old('user_id')}}">
                    

                     

                    <div class="modal-footer div-margin">
                        
                        <button type="submit" id="btn_submit" class="btn btn-success" >Submit</button>
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
                     
                        <th>User Name</th>
                        <th>Mobile </th>
                        <th>Product</th>
                        <th>Quantity issued</th>
                        <th>Date of Issue</th>
                        
                      </tr>
                    </tbody>
                    <tbody>
                      @foreach($data as $key => $value)
                       <tr>
                         <td>{{$value->user->firstname}} {{$value->user->lastname}}</td>
                         <td>{{$value->user->mobile}}</td>
                         <td>{{$value->stocks->product}}</td>
                         <td>{{$value->quantity}} {{$value->measurement}}</td>
                         <td>{{date('d M Y', strtotime($value->issue_date))}}</td>

                       </tr>
                      @endforeach
                    </tbody> 
                    
                    
                  </table>
                   
                 
      
    </div>
  
     
   </div>
  </div>
<script type="text/javascript">
   var i = 0;

 $( document ).ready(function() {
 
    
    $('select').on('change', function() {
    
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
             
              var response = data ;
              //var crops = $('#crop');

               var product = '<select class="form-control form-select" name="product" id="product"  onchange="jsFunction(this);"> <option value=""> Select Crop</option>'
          response.forEach(function(item) {
            
            product +=" <option value='"+item.id+"'>"+ item.product +" </option>";
           });
           product += '</select>'; 
           
           $('#products').html(product);
              
            }
          });
       

     });



  });

 function jsFunction(prod)
{
   var selectedText = prod.options[prod.selectedIndex].innerHTML;
   var selectedValue = prod.value;

   document.getElementById("product_name").value = selectedText;


}

 function getuserdetails(){
      var category = $('#user').val();
      var path = "{{ route('getuser') }}";
    
      $.ajax({
            url: path,
            type: 'GET',
            dataType: "json",
            data: {
               search: category
            },
            success: function( data ) {
              
              var response = data ;
              
              if(data == ''){
                document.getElementById('user_info').textContent  = "Mobile Number Doesn't Exists";
                 document.getElementById('user_id').value  ="";
               //  document.getElementById("btn_submit").disabled = true;
              }
              else {
                document.getElementById('user_info').textContent  = "Name : "+data.firstname+" "+data.lastname+" , Email iD : "+data.email+" ,"+" HUBID : "+data.hub_id;
                document.getElementById('user_id').value  = data.id;
              //  document.getElementById("btn_submit").disabled = false;
              
              }
              
            }
          });
    }
 
</script>
<script type="text/javascript">
   function saveInput(){

     var prod_id = $('#product').val();
     var in_stock = 0;
     var uom =0;
    
    $.ajax({
            url: "{{ route('check_stocks')}}",
            type: 'GET',
            dataType: "json",
            data: {
               search: prod_id
            },
            success: function( data ) {
              
              var response = data ;
              
              // alert("Available Stock :"+ data.in_stocks +" "+ data.uom);
              in_stock = data.in_stocks;
              uom = data.uom;

              if(in_stock == 0){
                alert('No Stock available');
              }
              else{

                 Swal.fire({
                     text: 'Available Stock : '+in_stock+' '+data.uom,
                     
                      showCancelButton: true,
                      confirmButtonText: 'Add to list',
                    }).then((result) => {
                      /* Read more about isConfirmed, isDenied below */
                      if (result.isConfirmed) {
                        //Swal.fire('Saved!', '', 'success')
                        var prod_id = $('#product').val();
               var prod_name = $('#product_name').val();
             /* $qty = $('#qty').val();
              $measurement = $('#measurement').val();*/

               document.getElementById('category').value = '';
               document.getElementById('product').value = '';

              // alert(in_stock);
               

              preparelist(prod_id , prod_name , in_stock , uom);
                      } else if (result.isDenied) {
                        Swal.fire('Changes are not saved', '', 'info')
                      }
                    })

              }

             

            }
          });




     
   }

   function preparelist(prod_id , prod_name,in_stock , uom){
    
    //alert(i);
    
    $('#cloneview').append('<div class="row"><div class="col-md-3"><div class="mb-3" ><label for="message-text" class="col-form-label">Product Name *</label><div><input class="form-control" type="text" name="indent['+ i +'][name]" value='+ prod_name +'></div></div></div><div class="col-md-3"><div class="mb-3"><label for="message-text" class="col-form-label">Quantity *</label><input class="form-control" type="number" name="indent['+ i +'][qty]" placeholder="Enter quantity" max='+ in_stock +' required></div></div><div class="col-md-3"><div class="mb-3"><label for="message-text" class="col-form-label">Measurement*</label><select class="form-control form-select" name="indent['+ i +'][measurement]" required><option value="">Select</option><option value="kg">kg</option><option value="grams">grams</option><option value="liter">liter</option><option value="ml">ml</option><option value="numbers">numbers</option></select></div></div> <input type="hidden" name="indent['+ i +'][stock_id]"  value='+ prod_id +'></div>');
    ++i;

   }
</script>


@endsection