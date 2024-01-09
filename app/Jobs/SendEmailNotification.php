<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\StockMaster;
use App\Models\Stock;
use App\Models\Cultivation;
use App\Models\Userdetail;
use App\Mail\RemainderMail;
use Mail;


class SendEmailNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $remainder=array();
        $expiry=array();
        $nutrients=array();

        $stock = StockMaster::where('measurement','!=','numbers')->where('available_weight','<=',1000)->get();

        foreach ($stock as $key => $value) {
           
            $remainder[] = [
                'category' => $value->category ,
                'product' => $value->product ,
                'brand' => $value->brand ,
                'weight' => $value->available_weight,
                'measurement' => $value->measurement ];

            $type = "stocks";

        }
        // Mail::to('druva@netiapps.com')->send(new RemainderMail($remainder ,$type ));

        $stock = StockMaster::where('measurement','numbers')->where('available_weight','<=',1)->get();

        foreach ($stock as $key => $value) {
           
            $remainder[] = [
                'category' => $value->category ,
                'product' => $value->product ,
                'brand' => $value->brand ,
                'weight' => $value->available_weight,
                'measurement' => $value->measurement ];

            $type = "stocks";

        }
        if(sizeof($remainder)>0){
         Mail::to('druva@netiapps.com')->send(new RemainderMail($remainder ,$type , $expiry ,$nutrients ));
        }


        //Expiry
        $newdate = date('Y-m-d', strtotime(date('Y-m-d'). ' + 15 days'));

        $ex = StockMaster::where('expiry_date',$newdate)->where('available_weight','>',0)->where('expiry_date', '!=','')->get();

        foreach ($ex as $key => $value) {
           
            $expiry[] = [
                'category' => $value->category ,
                'product' => $value->product ,
                'brand' => $value->brand ,
                'weight' => $value->available_weight,
                'measurement' => $value->measurement ,
                'expire' => $value->expiry_date];

            $type = "expiry";

        }
        if(sizeof($expiry)>0){
         Mail::to('druva@netiapps.com')->send(new RemainderMail($remainder ,$type , $expiry ,$nutrients));  
        }

        //Nutrient export
        $nutritinday = date('Y-m-d', strtotime(date('Y-m-d'). ' + 3 days'));
        $nutrition = Cultivation::where('nutrition_addition', $nutritinday)->get(); 

        foreach ($nutrition as $key => $value) {
            $user = Userdetail::where('id' , $value->user_id)->first();
            
            $nutrients[]=[
                'username' => $user->firstname ." ".$user->lastname ,
                'mobile' => $user->mobile,
                'address' => $user->address ,
                'crop' => $value->crop->name,
                'planted_date' => $value->planted_on ];

            $type = "nutrients";    

        }
        if(sizeof($nutrients)>0){
         Mail::to('druva@netiapps.com')->send(new RemainderMail($remainder ,$type , $expiry ,$nutrients));  
        }
    }
}
