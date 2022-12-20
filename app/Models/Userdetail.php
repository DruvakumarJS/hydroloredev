<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Ticket;
use App\Models\Alert;
use App\Models\Pod;
use App\Models\Hub;
use App\Models\Threshold;

class Userdetail extends Model
{
    use HasFactory;
    
     protected $fillable=[
        'user_id',
        'firstname',
        'lastname',
        'mobile',
        'email',
        'location',
        'address',
        'hub_id'];


        function tickets(){
            return $this->hasMany(Ticket::class,'id','user_id');
        }

        function alerts(){
            return $this->hasMany(Alert::class,'hub_id','hub_id');
        }

        function hubs(){
            return $this->hasMany(Hub::class,'id','user_id');
        }

        function threshold(){
            return $this->hasMany(Threshold::class,'id','user_id');
        }

       /* function pods(){
            return $this->hasMany(Pod::class,'id','user_id');
        }*/
        
}
