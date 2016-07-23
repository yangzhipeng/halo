<?php

namespace App\Console\Commands;

use App\Http\Models\UserAccount;
use Illuminate\Console\Command;

use App\Http\Utils\Request;
use Illuminate\Support\Facades\Redis as Redis;

use App\Http\Libs\TaskRedis;
use Illuminate\Support\Facades\DB;
use App\Http\Utils\KakatuService;

class UserTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:task';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '任务处理';

    private $kakatuService;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->redis = Redis::connection();
        $this->kakatuService = new KakatuService();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $taskredis = new TaskRedis();
        $usertask = $taskredis->hvals('usertask');
        //判断是否有人接受任务
        if($usertask){
            //接受任务
            foreach($usertask as $task){
                $task_arr = json_decode($task);
                //判断接受任务的用户是否处理（已返钱）
                if($task_arr->status == 1){
                    //已返钱
                    continue;
                }else{//未返钱
                    //获取任务的详细信息
                    $tasks = $taskredis->hget('tasks','id_'.$task_arr->taskid);
                    $tasksarr = json_decode($tasks);
                    //调用卡卡兔接口获取用户推荐人数
                    $result = Request::Post('http://120.24.56.38/api/v1/membercard/recommendMembers',
                        array('bid' => 10118089,'cid' => $task_arr->cid,'start_time' => $task_arr->start_time));
                    //判断是否有此用户记录
                    if($result['result'] == 4001){
                       // print_r('无此用户');
                        \Log::warning("none");
                    }else{
                        $share_num = $result['members'];
                        //判断分享次数是否足够
                        if($share_num >= $tasksarr->share_num){
                            //分享次数足够
                            $usertaskarr = array('cid' => $task_arr->cid, 'taskid' => $task_arr->taskid,'start_time'=>$task_arr->start_time, 'money' => $task_arr->money, 'status' => 1);
                            $user_task = json_encode($usertaskarr);
                            //更新usertask用户状态
                            $taskredis->hdel('usertask',$task_arr->cid.'_'.$task_arr->taskid);
                            $taskredis->hset('usertask',$task_arr->cid.'_'.$task_arr->taskid,$user_task);
                            //返钱给用户
                            $user_info = DB::table('weitown.wtown_account_balance')
                                ->where('cid',$task_arr->cid)
                                ->get();
                            $balance = (float)$user_info[0]->balance + (float)$task_arr->money;
                            DB::table('weitown.wtown_account_balance')
                                ->where('cid',$task_arr->cid)
                                ->update(array('balance'=> $balance));
                            //发送推送信息
                            $msg = '分享任务完成，请到您的帐户中查询余额';
                            $this->push($task_arr->cid,$msg);
                            \Log::warning($task_arr->cid."返钱成功");
                        }else{
                            \Log::warning("无满足条件用户");
                        }
                    }
                }
            }
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
