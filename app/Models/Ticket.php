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
        'sr_no'];


         public function user()
          {
             return $this->belongsTo(Userdetail::class,'user_id','id');

          }

}
