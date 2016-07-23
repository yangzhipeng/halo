<?php
/**
 * Created by PhpStorm.
 * User: wangyang
 * Date: 16-3-8
 * Time: 上午9:34
 */
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class CardCategory extends Model
{
    //初始化引用的表
    protected $table = 'umi_card_category';
    public $timestamps = false;

    public function getCardCategory($query='')
    {
        if(!$query)
        {
            return DB::table('umi_card_category')
                ->select('umi_card_category.*','wtown_community.name as schoolname','industry.name as industryname','subindustry.name as subindustryname')
                ->leftjoin('wtown_community','umi_card_category.school_id', '=', 'wtown_community.bid')
                ->leftjoin('industry','umi_card_category.industryid', '=', 'industry.id')
                ->leftjoin('subindustry','umi_card_category.subindustryid', '=', 'subindustry.id')
                ->where('umi_card_category.actiontype', '=', 1)
                ->orderBy('umi_card_category.id','desc')
                ->paginate($this->perPage);

        }else
        {
            return DB::table('umi_card_category')
                ->select('umi_card_category.*','wtown_community.name as schoolname','industry.name as industryname','subindustry.name as subindustryname')
                ->leftjoin('wtown_community','umi_card_category.school_id', '=', 'wtown_community.bid')
                ->leftjoin('industry','umi_card_category.industryid', '=', 'industry.id')
                ->leftjoin('subindustry','umi_card_category.subindustryid', '=', 'subindustry.id')
                ->where('umi_card_category.actiontype', '=', 1)
                //->where('umi_card_category.name', 'like', '%'.$query.'%')
                ->where('wtown_community.name', 'like', '%'.$query.'%')
                ->orderBy('umi_card_category.id','desc')
                ->paginate($this->perPage);
        }

    }

    public function getCardName($school_id)
    {

        return DB::table('umi_card_category')
            ->where('school_id', '=', $school_id)
            ->paginate($this->perPage);
    }

    public function getInsertCard($id)
    {

        return DB::table('umi_card_category')
                ->where('id', '=', $id)
                ->paginate($this->perPage);
    }

}
