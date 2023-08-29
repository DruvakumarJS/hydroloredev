<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Cultivation;
use App\Models\Crop;
use App\Models\Userdetail;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        //$data = Activity::where('cultivation_id' , $id)->get();
        $cultivation = Cultivation::where('id', $id)->first();
        $user = Userdetail::where('id', $cultivation->user_id)->first();
        $data= array();

        if(Activity::where('cultivation_id' , $id)->where('activity', 'pruning')->exists()){
            $detail = Activity::where('cultivation_id' , $id)->where('activity', 'pruning')->first();
            $data[]=[
                'activity' => 'Pruning',
                'expected_date' =>$cultivation->pruning, 
                'date' => $detail->created_at,
                'feedback' => $detail->feedback,
                'documents' => $detail->images];
        } 
        else{
            $data[]=[
                'activity' => 'Pruning',
                'expected_date' =>$cultivation->pruning, 
                'date' => '',
                'feedback' => '',
                'documents' => ''];
        }

        if(Activity::where('cultivation_id' , $id)->where('activity', 'staking')->exists()){
            $detail2 = Activity::where('cultivation_id' , $id)->where('activity', 'staking')->first();
            $data[]=[
                'activity' => 'Staking',
                'expected_date' =>$cultivation->staking, 
                'date' => $detail2->created_at,
                'feedback' => $detail2->feedback,
                'documents' => $detail2->images];
        } 
        else{
            $data[]=[
                'activity' => 'Staking',
                'expected_date' =>$cultivation->staking,
                'date' => '',
                'feedback' => '',
                'documents' => ''];
        }

        if(Activity::where('cultivation_id' , $id)->where('activity', 'nutrition')->exists()){
            $detail3 = Activity::where('cultivation_id' , $id)->where('activity', 'nutrition')->first();
            $data[]=[
                'activity' => 'Nutrition Addition',
                'expected_date' =>$cultivation->nutrition_addition, 
                'date' => $detail3->created_at,
                'feedback' => $detail3->feedback,
                'documents' => $detail3->images];
        } 
        else{
            $data[]=[
                'activity' => 'Nutrition Addition',
                'expected_date' =>$cultivation->nutrition_addition, 
                'date' => '',
                'feedback' => '',
                'documents' => ''];
        }

        if(Activity::where('cultivation_id' , $id)->where('activity', 'spray1')->exists()){
            $detail4 = Activity::where('cultivation_id' , $id)->where('activity', 'spray1')->first();
            $data[]=[
                'activity' => 'Spray 1',
                'expected_date' =>$cultivation->spray1, 
                'date' => $detail4->created_at,
                'feedback' => $detail4->feedback,
                'documents' => $detail4->images];
        } 
        else{
            $data[]=[
                'activity' => 'Spray 1',
                'expected_date' =>$cultivation->spray1, 
                'date' => '',
                'feedback' => '',
                'documents' => ''];
        }

        if(Activity::where('cultivation_id' , $id)->where('activity', 'spray2')->exists()){
            $detail5 = Activity::where('cultivation_id' , $id)->where('activity', 'spray2')->first();
            $data[]=[
                'activity' => 'Spray 2',
                'expected_date' =>$cultivation->spray2, 
                'date' => $detail5->created_at,
                'feedback' => $detail5->feedback,
                'documents' => $detail5->images];
        } 
        else{
            $data[]=[
                'activity' => 'Spray 2',
                'expected_date' =>$cultivation->spray2, 
                'date' => '',
                'feedback' => '',
                'documents' => ''];
        }

        if(Activity::where('cultivation_id' , $id)->where('activity', 'spray3')->exists()){
            $detail6 = Activity::where('cultivation_id' , $id)->where('activity', 'spray3')->first();
            $data[]=[
                'activity' => 'Spray 3',
                'expected_date' =>$cultivation->spray3, 
                'date' => $detail6->created_at,
                'feedback' => $detail6->feedback,
                'documents' => $detail6->images];
        } 
        else{
            $data[]=[
                'activity' => 'Spray 3',
                'expected_date' =>$cultivation->spray3, 
                'date' => '',
                'feedback' => '',
                'documents' => ''];
        }


       // print_r(json_encode($data)); die();
        return view('activity/list',compact('data' , 'cultivation' , 'user'));
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
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function show(Activity $activity)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function edit(Activity $activity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Activity $activity)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function destroy(Activity $activity)
    {
        //
    }
}
