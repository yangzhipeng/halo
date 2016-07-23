<?php
/**
 * Created by PhpStorm.
 * User: whoami
 * Date: 16-3-23
 * Time: 下午6:06
 */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Base\BaseController;
use App\Http\Libs\YouPaiYun;
use App\Http\Models\CardCategory;
use App\Http\Models\School;
use App\Http\Models\Industry;
use App\Http\Models\Subindustry;
use App\Http\Utils\Upload;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
//use Illuminate\Support\Facades\Redis as Redis;

class CardcategoryController extends BaseController
{
    //
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
        //$this->redis = Redis::connection();
    }

    //会员卡分类首页
    public function getVipCardIndex()
    {
        $schools = new School();
        $schools = $schools->getSchoolInfo();

        $cardCategory = new CardCategory();
        //获取分类
        $industry = new Industry();
        $industrys = $industry->getIndustry();

        //获取子分类
        $subindustry = new Subindustry();
        $subindustrys = $subindustry->getSubindustry();
        //获取所有子分类,以便修改使用
        $allsubindustrys = $subindustry->getAllSubindustry();

        $query = \Input::get('query');
        if(!$query)
        {
            /*
            $cacheCard = $this->redis->get('cardlist');
            //判断是否存入redis,优先读取redis
            if( $cacheCard )
            {
                $cards = unserialize($cacheCard);
                //写日志测试
                $str = "redis".date('Y-m-d H:i:s',time());
                $open=fopen("log.txt","a" );
                fwrite($open,$str);
                fclose($open);

                return view('admin.adv.vip_card_index', compact('cards','schools'));
            }else
            {
            */
            $cards = $cardCategory->getCardCategory();
            /*
                //存入redis
                $this->redis->set('cardlist',serialize($cards));
            */
            return view('admin.cardcategory.vip_card_index', compact('cards','schools','industrys','subindustrys','allsubindustrys'));
            //}
        }else
        {
            $cards = $cardCategory->getCardCategory($query);

            return view('admin.cardcategory.vip_card_index', compact('cards', 'schools','industrys','subindustrys','allsubindustrys','query'));
        }
    }
    //添加会员卡分类
    public function createCardCategory()
    {
        $route = array(
            'name' => 'required',
            'actionurl' => 'required'
        );

        $validator = \Validator::make(\Input::all(), $route);

        if($validator->fails())
        {
            return \Redirect::back()->withInput()->withErrors($validator->errors());
        }

        $card = new CardCategory();

        $card->actiontype = 1;
        $card->status = 1;
        $card->name = \Input::get('name');
        $card->actionurl = \Input::get('actionurl');
        $card->school_id = \Input::get('school');
        $cardNames = $card->getCardName($card->school_id);
        foreach($cardNames as $cardName)
        {
            if($cardName->name == $card->name)
            {
                return \Redirect::back()->withInput()->withErrors('您已经为该学校添加过此分类,请不要重复添加');
            }
        }
        $card->industryid = \Input::get('industry');
        $card->subindustryid = \Input::get('subindustry');
        $imageUrl = Upload::getInstance()->uploadImage(\Input::file('file'));
        if($imageUrl)
        {
            $card->iconurl = $imageUrl['imageurl'];
        }
        $card->save();

        //$this->redis->del('cardlist');

        return \Redirect::back()->with('success', '新增分类成功');
    }
    //修改会员卡分类
    public function postUpdateCard($cardId = NULL)
    {
        $route = array(
            'name' => 'required',
            'actionurl' => 'required',
        );

        $validator = \Validator::make(\Input::all(), $route);

        if($validator->fails())
        {
            return \Redirect::back()->withInput()->withErrors($validator->errors());
        }

        $card = CardCategory::find($cardId);

        if(!$card)
        {
            return \Redirect::back()->with('error', '没有找到该分类');
        }
        $card->school_id = \Input::get('school');
        $card->name = \Input::get('name');
        $card->actionurl = \Input::get('actionurl');
        $card->industryid = \Input::get('industry');
        $card->subindustryid = \Input::get('subindustry');
        $imageUrl = Upload::getInstance()->uploadImage(\Input::file('file'));
        if($imageUrl)
        {
            $card->iconurl = $imageUrl['imageurl'];
        }

        $card->save();

        return \Redirect::back()->with('success', '修改会员卡分类成功');
    }
    //删除会员卡分类
    public function getDeleteCard($cardId = NULL)
    {
        $card = CardCategory::find($cardId);
        if(!$card)
        {
            return \Redirect::back()->with('error', '没有找到该分类');
        }

        $card->delete();

        return \Redirect::back()->with('success', '删除会员卡分类成功');
    }

    public function postCardStatus()
    {
        $cardId = \Input::get('cardId');
        $status = \Input::get('status');

        $card = CardCategory::find($cardId);

        if(!$card)
        {
            return \Response::json(array('code' => -1));
        }

        if($status != 0)
        {
            $card->status = 1;
            $code = 1;
        }else{
            $card->status = 0;
            $code = 0;
        }

        $card->save();

        return \Response::json(array('code' => $code));
    }
    //根据行业分类改变
    public function postChangecategory()
    {
        $industryId = \Input::get('industryId');

        $subindustry = new Subindustry();
        $subindustrys = $subindustry->getSubindustry($industryId);

        return \Response::json($subindustrys);
    }

}
