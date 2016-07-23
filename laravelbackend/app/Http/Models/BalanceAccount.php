<?php
/**
 * Created by PhpStorm.
 * User: uni
 * Date: 16/1/4
 * Time: 下午1:19
 */


namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class BalanceAccount extends Model
{

    protected $table = 'wtown_account_balance';
    protected $primaryKey = 'cid';
    public $timestamps = false;

/*    public function getBalanceInfo(){
        return BalanceAccount::all();
    }*/
    public function user(){
        return $this->belongsTo('App\Http\Models\UserAccount', 'cid', 'cid');
    }
}

