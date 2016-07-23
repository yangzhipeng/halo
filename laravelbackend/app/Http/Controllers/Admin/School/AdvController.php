<?php

namespace App\Http\Controllers\Admin\School;

use App\Http\Controllers\Admin\Base\BaseController;
use App\Http\Models\Adv;
use App\Http\Models\School;
use App\Http\Utils\Upload;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdvController extends BaseController
{
    //
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    public function createTopBannerAdv($schoolid = NULL)

    {
        $route = array(
            'title' => 'required',
            'outerurl' => 'required'
        );

        $validator = \Validator::make(\Input::all(), $route);

        if($validator->fails())
        {
            return \Redirect::back()->withInput()->withErrors($validator->errors());
        }

        $school = School::where('bid', '=', $schoolid)->first();

        if(!$school)
        {
            return \Redirect::back()->with('error', 'bid错误!');
        }

        $content_type = \Input::get('content_type');

        if(!$content_type)
        {
            $content_type = 1;
        }

        if($content_type == 2)
        {
            if(!\Input::get('flex'))
            {
                return \Redirect::back()->with('error', '富文本内容为空');
            }
        }

        $newAdv = new Adv();

        $newAdv->ownerid = $schoolid;

        $newAdv->type = 4;
        $newAdv->status = 1;
        $newAdv->title = \Input::get('title');
        $newAdv->outerurl = \Input::get('outerurl');
        $imageUrl = Upload::getInstance()->uploadImage(\Input::file('file'));
        if($imageUrl)
        {
            $newAdv->imageurl = $imageUrl['imageurl'];
            $newAdv->image_md5 = $imageUrl['image_md5'];
        }
//        $newAdv->author = \Input::get('author');
        $newAdv->author = \Auth::getUser()->hasOneAdminInfo->admin_name;
        $newAdv->appid = $this->app_id;
        $newAdv->content_type = $content_type;
        $newAdv->flex = '外部广告';
        $newAdv->creationtime = strtotime(date('Y-m-d H:i:s'));

        $newAdv->save();

        return \Redirect::back()->with('success', '新增广告成功');
    }

    public function postUpdate($advId = NULL)
    {
        $route = array(
            'title' => 'required',
            'outerurl' => 'required',
        );

        $validator = \Validator::make(\Input::all(), $route);

        if($validator->fails())
        {
            return \Redirect::back()->withInput()->withErrors($validator->errors());
        }

        $adv = Adv::find($advId);

        if(!$adv)
        {
            return \Redirect::back()->with('error', '没有找到该广告');
        }


        if($adv->content_type == 2)
        {
            if(!\Input::get('flex'))
            {
                return \Redirect::back()->with('error', '富文本内容为空');
            }
        }

        $adv->title = \Input::get('title');
        $adv->outerurl = \Input::get('outerurl');
        $imageUrl = Upload::getInstance()->uploadImage(\Input::file('file'));
        if($imageUrl)
        {
            $adv->imageurl = $imageUrl['imageurl'];
            $adv->image_md5 = $imageUrl['image_md5'];
        }
        $adv->flex = \Input::get('flex');

        $adv->save();

        return \Redirect::back()->with('success', '修改广告成功');
    }


    public function getDelete($advId = NULL)
    {
        $adv = Adv::find($advId);

        if(!$adv)
        {
            return \Redirect::back()->with('error', '没有找到该广告');
        }

        $adv->delete();

        return \Redirect::back()->with('success', '删除广告成功');
    }

    public function postStatus()
    {
        $advId = \Input::get('advId');
        $status = \Input::get('status');

        $adv = Adv::find($advId);

        if(!$adv)
        {
            return \Response::json(array('code' => -1));
        }

        if($status != 0)
        {
            $adv->status = 1;
            $code = 1;
        }else{
            $adv->status = 0;
            $code = 0;
        }

        $adv->save();

        return \Response::json(array('code' => $code));
    }


    public function createAdvStyle1($schoolid = NULL){
        $route = array(
            'title0' => 'required',
            'outerurl0' => 'required',
        );

        $validator = \Validator::make(\Input::all(), $route);
        if($validator->fails())
        {
            return \Redirect::back()->withInput()->withErrors($validator->errors());
        }

        $adv = Adv::orderBy('set', 'desc')->first();
        //日后要考虑并行情况
        $set_num = (int)$adv['set'] + 1;
        $this->createMultiStyleAdv(1, $set_num, $schoolid);

        return \Redirect::back()->with('success', '新增广告成功');
    }

    public function createAdvStyle2($schoolid = NULL){
        $route = array(
            'title0' => 'required',
            'outerurl0' => 'required',
            'title1' => 'required',
            'outerurl1' => 'required'
        );

        $validator = \Validator::make(\Input::all(), $route);
        if($validator->fails())
        {
            return \Redirect::back()->withInput()->withErrors($validator->errors());
        }

        $adv = Adv::orderBy('set', 'desc')->first();
        //日后要考虑并行情况
        $set_num = (int)$adv['set'] + 1;
        $this->createMultiStyleAdv(2, $set_num, $schoolid);

        return \Redirect::back()->with('success', '新增广告成功');
    }

    public function createAdvStyle3($schoolid = NULL){
        $route = array(
            'title0' => 'required',
            'outerurl0' => 'required',
            'title1' => 'required',
            'outerurl1' => 'required',
            'title2' => 'required',
            'outerurl2' => 'required'
        );

        $validator = \Validator::make(\Input::all(), $route);
        if($validator->fails())
        {
            return \Redirect::back()->withInput()->withErrors($validator->errors());
        }

        $adv = Adv::orderBy('set', 'desc')->first();
        //日后要考虑并行情况
        $set_num = (int)$adv['set'] + 1;
        $this->createMultiStyleAdv(3, $set_num, $schoolid);

        return \Redirect::back()->with('success', '新增广告成功');
    }

    public function createAdvStyle4($schoolid = NULL){
        $route = array(
            'title0' => 'required',
            'outerurl0' => 'required',
            'title1' => 'required',
            'outerurl1' => 'required',
            'title2' => 'required',
            'outerurl2' => 'required',
            'title3' => 'required',
            'outerurl3' => 'required'
        );

        $validator = \Validator::make(\Input::all(), $route);
        if($validator->fails())
        {
            return \Redirect::back()->withInput()->withErrors($validator->errors());
        }

        $adv = Adv::orderBy('set', 'desc')->first();
        //日后要考虑并行情况
        $set_num = (int)$adv['set'] + 1;
        $this->createMultiStyleAdv(4, $set_num, $schoolid);

        return \Redirect::back()->with('success', '新增广告成功');
    }

    public function delMultiStyleAdv($setId){
        $advs = Adv::where('set', '=', $setId)->get();

        if(!$advs)
        {
            return \Redirect::back()->with('error', '没有找到该组广告');
        }

        foreach($advs as $adv){
            $adv->delete();
        }

        return \Redirect::back()->with('success', '删除广告成功');
    }

    private function createMultiStyleAdv($style_num, $set_num, $schoolid = NULL){
        $content_type = \Input::get('content_type');
        $content_type = $content_type == null ? 3 : $content_type;
        if ($content_type == 4) {
            if (!\Input::get('flex')) {
                return \Redirect::back()->with('error', '富文本内容为空');
            }
        }

        for($i = 0; $i < $style_num; $i++) {
            $tag_title = 'title'.$i;
            $tag_outerurl = 'outerurl'.$i;
            $tag_ownerid = 'ownerid'.$i;
            $tag_file = 'file'.$i;

            $newAdv = new Adv();

            $newAdv->title  = \Input::get($tag_title);
            $newAdv->outerurl = \Input::get($tag_outerurl);
            $newAdv->ownerid = $schoolid == null ? 0 : $schoolid;
            $newAdv->type = 4;
            $newAdv->status = 1;
            $newAdv->content_type = $content_type;
            $newAdv->style = $style_num;
            $newAdv->set = $set_num;

            $imageUrl = Upload::getInstance()->uploadImage(\Input::file($tag_file));
            if($imageUrl)
            {
                $newAdv->imageurl = $imageUrl['imageurl'];
                $newAdv->image_md5 = $imageUrl['image_md5'];
            }

            $newAdv->author = \Auth::getUser()->hasOneAdminInfo->admin_name;
            $newAdv->appid = $this->app_id;

            $newAdv->flex = '外部广告';
            $newAdv->creationtime = strtotime(date('Y-m-d H:i:s'));

            $newAdv->save();
        }

    }

}
