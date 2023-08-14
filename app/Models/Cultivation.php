<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cultivation extends Model
{
    use HasFactory;

    protected $fillable = [
                'user_id',
                'pod_id',
                'crop_id',
                'category_id',
                'chennel_no',
                'planted_on',
                'current_stage',
                'harvesting_date',
                'status'];

    public function crop(){
        return $this->belongsTo(Crop::class , 'crop_id', 'id');
    }            
}
