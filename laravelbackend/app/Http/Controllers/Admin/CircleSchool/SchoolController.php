<?php

namespace App\Http\Controllers\Admin\CircleSchool;

use App\Http\Controllers\Admin\Base\BaseController;
use App\Http\Models\Adv;
use App\Http\Models\City;
use App\Http\Models\District;
use App\Http\Models\Module;
use App\Http\Models\ModuleType;
use App\Http\Models\Province;
use App\Http\Models\School;
use App\Http\Utils\Request;
use App\Http\Models\UserAccount;

use App\Http\Models\UmiMsg;


use App\Http\Requests;
use App\Http\Controllers\Controller;

class SchoolController extends BaseController
{
    //
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    public function getIndex()
    {

        $query = \Input::get('query');
        if(!$query)
        {
            $schools = School::paginate($this->perPage);

            return view('admin.circleschool.index', compact('schools'));
        }else
        {
            $schools = School::where('name', 'like', '%'.$query.'%')->paginate($this->perPage);

            return view('admin.circleschool.index', compact('schools', 'query'));
        }

    }

    public function postBan()
    {
        $schoolId = \Input::get('schoolId');
        $isban = \Input::get('isBan');

        $school = School::where('bid', '=', $schoolId)->first();

        if(!$school)
        {
            return \Response::json(array(
                'code' => -1
            ));
        }

        if($isban != 0) {
            $school->isforbidded = 1;
            $code = 1;
        }else{
            $school->isforbidded = 0;
            $code = 0;
        }

        $school->save();

        return \Response::json(array(
            'code' => $code
        ));
    }

    public function getCreate()
    {
        $provinces = Province::all();

        return view('admin.circleschool.create', compact('provinces'));
    }

    public function postCities()
    {
        $provinceId = \Input::get('provinceId');

        $cities = City::where('provinceid', '=', $provinceId)->get();

        return \Response::json(array('cities' => $cities));
    }

    public function postDistricts()
    {
        $provinceId = \Input::get('provinceId');
        $cityId = \Input::get('cityId');

        $districts = District::where('provinceid', '=', $provinceId)
            ->where('cityid', '=', $cityId)
            ->get();

        return \Response::json(array('districts' => $districts));
    }

    public function postCreate()
    {
        $rules = array(
            'name'  => 'required',
            'mobile' => 'required',
            'ProvinceID' => 'required',
            'CityID' => 'required',
            'DistrictID' => 'required',
            'Addr' => 'required'
        );

        $validator = \Validator::make(\Input::all(), $rules);

        if($validator->fails())
        {

            return \Redirect::back()->withInput()->withErrors($validator);

        }

        if(!Province::find(\Input::get('ProvinceID')))
        {
            return \Redirect::back()->withInput()->withErrors('省份不存在');
        }

        if(!City::find(\Input::get('CityID')))
        {
            return \Redirect::back()->withInput()->withErrors('城市不存在');
        }

        if(!District::find(\Input::get('DistrictID')))
        {
            return \Redirect::back()->withInput()->withErrors('县区不存在');
        }

        $remoteResult = Request::Post(\Config::get('uni.kaka_server_ip'.\Config::get('uni.schoolCreteApi')),
            array('Name' => trim(\Input::get('name')),
            'Tel' => trim(\Input::get('mobile')),
            'Addr' => '',
            'IndustryID' => '9',
            'Invite_code' => '8711',
            'Bizno' => '',
            'BizType' => '100',// 商户类型强制100，表示小区
            'AppId' => $this->app_id,));

        if (!$remoteResult
            || !isset($remoteResult['result'])
            || $remoteResult['result'] > 0
        ) {
            return \Redirect::back()->withInput()->withErrors($remoteResult['reason']);
        }

        $bid = $remoteResult['Shop']['bid'];
        $extraData['Tel'] = trim(\Input::get('mobile'));
        $extraData['Addr'] = trim(\Input::get('Addr'));
        $lon = trim(\Input::get('Lon'));
        $lat = trim(\Input::get('Lat'));
        if($lon != '')
        {
            $extraData['Lon'] = $lon;
        }
        if($lat != '')
        {
            $extraData['Lat'] = $lat;
        }

        $extraData['DistrictID'] = \Input::get('DistrictID');
        $extraData['CityID'] = \Input::get('CityID');
        $extraData['ProvinceID'] = \Input::get('ProvinceID');
        $extraData['bid'] = $bid;
        $result = Request::Post(\Config::get('uni.kaka_server_ip'.\Config::get('uni.schoolUpdateApi')),$extraData);
        if ($result['result'] > 0) {
            return \Redirect::back()->withInput()->withErrors($result['reason']);
        }

        $newSchool = new School();
        $newSchool->bid = $bid;
        $newSchool->name = trim(\Input::get('name'));
        $newSchool->companyid = $this->company_id;
        $newSchool->isforbidded = 0;
        $newSchool->address = trim(\Input::get('Addr'));
        $newSchool->provinceid = \Input::get('ProvinceID');
        $newSchool->cityid = \Input::get('CityID');
        $newSchool->districtid = \Input::get('DistrictID');
        $newSchool->save();

    }


    public function getSchoolDashboardIndex($schoolid = NULL)
    {
        //告诉模板显示那个模块的数据
        $schoolMoudelId = \Config::get('uni.school_dashboard');
        $studentsCountPage = UserAccount::where('schoolid_original', '=', $schoolid)->first();//显示每校统计的学生数量的页面

        $schoolUserCount = UserAccount::where('schoolid_original','=',$schoolid)->count();

         $schoolNewUser = UserAccount::where('creationtime', '>=', strtotime(date('Y-m-d')))->where('schoolid_original', '=', $schoolid)->count();

         $school_action_user_today = UserAccount::where('modifiedtime', '>=', strtotime(date('Y-m-d')))->where('schoolid_original', '=', $schoolid)->count();

         $school_action_user_yesterday = UserAccount::where('modifiedtime', '>=', strtotime(date("Y-m-d", strtotime("-1 day"))))
             ->where('modifiedtime', '<', strtotime(date('Y-m-d')))->where('schoolid_original', '=', $schoolid)->count();

         $dataArray = $this->getPeopleNumForWeek(strtotime(date('Y-m-d')), $schoolid);

        return view('admin.circleschool.layout.school_master',compact('schoolMoudelId', 'schoolid','studentsCountPage','schoolUserCount','schoolNewUser','school_action_user_today','school_action_user_yesterday','dataArray'));

    }


    public function getSchoolHomeConfigIndex($schoolid = NULL)
    {

        $modules = Module::where('bid', '=', $schoolid)->orderBy('weight', 'desc')->paginate($this->perPage);

        $moduleTypes = ModuleType::all();

        //告诉模板显示那个模块的数据
        $schoolMoudelId = \Config::get('uni.school_home_config');

        return view('admin.circleschool.layout.school_master',compact('schoolMoudelId', 'modules', 'schoolid', 'moduleTypes'));
    }

    public function getSchoolTopBannerAdvIndex($schoolid = NULL)
    {
        //告诉模板显示那个模块的数据
        $schoolMoudelId = \Config::get('uni.school_adv_top_banner');

        $advs = Adv::where('type', '=', 4)->where('content_type', '=', 1)
            ->where('ownerid', '=', $schoolid)
            ->orderBy('creationtime', 'desc')
            ->paginate($this->perPage);

        return view('admin.circleschool.layout.school_master',compact('schoolMoudelId', 'schoolid', 'advs'));
    }

    public function getMultiStyleAdvIndex($schoolid = NULL)
    {
        $schoolMoudelId = \Config::get('uni.school_adv_multiple');

        $advs_style1 = Adv::where('status', '=', '1')->where('type', '=', 4)->where('content_type', '=', 3)
            ->where('style', '=', 1)
            ->where('ownerid', '=', $schoolid)
            ->paginate($this->perPage);

        $advs_style2_tmp = Adv::where('status', '=', '1')->where('type', '=', 4)->where('content_type', '=', 3)
            ->where('style', '=', 2)
            ->where('ownerid', '=', $schoolid)
            ->get();
        $advs_style2 = $this->packMultiStyleAdv($advs_style2_tmp, 2);

        $advs_style3_tmp = Adv::where('status', '=', '1')->where('type', '=', 4)->where('content_type', '=', 3)
            ->where('style', '=', 3)
            ->where('ownerid', '=', $schoolid)
            ->get();
        $advs_style3 = $this->packMultiStyleAdv($advs_style3_tmp, 3);

        $advs_style4_tmp = Adv::where('status', '=', '1')->where('type', '=', 4)->where('content_type', '=', 3)
            ->where('style', '=', 4)
            ->where('ownerid', '=', $schoolid)
            ->get();
        $advs_style4 = $this->packMultiStyleAdv($advs_style4_tmp, 4);

        return view('admin.circleschool.layout.school_master', compact('schoolMoudelId', 'schoolid', 'advs_style1', 'advs_style2', 'advs_style3', 'advs_style4'));

    }

    public function getSchoolMsgIndex($schoolid = NULL)
    {
        //告诉模板显示那个模块的数据
        $schoolMoudelId = \Config::get('uni.school_msg');

        $msg = UmiMsg::where('schoolid', '=', $schoolid)->first();
        

        return view('admin.circleschool.layout.school_master',compact('schoolMoudelId', 'schoolid', 'msg'));

    }

    // 每校每周数据报表
    public function postChangeDay()
    {

        $date = \Input::get('date');
        $schoolid = \Input::get('schoolid');

        $dataArray = $this->getPeopleNumForWeek(strtotime($date),$schoolid);

        return \Response::json(array('dataArray' => array($dataArray)));

    }

    // 每校每年数据报表
    public function postChangeYear()
    {
        $date = \Input::get('date');
        $schoolid = \Input::get('schoolid');
        $dataArray = $this->getPeopleNumForYear($date,$schoolid);
        return \Response::json(array('dataArray' => $dataArray));
    }


    private function getPeopleNumForWeek($time, $schoolid)
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
            . " else '8'" . " end as type from wtown_clientusers where creationtime > ". ($time - 6*86400) ." and creationtime <= " . ($time + 1*86400) . " and schoolid_original = ".$schoolid. ")t  group by t.type";

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


    private function getPeopleNumForYear($year,$schoolid)
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
            . " else '13'" . " end as type from wtown_clientusers where creationtime >= ". ($yearTime['Jan']) ." and creationtime <  " . ($yearTime['nextYearJan']) . " and schoolid_original = ". $schoolid ." )t  group by t.type";

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

    private function packMultiStyleAdv($advs_style2_tmp, $style_num){
        $cnt = 1;
        $advs_style2 = [];
        $tmp = [];

        foreach($advs_style2_tmp as $adv){
            array_push($tmp, $adv);
            if($cnt == $style_num){
                array_unshift($tmp, $adv['set']);
                array_push($advs_style2, $tmp);

                $cnt = 1;
                $tmp = [];
            }else{
                $cnt ++;
            }
        }

        return $advs_style2;
    }

}
