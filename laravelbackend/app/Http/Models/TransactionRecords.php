<?php
/**
 * Created by PhpStorm.
 * User: uni
 * Date: 16/1/4
 * Time: 下午10:10
 */


namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TransactionRecords extends Model
{

    protected $table = 'wtown_transaction_records';
    protected $primaryKey = 'id';
    public $timestamps = false;

 /*   public function getTransactionInfo(){
        return TransactionRecords::all();
    }*/
    public function user(){
        return $this->belongsTo('App\Http\Models\UserAccount', 'cid', 'cid');
    }

    public function balance(){
        return $this->belongsTo('App\Http\Models\BalanceAccount', 'cid', 'cid');
    }

    public function cashoutAccount(){
        return $this->belongsTo('App\Http\Models\CashoutAccount', 'third_no', 'account_id');
    }

    public static function getCashInfo($state){
        return DB::table('wtown_clientusers')
            ->select('wtown_transaction_records.*','wtown_clientusers.mobile','wtown_clientusers.realname')
            ->leftjoin('wtown_transaction_records','wtown_clientusers.cid','=','wtown_transaction_records.cid')
            ->where('wtown_transaction_records.transaction_type','=','cash')
            ->where('wtown_transaction_records.status','=',$state)
            ->orderby('wtown_transaction_records.modifiedtime','desc')
            ->paginate(20);
    }

}

