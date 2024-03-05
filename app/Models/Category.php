<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
    	'category_name',
    	'season',
    	'description'];

    public function crops(){
      return $this->hasMany(Crop::class, 'id' , 'category_id');
    } 
 	
}
