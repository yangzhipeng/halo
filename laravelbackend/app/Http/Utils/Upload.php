<?php
/**
 * Created by PhpStorm.
 * User: dengzhou
 * Date: 15/11/19
 * Time: 下午5:36
 */
namespace App\Http\Utils;

use App\Http\Libs\YouPaiYun;

class Upload {

    private static $_instance;

    private function __construct()
    {

    }

    public function _clone(){}

    public static function getInstance()
    {
        if(!(self::$_instance instanceof self))
        {
            self::$_instance = new self;
        }

        return self::$_instance;
    }

    public  function uploadImage($file, $isLocal = false, $url = NULL)
    {
        if($file)
        {
            if(is_file($file))
            {
              if($file->isValid())
              {

                  $extension = $file->getClientOriginalExtension(); //文件后缀

                  $extension = strtolower($extension);


                  if($extension !== 'jpg' and $extension !== 'png' and  $extension !== 'jpeg')
                  {
                      return false;
                  }

                  if($file->getClientSize() > 1024 * 1024)
                  {
                      return false;
                  }

                  $clientName = $file->getClientOriginalName(); //上传文件的名字
                  $tmpName = $file->getFilename();     //存在临时目录的文件名
                  $realPath = $file->getRealPath();    //临时文件的绝对路径
                  $mimeType = $file->getMimeType();


                  if(!$isLocal)
                  {
                      $newImagefileName = 'notice.imageurl.upload.' .
                          strtotime(date('Y-m-d H:i:s')).
                          '.'.md5(substr($clientName, 0, strrpos($clientName, '.'))).$extension;


                      $newFilePath = $file->move('storage/uploads', $newImagefileName);
                      $newFilePath = public_path().'/'.$newFilePath;

                      $newImageMd5 = md5_file($newFilePath);

                      if(!$url)
                      {
                          $imageUrl = 'notice/image' . date('/Y/m/d/')
                              . $newImageMd5 . '.'. $extension;
                      }else
                      {
                          $imageUrl = $url . date('/Y/m/d/')
                              . $newImageMd5 . '.'. $extension;
                      }

                      //同步到又拍云
                      $ypyouConfig = \Config::get('uni.upyun');

                      $youpaiyun = new YouPaiYun($ypyouConfig);

                      if($youpaiyun->upload($newFilePath, $ypyouConfig['bucketname'], $imageUrl) == false)
                      {
                          return false;
                      }

                      if(file_exists($newFilePath))
                      {
                          unlink($newFilePath);
                      }



                      return array('imageurl' => $imageUrl,
                          'image_md5' => $newImageMd5);
                  }else
                  {
                      $basePath = '/www/weitown/trunk/www/';
//                      $savePath = public_path().'/storage/uploads';
                      $savePath = $basePath.'upload/dantin';

//                      if(file_exists($savePath.'/'.$clientName.'.'.$extension))
//                      {
//                          if(!unlink($savePath.'/'.$clientName.'.'.$extension))
//                          {
//                              return  false;
//                          }
//                      }

                      $newFilePath = $file->move($savePath, $clientName);

                      $imageLocalUrl = 'upload/dantin/'.$clientName;

                      return $imageLocalUrl;
                  }

              }
              else{
                 return false;
              }
            }

        }else{
            return false;
        }
    }

}