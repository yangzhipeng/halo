<?php
/**
 * Created by PhpStorm.
 * User: whoami
 * Date: 16-3-23
 * Time: 下午8:42
 */
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Subindustry extends Model
{
    //初始化引用的表
    protected $table = 'subindustry';
    public $timestamps = false;

    public function getSubindustry($id='1')
    {
        return Subindustry::where('industryid','=',$id)->get();

    }

    public function getAllSubindustry()
    {
        return Subindustry::get();

    }

    public function getSubindustryName($id)
    {
        return Subindustry::where('id','=',$id)->get();

    }

}