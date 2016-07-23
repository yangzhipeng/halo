<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Base\BaseController;
use App\Http\Models\UserAccount;
use App\Http\Models\School;
use App\Http\Models\UserLog;
use App\Http\Models\Umipush;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis as Redis;


class UserController extends BaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
        $this->redis = Redis::connection();
    }

    public function getIndex()
    {

        $query = \Input::get('query');

        if(!$query)
        {
            $users = UserAccount::paginate($this->perPage);

            return view('admin.user.index', compact('users'));
        }else
        {
            $users = UserAccount::where('realname', 'like', '%'.$query.'%')->paginate($this->perPage);

            return view('admin.user.index', compact('users', 'query'));
        }


    }

    public function getUserLog($cid = Null)
    {

        $user = UserAccount::where('cid', '=', $cid)->first();

        if(!$user)
        {
            return \Redirect::back()->with('error', '用户不存在');
        }

        $logs = UserLog::where('cid', '=', $cid)->paginate($this->perPage);

        return view('admin.user.log', compact('logs', 'user'));

    }

    public function inputMsg(){
        $schools = School::paginate($this->perPage);

        return view('admin.user.inputmsg', compact('schools'));
    }

    public function  pushMsg(){
        $schoolid = \Input::get('schoolid');
        $msg = \Input::get('msg');
        $cmd = "p99"; //广播

        if($schoolid == '0'){
            $users = UserAccount::get();
        }else{
            $users = UserAccount::where('schoolid', '=', $schoolid)->get();
        }

        foreach($users as $user){
            $cid = $user->cid;
            $token = Umipush::where('cid', '=', $cid)->first();

            if(!$token){
                continue;
            }

            if($token->push_string){
                $push = array(
                    'objid'=>$token->cid,
                    'platform'=>$token->platform,
                    'token'=>$token->push_string,
                    'content'=>$msg,
                    'cmd'=>$cmd.'|'.$msg
                );

                $this->redis->lPush('pushdaemon',serialize($push));

            }
        }

        return view('admin.user.pushsuccess');
    }



    public function inputSms(){
        $schools = School::paginate($this->perPage);

        return view('admin.user.inputsms', compact('schools'));
    }

    public function  pushSms(){
        $schoolid = \Input::get('schoolid');
        $lastlogin = \Input::get('lastlogin');
        $msg = \Input::get('msg');

        $condition = 'where schoolid = '.$schoolid. ' and ';

        $now = time();
        if($lastlogin == 0){
            $one_month = $now - 30 * 24 * 60 * 60;
            $condition .= 'modifiedtime > '. $one_month;
        }else if($lastlogin == 1){
            $one_month = $now - 30 * 24 * 60 * 60;
            $three_month = $now - 90 * 24 * 60 * 60;
            $condition .= 'modifiedtime > '. $three_month . ' and modifiedtime < ' . $one_month;
        }else if($lastlogin == 2){
            $three_month = $now - 90 * 24 * 60 * 60;
            $six_month = $now - 180 * 24 * 60 * 60;
            $condition .= 'modifiedtime > '. $six_month . ' and modifiedtime < ' . $three_month;
        }else{
            $six_month = $now - 180 * 24 * 60 * 60;
            $condition .= 'modifiedtime < '. $six_month;
        }

        $sql = 'select * from wtown_clientusers '. $condition;
        $users = DB::select($sql);

        foreach($users as $user){
            $cid = $user->cid;
            $mobile = $user->mobile;

            $this->redis->lPush('sms', json_encode(array('phone' => $mobile, 'msg' => $msg)));
        }

        return view('admin.user.pushsuccess');
    }


}
