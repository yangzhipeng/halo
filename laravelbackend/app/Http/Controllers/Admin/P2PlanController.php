<?php
/**
 * Created by PhpStorm.
 * User: whoami
 * Date: 16-4-20
 * Time: 下午6:09
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Base\BaseController;
use App\Http\Libs\YouPaiYun;
use App\Http\Models\Product2Plan;
use App\Http\Models\ProductPlan;
use App\Http\Models\Product;

use App\Http\Utils\Upload;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redis as Redis;
use Illuminate\Support\Facades\DB;

class P2PlanController extends BaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
        $this->redis = Redis::connection();
    }

    //计划的商品列表
    public function getP2PlanIndex($planId)
    {
        $query = \Input::get('query');
        if(!$planId)
        {
            return \Redirect::back()->with('error', '计划无效');
        }

        $plan = new ProductPlan();
        $planInfo = $plan->getPlanInfo($planId);

        $product = new Product();
        $products = $product->getProductName();

        $product2plan = new Product2Plan();

        if(!$query)
        {

            $product2plans = $product2plan->getProductPlan($planId);
            return view('admin.flashsale.p2plan.p2plan_index', compact('product2plans','planId','planInfo','products'));

        }else
        {
            $product2plans = $product2plan->getProductPlan($planId,$query);

            return view('admin.flashsale.p2plan.p2plan_index', compact('product2plans','planId','planInfo','products','query'));
        }
    }
    //添加计划的商品
    public function createP2Plan()
    {
        $product2plan = new Product2Plan();

        $quantity = \Input::get('quntity');
        $product2plan->plan_id = \Input::get('planId');
        $product2plan->product_id = \Input::get('product');
        //$product2plan->total_activity_quntity = \Input::get('quntity');
        $product2plan->activity_price = \Input::get('activity_price');
        $product2plan->limit = \Input::get('limit');

        //判断是否已经为该计划添加过该商品
        $products = $product2plan->getProductInfo($product2plan->plan_id);
        foreach($products as $pro)
        {
            if($pro->product_id == $product2plan->product_id)
            {
                return \Redirect::back()->withInput()->withErrors('您已经为该计划添加过此商品,请不要重复添加');
            }
        }

        //增加的商品的数量不能大于商品库存
        $product = new Product();
        $productQuantity = Product::find($product2plan->product_id);
        $result_quantity = (int)$productQuantity->quantity - (int)$quantity;
        if($result_quantity >= 0) {
            $product2plan->total_activity_quntity = $quantity;

            $productQuantity->quantity = $result_quantity;
        }else {
            return \Redirect::back()->withInput()->withErrors('设置参加活动的商品数量不能大于该商品的库存数量');
        }

        //判断活动限制数量不能大于商品数量
        if($product2plan->limit-$product2plan->total_activity_quntity > 0) {
            return \Redirect::back()->withInput()->withErrors('设置限制的活动数量不能大于参加活动的商品数量');
        }
        DB::beginTransaction();
        try {
            $productQuantity->save();
            $product2plan->save();

            DB::commit();
        }catch(\Exception $e) {
            DB::rollBack();
        }

        return \Redirect::back()->with('success', '新增商品成功');
    }
    //修改计划的商品
    public function postUpdateP2Plan($p2planId = NULL)
    {

        $product2plan = Product2Plan::find($p2planId);

        if(!$product2plan)
        {
            return \Redirect::back()->with('error', '没有找到该商品');
        }
        $product_id = \Input::get('productid');
        $quantity = \Input::get('quntity');
        $original_quantity = \Input::get('original_quantity'); //更改之前的数量
        $product2plan->activity_price = \Input::get('activity_price');
        $product2plan->limit = \Input::get('limit');
        //判断库存
        $product = new Product();
        $productQuantity = Product::find($product_id);

        if((int)$quantity-(int)$original_quantity > 0){
            $reduce_quantity = (int)$quantity-(int)$original_quantity;
            $result_quantity = (int)$productQuantity->quantity - (int)$reduce_quantity;
            if($result_quantity >= 0) {
                $product2plan->total_activity_quntity = $quantity;
                $productQuantity->quantity = $result_quantity;
            }else {
                return \Redirect::back()->withInput()->withErrors('设置参加活动的商品数量不能大于该商品的库存数量');
            }

        }else if((int)$quantity-(int)$original_quantity < 0) {
            $add_quantity = (int)$original_quantity - (int)$quantity;
            $product2plan->total_activity_quntity = $quantity;
            $productQuantity->quantity = (int)$productQuantity->quantity + (int)$add_quantity;
        }else {
            $product2plan->total_activity_quntity = $quantity;
        }

        DB::beginTransaction();
        try {
            $productQuantity->save();
            $product2plan->save();

            DB::commit();
        }catch(\Exception $e) {
            DB::rollBack();
        }

        return \Redirect::back()->with('success', '修改商品成功');
    }
    //删除添加的商品
    public function getDeleteP2Plan($p2planId = NULL)
    {
        $product2plan = Product2Plan::find($p2planId);
        if(!$product2plan)
        {
            return \Redirect::back()->with('error', '没有找到该商品');
        }
        $plan = ProductPlan::find($product2plan->plan_id);
        if($plan->status == 1){
            DB::beginTransaction();
            try {
                //恢复库存
                $product = new Product();
                $productQuantity = Product::find($product2plan->product_id);
                $productQuantity->quantity = (int)$productQuantity->quantity + (int)$product2plan->total_activity_quntity;
                $productQuantity->save();

                $product2plan->delete();

                DB::commit();
            }catch(\Exception $e) {
                DB::rollBack();
            }

            return \Redirect::back()->with('success', '删除商品成功');
        }else if($plan->status == 0) {
            return \Redirect::back()->with('error', '该商品所在的计划已经发布，不能删除该商品');
        }else {
            return \Redirect::back()->with('error', '未知错误，删除失败');
        }

    }

}
