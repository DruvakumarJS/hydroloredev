<?php

namespace App\Http\Controllers;

use App\Models\NutritionMaster;

use Illuminate\Http\Request;

class NutritionMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = NutritionMaster::all();
        return view('nutrients/list',compact('data'));
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
        $save = NutritionMaster::create([
            'user_id' => $request->user_id,
            'nutrients' => $request->nutrient ,
            'quantity' => $request->qty ,
            'issue_date' => $request->date]);

        if($save){
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\NutritionMaster  $nutritionMaster
     * @return \Illuminate\Http\Response
     */
    public function show(NutritionMaster $nutritionMaster)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\NutritionMaster  $nutritionMaster
     * @return \Illuminate\Http\Response
     */
    public function edit(NutritionMaster $nutritionMaster)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\NutritionMaster  $nutritionMaster
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NutritionMaster $nutritionMaster)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\NutritionMaster  $nutritionMaster
     * @return \Illuminate\Http\Response
     */
    public function destroy(NutritionMaster $nutritionMaster)
    {
        //
    }
}
