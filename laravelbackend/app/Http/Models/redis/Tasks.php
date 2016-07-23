<?php
/**
 * Created by PhpStorm.
 * User: whoami
 * Date: 16-5-20
 * Time: 下午2:56
 */
namespace App\Http\Models\redis;

use App\Http\Libs\TaskRedis;
use Illuminate\Support\Facades\Redis as Redis;

class Tasks {

    private $taskredis;
    private $key;
    private $zkey;

    public function __construct()
    {
        $this->redis = Redis::connection();
        $this->taskredis = new TaskRedis();
        $this->key = 'tasks';
        $this->zkey = 'task_order';
    }

    public function get($field)
    {
        return $this->taskredis->hget($this->key,$field);
    }

    public function zget($start,$end)
    {
        return $this->taskredis->zrange($this->zkey,$start,$end);
    }

    public function set($field,$id,$title,$num,$share_num,$status)
    {
        $taskarr = array ('id'=>$id,'title'=>$title,'num'=>$num,'share_num'=>$share_num,'status'=>$status);
        $task = json_encode($taskarr);
        $this->taskredis->hset($this->key,$field,$task);
        $this->zset('id_'.$id,$id);
    }

    public function zset($member,$score)
    {
        $this->taskredis->zadd($this->zkey,$member,$score);
    }

    public function del($field)
    {
        $this->taskredis->hdel($this->key,$field);
    }

    public function zdel($member)
    {
        $this->taskredis->zrem($this->zkey,$member);
        //$this->del($member);
    }

    public function update($field)
    {
        $tasks = $this->get($field);
        $task_value = $this->taskredis->hmget($this->key,$field);
        if($task_value){
            foreach($task_value as $task_v){
                $taskarr = json_decode($task_v);
            }
        }
        $this->del($field);
        $arr = array ('id'=>$taskarr->id,'title'=>$taskarr->title,'num'=>$taskarr->num,'share_num'=>$taskarr->share_num,'status'=>1);
        $task = json_encode($arr);
        $this->taskredis->hset($this->key,$field,$task);

    }

}