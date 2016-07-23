<?php
/**
 * Created by PhpStorm.
 * User: uni
 * Date: 15/12/10
 * Time: 上午11:58
 */
namespace App\Http\Utils;

use \Exception;

class Request
{


    /**
     * curl 句柄
     * @var
     */
    private static $curl;

    /**
     * curl 默认参数
     * @var array
     */
    private static $defaultOption = array(
        //CURLOPT_URL => '',
        CURLOPT_REFERER => 'weitown.kakatool.com',
        CURLOPT_USERAGENT => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/35.0.1916.153 Safari/537.36',
        CURLOPT_TIMEOUT => 20,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        //CURLOPT_HTTPHEADER => array(),
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
    );

    /**
     * 设置curl参数
     * @var array
     */
    private static $options = array();


    public function __construct()
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_TIMEOUT, 20);

        static::$curl = $curl;
    }

    /**
     * 获取/设置参数
     * @param array $option
     * @return array|bool
     */
    public static function Option(array $option = array())
    {
        if (!$option) {
            return static::$options ? static::$options : static::$defaultOption;
        } else {
            if (static::$options) {
                static::$options[CURLOPT_URL] = $option[CURLOPT_URL];
                static::$options[CURLOPT_POST] = $option[CURLOPT_POST];
                static::$options[CURLOPT_POSTFIELDS] = $option[CURLOPT_POSTFIELDS];
                static::$options[CURLOPT_HTTPHEADER] = $option[CURLOPT_HTTPHEADER];
                //static::$options = static::$options + $option;
            } else {
                static::$options = static::$defaultOption + $option;
            }
            return static::$options;
        }
    }

    /**
     * 发送请求
     * @param array $options
     * @return array
     */
    private static function send(array $options = array())
    {
        $result = array(
            'result' => '0',
            'reason' => '',
        );
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_TIMEOUT, 20);

        static::$curl = $curl;
        if ($options) {
            curl_setopt_array(static::$curl, $options);
        } else {
            return $result;
        }

        $response = curl_exec(static::$curl);

        //$ci = &get_instance();
        //$ci->log->write_log('error','=============' . static::$curl . '==========' . $response);

        $error = curl_error(static::$curl);


        if ($error != '') {
            $result['result'] = '9999';
            $result['reason'] = $error;
            return $result;
        }

        return @json_decode($response, true);

    }
    /**
     * GET 请求
     * @param string $url
     * @param array $post
     * @param array $options
     * @param array $header
     * @return array
     */
    public static function Get($url = '')
    {
        $result = array(
            'result' => '0',
            'reason' => '',
        );
        $headers = array(
            'appKey: 4146220492',
            'license: jbmwwO4Lyv55IEwp/ahW4FPuLqseal5XFHiRZINAGUbHWbzjdP6m5JUqQ4yt7pIl',
        );

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_TIMEOUT, 20);

        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        $response =  curl_exec($curl);
        $error = curl_error($curl);
        curl_close($curl);
        if ($error != '') {
            $result['result'] = '9999';
            $result['reason'] = $error;
            return $result;
        }

        return @json_decode($response, true);
    }


    /**
     * POST 请求
     * @param string $url
     * @param array $post
     * @param array $options
     * @param array $header
     * @return array
     */
    public static function Post($url = '', array $post = array(), array $options = array(), array $header = array())
    {
        $setHeader = array(
            'Connection: Keep-Alive',
            'Content-type: application/x-www-form-urlencoded; charset=UTF-8'
        );
        if ($header) {
            $setHeader += $header;
        }

        $options[CURLOPT_URL] = $url;
        $options[CURLOPT_POST] = true;
        $options[CURLOPT_POSTFIELDS] = http_build_query($post);
        $options[CURLOPT_HTTPHEADER] = $setHeader;

        return static::send(static::Option($options));
    }

    public static function kakaCicRequest($module, $func, $get, $post){
        $cicConfig = \Config::get('uni.kaka_cic_account');

        if(!$cicConfig){
            return '';
        }

        $account = $cicConfig['account']; //对接账号
        $secret = $cicConfig['secrect']; //秘钥
        $baseUrl = $cicConfig['server']; //请求地址

        $get['timestamp'] = time(); //时间戳
        $get['cmdid'] = rand(1, 100000000); //命令号，防止重复请求多次
        $get['account'] = $account;

        ksort($get);
        $params = '';
        foreach ($get as $key => $value) {
            if ($key != 'sign') {
                $params .= '&' . $key . '=' . rawurlencode($value);
            }
        }
        $params = substr($params, 1);
        $url = 'cic/' . $module . '/' . $func;

        $sign = md5($url . '?' . $params . "&secret=" . $secret);
        $get['sign'] = $sign;

        $query = http_build_query($get);
        if ($query) {
            $url = $baseUrl.$url . '?' . $query;
        }

        try {
            $response = self::Post($url, $post);
        } catch (Exception $e) {
            $response = '';

            throw new Exception($e->getMessage(),$e->getCode());
        }

        return $response;

    }

    public function __destruct()
    {
        curl_close(static::$curl);
    }
}