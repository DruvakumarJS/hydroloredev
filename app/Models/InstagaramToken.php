<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstagaramToken extends Model
{
    use HasFactory;
    
     protected $fillable = [
     	'insta_token',
     	'start_date',
     	'expiry_date'
     ];
}
