<?php
/**
 * Created by PhpStorm.
 * User: uni
 * Date: 16/1/20
 * Time: 下午2:19
 */


namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;


class P2PComplaint extends Model
{

    protected $table = 'umi_p2p_complaint';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function admin(){
        return $this->belongsTo('App\Http\Models\AdminAccount', 'handler_id', 'id');
    }

    public function user(){
        return $this->belongsTo('App\Http\Models\UserAccount', 'handler_id', 'cid');
    }

    public function task(){
        return $this->belongsTo('App\Http\Models\P2PTask', 'task_id', 'task_id');
    }

}
