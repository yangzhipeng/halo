<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserAccount extends Model
{
    //
    protected $table = 'wtown_clientusers';
    protected $primaryKey = 'cid';
    public $timestamps = false;

    public static function getBalanceRecords($query='')
    {
        if (!$query) {
            return DB::table('wtown_clientusers')
                ->select('wtown_clientusers.realname', 'wtown_clientusers.mobile', 'wtown_account_balance.creationtime', 'wtown_account_balance.balance')
                ->leftjoin('wtown_account_balance', 'wtown_clientusers.cid', '=', 'wtown_account_balance.cid')
                ->whereNotNull('wtown_account_balance.cid')
                ->orderBy('wtown_account_balance.creationtime', 'desc')
                ->paginate(20);
        } else {
            return DB::table('wtown_clientusers')
                ->select('wtown_clientusers.realname', 'wtown_clientusers.mobile', 'wtown_account_balance.creationtime', 'wtown_account_balance.balance')
                ->leftjoin('wtown_account_balance', 'wtown_clientusers.cid', '=', 'wtown_account_balance.cid')
                ->whereNotNull('wtown_account_balance.cid')
                ->where('wtown_clientusers.realname', 'like', '%' . $query . '%')
                ->orwhere('wtown_clientusers.mobile', 'like', '%' . $query . '%')
                ->orderBy('wtown_account_balance.creationtime', 'desc')
                ->paginate(20);
        }
    }

   public static function getChargeRecords($query=''){
       if (!$query) {
           return DB::table('wtown_clientusers')
               ->select('wtown_transaction_records.transaction_id','wtown_clientusers.realname','wtown_clientusers.mobile',
                   'wtown_transaction_records.modifiedtime','wtown_transaction_records.fee','wtown_transaction_records.pay_type',
                   'wtown_transaction_records.status','wtown_transaction_records.memo')
               ->leftjoin('wtown_transaction_records','wtown_clientusers.cid','=','wtown_transaction_records.cid')
               ->where('wtown_transaction_records.transaction_type','=','charge')
               ->orderby('wtown_transaction_records.modifiedtime','desc')
               ->paginate(20);
       }else{
           return DB::table('wtown_clientusers')
               ->select('wtown_transaction_records.transaction_id','wtown_clientusers.realname','wtown_clientusers.mobile',
                   'wtown_transaction_records.modifiedtime','wtown_transaction_records.fee','wtown_transaction_records.pay_type',
                   'wtown_transaction_records.status','wtown_transaction_records.memo')
               ->leftjoin('wtown_transaction_records','wtown_clientusers.cid','=','wtown_transaction_records.cid')
               ->where('wtown_transaction_records.transaction_type','=','charge')
               ->where(function($qry) use($query){
                   $qry->where('wtown_clientusers.realname', 'like', '%' . $query . '%')
                       ->orwhere('wtown_clientusers.mobile', 'like', '%' . $query . '%')
                       ->orwhere('wtown_transaction_records.transaction_id', 'like', '%' . $query . '%');
               })
               ->orderby('wtown_transaction_records.modifiedtime','desc')
               ->paginate(20);
       }

   }

    public static function getCashRecords($query=''){
        if(!$query){
            return DB::table('wtown_clientusers')
                ->select('wtown_transaction_records.transaction_id','wtown_clientusers.realname','wtown_clientusers.mobile',
                    'wtown_transaction_records.modifiedtime','wtown_transaction_records.fee','wtown_transaction_records.pay_type',
                    'wtown_transaction_records.third_no','wtown_transaction_records.status','wtown_transaction_records.memo')
                ->leftjoin('wtown_transaction_records','wtown_clientusers.cid','=','wtown_transaction_records.cid')
                ->where('wtown_transaction_records.transaction_type','=','cash')
                ->orderby('wtown_transaction_records.modifiedtime','desc')
                ->paginate(20);
        }else{
            return DB::table('wtown_clientusers')
                ->select('wtown_transaction_records.transaction_id','wtown_clientusers.realname','wtown_clientusers.mobile',
                    'wtown_transaction_records.modifiedtime','wtown_transaction_records.fee','wtown_transaction_records.pay_type',
                    'wtown_transaction_records.third_no','wtown_transaction_records.status','wtown_transaction_records.memo')
                ->leftjoin('wtown_transaction_records','wtown_clientusers.cid','=','wtown_transaction_records.cid')
                ->where('wtown_transaction_records.transaction_type','=','cash')
                ->where(function($qry) use($query){
                    $qry->where('wtown_clientusers.realname', 'like', '%' . $query . '%')
                        ->orwhere('wtown_clientusers.mobile', 'like', '%' . $query . '%')
                        ->orwhere('wtown_transaction_records.transaction_id', 'like', '%' . $query . '%');
                })
                ->orderby('wtown_transaction_records.modifiedtime','desc')
                ->paginate(20);
        }
    }

    public static function getTransactionRecords($query=''){
        if(!$query){
            return DB::table('wtown_clientusers')
                ->select('wtown_transaction_records.transaction_id','wtown_transaction_records.creationtime','wtown_clientusers.realname',
                    'wtown_transaction_records.fee','wtown_transaction_records.pay_type','wtown_transaction_records.transaction_type','wtown_transaction_records.status')
                ->leftjoin('wtown_transaction_records','wtown_clientusers.cid','=','wtown_transaction_records.cid')
                ->where('wtown_clientusers.cid','=','10654945')
                ->orderby('wtown_transaction_records.creationtime','desc')
                ->paginate(20);
        }else{
            return DB::table('wtown_clientusers')
                ->select('wtown_transaction_records.transaction_id','wtown_transaction_records.creationtime','wtown_clientusers.realname',
                    'wtown_transaction_records.fee','wtown_transaction_records.pay_type','wtown_transaction_records.transaction_type','wtown_transaction_records.status')
                ->leftjoin('wtown_transaction_records','wtown_clientusers.cid','=','wtown_transaction_records.cid')
                ->where('wtown_clientusers.cid','=','10654945')
                ->where('wtown_transaction_records.transaction_id', 'like', '%' . $query . '%')
                ->orderby('wtown_transaction_records.creationtime','desc')
                ->paginate(20);
        }
    }

    public function hasManyLogs()
    {
        return $this->hasMany('App\Http\Models\UserLog', 'cid', 'cid');
    }

    /*   public function hasBalance(){
        return $this->hasOne('App\Http\Models\BalanceAccount','cid','cid');
    }*/

    /*    public function getUserInfo(){
         return UserAccount::all();
    }*/

}

