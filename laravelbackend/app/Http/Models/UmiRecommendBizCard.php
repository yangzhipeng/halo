<?php
/**
 * Created by PhpStorm.
 * User: uni
 * Date: 16/2/17
 * Time: 下午5:52
 */

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class UmiRecommendBizCard extends Model
{
    //
    protected $table = 'umi_recommend_bizcard';
    protected $primaryKey = 'bid';
    public $timestamps = false;

}