<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Locations;

class LocationController extends Controller
{
    //
    public function index()
    {

        // echo 'KK';
        $locations=Locations::paginate(10);
        return view('locations.list',compact('locations'));
    }

    // Add New Location Form
    public function create(){
        return view('locations.add');
    }

    // save locations
    public function store(Request $request){
        $location  =  new Locations();

        $location->location = $request->location;
        if($location->save()){
           return redirect()->route('locations');
        }
    }

    // to edit the location 
    public function edit($id){
        $location=Locations::find($id);
        return view('locations.edit',compact('location'));
    }

    // to update the location
    public function update(Request $request,$id){
        $location=Locations::find($id);
        $location->location = $request->location;
        $location->save();
        return redirect()->route('locations');
    }

    public function destroy($id){
        $delete = Locations::where('id',$id)->delete();
         return redirect()->route('locations');
    }

}
