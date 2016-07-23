<?php
/**
 * Created by PhpStorm.
 * User: whoami
 * Date: 16-4-21
 * Time: 下午2:53
 */

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class ProductPlan extends Model
{
    //初始化引用的表
    protected $table = 'umi_flash_sale_plan';
    public $timestamps = false;

    public function getProductPlan($query='')
    {
        if(!$query)
        {
            return DB::table('umi_flash_sale_plan')
                ->select('umi_flash_sale_plan.*','wtown_community.name as schoolname')
                ->leftjoin('wtown_community','umi_flash_sale_plan.school_id', '=', 'wtown_community.bid')
                ->where('status', '<', 2)
                ->orderBy('creation_time','desc')
                ->paginate($this->perPage);

        }else
        {
            return DB::table('umi_flash_sale_plan')
                ->select('umi_flash_sale_plan.*','wtown_community.name as schoolname')
                ->leftjoin('wtown_community','umi_flash_sale_plan.school_id', '=', 'wtown_community.bid')
                ->where('status', '<', 2)
                ->where('title', 'like', '%'.$query.'%')
                ->orderBy('creation_time','desc')
                ->paginate($this->perPage);

        }

    }

    public function getCirclePlan($query='')
    {
        if(!$query)
        {
            return DB::table('umi_flash_sale_plan')
                ->select('umi_flash_sale_plan.*')
                ->where('status', '<', 2)
                ->orderBy('creation_time','desc')
                ->paginate($this->perPage);

        }else
        {
            return DB::table('umi_flash_sale_plan')
                ->select('umi_flash_sale_plan.*')
                ->where('status', '<', 2)
                ->where('title', 'like', '%'.$query.'%')
                ->orderBy('creation_time','desc')
                ->paginate($this->perPage);

        }
    }

    public function getPlanInfo($planId='')
    {
        if($planId){
            return DB::table('umi_flash_sale_plan')
                ->select('title')
                ->where('id','=',$planId)
                ->get();
        }
    }

}
