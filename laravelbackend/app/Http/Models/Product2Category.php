<?php
/**
 * Created by PhpStorm.
 * User: whoami
 * Date: 16-4-21
 * Time: 上午11:01
 */

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Product2Category extends Model
{
    //初始化引用的表
    protected $table = 'umi_flash_sale_product_to_category';
    public $timestamps = false;

    //根据类别id获取商品id
    public function getProductCategory($categoryId)
    {
        return DB::table('umi_flash_sale_product_to_category')
            ->select('*')
            ->where('category_id','=',$categoryId)
            ->get();
    }

    //根据商品id删除信息
    public function delP2C($productId)
    {
        return Product2Category::where('product_id','=',$productId)->delete();
    }

    //根据商品id获取分类名称
    public function getP2C($productId)
    {
        return DB::table('umi_flash_sale_product_to_category')
            ->select('umi_flash_sale_product_to_category.category_id','umi_flash_sale_category.name')
            ->leftjoin('umi_flash_sale_category','umi_flash_sale_product_to_category.category_id', '=', 'umi_flash_sale_category.id')
            ->where('umi_flash_sale_product_to_category.product_id','=',$productId)
            ->get();
    }
}
