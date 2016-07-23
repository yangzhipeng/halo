<?php
/**
 * Created by PhpStorm.
 * User: dengzhou
 * Date: 16/5/26
 * Time: 下午2:32
 */

namespace App\Http\Utils;



class KakatuService
{
    public function __construct(){
//        $this->uni_server = 'http://120.25.218.232:80/api/v1/';
        $this->uni_server = 'http://120.24.56.38:80/api/v1/';
        $this->uni_secrect = "WeiTown_Token";
    }

    /**
     * 校里系统直接调用卡卡兔系统接口
     * @param $module 模块
     * @param $func 方法
     * @param $get get参数
     * @param $post post参数
     */
    public function uniV1Request($token, $module, $func, $get, $post){
        if(!array_key_exists("cid", $post)){
            throw new \Exception("缺少cid");
        }

        $baseUrl = $this->uni_server; //请求地址
        $timestamp = strtotime(date('Y-m-d H:i:s'));
        $cid = $post['cid'];

        $get['cid'] = $cid;
        $get['timestamp'] = $timestamp; //时间戳
        $get['token'] = md5($cid.$token.$timestamp);
        ksort($get);

        $query = http_build_query($get);
        if ($query) {
            $url = $baseUrl.  $module . '/' . $func . '?' . $query;
        }

        //echo $url;
        try {
            $response = Request::Post($url, $post);
        } catch (\Exception $e) {

            $response = '';
        }

        return $response;

    }

}