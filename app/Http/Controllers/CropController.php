<?php

namespace App\Http\Controllers;

use App\Models\Crop;
use App\Models\Pod;
use App\Models\Category;
use App\Models\GrowthDuration;
use App\Models\Cultivation;
use Illuminate\Http\Request;

class CropController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $category = Category::get();
       // $crops = Cultivation::where('pod_id' , $id)->orderBy('chennel_no','ASC')->get();
        //print_r(json_encode($crops)); die();

            $mycrops = Cultivation::where('pod_id',$id)->orderBy('chennel_no','ASC')->get();
            $count = 0;
            foreach ($mycrops as $key => $value) {
                $crop_detail = Crop::where('id' , $value->crop_id)->first();
                $crop_growth = GrowthDuration::where('crop_id',$value->crop_id)->where('category_id', $value->category_id)->first();
                
                $planting_date = $value->planted_on ;
                $today = date('Y-m-d');
                $age = (strtotime($today)-strtotime($planting_date))/(60*60*24);

                $seedling_day = $crop_growth->seedling;
                $young = $crop_growth->young_plants;
                $matured = $crop_growth->matured;
                if($value->category_id == '5'){
                    $vegetative = $crop_growth->vegetative_phase;
                    $flowering = $crop_growth->flowering_stage;
                    $fruiting = $crop_growth->fruiting_stage;

                    $vegetative_range= preg_split("/[-:]/", $vegetative);
                    $vegetative_start = $vegetative_range[0];
                    $vegetative_end = $vegetative_range[1];

                    $flowering_range= preg_split("/[-:]/", $flowering);
                    $flowering_start = $flowering_range[0];
                    $flowering_end = $flowering_range[1];

                    $fruitingd_range= preg_split("/[-:]/", $fruiting);
                    $fruiting_start = $fruitingd_range[0];
                    $fruiting_end = $fruitingd_range[1];
                }
                
                $harvest = $crop_growth->harvesting ;

                $seedling_range= preg_split("/[-:]/", $seedling_day);
                $seedling_start = $seedling_range[0];
                $seedling_end = $seedling_range[1];

                $young_range= preg_split("/[-:]/", $young);
                $young_start = $young_range[0];
                $young_end = $young_range[1];

                $matured_range= preg_split("/[-:]/", $matured);
                $matured_start = $matured_range[0];
                $matured_end = $matured_range[1];



                $harvest_range= preg_split("/[-:]/", $harvest);
                $harvest_start = $harvest_range[0];
                $harvest_end = $harvest_range[1];
               
               if($value->category_id != '5'){
                if($age < $seedling_start){
                    $current_stage = "Planted";

                }

                else if($age >= $seedling_start && $age < $young_start){
                      $current_stage = "Seedling";
                      $src =$crop_growth->seeding_image; 
                }

                else if($age >= $young_start && $age < $matured_start){
                      $current_stage = "Young Plants";
                      $src =$crop_growth->young_image;
                }
               else if($age >= $matured_start && $age < $harvest_start){
                      $current_stage = "Matured Plant";
                      $src =$crop_growth->matured_image;
                }
                else  if($age >= $harvest_start){
                     $current_stage = "Harvest";
                     $src =$crop_growth->harvesting_image;
                }
               }
               else {
                  if($age < $seedling_start){
                    $current_stage = "Planted";

                }

                else if($age >= $seedling_start && $age < $young_start){
                      $current_stage = "Seedling";
                      $src =$crop_growth->seeding_image; 
                }

                else if($age >= $young_start && $age < $vegetative_start ){
                      $current_stage = "Young Plants";
                      $src =$crop_growth->young_image;
                }
               else if($age >= $vegetative_start && $age < $flowering_start){
                      $current_stage = "Vegitative Phase";
                      $src =$crop_growth->matured_image;
                }

                else if($age >= $flowering_start && $age < $fruiting_start){
                      $current_stage = "Flowering Stage";
                      $src =$crop_growth->matured_image;
                }

                else if($age >= $fruiting_start && $age < $harvest_start){
                      $current_stage = "Fruiting Stage";
                      $src =$crop_growth->matured_image;
                }

                else  if($age >= $harvest_start){
                     $current_stage = "Harvest";
                     $src = $crop_growth->harvesting_image;
                }

               } 
           
                
                $harvest_date_range= preg_split("/[-:]/", $harvest);
                $harvest_start_date = $harvest_date_range[0];
                $harvest_date = date('Y-m-d', strtotime($planting_date . ' + '. $harvest_start_date . 'days'));

                $days_remaining  = (strtotime($harvest_date)-strtotime(date('Y-m-d')))/(60*60*24);
                
                $crops[]=[
                         'name' => $crop_detail->name ,
                         'description' => $crop_detail->description,
                         'plant_age' => $age.' days' ,
                         'channel_no'=> $value->chennel_no,
                         'current_stage' => $current_stage,
                         'image' => $crop_detail->image,
                         'planted_date' => $value->planted_on,
                         'harvesting_date'=> $days_remaining
                     ];


            }
           

        return view('crops/add',compact('category','crops','id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       // print_r($request->Input()); die();

        $pod_detail = Pod::select('user_id')->where('pod_id', $request->pod_id)->first();

        $myCrops = Cultivation::create([
            'user_id' => $pod_detail->user_id ,
            'pod_id' => $request->pod_id ,
            'crop_id' => $request->crop ,
            'category_id' => $request->category ,
            'chennel_no' => $request->channel_no ,
            'planted_on' => $request->planted_on ,
            'status' => 'active'
        ]);

        if($myCrops){

             return redirect()->route('add_crops',$request->pod_id);
        }

       


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Crop  $crop
     * @return \Illuminate\Http\Response
     */
    public function show(Crop $crop)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Crop  $crop
     * @return \Illuminate\Http\Response
     */
    public function edit(Crop $crop)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Crop  $crop
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Crop $crop)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Crop  $crop
     * @return \Illuminate\Http\Response
     */
    public function destroy(Crop $crop)
    {
        //
    }

    public function getcrops(Request $request){

        $crops = Crop::where('category_id',$request->search )->get();

       return response()->json($crops);
    }
}
