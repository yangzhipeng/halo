<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Base\BaseController;
use App\Http\Models\AdminAccount;
use App\Http\Models\AdminInfo;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminController extends BaseController
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
            $adminAccounts = AdminAccount::where('level_id', '<>', 1)->paginate($this->perPage);
            return view('admin.admin.index', compact('adminAccounts'));
        }else
        {
            $adminAccounts = AdminAccount::where('level_id', '<>', 1)
                ->where('account', 'like', '%'.$query.'%')->paginate($this->perPage);
            return view('admin.admin.index', compact('adminAccounts', 'query'));
        }
    }

    public function getCreate()
    {
        return view('admin.admin.account_create', compact('adminAccounts'));
    }

    public function postCreate()
    {
        $rules = array(
            'name' => 'required',
            'account' =>'required',
            'password' => 'required'
        );

        $validator = \Validator::make(\Input::all(), $rules);

        if($validator->fails())
        {

            return \Redirect::back()->withInput()->withErrors($validator);

        }

        $newAdminAccount = new AdminAccount();
        $newAdminAccount->account = \Input::get('account');
        $newAdminAccount->password = \Hash::make(\Input::get('password'));
        $newAdminAccount->level_id = 2;
        $newAdminAccount->save();

        $newAdminInfo = new AdminInfo();
        $newAdminInfo->admin_id = $newAdminAccount->id;
        $newAdminInfo->admin_name = \Input::get('name');
        $newAdminInfo->save();

        return \Redirect::to('/admin/admin')->with('success', '添加成功');

    }

    public function getBan($adminAccountId = NULL)
    {
        $adminAccount = AdminAccount::where('id', '=', $adminAccountId)->first();

        if(!$adminAccount)
        {
            return \Redirect::back()->with('error', '管理员账号不存在');
        }

        if($adminAccount->status == 0)
        {
            $adminAccount->status = 1;
        }else{

            $adminAccount->status = 0;
        }

        $adminAccount->save();

        return \Redirect::back()->with('success', '更改成功');


    }

    public function getAccountUpdate($adminAccountId = NULL)
    {

        $adminAccount = AdminAccount::where('id', '=', $adminAccountId)->first();

        if(!$adminAccount)
        {
            return \Redirect::back()->with('error', '管理员账号不存在');
        }

        return view('admin.admin.account_update', compact('adminAccount'));

    }

    public function postAccountUpdate()
    {

        $rules = array(
            'adminAccount_id' => 'required',
            'name' =>'required',
            'account' => 'required',
        );

        $validator = \Validator::make(\Input::all(), $rules);

        if($validator->fails())
        {

            return \Redirect::back()->withInput()->withErrors($validator);

        }

        $adminAccountId = \Input::get('adminAccount_id');

        $adminAccount = AdminAccount::where('id', '=', $adminAccountId)->first();

        if(!$adminAccount)
        {
            return \Redirect::back()->with('error', '管理员账号不存在');
        }

        $adminAccount->account = \Input::get('account');

        if(\Input::get('password') != '')
        {
            $adminAccount->password = \Hash::make(\Input::get('password'));
        }

        $adminAccountInfo = $adminAccount->hasOneAdminInfo;

        $adminAccountInfo->admin_name = \Input::get('name');

        $adminAccountInfo->save();

        $adminAccount->save();

        return \Redirect::to('admin/admin')->with('success', '修改成功');

    }


    public function getUpdate()
    {

        $adminAccount = \Auth::getUser();
        return view('admin.admin.update', compact('adminAccount'));
    }

    public function postUpdate()
    {
        $rules = array(
            'name' => 'required'
        );

        $validator = \Validator::make(\Input::all(), $rules);

        if($validator->fails())
        {

            return \Redirect::back()->withInput()->withErrors($validator);

        }



        $name = \Input::get('name');
        $oldPassword = \Input::get('oldPassword');
        $newPassword = \Input::get('newPassword');

        $adminAccount = AdminAccount::where('id', '=', \Auth::getUser()->id)->first();

        if(!$adminAccount)
        {
            return \Redirect::back()->with('error', '帐号不存在');
        }


        if($oldPassword != NULL)
        {
            if(!\Hash::check($oldPassword, $adminAccount->password))
            {
                return \Redirect::back()->with('error', '旧密码有误');
            }else{

                if($newPassword == NULL)
                {
                    return \Redirect::back()->with('error', '请输入新密码');
                }

                $adminAccount->password = \Hash::make($newPassword);

            }
        }

        $adminAccountInfo = $adminAccount->hasOneAdminInfo;

        $adminAccountInfo->admin_name = $name;

        $adminAccountInfo->save();

        $adminAccount->save();

        return \Redirect::to('/admin/dashboard')->with('success', '修改成功');

    }


}
