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
           </tr>
         @endforeach
       </tbody>


    </table> 
     
       
      
      
    </div>
     
   </div>
  </div>

</div>

@endsection