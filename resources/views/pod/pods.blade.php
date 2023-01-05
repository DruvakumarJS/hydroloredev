@extends('layouts.app')

@section('content')


    <div class="container-body">
        <div class="row justify-content-center">
            <form method="post" action="{{route('show_users')}}">
                @csrf
                <h2 class="head-h1">Pods</h2>
                <label class="date"> {{date('d M ,Y')}} </label>
                <div class="dropdown">
                    <input class="form-control" type="search" name="search" id="search" placeholder="search">
                </div>
            </form>
        </div>

            <div class="container-body">
                <div class="row">
                <div class="card table-responsive">
                    <table class="table" >
                        <tr>
                            <th>Sl.No</th>
                            <th>UserName</th>
                            <th>HUB ID</th>
                            <th>PODUID</th>
                            <th>Location</th>
                            <th>Polyhouses</th>
                            <th>Created</th>
                            <th>Lastest update</th>
                            <th></th>
                            <th></th>
                        </tr>

                        <tbody class="alldata" id="myTable">


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
                                <td><label>{{$value->pod_id}}</label></td>
                                <td>{{$value->location}}</td>
                                <td>{{$value->polyhouses}}</td>
                                <td>{{$value->created_at}}</td>
                                <td>{{$value->updated_at}}</td>
                                <td><a href="{{route('pod_history',$value->pod_id)}}">History</a>
                                </td>
                                <td></td>
                            </tr>

                        @endforeach

                        </tbody>
                        
                    </table>

                    

                    @if($pods->count())

                        <label>Showing {{ $pods->firstItem() }} to {{ $pods->lastItem() }} of {{$pods->total()}}
                            results</label>

                        {!! $pods->links() !!}

                    @else
                        <tr>
                            <td colspan="10">There are no data.</td>
                        </tr>
                    @endif

                </div>

            </div>

        </div>
    </div>

    <script>
$(document).ready(function(){
  $("#search").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>
   
@endsection
