<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
    use HasFactory;

    protected $fillable=[
    	'firstname',
    	'lastname',
    	'mobile',
    	'email',
    	'address',
    	'type_of_building',
    	'location',
    	'installation_date',
    	'no_of_channels',
    	'crops',
    	'require_monitoring',
    	'comments'];
}
