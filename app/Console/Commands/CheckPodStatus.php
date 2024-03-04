<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\MasterSyncData;
use App\Models\Pod;
use App\Mail\PODstatusEmail;
use App\Models\Userdetail;
use App\Models\User;
use Mail;

class CheckPodStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pod:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check POD status every 6 hours';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
       
       $pods  = Pod::get();
       $data = array();

        foreach ($pods as $key => $value) {
            $time = date('Y-m-d H:i:s', strtotime('-6 hour'));

              if(MasterSyncData::where('pod_id' , $value->pod_id)->whereBetween('created_at' , [$time , date('Y-m-d H:i:s')])->doesntExist()){

                if(MasterSyncData::where('pod_id' , $value->pod_id)->exists()){
                  $details = MasterSyncData::where('pod_id' , $value->pod_id)->orderBy('id', 'DESC')->first();
                  $last_entry = date('Y-m-d H:i' , strtotime($details->created_at)); 
                }
                else {
                  $last_entry = '' ;
                }
                $user = Userdetail::where('id', $value->user_id)->first();

                $data[]=['user' => $user , 'POD_ID' => $value->pod_id, 'HUB_ID' => $value->hub_id , 'last_entry' => $last_entry , 'installation_date' => date('Y-m-d' , strtotime($value->created_at)) ];
                      
            }
            
        }
        
       
        if(sizeof($data)>0){
            $admins = User::where('role_id' , '1')->get();

            foreach($admins as $key=>$value){
                $emailid[]=$value->email;

             }

            Mail::to('druva@netiapps.com')->send(new PODstatusEmail($data));
            //$this->sendFCM($data);
        }
    }
}
