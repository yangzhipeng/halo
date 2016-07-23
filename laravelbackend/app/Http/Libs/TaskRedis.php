<?php
/**
 * Created by PhpStorm.
 * User: whoami
 * Date: 16-5-19
 * Time: 上午10:41
 */
namespace App\Http\Libs;

use Illuminate\Support\Facades\Redis as Redis;

class TaskRedis
{
    public function __construct()
    {
        $this->redis = Redis::connection();
    }

    public function get($key)
    {
        return $this->redis->get($key);
    }

    public function set($key, $value, $expire = 0)
    {
        if(!$expire || $expire < 0)
        {
            return $this->redis->set($key, $value);
        }else
        {
            return $this->redis->setex($key, $expire, $value);
        }
    }

    public function hget($key,$field)
    {
        return $this->redis->hget($key,$field);
    }

    public function hset($key,$field,$value)
    {
        return $this->redis->hset($key,$field,$value);
    }

    public function hvals($key)
    {
        return $this->redis->hvals($key);
    }

    public function hmget($key,$field)
    {
        return $this->redis->hmget($key,$field);
    }

    public function hdel($key, $fields = array())
    {
        if(!is_array($fields))
        {
            $fields = [$fields];
        }
        return $this->redis->hdel($key, $fields);
    }

    public function hlen($key)
    {
        return $this->redis->hLen($key);
    }


    public function hexists($key, $field)
    {
        return $this->redis->hexists($key, $field);
    }



    public function zadd($key, $member, $score)
    {
        return $this->redis->zadd($key, $score, $member);
    }



    public function zrange($key, $start, $stop, $options = array())
    {
        return $this->redis->zrange($key, $start, $stop, $options);
    }

    public function zrem($key, $member)
    {
        return $this->redis->zrem($key, $member);
    }


}