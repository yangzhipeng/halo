<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class School extends Model
{
    //
    protected $table = 'wtown_community';
    protected $primaryKey = 'bid';
    public $timestamps = false;

    public function getSchoolInfo(){
        return School::all();
    }


}
