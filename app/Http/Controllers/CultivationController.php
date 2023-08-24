<?php

namespace App\Http\Controllers;

use App\Models\Cultivation;
use Illuminate\Http\Request;
use App\Models\Crop;
use App\Models\Pod;
use App\Models\Category;
use App\Models\GrowthDuration;


class CultivationController extends Controller
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
       // $crops = Cultivation::where('pod_id' , $id)->orderBy('channel_no','ASC')->get();
        //print_r(json_encode($crops)); die();

           
            $count = 1;
            $channel_array=array();
            $channel_no_array= array();
            $sub_channel_array= array();
            $crops= array();
            
             while($count < 17){

                 $channel_array['channel_no']=$count;
                 $channel_array['sub_chanel']=array();

                 for ($i=1; $i < 4; $i++) { 
                    if($i == 1){$k = 'A';}
                    if($i == 2){$k = 'B';}
                    if($i == 3){$k = 'C';}
                     if(Cultivation::where('pod_id',$id)->where('channel_no',$count)->where('sub_channel',$k)->exists()){
                        //$data=Cultivation::where('pod_id',$id)->where('channel_no',$count)->where('sub_channel',$k)->first();

                        $value= Cultivation::where('pod_id',$id)->where('channel_no',$count)->where('sub_channel',$k)->first();
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
                        if($value->category_id != '5'){
                           
                            $matured_range= preg_split("/[-:]/", $matured);
                            $matured_start = $matured_range[0];
                            $matured_end = $matured_range[1];

                        }
                        
                        $harvest = $crop_growth->harvesting ;

                        $seedling_range= preg_split("/[-:]/", $seedling_day);
                        $seedling_start = $seedling_range[0];
                        $seedling_end = $seedling_range[1];

                        $young_range= preg_split("/[-:]/", $young);
                        $young_start = $young_range[0];
                        $young_end = $young_range[1];

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

                        $sub_channel_array=[
                         'sub_channel'=> $k,   
                         'id'=> $value->id,
                         'name' => $crop_detail->name ,
                         'crop_id' => $value->crop_id,
                         'category_id' => $value->category_id,
                         'description' => $crop_detail->description,
                         'plant_age' => $age.' days' ,
                         'channel_no'=> $value->channel_no,
                         'current_stage' => $current_stage,
                         'image' => $crop_detail->image,
                         'planted_date' => $value->planted_on,
                         'harvesting_date'=> $days_remaining
                     ];

                     }
                     else{
                        $sub_channel_array=[
                         'sub_channel'=> $k,    
                         'id'=> '',
                         'name' => '' ,
                         'crop_id' => '',
                         'category_id' =>'',
                         'description' => '',
                         'plant_age' => '' ,
                         'channel_no'=> $count,
                         'current_stage' => '',
                         'image' => '',
                         'planted_date' => '',
                         'harvesting_date'=> ''
                     ];
                         
                     }

                      array_push($channel_array['sub_chanel'], $sub_channel_array);
                 }

                 $crops[]=$channel_array; 
                 $channel[]= $count ; 
             $count++;
           }
           
            
          // print_r(json_encode($final_array)); die();

        return view('crops/add',compact('category','crops','id','channel'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       //  print_r($request->Input()); 
        
        if(isset($request->sub_channel_a))$sub_chanel_array[] ='A';
        if(isset($request->sub_channel_b))$sub_chanel_array[] ='B'; 
        if(isset($request->sub_channel_c))$sub_chanel_array[] ='C';
        $message=array();

       
      //  print_r($sub_chanel_array); die();

        foreach($sub_chanel_array as $sub_channel){
          //  print_r($sub_channel);
             $pod_detail = Pod::select('user_id')->where('pod_id', $request->pod_id)->first();
             if(Cultivation::where('user_id',$pod_detail->user_id)->where('pod_id',$request->pod_id)->where('channel_no',$request->channel_no)->where('sub_channel',$sub_channel)->exists()){
                $message[]='Crop Already exists for Channel-'.$request->channel_no.$sub_channel;
             }
             else {
            $myCrops = Cultivation::create([
                    'user_id' => $pod_detail->user_id ,
                    'pod_id' => $request->pod_id ,
                    'crop_id' => $request->crop ,
                    'category_id' => $request->category ,
                    'channel_no' => $request->channel_no ,
                    'sub_channel' => $sub_channel ,
                    'planted_on' => $request->planted_on ,
                    'status' => '1'
                ]);
            $message[]='Crop added succesfully for  Channel-'.$request->channel_no.$sub_channel;
        }
        }

       //  return redirect()->route('add_crops',$request->pod_id)->withMessage($message);

        return redirect()->back()->withMessage($message);
        

       /* $pod_detail = Pod::select('user_id')->where('pod_id', $request->pod_id)->first();

        if(Cultivation::where('user_id',$pod_detail->user_id)->where('pod_id',$request->pod_id)->where('channel_no',$request->channel_no)->where('sub_channel',$request->sub_channel)->exists()){
             
             return redirect()->route('add_crops',$request->pod_id)->withMessage('Crop already exists for channel selected')->withInput();
        }
        else{
            $myCrops = Cultivation::create([
            'user_id' => $pod_detail->user_id ,
            'pod_id' => $request->pod_id ,
            'crop_id' => $request->crop ,
            'category_id' => $request->category ,
            'channel_no' => $request->channel_no ,
            'sub_channel' => $request->sub_channel ,
            'planted_on' => $request->planted_on ,
            'status' => '1'
        ]);

        if($myCrops){

             return redirect()->route('add_crops',$request->pod_id);
        }
        }*/

        

       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cultivation  $cultivation
     * @return \Illuminate\Http\Response
     */
    public function show(Cultivation $cultivation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cultivation  $cultivation
     * @return \Illuminate\Http\Response
     */
    public function edit(Cultivation $cultivation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cultivation  $cultivation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       // print_r($request->Input()); die();

        $update = Cultivation::where('id', $id)->where('pod_id', $request->pod_id)->update([
            'channel_no' => $request->channel_no ,
            'category_id' => $request->category ,
            'sub_channel'=> $request->sub_channel,
            'crop_id' => $request->crop,
            'planted_on' => $request->planted_on]);

        if($update){
            $message=array();
            $message[] = 'Channel -'.$request->channel_no.$request->sub_channel." updated suceesfully";
            return redirect()->back()->withMessage($message);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cultivation  $cultivation
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $remove = Cultivation::where('id', $id)->delete();

        if($remove){
            $message=array();
            $message[] = "Crop Removed suceesfully";

            return redirect()->back()->withMessage($message);
        }
    }

    public function getcrops(Request $request){

        $crops = Crop::where('category_id',$request->search )->get();

       return response()->json($crops);
    }


}
