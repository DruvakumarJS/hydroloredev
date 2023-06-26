
@extends('layouts.app')
@section('content')
<div class="container-body ">
       <div class="row justify-content-center p-10">

                
                <div class="row">
                    <div class="col-md-6">
                         <h2>Admins</h2>
                    </div>
                    <div class="col-md-6 text-end">
                          <a class="btn btn-primary " href="{{route('add_admin')}}">Add Admin</a>
                    </div>
                </div>
                <div class="row">

                    <div class="card">                    
                        <table class="table table-responsive">
                                    
                                    <tr>
                                    <th>Sl.No</th>
                                    <th>Name</th>
                                    <th>email</th>
                                    <th></th>
                                   
                                   @foreach ($admins as $key => $value) 
                                   <tr>
                                      <td>{{$key+1}}</td>
                                      <td>{{$value->name}}</td>
                                      <td>{{$value->email}}</td>
                                     
                                      <td>
                                        <a href="{{route('delete_admin',$value->id)}}" onclick="return confirm('Are you sure to delete the user {{$value->name}}?')"> <button class="btn btn-sm btn-outline-danger">Delete</button>
                                        </a> 
                                      </td>
                                    </tr>
                                    
                                    @endforeach
                            </table>
                    </div>

                </div>
        <div>
</div>
@endsection
