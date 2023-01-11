<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
Use App\Models\Hub;
Use App\Models\PodMaster;
Use App\Models\Threshold;
Use App\Models\Userdetail;
use App\Models\Pod;

use Illuminate\Support\Facades\Schema;


class HubController extends Controller
{
    public function show()
    {
       
        $hubs_details=Hub::all();
        $podMaster=PodMaster::all();


        return view('hubdetails',compact('hubs_details', 'podMaster'));

      //return hubs::find(1)->getpods;

    }

    public function search(Request $request)
    {
        $hubid=$request->search;

        $userdetails=Userdetail::where('hub_id',$request->search)->get();

        if(sizeof($userdetails)>0)
        {

            $Pod_details=Pod::where('hub_id',$request->search)->get();
            
            return view('hub_search' , compact('hubid','Pod_details','userdetails'));
       }

       else {

           return redirect()->route('home')
                        ->withMessage('Requested HUB not found')
                        ->withInput();

       }
    }
}
    