<?php

namespace App\Http\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class AdminAccount extends Model implements AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;
    //
    protected $table= 'admin_accounts';


    public function belongsToAdminLevel()
    {
        return $this->belongsTo('App\Http\Models\AdminLevel', 'level_id', 'id');
    }

    public function hasOneAdminInfo()
    {
        return $this->hasOne('App\Http\Models\AdminInfo', 'admin_id', 'id');
    }
}
