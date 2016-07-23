<?php
/**
 * Created by PhpStorm.
 * User: uni
 * Date: 16/1/4
 * Time: 下午1:19
 */


namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class CashoutAccount extends Model
{

    protected $table = 'wtown_cash_out_accounts';
    protected $primaryKey = 'id';
    public $timestamps = false;

}

