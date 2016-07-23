<?php
/**
 * Created by PhpStorm.
 * User: YOUNG
 * Date: 2016-04-28
 * Time: 15:42
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Base\BaseController;
use App\Http\Models\ProductOrder;
use App\Http\Requests;
use App\Http\Models\ProductOrderStatus;
use Illuminate\Support\Facades\DB;

class ProductOrderController extends BaseController{

    public function __construct(){
        parent::__construct();
        $this->middleware('auth');
    }

    public function getOrderIndex(){
        $query = \Input::get('query');
         if(!$query){
             $orders = ProductOrder::getOrderDetail();
             return view('admin.flashsale.order.orderDetail',compact('orders'));
         }else{
             $orders = ProductOrder::getOrderDetail($query);
             return view('admin.flashsale.order.orderDetail',compact('orders','query'));
         }
    }

    //获得状态信息
    public function getOrderStatusIndex($order_id = NULL){
        $order = ProductOrder::where('order_id', '=', $order_id)->first();

        if(!$order)
        {
            return \Redirect::back()->with('error', '订单不存在');
        }
        $orderStatus = ProductOrderStatus::where('order_id', '=', $order_id)->first();

        return view('admin.flashsale.order.orderStatus',compact('orderStatus','order'));

    }

    //添加状态
    public function postCreate($order_id = NULL)
    {
        $route = array(
            'order_status_code' => 'required',
            'order_status_memo' => 'required',
        );

        $validator = \Validator::make(\Input::all(), $route);

        if($validator->fails())
        {
            return \Redirect::back()->withInput()->withErrors($validator->errors());
        }

        $orders = ProductOrder::where('order_id', '=', $order_id)->first();

        if(!$orders) {
            return \Redirect::back()->with('error', 'order_id错误!');
        }

        $orderStatus = ProductOrderStatus::where('order_id','=',$order_id)->first();

        if(!$orderStatus)
        {
            $orderStatus = new ProductOrderStatus();
        }

        $order_status_code = \Input::get('order_status_code');
        $order_status_memo = \Input::get('order_status_memo');
        $orderStatus->order_status_code = $order_status_code;
        $orderStatus->order_status_memo = $order_status_memo;
        $time = strtotime(date('Y-m-d H:i:s'));
        $orderStatus->creation_time = $time;
        $orderStatus->update_time = $time;
        $orderStatus->order_id = $order_id;

        $orderStatus->save();

        return \Redirect::back()->with('success', '添加订单状态成功');
    }

    //更新状态
    public  function updateStatus($order_id = NULL){
        $route = array(
            'order_status_code' => 'required',
            'order_status_memo' => 'required',
        );

        $validator = \Validator::make(\Input::all(), $route);
        if($validator->fails())
        {
            return \Redirect::back()->withInput()->withErrors($validator->errors());
        }

        $orderStatus = ProductOrderStatus::where('order_id','=',$order_id)->first();

        if(!$orderStatus){
            return \Redirect::back()->with('error', '没有订单状态');
        }

        $orderStatus->order_status_code = \Input::get('order_status_code');
        $orderStatus->order_status_memo = \Input::get('order_status_memo');
        $time = strtotime(date('Y-m-d H:i:s'));
        $orderStatus->update_time = $time;
        $orderStatus->save();

        return \Redirect::back()->with('success', '订单状态修改成功');
    }
}