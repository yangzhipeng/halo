<?php
/**
 * Created by PhpStorm.
 * User: whoami
 * Date: 16-4-20
 * Time: 上午10:05
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Base\BaseController;
use App\Http\Libs\YouPaiYun;
use App\Http\Models\Product;
use App\Http\Models\ProductPlan;
use App\Http\Models\Product2Plan;
use App\Http\Models\School;

use App\Http\Utils\Upload;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Http\Utils\Request;
use Illuminate\Support\Facades\Redis as Redis;
use Illuminate\Support\Facades\DB;

class ProductPlanController extends BaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
        $this->redis = Redis::connection();
    }

    //商品计划列表
    public function getPlanIndex()
    {
        $plan = new ProductPlan();

        $school = new School();
        $schools = $school->getSchoolInfo();

        $query = \Input::get('query');
        if(!$query)
        {

            $plans = $plan->getProductPlan();

            return view('admin.flashsale.plan.plan_index', compact('plans','schools'));

        }else
        {
            $plans = $plan->getProductPlan($query);

            return view('admin.flashsale.plan.plan_index', compact('plans','schools','query'));
        }
    }

    //圈圈学校获取首页
    public function getPlan()
    {
        $plan = new ProductPlan();

        $schoolInfo = Request::Get('http://admin.itxedu.com:8080/api/admin/uni/college/get');
        $schools = $schoolInfo['body'];
        $query = \Input::get('query');
        if(!$query)
        {
            $plans = $plan->getCirclePlan();
            foreach($plans as $plan){
                $schoolNameInfo = Request::Get("http://admin.itxedu.com:8080/api/admin/uni/college/getById?collegeId=$plan->school_id");
                if($schoolNameInfo['code'] == 200){
                    $plan->schoolname = $schoolNameInfo['body']['xxmc'];
                }else{
                    $plan->schoolname = '';
                }
            }
            return view('admin.flashsale.plan.plan_index', compact('plans','schools'));

        }else
        {
            $plans = $plan->getCirclePlan($query);

            return view('admin.flashsale.plan.plan_index', compact('plans','schools','query'));
        }
    }

    //添加商品计划草稿
    public function createPlan()
    {
        $route = array(
            'title' => 'required',
        );

        $validator = \Validator::make(\Input::all(), $route);

        if($validator->fails())
        {
            return \Redirect::back()->withInput()->withErrors($validator->errors());
        }

        $plan = new ProductPlan();

        $plan->status = 1;
        $add_time = strtotime(date('Y-m-d H:i:s'));
        $plan->creation_time = $add_time;
        $plan->update_time = $add_time;
        $plan->title = \Input::get('title');
        $plan->starttime = strtotime(\Input::get('starttime'));
        $plan->endtime = strtotime(\Input::get('endtime'));
        //判断结束时间是否大于开始时间
        $time =   $plan->endtime - $plan->starttime;
        if($time <= 0){
            return \Redirect::back()->with('error', '结束时间不能早于开始时间');
        }
        $plan->description = \Input::get('description');
        $plan->memo = \Input::get('memo');
        $plan->school_id = \Input::get('school');
        $imageUrl = Upload::getInstance()->uploadImage(\Input::file('file'));
        if($imageUrl)
        {
            $plan->icon = $imageUrl['imageurl'];
        }
        $plan->save();

        return \Redirect::back()->with('success', '新增商品计划成功');
    }
    //修改商品计划草稿
    public function postUpdatePlan($planId = NULL)
    {
        $route = array(
            'title' => 'required',
        );

        $validator = \Validator::make(\Input::all(), $route);

        if($validator->fails())
        {
            return \Redirect::back()->withInput()->withErrors($validator->errors());
        }

        $plan = ProductPlan::find($planId);

        if(!$plan)
        {
            return \Redirect::back()->with('error', '没有找到该计划');
        }
        $plan->update_time = strtotime(date('Y-m-d H:i:s'));
        $plan->title = \Input::get('title');
        $plan->starttime = strtotime(\Input::get('starttime'));
        $plan->endtime = strtotime(\Input::get('endtime'));
        //判断结束时间是否大于开始时间
        $time =   $plan->endtime - $plan->starttime;
        if($time <= 0){
            return \Redirect::back()->with('error', '结束时间不能早于开始时间');
        }
        $plan->description = \Input::get('description');
        $plan->memo = \Input::get('memo');
        $plan->school_id = \Input::get('school');
        $imageUrl = Upload::getInstance()->uploadImage(\Input::file('file'));
        if($imageUrl)
        {
            $plan->icon = $imageUrl['imageurl'];
        }

        $plan->save();

        return \Redirect::back()->with('success', '修改商品计划成功');
    }
    //删除商品计划
    public function getDeletePlan($planId = NULL)
    {
        $plan = ProductPlan::find($planId);

        if(!$plan)
        {
            return \Redirect::back()->with('error', '没有找到该计划');
        }
        //只有商品计划为草稿时可以删除
        if($plan->status == 1) {
            DB::beginTransaction();
            try {
                //删除商品计划
                $plan->status = 2;
                $plan->update_time = strtotime(date('Y-m-d H:i:s'));
                $plan->save();
                //有商品回退库存
                $p2plan = new Product2Plan();
                $p2plans = $p2plan->getProductInfo($planId);
                foreach($p2plans as $p2p){
                    $product = Product::find($p2p->product_id);
                    $product->quantity = (int)$product->quantity + (int)$p2p->total_activity_quntity;
                    $product->save();
                }
                //删除计划下的商品
                $p2plan = new Product2Plan();
                $p2plan->delProductInfo($planId);

                DB::commit();
            }catch(\Exception $e) {
                DB::rollBack();
            }
            return \Redirect::back()->with('success', '删除商品计划成功');
        }else if($plan->status == 0) {
            return \Redirect::back()->with('error', '该计划已经发布，不允许删除');
        }else {
            return \Redirect::back()->with('error', '未知错误，删除失败');
        }

    }
    //修改商品计划状态
    public function postPlanStatus()
    {
        $planId = \Input::get('planId');
        $status = \Input::get('status');

        $plan = ProductPlan::find($planId);

        if(!$plan)
        {
            return \Response::json(array('code' => -1));
        }

        $p2plan = new Product2Plan();
        $p2plans = $p2plan->getProductInfo($planId);
        //判断计划下是否有商品
        if(!empty($p2plans)) {
            if($status == 0)
            {
                //判断发布时间是否大于开始时间
                $current_time = strtotime(date('Y-m-d H:i:s'));
                $time = $plan->starttime - (int)$current_time;
                if($time < 0){
                    $code = 4;
                    return \Response::json(array('code' => $code));
                }else {
                    try {
                        $plan->status = 0;
                        $plan->update_time = strtotime(date('Y-m-d H:i:s'));
                        $code = 0;
                        $plan->save();
                        foreach($p2plans as $p2plan){
                            $now_time = strtotime(date('Y-m-d H:i:s'));
                            $string = array('lib_num'=>$p2plan->total_activity_quntity,'limit'=>$p2plan->limit,'price'=>$p2plan->activity_price);
                            $json = json_encode($string);
                            $keyname = 'flash_lib_inventory_'.$planId.'_'.$p2plan->product_id;
                            $seconds = $plan->endtime - $plan->starttime +1+($plan->starttime-(int)$now_time);
                            $this->redis->setex($keyname,$seconds,$json);
                        }

                    }catch (\Exception $e) {
                        $code = 3;
                        return \Response::json(array('code' => $code,'message' => $e->getMessage()));
                    }
                }

            }else{
                $code = 1;
            }
        }else {
            $code = 2;
        }

        return \Response::json(array('code' => $code));
    }

}
