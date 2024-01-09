<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Indent extends Model
{
    use HasFactory;

     protected $fillable = [
    	'user_id',
    	'pod_id',
    	'stock_id',
    	'quantity',
    	'measurement',
    	'issue_date',
    	'comments'];

    public function user(){
    	return $this->belongsTo(Userdetail::class , 'user_id' , 'id');
    } 

     public function stocks(){
    	return $this->belongsTo(StockMaster::class , 'stock_id' , 'id');
    }	
}
