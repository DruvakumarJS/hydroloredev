@extends('layouts.app')

@section('content')

<body>

<div class="container-body">

    <div class="row justify-content-center">

           <form method="post" action="{{route('show_users')}}">
                @csrf        

            <h2 class="head-h1">Pods</h2>
            <label class="date"> {{date('d M ,Y')}} </label>

        
            <div class="dropdown">
 
 
<div class="dropdown">
   
   <input class="search button-right mr:10 rounded mr" type="search" name="search" id="search" placeholder="search">

  
</div>
 
           

              
    </div>  

    <div class="card table-responsive" >
     <table class="table" >
        <tr >
          <th>Sl.No</th>
          <th>UserName</th>
          <th>HUB ID</th>
          <th>PODUID</th>
          <th>Location</th>
          <th>Polyhouses</th>
          <th>created </th>                                                                                        
          <th>Lastest update</th>
         
          <th>   </th>
         </tr>

         <tbody class="alldata">
         

         @php

         if(!empty($pods) && $pods->count())
         @endphp

         
         @foreach($pods as $key => $value) 
         @php
            $statusvalue=$value->status;
         @endphp
                     
       

          <tr>
          <td>{{$key + $pods->firstItem()}}</td>
          <td>{{$value->user->firstname}}</td>
          <td>{{$value->hub_id}}</td>
          <td> <label>{{$value->pod_id}}</label> </td>        
         <td>{{$value->location}}</td>
         <td>{{$value->polyhouses}}</td>
         <td>{{$value->created_at}}</td>
         <td>{{$value->updated_at}}</td>
         <td><a href="{{route('pod_history',$value->pod_id)}}">History</a>
         </td>
        

        
        </tr>


        @endforeach

         </tbody>
         <tbody id="Content" class="searchdata"> </tbody> 

     </table> 

     <script type="text/javascript">
          
         $('#search').on('keyup',function(){

          $value=$(this).val();
           if($value)
           {
            $('.alldata').hide();
            $('.searchdata').show();
           }
           else
           {
            $('.alldata').show();
            $('.searchdata').hide();
           }

          
           
          $.ajax({
             type:'get',
             url:'{{URL::to('searchpod')}}',
             data:{'search':$value},

             success:function(data)
             {
             
              console.log(data);
              $('#Content').html(data);
             }
 
          });

         });

        </script>

        
      @if($pods->count())  
     

          <label>Showing {{ $pods->firstItem() }} to {{ $pods->lastItem() }} of {{$pods->total()}} results</label>
         
          {!! $pods->links() !!}

         @else
              <tr>
                    <td colspan="10">There are no data.</td>
                </tr>
         @endif  
           
    </div>  
</div>  




@endsection