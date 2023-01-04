@extends('layouts.app')

@section('content')


<div class="container-body">

    <div class="row justify-content-center">

           <form method="post" action="{{route('show_users')}}">
                @csrf        

            <h2 class="head-h1">Pods</h2>
            <label class="date"> {{date('d M ,Y')}} </label>

        
            <div class="dropdown">
 
 
<div class="dropdown">
  <input style="border-radius: 7px;" type="text" placeholder="  search POD ID" name="search">
   
  </button>
  
</div>
             
    </div>  

    <div class="card table-responsive" >
     <table class="table" >
        <tr >
          <th>Sl.No</th>
           <th>HUB ID</th>
          <th>PODUID</th>
          <th>Location</th>
          <th>Polyhouses</th>
          <th>created </th>                                                                                        
          <th>Lastest update</th>
         
          <th>   </th>
         </tr>

         <?php

         if(!empty($pods) && $pods->count())
         {

         foreach ($pods as $key => $value) {
            $statusvalue=$value->status;
 
                     
          ?>

          <tr>
          <td>{{$key + $pods->firstItem()}}</td>
          <td>{{$value->hub_id}}</td>
          <td> <label>{{$value->pod_id}}</label> </td>        
         <td>{{$value->location}}</td>
         <td>{{$value->polyhouses}}</td>
         <td>{{$value->created_at}}</td>
         <td>{{$value->updated_at}}</td>
       
        </tr>


        <?php } ?>

        

     </table>  
    

          <label>Showing {{ $pods->firstItem() }} to {{ $pods->lastItem() }} of {{$pods->total()}} results</label>
         
          {!! $pods->links() !!}

           <?php 
          } 
           else 
           {
         ?>
              <tr>
                    <td colspan="10">There are no data.</td>
                </tr>
            <?php 
          }
            ?>

    </div>  
</div>  

@endsection