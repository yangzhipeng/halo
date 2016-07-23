<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

/**
* 
*/
class UmiMsg extends Model
{
	protected $table = 'youli_delivery_sms';
    protected $primaryKey = 'mid';
    public $timestamps = false;

}