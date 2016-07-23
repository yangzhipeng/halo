<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Base\BaseController;
use App\Http\Models\UserAccount;
use App\Http\Models\School;
use App\Http\Models\UserLog;
use App\Http\Models\Umipush;

use App\Http\Requests;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Http\Utils\Request;
use Illuminate\Support\Facades\Redis as Redis;


class CircleUserController extends BaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
        $this->redis = Redis::connection();
    }

    public function getIndex()
    {
        $page = \Input::get('page');
        if(!$page){
            $page=1;
        }
        $pagesize = 15;//每页显示页数
        $offset=$pagesize*($page - 1);

        $query = \Input::get('query');
        if(!$query)
        {
            try{
                //分页
                $userAccount = Request::Get('http://admin.itxedu.com:8080/api/admin/uni/user/getCount');
                if(!isset($userAccount)){
                    $result = Request::Get('http://admin.itxedu.com:8080/api/admin/uni/user/get');
                    $total = count($result['body']);
                }else{
                    $total = $userAccount['body'];
                }

                $pages=ceil($total/$pagesize);//一共多少页
                $result = Request::Get("http://admin.itxedu.com:8080/api/admin/uni/user/get?name=&offset=$offset&limit=$pagesize");

                if($result['code'] == 200){
                    $users = $result['body'];
                    return view('admin.circleuser.index', compact('users','pages','page','total'));
                }
            }catch (\Exception $e) {
                return $e->getMessage();
            }
        }else
        {
            //分页
            $userAccount = Request::Get("http://admin.itxedu.com:8080/api/admin/uni/user/getCount?name=$query");
            if(!isset($userAccount)){
                $result = Request::Get("http://admin.itxedu.com:8080/api/admin/uni/user/get?name=$query");
                $total = count($result['body']);
            }else{
                $total = $userAccount['body'];
            }
            $pages=ceil($total/$pagesize);//一共多少页

            $result = Request::Get("http://admin.itxedu.com:8080/api/admin/uni/user/get?name=$query&offset=$offset&limit=$pagesize");
            if($result['code'] == 200){
                $users = $result['body'];
                return view('admin.circleuser.index', compact('users','query','pages','page','total'));
            }
        }

    }

    public function getUserLog($cid = Null)
    {
        $page = \Input::get('page');
        if(!$page){
            $page=1;
        }
        $pagesize = 16;//每页显示页数
        $offset=$pagesize*($page - 1);

        $userResult = Request::Get("http://admin.itxedu.com:8080/api/admin/uni/user/getById?userId=$cid");
        $user = $userResult['body'];

        if(!$userResult['body'])
        {
            return \Redirect::back()->with('error', '用户不存在');
        }

        $logAccount = Request::Get("http://admin.itxedu.com:8080/api/admin/uni/user/getLoginInfo?userId=$cid");
        $total = count($logAccount['body']);
        $pages=ceil($total/$pagesize);//一共多少页

        $logsResult = Request::Get("http://admin.itxedu.com:8080/api/admin/uni/user/getLoginInfo?userId=$cid&offset=$offset&limit=$pagesize");
        $logs = $logsResult['body'];

        return view('admin.circleuser.log', compact('logs', 'user','cid','total','page','pages'));

    }

    public function getSchool()
    {
        $page = \Input::get('page');
        if(!$page){
            $page=1;
        }
        $pagesize = 15;//每页显示页数
        $offset=$pagesize*($page - 1);

        $query = \Input::get('query');
        if(!$query)
        {
            //分页
            $schoolAccount = Request::Get('http://admin.itxedu.com:8080/api/admin/uni/college/getCount');

            if(!isset($schoolAccount)){
                $result = Request::Get('http://admin.itxedu.com:8080/api/admin/uni/college/get');
                $total = count($result['body']);
            }else{
                $total = $schoolAccount['body'];
            }

            $pages=ceil($total/$pagesize);//一共多少页
            $result = Request::Get("http://admin.itxedu.com:8080/api/admin/uni/college/get?name=&offset=$offset&limit=$pagesize");

            if($result['code'] == 200){
                $schools = $result['body'];
                return view('admin.circleuser.school', compact('schools','pages','page','total'));
            }
        }else
        {
            //分页
            $schoolAccount = Request::Get("http://admin.itxedu.com:8080/api/admin/uni/college/getCount?name=$query");
            if(!isset($schoolAccount)){
                $result = Request::Get("http://admin.itxedu.com:8080/api/admin/uni/college/get?name=$query");
                $total = count($result['body']);
            }else{
                $total = $schoolAccount['body'];
            }
            $pages=ceil($total/$pagesize);//一共多少页

            $result = Request::Get("http://admin.itxedu.com:8080/api/admin/uni/college/get?name=$query&offset=$offset&limit=$pagesize");
            if($result['code'] == 200){
                $schools = $result['body'];
                return view('admin.circleuser.school', compact('schools','query','pages','page','total'));
            }

        }

    }



}
