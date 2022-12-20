<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PodMaster extends Model
{
    use HasFactory;
    protected $fillable=[
        'data_frame',
        'description',
        'unit',
        'range',
        'threshold',
        'min',
        'max',
        'x_value'];
}
