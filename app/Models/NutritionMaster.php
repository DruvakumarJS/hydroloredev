<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NutritionMaster extends Model
{
    use HasFactory;

    protected $fillable = [
    	'user_id',
    	'pod_id',
    	'nutrients',
    	'quantity',
    	'issue_date'];

    public function user(){
    	return $this->belongsTo(Userdetail::class , 'user_id' , 'id');
    } 	
}


