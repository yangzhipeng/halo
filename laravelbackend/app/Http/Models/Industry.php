<?php
/**
 * Created by PhpStorm.
 * User: whoami
 * Date: 16-3-23
 * Time: 下午5:48
 */
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Industry extends Model
{
    //初始化引用的表
    protected $table = 'industry';
    public $timestamps = false;

    public function getIndustry()
    {
        return Industry::get();

    }

    public function getIndustryName($id)
    {
        return Industry::where('id','=',$id)->get();

    }

}