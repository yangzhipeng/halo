<?php
/**
 * Created by PhpStorm.
 * User: YOUNG
 * Date: 2016-04-28
 * Time: 16:23
 */
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class ProductOrder extends Model
{
    protected $table = 'umi_flash_sale_order';
    protected $primaryKey = 'order_id';
    public $timestamps = false;

   public static function getOrderDetail($query=''){
           if(!$query){
               return DB::table('umi_flash_sale_order')
                   ->select('umi_flash_sale_order.customer_name','umi_flash_sale_order.customer_school_name','umi_flash_sale_order.delivery_name',
                   'umi_flash_sale_order.delivery_address','umi_flash_sale_order.delivery_mobile','umi_flash_sale_order.delivery_postcode',
                   'umi_flash_sale_order.billing_company','umi_flash_sale_order.billing_to_address', 'umi_flash_sale_order.billing_mobile','umi_flash_sale_order.total_price','umi_flash_sale_order.creation_time',
                       'umi_flash_sale_order.order_id')
                   ->orderBy('umi_flash_sale_order.creation_time','desc')
                   ->paginate(20);
           }else{
               return DB::table('umi_flash_sale_order')
                   ->select('umi_flash_sale_order.customer_name','umi_flash_sale_order.customer_school_name','umi_flash_sale_order.delivery_name',
                       'umi_flash_sale_order.delivery_address','umi_flash_sale_order.delivery_mobile','umi_flash_sale_order.delivery_postcode',
                       'umi_flash_sale_order.billing_company','umi_flash_sale_order.billing_to_address',
                       'umi_flash_sale_order.billing_mobile','umi_flash_sale_order.total_price','umi_flash_sale_order.creation_time',
                       'umi_flash_sale_order.order_id')
                   ->where('umi_flash_sale_order.customer_name', 'like', '%' . $query . '%')
                   ->orwhere('umi_flash_sale_order.delivery_mobile', 'like', '%' . $query . '%')
                   ->orderBy('umi_flash_sale_order.creation_time','desc')
                   ->paginate(20);
           }
    }
}