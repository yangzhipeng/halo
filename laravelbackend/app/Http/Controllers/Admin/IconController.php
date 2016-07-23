<?php
/**
 * Created by PhpStorm.
 * User: YOUNG
 * Date: 2016-03-17
 * Time: 17:47
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Base\BaseController;
use App\Http\Libs\YouPaiYun;
use App\Http\Utils\Upload;
use Illuminate\Http\Request;
use App\Http\Models\Module;
use App\Http\Models\ModuleType;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class IconController extends BaseController
{
    //
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    //icon配置
    public function getIconIndex()
    {
        $modules = Module::paginate($this->perPage);

        $moduleTypes = ModuleType::all();

        return view('admin.adv.icon.icon_index',compact('modules','moduleTypes'));
    }
    //icon配置
    public function postCreateIcon()
    {
        $route = array(
            'name' => 'required',
            'actiontype' => 'required',
            'weight' => 'required',
            'mtype' => 'required',
        );

        $validator = \Validator::make(\Input::all(), $route);

        if($validator->fails())
        {
            return \Redirect::back()->withInput()->withErrors($validator->errors());
        }

        $name = \Input::get('name');
        if(\Input::file('file'))
        {
            $imageUrl = Upload::getInstance()->uploadImage(\Input::file('file'), true);
            if($imageUrl)
            {
                $iconurl = $imageUrl;
            }else{
                return \Redirect::back()->with('error', '文件上传失败');
            }
        }else
        {
            return \Redirect::back()->with('error', '请上传图片');
        }
        //$iconurl = \Input::get('iconurl');
        $actionandroid = \Input::get('actionandroid');
        $actionios = \Input::get('actionios');
        $actionurl = \Input::get('actionurl');
        $actiontype = \Input::get('actiontype');
        $weight = \Input::get('weight');
        $mtype = \Input::get('mtype');

        $newModule = new Module();
        $newModule->name = $name;
        $newModule->iconurl = $iconurl;
        $newModule->actionandroid = $actionandroid;
        $newModule->actionios = $actionios;
        $newModule->actionurl = $actionurl;
        $newModule->actiontype = $actiontype;
        $newModule->weight = $weight;
        $newModule->appid = $this->app_id;
        $newModule->mtype = $mtype;

        $newModule->save();

        return \Redirect::back()->with('success', '新增Icon设置成功');

    }

    public function postUpdateIcon($moduleId = NULL)
    {
        $route = array(
            'name' => 'required',
            'actiontype' => 'required',
            'weight' => 'required',
            'mtype' => 'required',
        );

        $validator = \Validator::make(\Input::all(), $route);

        if($validator->fails())
        {
            return \Redirect::back()->withInput()->withErrors($validator->errors());
        }

        $module = Module::where('id', '=', $moduleId)->first();

        if(!$module)
        {
            return \Redirect::back()->with('error', '没找到该设置');
        }

        $module->name = \Input::get('name');

        if(\Input::file('file'))
        {
            $imageUrl = Upload::getInstance()->uploadImage(\Input::file('file'), true);
            if($imageUrl)
            {
                $module->iconurl = $imageUrl;
            }else{
                return \Redirect::back()->with('error', '文件上传失败');
            }
        }

        $module->actionandroid = \Input::get('actionandroid');
        $module->actionios = \Input::get('actionios');
        $module->actionurl = \Input::get('actionurl');
        $module->actiontype = \Input::get('actiontype');
        $module->weight = \Input::get('weight');
        $module->mtype = \Input::get('mtype');

        $module->save();

        return \Redirect::back()->with('success', '修改设置成功');

    }

    public function DeleteIcon($moduleId = NULL)
    {
        $module = Module::where('id', '=', $moduleId)->first();

        if(!$module)
        {
            return \Redirect::back()->with('error', '没找到该设置');
        }

        $module->delete();

        return \Redirect::back()->with('success', '删除成功');
    }

    public function postForbidden()
    {

        $moduleId = \Input::get('moduleId');
        $isForbidden = \Input::get('isForbidden');

        $module = Module::where('id', '=', $moduleId)->first();

        if(!$module)
        {
            return \Response::json(array('code' => -1));
        }

        if($isForbidden != 0)
        {
            $module->status = 1;
            $code = 1;
        }else{
            $module->status = 0;
            $code = 0;
        }

        $module->save();

        return \Response::json(array('code' => $code));


    }
}
