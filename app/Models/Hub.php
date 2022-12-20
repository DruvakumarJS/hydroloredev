<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pod;

class Hub extends Model
{
    use HasFactory;

    protected $fillable=[
        'user_id',
        'hub_id',
        'hub_name',
        'hub_location',
        'pods_count',       
        'status'
        ];


        function getpods(){
            return $this->hasMany(Pod::class,'hub_id', 'hub_id');
        }

         public function user()
          {
             return $this->belongsTo(Userdetail::class,'user_id','id');

          }
    
}
