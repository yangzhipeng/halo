<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    //
    protected $table = 'wtown_module';

    public $timestamps = false;

    public function belongsToModuleType()
    {
        return $this->belongsTo('App\Http\Models\ModuleType', 'mtype', 'id');
    }



}
