<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    //
    protected $table = 'city';
    protected $primaryKey = 'cityid';
    public $timestamps = false;
}
