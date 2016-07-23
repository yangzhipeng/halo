<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class UserLog extends Model
{
    //
    protected $table = 'wtown_log';
    public $timestamps = false;


    public function belongsToUserAccount()
    {
        return $this->belongsTo('App\Http\Models\UserAccount', 'cid', 'cid');
    }

}
