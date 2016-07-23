<?php
/**
 * Created by PhpStorm.
 * User: uni
 * Date: 16/2/17
 * Time: 下午5:54
 */

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class UmiBizCard2School extends Model
{
    //
    protected $table = 'umi_card2school';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function belongsToCards(){
        return $this->belongsTo('App\Http\Models\UmiRecommendBizCard', 'bid', 'bid');
    }

}