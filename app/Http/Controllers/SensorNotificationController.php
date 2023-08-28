<?php

namespace App\Http\Controllers;

use App\Models\SensorNotification;
use Illuminate\Http\Request;


class SensorNotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = SensorNotification::all();
        return view('sensormaster/list',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $insert = SensorNotification::create([
            'tittle' => $request->tittle ,
            'issue' => $request->issue ,
            'description' => $request->desc ,
            'solution' => $request->solution,
            'sensor_key' => $request->param ,
            'type' => $request->type]);

        if($insert){
            return redirect()->route('sensor_master');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SensorNotification  $sensorNotification
     * @return \Illuminate\Http\Response
     */
    public function show(SensorNotification $sensorNotification)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SensorNotification  $sensorNotification
     * @return \Illuminate\Http\Response
     */
    public function edit(SensorNotification $sensorNotification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SensorNotification  $sensorNotification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $update  = SensorNotification::where('id', $id)->update([
            'tittle' => $request->tittle ,
            'issue' => $request->issue ,
            'description' => $request->desc ,
            'solution' => $request->solution,
            'sensor_key' => $request->param ,
            'type' => $request->type]);
        if($update){
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SensorNotification  $sensorNotification
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = SensorNotification::where('id', $id)->delete();

        if($delete){
            return redirect()->back();
        }
    }
}
