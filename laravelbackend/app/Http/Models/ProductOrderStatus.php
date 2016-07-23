<?php
/**
 * Created by PhpStorm.
 * User: YOUNG
 * Date: 2016-04-28
 * Time: 17:12
 */

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class ProductOrderStatus extends Model
{
    //
    protected $table = 'umi_flash_sale_order_status';
    protected $primaryKey = 'id';
    public $timestamps = false;

   public static function getOrderStatus($order_id = ''){
        return DB::table('umi_flash_sale_order_status')
            ->select('umi_flash_sale_order_status.order_id','umi_flash_sale_order_status.order_status_memo',
                'umi_flash_sale_order_status.order_status_memo','umi_flash_sale_order_status.update_time')
            ->where('umi_flash_sale_order_status.order_id','=',$order_id)
            ->get();
    }
}