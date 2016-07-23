<?php
/**
 * Created by PhpStorm.
 * User: whoami
 * Date: 16-5-19
 * Time: 上午10:40
 */
namespace App\Http\Controllers\Admin\School;

use App\Http\Controllers\Admin\Base\BaseController;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Models\redis\Tasks;
use App\Http\Models\redis\SendTask;
use App\Http\Models\redis\UserTask;


use App\Http\Utils\Request;
use Illuminate\Support\Facades\Redis as Redis;

use App\Http\Libs\TaskRedis;
use Illuminate\Support\Facades\DB;

class UserTaskController extends BaseController
{
    private $tasks;
    private $sendtask;
    private $usertask;

    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
        $this->redis = Redis::connection();
        $this->tasks = new Tasks();
        $this->sendtask = new SendTask();
        $this->usertask = new UserTask();
    }

    public function test()
    {
        // $aa =  $this->redis->hmget('send_task','is_task');
        //$aa = json_decode($aa[0]);
        $z_tasks = $this->redis->zrange('task_order',0,-1);
        $a =$this->redis->hvals('tasks');
        $b =$this->sendtask->get('is_task');
        $c = $this->redis->hvals('usertask');
        $d = $this->redis->hgetall('task_money');
        print_r('task_order:');
        print_r($z_tasks);
        print_r("<hr/>");
        print_r('tasks:');
        print_r($a);
        print_r("<hr/>");
        print_r('is_task:');
        print_r($b);
        print_r("<hr/>");
        print_r('usertask:');
        print_r($c);
        print_r("<hr/>");
        print_r('task_money:');
        print_r($d);
        exit;
        $a =  $this->redis->ZREMRANGEBYRANK('task_order',0,-1);
        $b =  $this->redis->del('send_task');
        $c =  $this->redis->del('usertask');
        $d =  $this->redis->del('tasks');
        $e =  $this->redis->del('task_money');
    }

    //后台显示任务
    public function getIndex()
    {
        $z_tasks = $this->tasks->zget(0,-1);
        $taskarr = array();
        foreach($z_tasks as $z){
            $tasks = NULL;
            $tasks = $this->tasks->get($z);
            if(!$tasks){
                $tasks = $this->sendtask->get('is_task');
            }
            if(empty($tasks)){
                return \Redirect::back()->with('error', '未知错误');
            }else{
                $taskarr[] = json_decode($tasks);
            }
        }

        return view('admin.school.usertask.index', compact('taskarr'));
    }

    //后台添加任务
    public function sendTask()
    {
        $route = array(
            'title' => 'required',
            'num' => 'required',
            'share_num' => 'required',
        );

        $validator = \Validator::make(\Input::all(), $route);

        if($validator->fails())
        {
            return \Redirect::back()->withInput()->withErrors($validator->errors());
        }

        $id = strtotime(date('Y-m-d H:i:s',time()));
        $title = \Input::get('title');
        $num = \Input::get('num');
        $share_num = \Input::get('share_num');
        $status = 0;

        $this->tasks->set('id_'.$id,$id,$title,$num,$share_num,$status);

        return \Redirect::back()->with('success', '新增任务成功');
    }

    //后台发布任务
    public function postStatus()
    {
        $taskid = \Input::get('taskid');
        $status = \Input::get('status');

        if($status == 1)
        {
            $tasks = $this->tasks->get('id_'.$taskid);
            if(!$tasks)
            {
                return \Response::json(array('code' => -1));
            }
            //判断之前有没有发布任务
            $is_task = $this->sendtask->get('is_task');

            if(!empty($is_task)){
                //如果有记录则返回提示，不能发布
                return \Response::json(array('code' => 2));
            }else{
                $taskarr = json_decode($tasks);
                $task_arr = array ('id'=>$taskid,'num'=>$taskarr->num);
                $task = json_encode($task_arr);
                $this->sendtask->set('is_task',$task);
                $this->tasks->update('id_'.$taskid);
                $code = 1;
            }
        }else{
            $code = 0;
        }

        return \Response::json(array('code' => $code));
    }

    //后台删除任务
    public function getDeleteTask($taskid = NULL)
    {
        $tasks = $this->tasks->get('id_'.$taskid);

        if($tasks)
        {
            $this->tasks->zdel('id_'.$taskid);
            //判断是否为发布任务
            $task_id = $this->sendtask->get('is_task');
            $sendtask = json_decode($task_id);
            if($task_id && $sendtask->id == $taskid){
                $this->sendtask->del('is_task');
            }
            return \Redirect::back()->with('success', '删除任务成功');
        }else{
            return \Redirect::back()->with('error', '没有找到该任务');
        }
    }

}


