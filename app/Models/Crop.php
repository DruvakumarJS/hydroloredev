<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Crop extends Model
{
    use HasFactory;

    protected $fillable=[
       'name',
       'category_id',
       'season',
       'duration',
       'description',
       'image',
       'pruning',
       'staking',
       'pruning_steps',
       'staking_steps',
       'nutrients_addition_steps',
       'spray1_steps',
       'spray2_steps',
       'spray3_steps' ];

    public function cultivation(){
        return $this->hasMany(Cultivation::class , 'id', 'crop_id');
    } 

    public function category(){
      return $this->belongsTo(Category::class, 'category_id' , 'id');
    } 

    public function growth(){
      return $this->hasOne(GrowthDuration::class);
    }   
}
