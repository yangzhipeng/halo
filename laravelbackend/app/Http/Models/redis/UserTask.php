<?php
/**
 * Created by PhpStorm.
 * User: whoami
 * Date: 16-5-23
 * Time: 上午9:25
 */
namespace App\Http\Models\redis;

use App\Http\Libs\TaskRedis;
use Illuminate\Support\Facades\Redis as Redis;

class UserTask {

    private $taskredis;
    private $key;

    public function __construct()
    {
        $this->redis = Redis::connection();
        $this->taskredis = new TaskRedis();
        $this->key = 'usertask';
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

    public function save(){

    }

}