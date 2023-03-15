<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;
    protected $table = 'countries';
    public $timestamps = false;
    protected $fillable = [
     'slug',
     'country',
     'country_code',
     'new_confirmed',
     'total_confirmed',
     'new_deaths',
     'new_recovered',
     'total_recovered',
     'total_deaths' 
    ];
}
