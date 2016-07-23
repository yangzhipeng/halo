<?php
/**
 * Created by PhpStorm.
 * User: whoami
 * Date: 16-5-20
 * Time: 下午3:57
 */
namespace App\Http\Models\redis;

use App\Http\Libs\TaskRedis;
use Illuminate\Support\Facades\Redis as Redis;

class SendTask {

    private $taskredis;
    private $key;

    public function __construct()
    {
        $this->redis = Redis::connection();
        $this->taskredis = new TaskRedis();
        $this->key = 'send_task';
    }

    public function get($field)
    {
        return $this->taskredis->hget($this->key,$field);
    }

    public function set($field,$value)
    {
        $this->taskredis->hset($this->key,$field,$value);
    }

    public function del($field)
    {
        $this->taskredis->hdel($this->key,$field);
    }

    public function zdel($member)
    {
        return $this->taskredis->zrem($this->zkey,$member);
    }

    public function update($field){
        $sendtask = $this->get($field);
        $task_arr = json_decode($sendtask);
        $num = (int)$task_arr->num - 1;

        $this->del($field);
        $arr = array ('id'=>$task_arr->id,'num'=>$num);
        $task = json_encode($arr);
        $this->set($field,$task);
    }



}