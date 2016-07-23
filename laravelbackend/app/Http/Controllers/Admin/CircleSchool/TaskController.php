<?php

namespace App\Http\Controllers\Admin\CircleSchool;

use App\Http\Controllers\Admin\Base\BaseController;
use App\Http\Models\School;
use App\Http\Models\P2PTaskTemp;
use App\Http\Models\P2PTask;
use App\Http\Utils\Upload;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Utils\Request;
use Illuminate\Support\Facades\Redis as Redis;



class TaskController extends BaseController
{
    private static $PUBLISHER = 10802352;

    private static $PUBLISHER_SIGN = '9fffde70b364c5abf3b2ea2bef66ef2b';

    private static $PUBLISHER_TOKEN = '10802352#64db80feb6a281a5aafe066aa1758096';

    private static  $HASHTABLE = "task-table"; //缓存task的状态

    private static $HASHTABLE_EXPIRE = "task-table-expire";//缓存task的过期日期

    private static $HASHTABLE_DESC = "task-table-desc";//缓存task的描述

    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
        $this->redis = Redis::connection();
    }

    public function getIndex($schoolid = NULL)
    {
        //告诉模板显示那个模块的数据
        $schoolMoudelId = \Config::get('uni.school_task');

        $tasks = P2PTaskTemp::where('is_published', '=', 0)->where('school_id', '=', $schoolid)
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);
        return view('admin.circleschool.layout.school_master',compact('schoolMoudelId', 'schoolid', 'tasks'));

    }

    public function postTempTaskCreate($schoolid = NULL)
    {
        $route = array(
            'title' => 'required',
            'description' => 'required',
            'privacy' => 'required',
            'decimal' => 'required',
            'expire' => 'required',
        );

        $validator = \Validator::make(\Input::all(), $route);

        if($validator->fails())
        {
            return \Redirect::back()->withInput()->withErrors($validator->errors());
        }

        $title = \Input::get('title');
        $description = \Input::get('description');
        $privacy = \Input::get('privacy');
        $decimal = \Input::get('decimal');
        $expire = \Input::get('expire');

        $school = Request::Get("http://admin.itxedu.com:8080/api/admin/uni/college/getById?collegeId=$schoolid");

        if($school['code'] != 200)
        {
            return \Redirect::back()->with('error', '学校不存在');
        }

        $imageUrl = Upload::getInstance()->uploadImage(\Input::file('file'), false, 'task/image');

        $newTempTask = new P2PTaskTemp();
        $newTempTask->title = $title;
        $newTempTask->description = $description;
        $newTempTask->privacy = $privacy;
        $newTempTask->decimal = $decimal;
        $newTempTask->expire = strtotime($expire);
        if($imageUrl)
        {
//            $imageArray = array();
//            $imageArray[] = $imageUrl['imageurl'];
            $newTempTask->image_url = \Config::get('uni.image_base_url').$imageUrl['imageurl'];
            $newTempTask->image_num = 1;
        }
        $newTempTask->school_id = $schoolid;
        $newTempTask->school_name = $school['body']['xxmc'];
        $newTempTask->save();
        return \Redirect::back()->with('success', '新增成功!');

    }

    public function postTempTaskUpdate($tempTaskId = NULL)
    {
        $route = array(
            'title' => 'required',
            'description' => 'required',
            'privacy' => 'required',
            'decimal' => 'required',
            'expire' => 'required',
        );

        $validator = \Validator::make(\Input::all(), $route);

        if($validator->fails())
        {
            return \Redirect::back()->withInput()->withErrors($validator->errors());
        }

        $title = \Input::get('title');
        $description = \Input::get('description');
        $privacy = \Input::get('privacy');
        $decimal = \Input::get('decimal');
        $expire = \Input::get('expire');

        $tempTask = P2PTaskTemp::find($tempTaskId);

        if(!$tempTask)
        {
            return \Redirect::back()->with('error', '任务不存在!');
        }

        $imageUrl = Upload::getInstance()->uploadImage(\Input::file('file'), false, 'task/image');

        if($title)
        {
            $tempTask->title = $title;
        }
        if($description)
        {
            $tempTask->description = $description;
        }
        if($privacy)
        {
            $tempTask->privacy = $privacy;
        }
        if($decimal)
        {
            $tempTask->decimal = $decimal;
        }
        if($expire)
        {
            $tempTask->expire = strtotime($expire);
        }

        if($imageUrl)
        {
            $tempTask->image_url = \Config::get('uni.image_base_url').$imageUrl['imageurl'];
        }

        $tempTask->save();
        return \Redirect::back()->with('success', '更新成功!');

    }


    public function postTempTaskDelete($tempTaskId = NULL)
    {
        $tempTask = P2PTaskTemp::find($tempTaskId);

        if(!$tempTask)
        {
            return \Redirect::back()->with('error', '任务不存在!');
        }

        $tempTask->delete();

        return \Redirect::back()->with('success', '删除成功!');

    }

    public function postSend()
    {
        $tempTasks = \Input::get('temp_tasks');
        $tempTasks = json_decode($tempTasks,true);

        $random_arr = $this->random($tempTasks);

        $now = time();
        $cnt = 0;
        for($i = 0; $i < sizeof($tempTasks); $i++){
            $task_temp = P2PTaskTemp::where('category_id', '=', $tempTasks[$i]['category_id'] )->get();

            if(sizeof($task_temp) == 0){
                continue;
            }

            $num = $tempTasks[$i]['send_num'];
            for($j = 0; $j < $num; $j++){
                $task = new P2PTask();

                $task_id = $this->genTaskID($cnt, $now);
                $desc = $task_temp[0]['description'] == null ? '' : $task_temp[0]['description'];
                $expire = $task_temp[0]['expire'] == null ? 0 : strtotime($task_temp[0]['expire']);
                $payment = $task_temp[0]['decimal'] == null ? '' : $task_temp[0]['decimal'];

                $task->task_id = $task_id;
                $task->issuer_id = TaskController::$PUBLISHER;
                $task->type = 0;
                $task->title = $task_temp[0]['title'] == null ? '' : $task_temp[0]['title'];
                $task->description = $desc;
                $task->privacy = $task_temp[0]['privacy'] == null ? '' : $task_temp[0]['privacy'];
                $task->payment = $payment;
               // $task->payment= 0;
                $task->creationtime = $now + $random_arr[$cnt]; //在抽奖场景中，任务是随机排序的
                $task->expire = $expire;
                $task->viewer_num = 0;
                $task->issuer_comment = '';
                $task->acceptor_comment = '';
                $task->image_num = $task_temp[0]['image_num'] == null ? 0 : $task_temp[0]['image_num'];
                //$task->image_url = $task_temp[0]['image_url'] == null ? '' : $task_temp[0]['image_url'];
                $task->status = 0;
                $task->accept_time = 0;
                $task->school_id = $task_temp[0]['school_id'] == null ? 0 : $task_temp[0]['school_id'];
                $task->school_name = $task_temp[0]['school_name'] == null ? '' : $task_temp[0]['school_name'];

                //更新数据库
                $task->save();

                //更新redis
                $this->cache($task_id, 0, $expire, $desc);

                $cnt ++;

                P2PTaskTemp::where('category_id', '=', $tempTasks[$i]['category_id'] )->delete();

                $this->paid(TaskController::$PUBLISHER, $payment, $task_id);
            }

        }

        $this->makeFake(++$cnt, $now, '');

        return json_encode(array('num' => $cnt));
    }



    private function random($tempTasks){
        $total_tasks = 0;
        if(sizeof($tempTasks) == 0){
            return [];
        }

        foreach($tempTasks as $tempTask){
            $total_tasks += $tempTask['send_num'];
        }

        $random_arr=range(0, $total_tasks);
        shuffle($random_arr);

        return $random_arr;
    }

    private function genTaskID($cnt, $time){
        list($tmp1, $tmp2) = explode(' ', microtime());

        $msec =  (String)((int)sprintf('%.0f', (floatval($tmp1) + floatval($tmp2)) * 10000));

        $taskid = md5('10802352'.$cnt.$time.substr($msec, 4, 10));

        return $taskid;
    }

    private function cache($task_id, $status, $expire, $desc){
        $this->redis->hset(TaskController::$HASHTABLE, $task_id, $status);
        $this->redis->hset(TaskController::$HASHTABLE_EXPIRE, $task_id, $expire);
        $this->redis->hset(TaskController::$HASHTABLE_DESC, $task_id, $desc);
        //$this->redis->hset(TaskController::$HASHTABLE_DECIM,$task_id,$decim);
    }


    public function paid($paid_account, $fee, $task_id){
        $baseUrl = \Config::get('uni.uni_api_server_ip'). 'account/trade' ; //请求地址

        $get = [];
        $post = [
            'cid' => $paid_account,
            'sign' => TaskController::$PUBLISHER_SIGN,
            'fee' => $fee,
            'trade_type'=> 'paid',
            'rel_account' => \Config::get('uni.UNI_ACCOUNT'),
            'order_id' => $task_id,
        ];

        $timestamp = time();
        $cid = $post['cid'];
        $get['cid'] = $cid;
        $get['timestamp'] = $timestamp; //时间戳
        $get['token'] = md5($cid.TaskController::$PUBLISHER_TOKEN.$timestamp);
        ksort($get);

        $query = http_build_query($get);
        $url = $query != null ? $baseUrl.  '?' . $query : $baseUrl;

        try {
            $response = \App\Http\Utils\Request::Post($url, $post);
            \Log::error($response['result']);
            \Log::error($response['reason']);
        } catch (Exception $e) {
            //$this->logger->fatal($e->getMessage());

            $response = '';
        }

        return $response;


    }

    private function makeFake($task_cnt, $now, $url_tmp){
        $task = new P2PTask();

        $expire = 1458638903;
        $image_url = $url_tmp == null ? '' : $url_tmp;

        $task_id = $this->genTaskID($task_cnt, $now);

        $task->task_id = $task_id;
        $task->issuer_id = TaskController::$PUBLISHER;
        $task->acceptor_id = 10988600;
        $task->type = 0;
        $task->title = '';
        $task->description =  'Uni 任务红包';
        $task->privacy = '恭喜你获得2000元校里创业基金';
        $task->payment = 0.01;
        $task->creationtime = $now; //在抽奖场景中，任务是随机排序的
        $task->expire = $expire;
        $task->viewer_num = 0;
        $task->issuer_comment = '';
        $task->acceptor_comment = '';
        $task->image_num = 0;
        $task->image_url = $image_url;
        $task->status = 1;
        $task->accept_time = $now;
        $task->school_id = 10111894;
        $task->school_name = '北京师范大学珠海分校';

        //更新数据库
        $task->save();

        $this->redis->hset(TaskController::$HASHTABLE, $task_id, 1);
        $this->redis->hset(TaskController::$HASHTABLE_EXPIRE, $task_id, $expire);
        $this->redis->hset(TaskController::$HASHTABLE_DESC, $task_id, 'Uni 任务红包');

        $this->paid(TaskController::$PUBLISHER, 0.01, $task_id);
    }
}

