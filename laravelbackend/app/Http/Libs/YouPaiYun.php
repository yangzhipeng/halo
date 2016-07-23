<?php
// $bucketName = 'kakatool';
// $ypy = new YouPaiYun('sense', 'k@k@2123');
// $result = $ypy->upload('D:/php5.5/testsrc/2.jpg', $bucketName, 'abc.jpg');
// echo $result . "\n";
/*
 * 又拍云api
 * 
 */
namespace App\Http\Libs;

class YouPaiYun
{
	private $operatorName = 'kakatool';
	private $operatorPwd = 'k@k@2123';

	public function __construct($config = array())
	{
		if (isset($config['operatorName'])) {
			$this->operatorName = $config['operatorName'];
		}
		if (isset($config['operatorPwd'])) {
			$this->operatorPwd = $config['operatorPwd'];
		}
	}

	public function upload($filePath, $bucketName, $serverPath)
	{
		if (!file_exists($filePath)) {
			return false;
		}
		$fileSize = filesize($filePath);
		if ($fileSize <= 0) {
			return false;
		}
		//文件上传到服务器的服务端路径
		$uri = "/$bucketName/$serverPath";

		//生成签名时间。得到的日期格式如：Thu, 11 Jul 2014 05:34:12 GMT
		$date = gmdate('D, d M Y H:i:s \G\M\T');
		$sign = md5("PUT&{$uri}&{$date}&{$fileSize}&" . md5($this->operatorPwd));

		$ch = curl_init('http://v0.api.upyun.com' . $uri);

		$headers = array(
			"Expect:",
			"Date: " . $date, // header 中需要使用生成签名的时间
			"Authorization: UpYun $this->operatorName:" . $sign
		);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_PUT, true);

		$fh = fopen($filePath, 'rb');
		curl_setopt($ch, CURLOPT_INFILE, $fh);
		curl_setopt($ch, CURLOPT_INFILESIZE, $fileSize);
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		$result = curl_exec($ch);
		if (curl_getinfo($ch, CURLINFO_HTTP_CODE) === 200) {
			$result = $bucketName . '.b0.upaiyun.com/' . $serverPath;
		} else {
			//echo $result . "\n";
			$result = false;
		}
		curl_close($ch);
		return $result;
	}
}
