<?php
/**
 * Created by PhpStorm.
 * User: uni
 * Date: 16/1/15
 * Time: 下午2:39
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Base\BaseController;
use App\Http\Models\P2PComplaint;
use App\Http\Models\P2PTask;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis as Redis;

class ComplainController extends BaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
        $this->redis = Redis::connection();
    }

    public function getP2PComplaintList(){
        $complaints = P2PComplaint::where('status', '<', '3')->paginate($this->perPage);

        return view('admin.contact.p2pcomplaint', compact('complaints'));
    }

    public function getP2PComplaintListByStatus($status){
        $complaints = P2PComplaint::where('status', '=', $status)->paginate($this->perPage);

        return view('admin.contact.p2pcomplaint', compact('complaints'));
    }

    public function getP2PComplaintDetail($taskid = '0'){
        $complaints = $this->getComplaintDetail($taskid);

        $taskinfo = new P2PTask();
        $task = $taskinfo->getTaskInfo($taskid);
        return view('admin.contact.p2pcomplaindetail', compact('complaints','task'));

    }

    public function commentP2PComplaint(){
        $comment = \Input::get('comment');
        $taskid = \Input::get('taskid');
        $admin = \Auth::getUser();
        $now = time();

        $token = \Session::get('mytoken');
        $post_token = \Input::get('mytoken');

        $taskinfo = new P2PTask();
        $task = $taskinfo->getTaskInfo($taskid);

        if($token != $post_token){
            \Session::set('mytoken', $post_token );

            $complaint = new P2PComplaint;
            $complaint->task_id = $taskid;
            $complaint->handler_id = $admin->id;
            $complaint->creationtime = $now;
            $complaint->modifiedtime = $now;
            $complaint->content = $comment;
            $complaint->status = 3;

            $complaint->save();
        }

        P2PComplaint::where('task_id', '=', $taskid)->where('status', '=', '0') -> update(['status' => 1]);

        $complaints = $this->getComplaintDetail($taskid);

        return view('admin.contact.p2pcomplaindetail', compact('complaints','task'));
    }

    private function getComplaintDetail($taskid){
        $complaints = [];
        $complaints_tmp = P2PComplaint::where('task_id', '=', $taskid)
            ->where('status', '<', '3')
            ->first();

        array_push($complaints, $complaints_tmp);

        $complaints_tmp = P2PComplaint::where('task_id', '=', $taskid)
            ->where('status', '=', '3')
            ->get();
        foreach ($complaints_tmp as $complaint_tmp) {
            array_push($complaints, $complaint_tmp);
        }

        return $complaints;
    }

    public function closeP2PComplaint(){
        $taskid = \Input::get('taskid');

        P2PComplaint::where('task_id', '=', $taskid)->where('status', '<', '2') -> update(['status' => 2]);

        $complaints = P2PComplaint::where('status', '<', '3')->paginate($this->perPage);

        return view('admin.contact.p2pcomplaint', compact('complaints'));
    }

    //还原任务,当任务未过期或用户未确认付款
    public function resetComplainTask(){
        $taskid = \Input::get('taskid');
        //更新数据库
        $taskinfo = new P2PTask();
        try {
            $result = $taskinfo->updateTaskInfo($taskid);
        }catch (\Exception $e) {
            return Response::json(array($e => $e->getMessage()));
        }
        //更新redis
        $this->redis->hset("task-table", $taskid, "0");

        $complaints = $this->getComplaintDetail($taskid);

        $task = $taskinfo->getTaskInfo($taskid);
        return view('admin.contact.p2pcomplaindetail', compact('complaints','task'));

    }
}