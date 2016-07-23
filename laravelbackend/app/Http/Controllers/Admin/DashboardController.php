<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Base\BaseController;
use App\Http\Models\UserAccount;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class DashboardController extends BaseController
{
    //
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    public function getIndex()
    {

        $userCount = UserAccount::count();
        $newUser = UserAccount::where('creationtime', '>=', strtotime(date('Y-m-d')))->count();

        $action_user_today = UserAccount::where('modifiedtime', '>=', strtotime(date('Y-m-d')))->count();

        $action_user_yesterday = UserAccount::where('modifiedtime', '>=', strtotime(date("Y-m-d",strtotime("-1 day"))))
            ->where('modifiedtime', '<', strtotime(date('Y-m-d')))->count();

        $dataArray = $this->getPeopleNumForWeek(strtotime(date('Y-m-d')));
        return view('admin.dashboard.index', compact('userCount', 'newUser', 'action_user_today', 'action_user_yesterday', 'dataArray'));
    }

    public function postChangeDay()
    {

        $date = \Input::get('date');

        $dataArray = $this->getPeopleNumForWeek(strtotime($date));

        return \Response::json(array('dataArray' => array($dataArray)));

    }

    public function postChangeYear()
    {
        $date = \Input::get('date');

        $dataArray = $this->getPeopleNumForYear($date);

        return \Response::json(array('dataArray' => $dataArray));
    }



    private function getPeopleNumForWeek($time)
    {
        $time = (int)$time;

        $sql = "select t.type, sum(t.num ) as count from" . "(select cid, 1 as num," .
            " case" . " when(creationtime > ". ($time - 6*86400) ." and creationtime <= ". ($time - 5*86400) .") then '1'"
            . " when(creationtime > ". ($time - 5*86400) ." and creationtime <= ". ($time - 4*86400) .") then '2'"
            . " when(creationtime > ". ($time - 4*86400) ." and creationtime <= ". ($time - 3*86400) .") then '3'"
            . " when(creationtime > ". ($time - 3*86400) ." and creationtime <= ". ($time - 2*86400) .") then '4'"
            . " when(creationtime > ". ($time - 2*86400) ." and creationtime <= ". ($time - 1*86400) .") then '5'"
            . " when(creationtime > ". ($time - 1*86400) ." and creationtime <= ". ($time) .") then '6'"
            . " when(creationtime > ". ($time) ." and creationtime <= ". ($time + 1*86400) .") then '7'"
            . " else '8'" . " end as type from wtown_clientusers where creationtime > ". ($time - 6*86400) ." and creationtime <= ". ($time + 1*86400) .")t  group by t.type";

        $results = \DB::select($sql);


        $dataArray = array('one' => array('x' => date('Y-m-d',$time - 6*86400), 'y' => 0),
            'tow' => array('x' => date('Y-m-d',$time - 5*86400), 'y' => 0),
            'three' => array('x' => date('Y-m-d',$time - 4*86400), 'y' => 0),
            'four' => array('x' => date('Y-m-d',$time - 3*86400), 'y' => 0),
            'five' => array('x' => date('Y-m-d',$time - 2*86400), 'y' => 0),
            'six' => array('x' => date('Y-m-d',$time - 1*86400), 'y' => 0),
            'seven' => array('x' => date('Y-m-d', $time), 'y' => 0));

        if(count($results) > 0)
        {
            foreach($results as $result)
            {
                if($result->type == '1')
                {
                    $dataArray['one']['y'] = (int)$result->count;
                }elseif($result->type == '2')
                {
                    $dataArray['tow']['y'] = (int)$result->count;
                }elseif($result->type == '3')
                {
                    $dataArray['three']['y'] = (int)$result->count;
                }elseif($result->type == '4')
                {
                    $dataArray['four']['y'] = (int)$result->count;
                }elseif($result->type == '5')
                {
                    $dataArray['five']['y'] = (int)$result->count;
                }elseif($result->type == '6')
                {
                    $dataArray['six']['y'] = (int)$result->count;
                }elseif($result->type == '7')
                {
                    $dataArray['seven']['y'] = (int)$result->count;
                }
            }
        }
        return $dataArray;
    }


    private function getPeopleNumForYear($year)
    {
        $yearTime = array('Jan' => strtotime($year.'-01'),
            'Feb' => strtotime($year.'-02'),
            'Mar' => strtotime($year.'-03'),
            'Apr' => strtotime($year.'-04'),
            'May' => strtotime($year.'-05'),
            'Jun' => strtotime($year.'-06'),
            'Jul' => strtotime($year.'-07'),
            'Aug' => strtotime($year.'-08'),
            'Sep' => strtotime($year.'-09'),
            'Oct' => strtotime($year.'-10'),
            'Nov' => strtotime($year.'-11'),
            'Dec' => strtotime($year.'-12'),
            'nextYearJan' => strtotime((((int)$year) + 1) .'-01'),);

        $sql = "select t.type, sum(t.num ) as count from" . "(select cid, 1 as num," .
            " case" . " when(creationtime >= ". ($yearTime['Jan']) ." and creationtime < ". ($yearTime['Feb']) .") then '1'"
            . " when(creationtime >= ". ($yearTime['Feb']) ." and creationtime < ". ($yearTime['Mar']) .") then '2'"
            . " when(creationtime >= ". ($yearTime['Mar']) ." and creationtime < ". ($yearTime['Apr']) .") then '3'"
            . " when(creationtime >= ". ($yearTime['Apr']) ." and creationtime < ". ($yearTime['May']) .") then '4'"
            . " when(creationtime >= ". ($yearTime['May']) ." and creationtime < ". ($yearTime['Jun']) .") then '5'"
            . " when(creationtime >= ". ($yearTime['Jun']) ." and creationtime < ". ($yearTime['Jul']) .") then '6'"
            . " when(creationtime >= ". ($yearTime['Jul']) ." and creationtime < ". ($yearTime['Aug']) .") then '7'"
            . " when(creationtime >= ". ($yearTime['Aug']) ." and creationtime < ". ($yearTime['Sep']) .") then '8'"
            . " when(creationtime >= ". ($yearTime['Sep']) ." and creationtime < ". ($yearTime['Oct']) .") then '9'"
            . " when(creationtime >= ". ($yearTime['Oct']) ." and creationtime < ". ($yearTime['Nov']) .") then '10'"
            . " when(creationtime >= ". ($yearTime['Nov']) ." and creationtime < ". ($yearTime['Dec']) .") then '11'"
            . " when(creationtime >= ". ($yearTime['Dec']) ." and creationtime < ". ($yearTime['nextYearJan']) .") then '12'"
            . " else '13'" . " end as type from wtown_clientusers where creationtime >= ". ($yearTime['Jan']) ." and creationtime < ". ($yearTime['nextYearJan']) .")t  group by t.type";

        $results = \DB::select($sql);

        $dataArray = array();
        if($year == date('Y'))
        {
            $mNum = (int)(substr(date('Y-m'), stripos(date('Y-m'), '-') + 1));

        }else
        {
            $mNum = 12;
        }

        for($i = 1; $i <= $mNum; $i++)
        {
            $item = array('x' => $year.'-'.$i, 'y' => 0);
            $dataArray[] = $item;
        }

        if(count($results) > 0)
        {
            foreach($results as $result)
            {
                if($result->type == '1')
                {
                    $dataArray[0]['y'] = (int)$result->count;
                }elseif($result->type == '2')
                {
                    $dataArray[1]['y'] = (int)$result->count;
                }elseif($result->type == '3')
                {
                    $dataArray[2]['y'] = (int)$result->count;
                }elseif($result->type == '4')
                {
                    /*$item = array('x' => $year.'-'.'4', 'y' => 0);
                    $dataArray[] = $item;*/
                    $dataArray[3]['y'] = (int)$result->count;
                }elseif($result->type == '5')
                {
                    $dataArray[4]['y'] = (int)$result->count;
                }elseif($result->type == '6')
                {
                    $dataArray[5]['y'] = (int)$result->count;
                }elseif($result->type == '7')
                {
                    $dataArray[6]['y'] = (int)$result->count;
                }elseif($result->type == '8')
                {
                    $dataArray[7]['y'] = (int)$result->count;
                }elseif($result->type == '9')
                {
                    $dataArray[8]['y'] = (int)$result->count;
                }elseif($result->type == '10')
                {
                    $dataArray[9]['y'] = (int)$result->count;
                }elseif($result->type == '11')
                {
                    $dataArray[10]['y'] = (int)$result->count;
                }elseif($result->type == '12')
                {
                    $dataArray[11]['y'] = (int)$result->count;
                }
            }
        }

        return $dataArray;

    }

}
