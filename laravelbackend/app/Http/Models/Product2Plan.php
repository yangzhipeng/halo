<?php
/**
 * Created by PhpStorm.
 * User: whoami
 * Date: 16-4-22
 * Time: 下午4:26
 */
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Product2Plan extends Model
{
    //初始化引用的表
    protected $table = 'umi_flash_sale_plan_to_product';
    public $timestamps = false;

    //根据类别id获取商品id
    public function getProductPlan($planId,$query='')
    {
        if(!$query)
        {
            return DB::table('umi_flash_sale_plan_to_product')
                ->select('umi_flash_sale_plan_to_product.*','umi_flash_sale_product.name as productname','umi_flash_sale_product.id as productid')
                ->leftjoin('umi_flash_sale_product','umi_flash_sale_plan_to_product.product_id', '=', 'umi_flash_sale_product.id')
                ->where('umi_flash_sale_plan_to_product.plan_id','=',$planId)
                ->paginate($this->perPage);

        }else
        {
            return DB::table('umi_flash_sale_plan_to_product')
                ->select('umi_flash_sale_plan_to_product.*','umi_flash_sale_product.name as productname','umi_flash_sale_product.id as productid')
                ->leftjoin('umi_flash_sale_product','umi_flash_sale_plan_to_product.product_id', '=', 'umi_flash_sale_product.id')
                ->where('umi_flash_sale_plan_to_product.plan_id','=',$planId)
                ->paginate($this->perPage);

        }
    }

    //根据计划查找商品
    public function getProductInfo($planId)
    {
        return DB::table('umi_flash_sale_plan_to_product')
            ->select('*')
            ->where('plan_id','=',$planId)
            ->get();
    }

    //根据计划删除商品
    public function delProductInfo($planId)
    {
        return Product2Plan::where('plan_id','=',$planId)->delete();
    }

    //根据商品查找信息?
    public function getPlanInfo($productId)
    {
        return DB::table('umi_flash_sale_plan_to_product')
            ->select('*')
            ->where('product_id','=',$productId)
            ->get();
        //return Product2Plan::where('product_id','=',$productId)->get();
    }

}
