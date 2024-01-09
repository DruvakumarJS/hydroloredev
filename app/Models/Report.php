<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
    	'user_id',
    	'user_name',
    	'mobile',
    	'email',
    	'category',
    	'crop_id',
    	'crop_name',
    	'duration',
    	'channel',
    	'seeds_quantity',
    	'planted_date',
    	'pruning_date',
    	'staking_date',
        'nutrition_date',
        'spray1_date',
        'spray2_date',
        'spray3_date',
        'nutritions',
        'pesticides',
        'avg_ab',
        'avg_pod',
        'avg_tds',
        'avg_ph',
        'avg_nut',
        'harvesting_date',
        'expected_quantitiy',
        'actual_quantity',
        'grade1',
        'grade2',
        'grade3',
        'status',
        'comments'
    	  ];
}
