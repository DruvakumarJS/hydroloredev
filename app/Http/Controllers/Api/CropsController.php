<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cultivation;
use App\Models\Crop;
use App\Models\GrowthDuration;

class CropsController extends Controller
{
    public function mycrops(Request $request){
    	
    	$data = array();

    	if(isset($request->user_id) && isset($request->pod_id)){
    		$user_id = $request->user_id ;
    	    $pod_id = $request->pod_id ;

    		$mycrops = Cultivation::where('user_id' , $user_id)->where('pod_id',$pod_id)->orderBy('chennel_no', 'ASC')->get();

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
                

    			$data[]=[
    				       'name' => $crop_detail->name ,
    			         'description' => $crop_detail->description,
                   'plant_age' => $age.' days' ,
                   'channel_no'=> $value->chennel_no,
    			         'current_stage' => $current_stage,
    			         'filepath' => url('/').'/crops/'.$crop_detail->image,
    			         'planted_date' => $planting_date,
    			         'harvesting_in'=> $days_remaining.' days'
    			     ];
    		}
           
           return response()->json([
    		       'status' => '1',
    		       'message' => 'Success',
    		       'data'=>$data ]);
    	}
    	else{

    		return response()->json([
    		       'status' => '0',
    		       'message' => 'Insufficient Inputs',
    		       'data'=>$data ]);
    	}
    }
}