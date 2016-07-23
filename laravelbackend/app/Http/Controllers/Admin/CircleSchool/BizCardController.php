<?php
/**
 * Created by PhpStorm.
 * User: uni
 * Date: 16/2/17
 * Time: 下午5:13
 */


namespace App\Http\Controllers\Admin\CircleSchool;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Http\Controllers\Admin\Base\BaseController;
use App\Http\Models\UmiRecommendBizCard;
use App\Http\Models\UmiBizCard2School;

use App\Http\Requests;

class BizCardController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    public function index($schoolid = NULL){
        $bid = \Input::get('query');
        $bizcards_temp = $this->getBizinfo($bid);

        $unibizcards = DB::table('umi_recommend_bizcard')
            ->join('umi_card2school','umi_recommend_bizcard.bid', '=', 'umi_card2school.bid')
            ->where('school_id', '=', $schoolid)
            ->paginate($this->perPage);

        $bizcards_temp_size = sizeof($bizcards_temp);
        if($bizcards_temp_size > 0){
            $bizcards_temp['isunirecommend'] = ($bid == $unibizcards['bid']) ? 'Y' : 'N';
            $data = [$bizcards_temp];
        }else{
            $data = [];
        }


        $bizcards =  new LengthAwarePaginator($data, 1, 10, 1, [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => 'page',
        ]);

        //告诉模板显示那个模块的数据
        $schoolMoudelId = \Config::get('uni.school_bizcard');

        return view('admin.circleschool.layout.school_master',compact('schoolMoudelId', 'schoolid', 'bizcards', 'unibizcards'));
//        return view('admin.school.layout.school_master',array('schoolMoudelId' => $schoolMoudelId,
//            'schoolid' => $schoolid, 'bizcards' => $bizcards, 'unibizcards' => $unibizcards, 'bid' => $schoolid));

    }

    public function setUniRecommend($schoolid = NULL){
        $bid = \Input::get('bid');

        $bizcard = $this->getBizinfo($bid);
        if(sizeof($bizcard) == 0){
            return \Redirect::back()->with('Fail', '找不到该会员卡');
        }

        $now = time();

        DB::beginTransaction();
        try {
            $uniCard = new UmiRecommendBizCard();

            $bid = $bizcard['bid'] == null ? '' : $bizcard['bid'];

            $uniCard->bid = $bid;
            $uniCard->cardid = $bizcard['cardid'];
            $uniCard->biz_name = $bizcard['biz_name'];
            $uniCard->biz_address = $bizcard['biz_address'];
            $uniCard->frontimageurl = $bizcard['frontimageurl'];
            $uniCard->backimageurl = $bizcard['backimageurl'];
            $uniCard->creationtime = $now;
            $uniCard->modifiedtime = $now;
            $uniCard->isdeleted = 0;
            if(!$bizcard['card_category']) $bizcard['card_category'] = '小吃快餐';
            $uniCard->card_category = $bizcard['card_category'];
            $uniCard->credit_coupon_flag = $bizcard['credit_coupon_flag'];
            $uniCard->credit_coupon_amount = $bizcard['credit_coupon_amount'];
            $uniCard->discount_flag = $bizcard['discount_flag'];
            $uniCard->discount_amount = $bizcard['discount_amount'];
            $uniCard->stored_card_flag = $bizcard['stored_card_flag'];
            $uniCard->stored_card_amount = $bizcard['stored_card_amount'];
            $uniCard->point_card_flag = $bizcard['point_card_flag'];
            $uniCard->point_card_amount = $bizcard['point_card_amount'];
            $uniCard->extra = $bizcard['extra'];
            $uniCard->save();

            $uni2school = new UmiBizCard2School();
            $uni2school->bid = $bid;
            $uni2school->school_id = $schoolid;
            $uni2school->updatetimes =$now;
            $uni2school->save();

            DB::commit();
        }catch (\Exception $e) {
            DB::rollBack();
        }

        return \Redirect::back()->with('success', '成功将会员卡添加为校里会员卡');
    }

    public function removeUniRecommend($schoolid = NULL){
        $bid = \Input::get('bid');

        DB::beginTransaction();
        try {
            UmiRecommendBizCard::where('bid', '=', $bid)->delete();
            UmiBizCard2School::where('bid', '=', $bid)->where('school_id', '=', $schoolid)->delete();

            DB::commit();
        }catch (\Exception $e) {
            DB::rollBack();
        }

        return \Redirect::back()->with('success', '成功将会员卡从校里目录中移除');

    }

    private function getBizinfo($bid){
        if($bid == null){
            return [];
        }

        $list = \App\Http\Utils\Request::kakaCicRequest('biz','getBizInfo',array(),array('bid'=>$bid));

        if($list['result'] !=  '0' ){
            return [];
        }else{
            return $list['biz'];
        }

    }

}
