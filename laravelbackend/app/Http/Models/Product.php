<?php
/**
 * Created by PhpStorm.
 * User: whoami
 * Date: 16-4-20
 * Time: 下午3:48
 */
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Product extends Model
{
    //初始化引用的表
    protected $table = 'umi_flash_sale_product';
    public $timestamps = false;

    public function getProduct($query='')
    {
        if(!$query)
        {
            return DB::table('umi_flash_sale_product')
                ->select('umi_flash_sale_product.*','umi_flash_sale_brand.name as brandname')
                ->leftjoin('umi_flash_sale_brand','umi_flash_sale_product.brand_id', '=', 'umi_flash_sale_brand.id')
                ->where('umi_flash_sale_product.status', '<', 2)
                ->orderBy('creation_time','desc')
                ->paginate($this->perPage);

        }else
        {
            return DB::table('umi_flash_sale_product')
                ->select('umi_flash_sale_product.*','umi_flash_sale_brand.name as brandname')
                ->leftjoin('umi_flash_sale_brand','umi_flash_sale_product.brand_id', '=', 'umi_flash_sale_brand.id')
                ->where('umi_flash_sale_product.status', '<', 2)
                ->where('umi_flash_sale_product.name', 'like', '%'.$query.'%')
                ->orderBy('creation_time','desc')
                ->paginate($this->perPage);

        }

    }
    //根据品牌id获取商品信息
    public function getProductBrand($brandId)
    {
        return DB::table('umi_flash_sale_product')
            ->select('*')
            ->where('status', '<', 2)
            ->where('brand_id','=',$brandId)
            ->orderBy('creation_time','desc')
            ->get();
    }

    //获取商品名称
    public function getProductName()
    {
        return DB::table('umi_flash_sale_product')
            ->select('id','name')
            ->where('status', '=', 0)
            ->orderBy('creation_time','desc')
            ->get();
    }


}
