<?php
/**
 * Created by PhpStorm.
 * User: whoami
 * Date: 16-4-20
 * Time: 下午12:01
 */
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class ProductBrand extends Model
{
    //初始化引用的表
    protected $table = 'umi_flash_sale_brand';
    public $timestamps = false;

    public function getProductBrand($query='')
    {
        if(!$query)
        {
            return DB::table('umi_flash_sale_brand')
                ->select('*')
                ->where('status', '<', 2)
                ->orderBy('creation_time','desc')
                ->paginate($this->perPage);

        }else
        {
            return DB::table('umi_flash_sale_brand')
                ->select('*')
                ->where('status', '<', 2)
                ->where('name', 'like', '%'.$query.'%')
                ->orderBy('creation_time','desc')
                ->paginate($this->perPage);

        }

    }

    public function getBrandInfo(){
        return DB::table('umi_flash_sale_brand')
            ->select('id','name')
            ->where('status', '=', 0)
            ->orderBy('creation_time','desc')
            ->get();
    }

}
