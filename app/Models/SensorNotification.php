<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SensorNotification extends Model
{
    use HasFactory;

    protected $fillable=[
    	'issue',
    	'tittle',
    	'description',
    	'solution',
    	'sensor_key',
    	'type'];
}
