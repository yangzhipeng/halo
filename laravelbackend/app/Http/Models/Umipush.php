<?php
/**
 * Created by PhpStorm.
 * User: uni
 * Date: 16/1/14
 * Time: 下午12:01
 */

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Umipush extends Model
{
    //
    protected $table = 'umi_push';
    protected $primaryKey = 'cid';
    public $timestamps = false;

}