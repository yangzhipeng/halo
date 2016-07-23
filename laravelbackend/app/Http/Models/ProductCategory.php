<?php
/**
 * Created by PhpStorm.
 * User: whoami
 * Date: 16-4-20
 * Time: 下午2:34
 */

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class ProductCategory extends Model
{
    //初始化引用的表
    protected $table = 'umi_flash_sale_category';
    public $timestamps = false;

    public function getProductCategory($query='')
    {
        if(!$query)
        {
            return DB::table('umi_flash_sale_category')
                ->select('*')
                ->where('status', '<', 2)
                ->orderBy('creation_time','desc')
                ->paginate($this->perPage);

        }else
        {
            return DB::table('umi_flash_sale_category')
                ->select('*')
                ->where('status', '<', 2)
                ->where('name', 'like', '%'.$query.'%')
                ->orderBy('creation_time','desc')
                ->paginate($this->perPage);

        }

    }

    public function getCategoryInfo()
    {
        return DB::table('umi_flash_sale_category')
            ->select('id','name')
            ->where('status', '=', 0)
            ->orderBy('creation_time','desc')
            ->paginate($this->perPage);
    }

}
