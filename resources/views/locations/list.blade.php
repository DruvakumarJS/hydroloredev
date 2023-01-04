
@extends('layouts.app')
@section('content')

<div class="container-body ">
       <div class="row justify-content-center p-10">
                
                <div class="row">
                    <div class="col-md-6">
                         <h2>Locations</h2>
                    </div>
                    <div class="col-md-6 text-end">
                          <a class="btn btn-primary " href="{{route('add-location')}}">Add New Location</a>
                    </div>
                </div>
                <div class="row">

                    <div class="card">                    
                        <table class="table table-responsive">
                                    
                                    <tr>
                                    <th>Sl.No</th>
                                    <th>Locations</th>
                                    <th>Actin</th>
                                    </tr>
                                    @php
                                       $index = $locations->firstItem()
                                    @endphp
                                    @foreach($locations as $location)
                                    <tr>
                                        <td>{{ $index++ }}</td>
                                        <td>{{ $location->location }}</td>
                                        <td>
                                            <a href="{{ route('edit-location', $location->id)}}">Edit</a>
                                        </td>
                                    </tr>
                                    @endforeach
                            </table>
                    </div>

                </div>
        <div>
</div>


@endsection
