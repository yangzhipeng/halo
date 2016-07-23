<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Base\BaseController;

class LoginController extends BaseController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getIndex()
    {

        return view('admin/login');

    }

    public function postLogin()
    {

        $rules = array(
            'account'  => 'required',
            'password' => 'required'
        );

        $validator = \Validator::make(\Input::all(), $rules);

        if($validator->fails())
        {

            return \Redirect::back()->withInput()->withErrors($validator);

        }

        $account = \Input::get('account');
        $password = \Input::get('password');

        if(\Auth::attempt(['account' => $account, 'password' => $password, 'status' => 0]))
        {
            if(\Auth::getUser()->belongsToAdminLevel->authorization_value == 255)
            {
                return \Redirect::to('admin/dashboard');
            }else{

                return \Redirect::to('admin/dashboard');
            }

        }else{

            return \Redirect::back()->withInput()->withErrors('账号或密码错误!或账号已被禁用');

        }

    }

    public function getLogout()
    {

        if(\Auth::check())
        {
            \Auth::logout();
            return \Redirect::to('admin/login');
        }

        return \Redirect::to('admin/login');

    }

}