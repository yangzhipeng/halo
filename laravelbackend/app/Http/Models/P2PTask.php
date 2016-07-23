<?php
/**
 * Created by PhpStorm.
 * User: uni
 * Date: 16/1/20
 * Time: 下午2:19
 */


namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class P2PTask extends Model
{

    protected $table = 'umi_p2p_job';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function issuer(){
        return $this->belongsTo('App\Http\Models\UserAccount', 'issuer_id', 'cid');
    }

    public function acceptor(){
        return $this->belongsTo('App\Http\Models\UserAccount', 'acceptor_id', 'cid');
    }

    public function getTaskInfo($taskid='0'){
        return P2PTask::where('task_id', '=', $taskid)->get();
    }
    public function updateTaskInfo($taskid='0'){
        return P2PTask::where('task_id', '=', $taskid)-> update(['status' => 0,'acceptor_id' => 0]);
    }

}
