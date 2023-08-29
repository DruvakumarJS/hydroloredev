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
        
        $data = Crop::paginate(25);
        $category = Category::all();
       return view('cropsmaster/crops',compact('data' , 'category'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
    }

    public function search(Request $request){
      //  print_r($request->Input()); die();
        if($request->search == ''){
            return redirect()->route('Crop_master');
        }
        else {
          $search = $request->search;
        $data = Crop::whereHas('category', function($query)use($search){
                      $query->where('category_name', 'LIKE' , $search.'%');
                    })
                    ->orWhere('name' , 'LIKE' , $request->search.'%')
                    ->orWhere('season' ,'LIKE' ,$request->search.'%' )
                    ->orWhere('duration' , 'LIKE' ,$request->search.'%')
                    ->orWhere('description','LIKE' ,$request->search.'%')
                    ->paginate(25);

        $category = Category::all();
       return view('cropsmaster/crops',compact('data' , 'category'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $crop_image="";
        $seedling_image="";
        $young_image="";
        $matured_image="";
        $vegetative_image="";
        $flowering_image="";
        $fruiting_image="";
        $harvesting_image="";

     
       if($file = $request->hasFile('crops_img')) {
            $fileName = basename($_FILES['crops_img']['name']);        
            $temp = explode(".", $fileName);             
            $fileName = rand('111111','999999') . '.' . end($temp);
            $destinationPath = public_path().'/crops/'.$fileName ;
            move_uploaded_file($_FILES["crops_img"]["tmp_name"], $destinationPath);
            $crop_image= $fileName;
        }

        if($file = $request->hasFile('seedings_img')) {
            $fileName = basename($_FILES['seedings_img']['name']);        
            $temp = explode(".", $fileName);             
            $fileName = rand('111111','999999') . '.' . end($temp);
            $destinationPath = public_path().'/growth/'.$fileName ;
            move_uploaded_file($_FILES["seedings_img"]["tmp_name"], $destinationPath);
            $seedling_image= $fileName;
        }

        if($file = $request->hasFile('young_plant_img')) {
            $fileName = basename($_FILES['young_plant_img']['name']);        
            $temp = explode(".", $fileName);             
            $fileName = rand('111111','999999') . '.' . end($temp);
            $destinationPath = public_path().'/growth/'.$fileName ;
            move_uploaded_file($_FILES["young_plant_img"]["tmp_name"], $destinationPath);
            $young_image= $fileName;
        }

         if($file = $request->hasFile('matured_img')) {
            $fileName = basename($_FILES['matured_img']['name']);        
            $temp = explode(".", $fileName);             
            $fileName = rand('111111','999999') . '.' . end($temp);
            $destinationPath = public_path().'/growth/'.$fileName ;
            move_uploaded_file($_FILES["matured_img"]["tmp_name"], $destinationPath);
            $matured_image= $fileName;
        }

        if($file = $request->hasFile('vegetative_img')) {
            $fileName = basename($_FILES['vegetative_img']['name']);        
            $temp = explode(".", $fileName);             
            $fileName = rand('111111','999999') . '.' . end($temp);
            $destinationPath = public_path().'/growth/'.$fileName ;
            move_uploaded_file($_FILES["vegetative_img"]["tmp_name"], $destinationPath);
            $vegetative_image= $fileName;
        }

        if($file = $request->hasFile('flowering_img')) {
            $fileName = basename($_FILES['flowering_img']['name']);        
            $temp = explode(".", $fileName);             
            $fileName = rand('111111','999999') . '.' . end($temp);
            $destinationPath = public_path().'/growth/'.$fileName ;
            move_uploaded_file($_FILES["flowering_img"]["tmp_name"], $destinationPath);
            $flowering_image= $fileName;
        }

        if($file = $request->hasFile('fruit_img')) {
            $fileName = basename($_FILES['fruit_img']['name']);        
            $temp = explode(".", $fileName);             
            $fileName = rand('111111','999999') . '.' . end($temp);
            $destinationPath = public_path().'/growth/'.$fileName ;
            move_uploaded_file($_FILES["fruit_img"]["tmp_name"], $destinationPath);
            $fruiting_image= $fileName;
        }

       
        if($file = $request->hasFile('harvesting_img')) {
            $fileName = basename($_FILES['harvesting_img']['name']);        
            $temp = explode(".", $fileName);             
            $fileName = rand('111111','999999') . '.' . end($temp);
            $destinationPath = public_path().'/growth/'.$fileName ;
            move_uploaded_file($_FILES["harvesting_img"]["tmp_name"], $destinationPath);
            $harvesting_image= $fileName;
        }

    

      if($request->category == '5'){

        $crop = new Crop();
        $crop->name = $request->crop;
        $crop->category_id = $request->category;
        $crop->season = $request->season;
        $crop->duration = $request->duration;
        $crop->description = $request->desc;
        $crop->image = $crop_image;
        $crop->pruning = $request->pruning ;
        $crop->staking = $request->staking;

        $crop->save();

        $id = $crop->id;

        if($id != ''){
           
            $duration = GrowthDuration::create([
                'category_id' => $request->category ,
                'crop_id' => $id ,
                'seedling' => $request->seedings ,
                'seeding_image'=> $seedling_image ,
                'young_plants' => $request->young_plant ,
                'young_image' => $young_image ,
                'vegetative_phase' => $request->vegetative ,
                'vegetative_image' => $vegetative_image ,
                'flowering_stage' => $request->flowering ,
                'flowering_image' => $flowering_image ,
                'fruiting_stage' => $request->fruit ,
                'fruiting_image' => $fruiting_image ,
                'harvesting' => $request->harvesting ,
                'harvesting_image' => $harvesting_image ]);

            if($duration){
                return redirect()->route('Crop_master');
            }
        }
      }
      else {

        $crop = new Crop();
        $crop->name = $request->crop;
        $crop->category_id = $request->category;
        $crop->season = $request->season;
        $crop->duration = $request->duration;
        $crop->description = $request->desc;
        $crop->image = $crop_image;
        $crop->pruning = $request->pruning ;
        $crop->staking = $request->staking;

        $crop->save();

        $id = $crop->id;

        if($id != ''){
           
            $duration = GrowthDuration::create([
                'category_id' => $request->category ,
                'crop_id' => $id ,
                'seedling' => $request->seedings ,
                'seeding_image'=> $seedling_image ,
                'young_plants' => $request->young_plant ,
                'young_image' => $young_image ,
                'matured' => $request->matured ,
                'matured_image' => $matured_image ,
                'harvesting' =>$request->harvesting ,
                'harvesting_image' => $harvesting_image ]);

            if($duration){
                return redirect()->route('Crop_master');
            }
        }
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
    public function update(Request $request,$id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Crop  $crop
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = Crop::where('id', $id)->delete();

        if($delete){
          return redirect()->route('Crop_master');
        }
    }

    
}
