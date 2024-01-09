<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable=[
    	'stock_master_id',
    	'total_weight',
    	'measurement',
    	'expiry_date',
    	'source_of_import'];

    public function stockMaster(){
    	return $this->belongsTo(StockMaster::class,'stock_master_id' , 'id');
    }  	
}
