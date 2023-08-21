@extends('layouts.app')

@section('content')

<div class="container-body">
    <div class="container-header">
      
      <div >
        <label class="label-bold">Category Master</label>
        
      </div>
      <label class="date">{{date('d M ,Y')}} </label>

    </div>

  <div class="page-container" style="margin-top: 20px">
    <form method="post" action="{{route('save_category')}}">
      @csrf
     <div class="row justify-content-bottom">
      
        <div class="col-md-3">
          <label>Crop Category Name *</label>
          <input class="form-control" type="text" name="category" placeholder="Category name" required>
        </div>

        <div class="col-md-5">
           <label>Description *</label>
          <input class="form-control" type="text" name="desc" placeholder="Category description" required>
        </div>
        <div class="col-md-1">
          <label></label>
          <input class="btn btn-light btn-outline-primary form-control" type="submit" value="submit" >
        </div>
     
     </div>
   </form> 

   <div class="card div-margin">
    <table class="table">
       <tr>
          <th>Category</th>
          <th>Description</th>
       </tr>

       <tbody>
         @foreach($data as $key=>$value)
           <tr>
             <td width="200px">{{$value->category_name}}</td>
             <td>{{$value->description}}</td>
             <td>
               <a href="#" id="MybtnModal_{{$key}}"><button class="btn btn-sm btn-outline-primary">Edit</button></a>

             </td>
             <td><a onclick="return confirm('Are you sure to delete?')" href="{{route('delete_category',$value->id)}}"><button class="btn btn-sm btn-outline-danger">Delete</button></a></td>
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
                    <form method="post" action="{{route('update_category',$value->id)}}">
                       @method('PUT')
                       @csrf
                      <div class="mb-3">
                        <label for="recipient-name" class="col-form-label">Category Name:</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Category name" value="{{$value->category_name}}" required>
                      </div>
                      
                      <div class="mb-3">
                        <label for="message-text" class="col-form-label">Description (optional)</label>
                        <textarea class="form-control" id="desc" name="desc" >{{$value->description}}</textarea>
                      </div>
                      <input type="hidden" name="id" value="{{$value->id}}">

                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Update</button>
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