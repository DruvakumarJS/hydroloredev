<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\StockMaster;
use App\Models\NutritionMaster;
use Illuminate\Http\Request;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stocks=StockMaster::select('category')->orderByRaw('FIELD(category, "Spray" ,"Nutrition" ,"Seeds","others")')->groupBy('category')->get();

        $categoryarray=array();
    

        foreach ($stocks as $key => $value) {
           $productarray=array();
           $category= ['category'=>$value->category];
           $category['prod']= array();
           
           $data = StockMaster::where('category' , $value->category)->get();

           foreach ($data as $key2 => $value2) {
              $product = [
                'id' => $value2->id ,
                'product' => $value2->product,
                'brand' => $value2->brand,
                'weight' => $value2->total_weight,
                'comments' => $value2->comments ,
                'expiry_date' => $value2->expiry_date,
                'available_weight' => $value2->available_weight ,
                'measurement'=> $value2->measurement,
                'image'=> $value2->image
            ];

             array_push($productarray , $product);
             $category['prod'] = $productarray;

           }
        

           array_push($categoryarray , $category);
          

        } 

        

        // print_r(json_encode($categoryarray));die();
        $stock = $categoryarray;
        $history = Stock::paginate(5);
       
        return view('stock/list',compact('stock', 'history'));
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
       // print_r($request->Input()); die();
        $product_image = '';
        if($request->measurement == 'kg'){
            $weight = $request->weight*1000;
            $measurement = 'grams';
        }
        else if($request->measurement == 'grams') {
            $weight = $request->weight;
            $measurement = 'grams';
        }

        if($request->measurement == 'liter'){
            $weight = $request->weight*1000;
            $measurement = 'ml';
        }
        else if($request->measurement == 'ml') {
            $weight = $request->weight;
            $measurement = 'ml';
        }

        if($request->measurement == 'numbers'){
            $weight = $request->weight;
            $measurement = 'numbers';
        }

        if($file = $request->hasFile('image')) {
            $fileName = basename($_FILES['image']['name']);        
            $temp = explode(".", $fileName);             
            $fileName = rand('111111','999999') . '.' . end($temp);
            $destinationPath = public_path().'/stockimages/'.$fileName ;
            move_uploaded_file($_FILES["image"]["tmp_name"], $destinationPath);
            $product_image= $fileName;
        }
       
       //print_r($product_image); die();
        $stcoksmaster = new StockMaster();
        $stcoksmaster->category =$request->category; 
        $stcoksmaster->product =$request->name; 
        $stcoksmaster->brand =$request->brand; 
        $stcoksmaster->total_weight =$weight; 
        $stcoksmaster->measurement =$measurement; 
        $stcoksmaster->available_weight =$weight; 
        $stcoksmaster->expiry_date =$request->expiry; 
        $stcoksmaster->comments =$request->comments;
        $stcoksmaster->image =$product_image;
        $stcoksmaster->save();

        $id = $stcoksmaster->id;
               
        if($id != ''){
            $stcoks  = Stock::create([
                'stock_master_id' => $id ,
                'total_weight' => $weight,
                'measurement' => $measurement,
                'expiry_date' => $request->expiry ,
                'source_of_import' => $request->source,
                '']);
                return redirect()->back();
        }

        


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function history()
    {
        $history = Stock::paginate(25);
        return view('stock/history',compact('history'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function edit(Stock $stock)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $stock)
    {
        $product_image = '';
        if($request->measurement == 'kg'){
            $weight = $request->weight*1000;
            $measurement = 'grams';
        }
        else if($request->measurement == 'grams') {
            $weight = $request->weight;
            $measurement = 'grams';
        }

        if($request->measurement == 'liter'){
            $weight = $request->weight*1000;
            $measurement = 'ml';
        }
        else if($request->measurement == 'ml') {
            $weight = $request->weight;
            $measurement = 'ml';
        }

        if($request->measurement == 'numbers'){
            $weight = $request->weight;
            $measurement = 'numbers';
        }

        if($file = $request->hasFile('image')) {
            $fileName = basename($_FILES['image']['name']);        
            $temp = explode(".", $fileName);             
            $fileName = rand('111111','999999') . '.' . end($temp);
            $destinationPath = public_path().'/stockimages/'.$fileName ;
            move_uploaded_file($_FILES["image"]["tmp_name"], $destinationPath);
            $product_image= $fileName;
        }

        if($product_image == ''){

             $update = StockMaster::where('id', $stock)->update([
            'category' => $request->category ,
            'product' => $request->name ,
            'brand' => $request->brand ,
            'comments' => $request->comments]);
        }
        else {
            $update = StockMaster::where('id', $stock)->update([
            'category' => $request->category ,
            'product' => $request->name ,
            'brand' => $request->brand ,
            'comments' => $request->comments,
            'image' => $product_image]);
        }

       if($update){

        return redirect()->back();
       }
    }

    public function update_quantity(Request $request, $stock){
        
        if($request->measurement == 'kg'){
            $weight = $request->weight*1000;
            $measurement = 'grams';
        }
        else if($request->measurement == 'grams') {
            $weight = $request->weight;
            $measurement = 'grams';
        }

        if($request->measurement == 'liter'){
            $weight = $request->weight*1000;
            $measurement = 'ml';
        }
        else if($request->measurement == 'ml') {
            $weight = $request->weight;
            $measurement = 'ml';
        }

        if($request->measurement == 'numbers'){
            $weight = $request->weight;
            $measurement = 'numbers';
        }

          $stocks  = Stock::create([
                'stock_master_id' => $stock ,
                'total_weight' => $weight,
                'measurement' => $measurement,
                'expiry_date' => $request->expiry ,
                'source_of_import' => $request->source]);

       if($stocks){
        $stockMaster = StockMaster::where('id', $stock)->first();

        $total_weight = $stockMaster->total_weight ;
        $available_weight = $stockMaster->available_weight ; 


        $totalWeight = intval($total_weight)+intval($weight);
        $totalAvailableWeight = intval($available_weight)+intval($weight);

        $updateMaster = StockMaster::where('id', $stock)->update([
            'total_weight' => $totalWeight ,
            'available_weight' => $totalAvailableWeight]);
        if($updateMaster){
            return redirect()->back();
        }

        
       }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stock $stock)
    {
        //
    }

    public function get_products(Request $request){

        $data = StockMaster::where('category',$request->search)->get();
         return response()->json($data);

    }
}
