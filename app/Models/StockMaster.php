<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMaster extends Model
{
    use HasFactory;

    protected $fillable=[
    	'category',
    	'product',
    	'brand',
    	'total_weight',
    	'measurement',
    	'available_weight',
    	'expiry_date',
    	'image',
    	'comments'];

    public function stocks(){
        return $this->hasMany(Stock::class , 'id','stock_master_id');

    } 

    public function indent(){
        return $this->hasMany(Indent::class , 'id','stock_id');

    }    
}
