<?php

namespace App\Http\Controllers\Admin\Base;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    //
    protected $app_id = 114;
    protected $company_id = 59;

    protected $perPage = 20;


    public function __construct()
    {
        \Config::set('auth.driver', 'eloquent');
        \Config::set('auth.model', 'App\Http\Models\AdminAccount');
        \Config::set('auth.table', 'admin_accounts');
        \Config::set('auth.reminder', array());
    }


}
