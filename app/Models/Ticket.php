<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
     protected $fillable=[
        'subject',
        'status',
        'user_id',
        'hub_id',
        'pod_id',
        'threshold_value',
        'current_value',
        'sr_no',
        'inputkeys',
        'api_type',
        'is_critical_param'];


         public function user()
          {
             return $this->belongsTo(Userdetail::class,'user_id','id');

          }

         public function threshold()
         {
          return $this->hasOne(Threshold::class,'pod_id','pod_id');
         } 

}
