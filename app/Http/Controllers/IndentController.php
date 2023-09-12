<?php

namespace App\Http\Controllers;

use App\Models\Indent;
use App\Models\Userdetail;
use App\Models\StockMaster;
use Illuminate\Http\Request;

class IndentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $category = StockMaster::select('category')->orderByRaw('FIELD(category, "Spray" ,"Nutrition" ,"Seeds","others")')->groupBy('category')->get();

       $data = Indent::all();

        return view('indent/list',compact('category' , 'data'));
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
      //  print_r($request->Input()); die();
        if(Userdetail::where('id', $request->user_id)->exists() || Userdetail::where('mobile', $request->mobile)->exists()){
    
            if(isset($request->indent)){
                
                if(isset($request->user_id)){
                    $user_id = $request->user_id;
                }
                else {
                    $user = Userdetail::where('mobile', $request->mobile)->first();
                    $user_id = $user->id;
                }
              
                 $message = array();
                foreach ($request->indent as $key => $value) {

                    if($value['measurement'] == 'kg'){
                        $weight = $value['qty']*1000;
                        $measurement = 'grams';
                    }
                    else if($value['measurement'] == 'grams') {
                        $weight = $value['qty'];
                        $measurement = 'grams';
                    }

                    if($value['measurement'] == 'liter'){
                        $weight = $value['qty']*1000;
                        $measurement = 'ml';
                    }
                    else if($value['measurement'] == 'ml') {
                        $weight = $value['qty'];
                        $measurement = 'ml';
                    }

                    if($value['measurement'] == 'numbers'){
                        $weight = $value['qty'];
                        $measurement = 'numbers';
                    }
                    $stock = StockMaster::where('id' , $value['stock_id'])->first();
                    $available_weight = $stock->available_weight;

                    if(intval($available_weight) >= intval($weight)){
                        $save = Indent::create([
                        'user_id' => $user_id ,
                        'stock_id'=> $value['stock_id'] ,
                        'quantity'=> $weight ,
                        'measurement'=> $measurement ,
                        'issue_date'=> $request->date]);

                    if($save){
                        $stock = StockMaster::where('id' , $value['stock_id'])->first();
                        $available_weight = $stock->available_weight;

                        $new_weight = intval($available_weight)-intval($weight);
                       // print_r($new_weight); die();
                        $update = StockMaster::where('id' , $value['stock_id'])->update(['available_weight' => $new_weight]);
                    }
                    }
                    else {
                        $message[]=$stock->product.' : requested quantity is not available in the stock';
                    }

                    
                }
                 
                 if(sizeof($message) == 0){
                     return redirect()->back();
                 }
                 else{
                     return redirect()->back()->with('msg',$message);
                 }

                

            }
            else {
               
                return redirect()->back()->withMessage('Indents cannot be empty')->withInput();
            }

        }
        else {
            return redirect()->back()->withMessage('Please Check the Mobile Number')->withInput();
        }
      //  print_r(json_encode($request->Input())); die();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Indent  $indent
     * @return \Illuminate\Http\Response
     */
    public function show(Indent $indent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Indent  $indent
     * @return \Illuminate\Http\Response
     */
    public function edit(Indent $indent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Indent  $indent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Indent $indent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Indent  $indent
     * @return \Illuminate\Http\Response
     */
    public function destroy(Indent $indent)
    {
        //
    }
}
