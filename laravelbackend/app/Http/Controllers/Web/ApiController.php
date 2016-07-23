<?php
/**
 * Created by PhpStorm.
 * User: whoami
 * Date: 16-5-19
 * Time: 上午10:40
 */
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Admin\Base\BaseController;
use App\Http\Models\UserAccount;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Models\redis\Tasks;
use App\Http\Models\redis\SendTask;
use App\Http\Models\redis\UserTask;


use App\Http\Utils\KakatuService;
use App\Http\Utils\Request;
use Illuminate\Support\Facades\Redis as Redis;

use App\Http\Libs\TaskRedis;
use Illuminate\Support\Facades\DB;

class ApiController extends BaseController
{
    private $tasks;
    private $sendtask;
    private $usertask;
    private $taskredis;
    private $kakatuService;

    public function __construct()
    {
        parent::__construct();
        $this->redis = Redis::connection();
        $this->tasks = new Tasks();
        $this->sendtask = new SendTask();
        $this->usertask = new UserTask();
        $this->taskredis = new TaskRedis();
        $this->kakatuService = new KakatuService();
    }
    //app接口
    public function getTaskIndex()
    {
        $cid = \Input::get('cid');
        if(!empty($cid)){
            //获取正确的cid
            $a =strstr($cid,'$cid$cid=');
            if(!empty($a)){
                $cid = substr($cid,9);
            }
            //获取任务
            $tasks = $this->sendtask->get('is_task');

            if(!empty($tasks)){
                //发布任务。判断用户是否接受过该任务
                $task_arr = json_decode($tasks);
                //获取任务详细信息
                $task_info = $this->tasks->get('id_'.$task_arr->id);
                $taskinfo = json_decode($task_info);

                $usertask = $this->usertask->get($cid.'_'.$task_arr->id);
                $user_task = json_decode($usertask);

                if(!empty($usertask)){
                    //已接受任务，提醒用户分享
                    //调用卡卡兔接口获取用户推荐人数
                    $result = Request::Post('http://120.24.56.38/api/v1/membercard/recommendMembers',
                        array('bid' => 10118089,'cid' =>$cid,'start_time'=>$user_task->start_time));

                    if($result['result'] == 0){
                        $num = $result['members'];
                        if($num >= $taskinfo->share_num){
                            if($user_task->status == 0){
                                //返现金
                                $this->ReturnMoney($user_task);
                            }
                            return view('admin.school.usertask.task_success');
                        }else{
                            return view('admin.school.usertask.accept_task',compact('num'));
                        }
                    }else{
                        $num = 0;
                        return view('admin.school.usertask.accept_task',compact('num'));
                    }
                }else{
                    //未接受任务,判断任务数量
                    if($task_arr->num > 0){
                        return view('admin.school.usertask.no_accept_task',compact('taskinfo','cid'));
                    }else{
                        return view('admin.school.usertask.task_end');
                    }
                }
            }else{
                //没有任务发布,显示无任务页面
                return view('admin.school.usertask.no_task');
            }
        }else{
            return "无此用户，非法进入";
        }

    }

    //返现金红包
    public function ReturnMoney($user_task)
    {
        $taskredis = new TaskRedis();
        $usertaskarr = array('cid' => $user_task->cid, 'taskid' => $user_task->taskid, 'start_time'=>$user_task->start_time, 'money' => $user_task->money, 'status' => 1);
        $user_taskinfo = json_encode($usertaskarr);
        //更新usertask用户状态
        $taskredis->hdel('usertask',$user_task->cid.'_'.$user_task->taskid);
        $taskredis->hset('usertask',$user_task->cid.'_'.$user_task->taskid,$user_taskinfo);
        //返钱给用户
        $user_info = DB::table('weitown.wtown_account_balance')
            ->where('cid',$user_task->cid)
            ->get();
        $balance = (float)$user_info[0]->balance + (float)$user_task->money;
        DB::table('weitown.wtown_account_balance')
            ->where('cid',$user_task->cid)
            ->update(array('balance'=> $balance));
        //发送推送信息
        $msg = '分享任务完成，请到您的帐户中查询余额';
        $this->push($user_task->cid,$msg);
    }

    //用户接受任务接口
    public function accepttask()
    {
        $taskid = \Input::get('taskid');
        $cid = \Input::get('cid');
        $time = date('Y-m-d',time());

        if ($taskid && $cid) {
            //判断任务数量
            $usertask = $this->sendtask->get('is_task');
            $usertask = json_decode($usertask);
            if ($usertask->num > 0) {
                $money = rand(1, 10);
                $status = 0;
                $usertaskarr = array('cid' => $cid, 'taskid' => $taskid,'start_time'=>$time, 'money' => $money, 'status' => $status);
                $task = json_encode($usertaskarr);
                $this->usertask->set($cid . '_' . $taskid, $task);
                $this->sendtask->update('is_task');//更改数量
                //存金钱记录
                $this->taskredis->hset('task_money',$cid.'_'.$taskid,$money);
                return \Response::json(array('code' => 1));
            } else {
                return \Response::json(array('code' => 0));
            }

        } else {
            return \Response::json(array('code' => 2));
        }
    }

    private function push($cid, $msg){
        $module = 'umipush';
        $func = 'pushext';
        $user = UserAccount::where('cid', '=', $cid)->first();
        if(!$user) return false;
        $get = [];
        $post = [
            'cid' => $cid,
            'title' => '',
            'content' => $msg,
            'cmd' => 'c999',
            'extras' => '',
        ];
        if(!$user->token) return false;
        $result = $this->kakatuService->uniV1Request($user->token, $module, $func, $get, $post);
        if($result){
            if($result['reason'] == null) return true;
        }
        return false;
    }

}


