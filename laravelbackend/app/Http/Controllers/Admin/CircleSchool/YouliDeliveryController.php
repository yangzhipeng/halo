<?php

namespace App\Http\Controllers\Admin\CircleSchool;

use App\Http\Controllers\Admin\Base\BaseController;
use App\Http\Models\UmiMsg;
use App\Http\Models\School;
use App\Http\Utils\Upload;
use App\Http\Utils\Request;
use Illuminate\Support\Facades\Redis as Redis;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class YouliDeliveryController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
        $this->redis = Redis::connection();
    }

   //增加信息内容
      public function postCreate($schoolid = NULL)
     {
        $route = array(
            'contents' => 'required'
        );

        $validator = \Validator::make(\Input::all(), $route);

        if($validator->fails())
        {
            return \Redirect::back()->withInput()->withErrors($validator->errors());
        }

        $school = Request::Get("http://admin.itxedu.com:8080/api/admin/uni/college/getById?collegeId=$schoolid");

         if($school['code'] != 200) {
            return \Redirect::back()->with('error', 'bid错误!');
        }

        $umiMsg = UmiMsg::where('schoolid', '=', $schoolid)->first();

        if(!$umiMsg)
        {
           $umiMsg = new UmiMsg();
        }

        $contents = \Input::get('contents');

        $umiMsg->contents = $contents;

        $umiMsg->schoolid = $schoolid;

        $umiMsg->save();

         $this->redis->hSet('youli_delivery_sms',$schoolid, $contents);
         //$this->redis->set($bid, $contents);
         //return RedisUtil::getInstance()->getValue($bid);
        return \Redirect::back()->with('success', '新增短信成功');
    }

    //更新信息
    public function postUpdate($schoolid = NULL)
    {
        $route = array(
            'contents' => 'required',
        );

        $validator = \Validator::make(\Input::all(), $route);

        if($validator->fails())
        {
            return \Redirect::back()->withInput()->withErrors($validator->errors());
        }

        $msg = UmiMsg::where('schoolid', '=', $schoolid)->first();
        if(!$msg)
        {
            return \Redirect::back()->with('error', '没有信息内容');
        }


        $msg->contents = \Input::get('contents');

        $contents = $msg->contents;
        //return $schoolid;
         //return $contents;
        $msg->save();

       $this->redis->hSet('youli_delivery_sms',$schoolid, $contents);

       // RedisUtil::getInstance()->setValue($schoolid, $contents);

       // return RedisUtil::getInstance()->getValue($schoolid);

        return \Redirect::back()->with('success', '修改信息成功');
    }

     //删除短信
     public function getDelete($mid = NULL)
    {
        $msg = UmiMsg::find($mid);

        if(!$msg)
        {
            return \Redirect::back()->with('error', '没有找到任何信息');
        }

        $msg->delete();

        return \Redirect::back()->with('success', '删除信息成功');
    }

    //禁用信息
 public function postuseStatus()
    {
        $mid = \Input::get('mid');
        $isValid = \Input::get('isValid');
        $msg = UmiMsg::find($mid);

        if(!$msg)
        {
            return \Response::json(array('code' => -1));
        }

        if($isValid != 0)
        {
            $msg->isValid = 1;
            $code = 1;
        }else{
        	$msg->isValid = 0;
        	$code = 0;
        }

        $msg->save();

        return \Response::json(array('code' => $code));
    }
}