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
       'image'];

    public function cultivation(){
        return $this->hasMany(Cultivation::class , 'id', 'crop_id');
    }     
}