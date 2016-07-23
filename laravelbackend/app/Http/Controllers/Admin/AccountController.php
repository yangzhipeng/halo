<?php
/**
 * Created by PhpStorm.
 * User: uni
 * Date: 16/1/4
 * Time: 下午12:08
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Base\BaseController;
use App\Http\Models\BalanceAccount;
use App\Http\Models\TransactionRecords;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Models\UserAccount;
use Illuminate\Support\Facades\DB;

class AccountController extends BaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    public function getBalance()
    {
        //$BalanceInfo = new BalanceAccount();
        //$BalanceInfos = $BalanceInfo->getBalanceInfo();
        //$UserBalanceInfo = new UserAccount();
        $query = \Input::get('query');
        if(!$query)
        {
             $UserBalanceInfos = UserAccount::getBalanceRecords();
            return view('admin.account.balance', compact('UserBalanceInfos'));

        }else{
            $UserBalanceInfos = UserAccount::getBalanceRecords($query);
            return view('admin.account.balance', compact('UserBalanceInfos', 'query'));
        }

    }

    public function getChargeRecords()
    {
            //$TransactionInfo = new TransactionRecords();
            //$TransactionInfos = $TransactionInfo->getTransactionInfo();
            //$UserChargeRecord = new UserAccount();
            $query = \Input::get('query');
            if(!$query) {
                $UserChargeRecords = UserAccount::getChargeRecords();
               return view('admin.account.chargerecords', compact('UserChargeRecords'));
           }else
          {
              $UserChargeRecords = UserAccount::getChargeRecords($query);
              return view('admin.account.chargerecords', compact('UserChargeRecords','query'));
          }
    }

    public function getCashRecords()
    {
        //$UserCashRecord = new UserAccount();
        $query = \Input::get('query');
        if(!$query){
            $UserCashRecords = UserAccount::getCashRecords();
            return view('admin.account.cashrecords', compact('UserCashRecords'));
        }else{
            $UserCashRecords = UserAccount::getCashRecords($query);
            return view('admin.account.cashrecords', compact('UserCashRecords','query'));
        }
    }

    public function getCashRecordsByStatus($status = '3')
    {
        switch($status){
            case '0' : $state = 'success';  break;
            case '1' : $state = 'failed' ;  break;
            case '2' : $state = 'cancel';  break;
            case '3' : $state = 'submit' ;  break;
            default : $state = 'submit'  ;
        }

        //$UserCashRecords = TransactionRecords::where('transaction_type', '=', 'cash')->where('status', '=', $state)->paginate($this->perPage);
        $UserCashRecords = TransactionRecords::getCashInfo($state);
        return view('admin.account.cashrecords', compact('UserCashRecords'));
    }

    public function cashoutDetail($transaction_id){
        //$UserBalance = UserAccount::getBalanceRecords();
        $UserCashRecord = TransactionRecords::where('transaction_id', '=', $transaction_id)->paginate($this->perPage);
        return view('admin.account.cashout', compact('UserCashRecord'));
    }

    public function confirmCashout($transaction_id){
        $mytxes = TransactionRecords::where('transaction_id', '=', $transaction_id)->paginate($this->perPage);

        $id = $mytxes[0]->id;
        $UserCashRecord = TransactionRecords::find($id);
        $UserCashRecord->status = 'success';

        $UserCashRecord->save();

        //$UserCashRecords = TransactionRecords::where('transaction_type', '=', 'cash')->paginate($this->perPage);
        //$UserCashRecords = UserAccount::getCashRecords();
        //return view('admin.account.cashrecords', compact('UserCashRecords'));
        return \Redirect::to('admin/account/cash');

    }


    public function  getUmiAccountTransactionInfo(){
        $query = \Input::get('query');
        if(!$query) {
            $transactionInfos = UserAccount::getTransactionRecords();
            return view('admin.account.transaction_records',compact('transactionInfos'));//显示所有交易记录的页面
       }else {
            $transactionInfos = UserAccount::getTransactionRecords($query);
            return view('admin.account.transaction_records', compact('transactionInfos','query'));//显示所有交易记录的页面
        }
    }


   public function getTransactionByStatus($trans_status = '0')
    {
        switch($trans_status){
            case '0' : $trans_statu = 'success';break;
            case '1' : $trans_statu = 'failed';break;
            case '2' : $trans_statu = 'cancel';break;
        }

        $transactionInfos = TransactionRecords::where('cid', '=', '10654945')->where('status', '=', $trans_statu)->paginate($this->perPage);

        return view('admin.account.transaction_records', compact('transactionInfos'));
    }

    public function getTransactionType($transaction_type = '0')
    {
        switch($transaction_type){
            case '0' : $trans_type = 'income';break;
            case '1' : $trans_type = 'paid';break;
        }

        $transactionInfos = TransactionRecords::where('cid', '=', '10654945')->where('transaction_type', '=', $trans_type)->paginate($this->perPage);

        return view('admin.account.transaction_records', compact('transactionInfos'));
    }
}