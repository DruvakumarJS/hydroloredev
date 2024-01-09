<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable  = [
    	'user_id',
    	'cultivation_id',
    	'activity',
    	'feedback',
    	'images'];

    public function cultivation(){
        return $this->belongsTo(Cultivation::class , 'cultivation_id', 'id');
    }  	
}
