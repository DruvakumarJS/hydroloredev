<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrowthDuration extends Model
{
    use HasFactory;

    protected $fillable=[
          'category_id',
          'crop_id',
          'seedling',
          'seeding_image',
          'young_plants',
          'young_image',
          'matured',
          'matured_image',
          'vegetative_phase',
          'vegetative_image',
          'flowering_stage',
          'flowering_image',
          'fruiting_stage',
          'fruiting_image',
          'harvesting',
          'harvesting_image',
          're_harvestable_crop',
          're_harvesting_day'];  

    public function crop(){
      return $this->belongsTo(Crop::class);
    }       
}


