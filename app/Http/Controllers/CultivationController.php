<?php

namespace App\Http\Controllers;

use App\Models\Cultivation;
use Illuminate\Http\Request;
use App\Models\Crop;
use App\Models\User;
use App\Models\Pod;
use App\Models\Category;
use App\Models\GrowthDuration;
use App\Models\Activity;
use App\Models\Report;
use App\Models\Userdetail;
use App\Models\MasterSyncData;
use App\Http\Controllers\web\FirebaseNotificationController;
use PDF;


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
        // print_r(json_encode($category->crops)); die();
       // $crops = Cultivation::where('pod_id' , $id)->orderBy('channel_no','ASC')->get();
        
            $count = 1;
            $channel_array=array();
            $channel_no_array= array();
            $sub_channel_array= array();
            $crops= array();
            
             while($count < 17){

                 $channel_array['channel_no']=$count;
                 $channel_array['sub_chanel']=array();

                 for ($i=1; $i < 7; $i++) { 
                    if($i == 1){$k = 'A';}
                    if($i == 2){$k = 'B';}
                    if($i == 3){$k = 'C';}
                    if($i == 4){$k = 'D';}
                    if($i == 5){$k = 'E';}
                    if($i == 6){$k = 'F';}
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

                        $cropslist = Crop::where('category_id',$value->category_id)->get();

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
                         'harvesting_date'=> $days_remaining,
                         'cropslist' => $cropslist
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
                         'harvesting_date'=> '',
                         'cropslist' => []
                     ];
                         
                     }

                      array_push($channel_array['sub_chanel'], $sub_channel_array);
                 }

                 $crops[]=$channel_array; 
                 $channel[]= $count ; 
             $count++;
           }
           
            
          // print_r(json_encode($crops)); die();

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
        // print_r($request->Input()); die();
        
        if(isset($request->sub_channel_a))$sub_chanel_array[] ='A';
        if(isset($request->sub_channel_b))$sub_chanel_array[] ='B'; 
        if(isset($request->sub_channel_c))$sub_chanel_array[] ='C';
        if(isset($request->sub_channel_d))$sub_chanel_array[] ='D';
        if(isset($request->sub_channel_e))$sub_chanel_array[] ='E'; 
        if(isset($request->sub_channel_f))$sub_chanel_array[] ='F';
        $message=array();

       
      //  print_r($sub_chanel_array); die();

        foreach($sub_chanel_array as $sub_channel){
          //  print_r($sub_channel);
             $pod_detail = Pod::select('user_id')->where('pod_id', $request->pod_id)->first();
             if(Cultivation::where('user_id',$pod_detail->user_id)->where('pod_id',$request->pod_id)->where('channel_no',$request->channel_no)->where('sub_channel',$sub_channel)->exists()){
                $message[]='Crop Already exists for Channel-'.$request->channel_no.$sub_channel;
             }
             else {
                $crop_details = Crop::where('id', $request->crop)->first();
                $pruning = $crop_details->pruning;
                $staking  = $crop_details->staking;
                $plantation_date = $request->planted_on;

                if($staking == 'NA'){
                    $staking = "0";
                }
                
                $crop_growth = GrowthDuration::where('crop_id',$request->crop)->first();
                $harvest = $crop_growth->harvesting;
                
                $harvest_range= preg_split("/[-:]/", $harvest);
                $harvest_start = $harvest_range[0];
               // print_r($harvest); die();
               // print_r($harvest_start); die();
                $harvest_date = date('Y-m-d', strtotime($request->planted_on . ' + '. $harvest_start . 'days'));


                $pruning_date = date('Y-m-d',strtotime($plantation_date.' +'.$pruning.' days'));
                $staking_date = date('Y-m-d',strtotime($plantation_date.' +'.$staking.' days'));
                $nutrition_date = date('Y-m-d',strtotime($plantation_date.' + 10 days'));
                $spray1_date = date('Y-m-d',strtotime($plantation_date.' + 30 days'));
                $spray2_date = date('Y-m-d',strtotime($spray1_date.' + 10 days'));
                $spray3_date = date('Y-m-d',strtotime($spray2_date.' + 10 days'));

                /*print_r($plantation_date);print_r('<br>');
                print_r($pruning_date);print_r('<br>');
                print_r($staking_date);print_r('<br>');
                print_r($nutrition_date);print_r('<br>');
                print_r($spray1_date);print_r('<br>');
                print_r($spray2_date);print_r('<br>');
                print_r($spray3_date);print_r('<br>');
                die();*/


                $myCrops = Cultivation::create([
                        'user_id' => $pod_detail->user_id ,
                        'pod_id' => $request->pod_id ,
                        'crop_id' => $request->crop ,
                        'category_id' => $request->category ,
                        'channel_no' => $request->channel_no ,
                        'sub_channel' => $sub_channel ,
                        'planted_on' => $request->planted_on ,
                        'harvesting_date' => $harvest_date ,
                        'pruning' => $pruning_date ,
                        'staking' => $staking_date ,
                        'nutrition_addition' => $nutrition_date ,
                        'spray1' => $spray1_date ,
                        'spray2' => $spray2_date ,
                        'spray3' => $spray3_date ,
                        'status' => '1'
                    ]);
                $message[]='Crop added succesfully for  Channel-'.$request->channel_no.$sub_channel;
            }
        }

        $fcm = new FirebaseNotificationController;

        $data = new Request([
            'title' => 'Hydrolore' ,
            'body' => 'New Crop Added to your POD ' ]);
      
        $fcm->show($data);

      return redirect()->back()->withMessage($message);
       
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
        $message=array();

        if(Activity::where('cultivation_id' , $id)->exists()){
             $remove_activity = Activity::where('cultivation_id' , $id)->delete();
                if($remove_activity){
                    $remove = Cultivation::where('id', $id)->delete();

                if($remove){
                    
                    $message[] = "Crop Removed succesfully";

                    return redirect()->back()->withMessage($message);
                }
                else {
                    $message[] = "Could not remove the crop";
                     return redirect()->back()->withMessage($message);
                }
                }
                else {
                    $message[] = "Something went wrong";
                     return redirect()->back()->withMessage($message);
                }

        }
        else{
           
            $remove = Cultivation::where('id', $id)->delete();

            if($remove){
                    
                    $message[] = "Crop Removed succesfully";

                    return redirect()->back()->withMessage($message);
                }
                else {
                    $message[] = "Could not remove the crop";
                     return redirect()->back()->withMessage($message);
                }

        }
       

        
    }

    public function getcrops(Request $request){

        $crops = Crop::where('category_id',$request->search )->get();

       return response()->json($crops);
    }

    public function save_harvest_data(Request $request){
        //print_r($request->Input()); die();
        $cultivation_id = $request->c_id ;

        $cultivation = Cultivation::where('id', $cultivation_id)->first();
        $crop = Crop::where('id' , $cultivation->crop_id)->first();
       // $activity = Activity::where('cultivation_id',$cultivation_id)->get();
        $user = Userdetail::where('id',$cultivation->user_id)->first();

        if(Activity::where('cultivation_id',$cultivation_id)->where('activity','pruning')->exists()){
            $pr = Activity::where('cultivation_id',$cultivation_id)->where('activity','pruning')->first();
            $pruning = $pr->created_at ;
        }
        else {
            $pruning = $cultivation->pruning ;
        }

        if(Activity::where('cultivation_id',$cultivation_id)->where('activity','staking')->exists()){
            $st = Activity::where('cultivation_id',$cultivation_id)->where('activity','staking')->first();
            $staking = $st->created_at ;
        }
        else {
            $staking = $cultivation->staking ;
        }

        if(Activity::where('cultivation_id',$cultivation_id)->where('activity','nutrition')->exists()){
            $nutr = Activity::where('cultivation_id',$cultivation_id)->where('activity','nutrition')->first();
            $nutrition_addition = $nutr->created_at ;
        }
        else {
            $nutrition_addition = $cultivation->nutrition_addition ;
        }

        if(Activity::where('cultivation_id',$cultivation_id)->where('activity','spray1')->exists()){
            $sp1 = Activity::where('cultivation_id',$cultivation_id)->where('activity','pruning')->first();
            $spray1 = $sp1->created_at ;
        }
        else {
            $spray1 = $cultivation->spray1 ;
        }

        if(Activity::where('cultivation_id',$cultivation_id)->where('activity','spray2')->exists()){
            $sp2 = Activity::where('cultivation_id',$cultivation_id)->where('activity','spray2')->first();
            $spray2 = $sp2->created_at ;
        }
        else {
            $spray2 = $cultivation->spray2 ;
        }

        if(Activity::where('cultivation_id',$cultivation_id)->where('activity','spray3')->exists()){
            $sp3 = Activity::where('cultivation_id',$cultivation_id)->where('activity','spray3')->first();
            $spray3 = $sp3->created_at ;
        }
        else {
            $spray3 = $cultivation->spray3 ;
        }

        
        $ab = MasterSyncData::select('AB_T1')->where('pod_id',$cultivation->pod_id)->whereBetween('date',[$cultivation->planted_on , date('Y-m-d')])->avg('AB_T1');
        $pod = MasterSyncData::select('POD_T1')->where('pod_id',$cultivation->pod_id)->whereBetween('date',[$cultivation->planted_on , date('Y-m-d')])->avg('POD_T1');
        $tds = MasterSyncData::select('TDS_V1')->where('pod_id',$cultivation->pod_id)->whereBetween('date',[$cultivation->planted_on , date('Y-m-d')])->avg('TDS_V1');
        $ph = MasterSyncData::select('PH_V1')->where('pod_id',$cultivation->pod_id)->whereBetween('date',[$cultivation->planted_on , date('Y-m-d')])->avg('PH_V1');
        $nut = MasterSyncData::select('NUT_T1')->where('pod_id',$cultivation->pod_id)->whereBetween('date',[$cultivation->planted_on , date('Y-m-d')])->avg('NUT_T1');

        $harvest = GrowthDuration::where('crop_id', $cultivation->crop_id)->first();
        $harvest_date_range= preg_split("/[-:]/", $harvest->harvesting);
        $harvest_start_date = $harvest_date_range[0];
        $harvest_date = date('Y-m-d', strtotime($cultivation->planted_on . ' + '. $harvest_start_date . 'days'));


       // print_r($ab);die();

        $report = Report::create([
            'user_id' => $cultivation->user_id,
            'user_name'=> $user->firstname." ".$user->lastname,
            'mobile'=> $user->mobile,
            'email'=> $user->email,
            'category'=> $cultivation->crop->category->category_name,
            'crop_id'=> $cultivation->crop_id,
            'crop_name'=> $crop->name,
            'duration'=> $crop->duration,
            'channel'=> $request->channel,
            'seeds_quantity'=> $request->seeds.' '.$request->uom,
            'planted_date'=> $cultivation->planted_on,
            'pruning_date'=> $pruning,
            'staking_date'=> $staking,
            'nutrition_date'=> $nutrition_addition,
            'spray1_date'=> $spray1,
            'spray2_date'=> $spray2,
            'spray3_date'=> $spray3,
            'nutritions'=> $request->nutritions,
            'pesticides'=> $request->pesticides,
            'avg_ab'=> $ab,
            'avg_pod'=> $pod,
            'avg_tds'=> $tds,
            'avg_ph'=> $ph,
            'avg_nut'=> $nut,
            'harvesting_date'=> $harvest_date,
            'expected_quantitiy'=> $request->estimated_yield,
            'actual_quantity'=> $request->total_yield,
            'grade1'=> $request->grade1,
            'grade2'=> $request->grade2,
            'grade3'=> $request->grade3,
            'status'=> $request->Status,
            'comments'=> $request->comments,
        ]);   

        if($report){
            if(Activity::where('cultivation_id' , $cultivation_id)->exists()){
                $remove_activity = Activity::where('cultivation_id' , $cultivation_id)->delete();
                    if($remove_activity){
                        $remove = Cultivation::where('id', $cultivation_id)->delete();

                        if($remove){
                            
                            $message = "Crop Removed and Report Genrated Succesfully";

                            return redirect()->route('reports');
                        }
                        else {
                            $message = "Could Not Remove The Crop";
                             return redirect()->back()->withMessage($message);
                        }
                    }
                    else {
                        $message = "Could Not Remove Activities";
                         return redirect()->back()->withMessage($message);
                    }

            }
            else{
                $remove = Cultivation::where('id', $cultivation_id)->delete();

                        if($remove){
                            
                            $message = "Crop Removed and Report Genrated Succesfully";

                           return redirect()->route('reports');
                        }
                        else {
                            $message = "Could Not Remove The Crop";
                             return redirect()->back()->withMessage($message);
                        }
            }
            
        }
        else {
             $message = "Could Not Generate Report";
             return redirect()->back()->withMessage($message);
        }
    }


    public function report(){
        $data = Report::orderBy('id', 'DESC')->get();
        return view('report/list',compact('data'));
    }

    public function download($id){
      //print_r($id) ;die();
        $value = Report::where('id', $id)->first();
        $filename = 'Report.pdf';
        $pdf = PDF::loadView('report/pdf', compact('value'));
    
        return $pdf->download();
    }


}
