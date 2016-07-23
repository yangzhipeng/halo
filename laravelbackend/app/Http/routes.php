<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return \Redirect::to('admin/login');
});


Route::group(['prefix' => 'admin'], function(){


    Route::get('/', function(){
        return \Redirect::to('admin/login');
    });
    Route::get('login', 'Admin\LoginController@getIndex');
    Route::post('login', 'Admin\LoginController@postLogin');
    Route::get('logout', 'Admin\LoginController@getLogout');

    //数据报表
    Route::get('dashboard', 'Admin\DashboardController@getIndex');
    Route::post('dashboard/changeday', 'Admin\DashboardController@postChangeDay');
    Route::post('dashboard/changeyear', 'Admin\DashboardController@postChangeYear');

    //管理员管理
    Route::get('admin', 'Admin\AdminController@getIndex');
    Route::get('admin/create', 'Admin\AdminController@getCreate');
    Route::post('admin/create', 'Admin\AdminController@postCreate');
    Route::get('admin/ban/{adminAccountId}', 'Admin\AdminController@getBan');
    Route::get('admin/update/{adminAccountId}', 'Admin\AdminController@getAccountUpdate');
    Route::post('admin/update', 'Admin\AdminController@postAccountUpdate');
    Route::get('admin/admininfo/update', 'Admin\AdminController@getUpdate');
    Route::post('admin/admininfo/update', 'Admin\AdminController@postUpdate');

    //用户管理
    Route::get('user', 'Admin\UserController@getIndex');
    Route::get('user/inputmsg', 'Admin\UserController@inputMsg');
    Route::post('user/pushmsg', 'Admin\UserController@pushMsg');
    Route::get('user/inputsms', 'Admin\UserController@inputSms');
    Route::post('user/pushsms', 'Admin\UserController@pushSms');
    Route::get('user/log/{cid}', 'Admin\UserController@getUserLog');

    //圈圈管理
    Route::get('circleuser', 'Admin\CircleUserController@getIndex');
    Route::get('circleuser/log/{cid}', 'Admin\CircleUserController@getUserLog');
    Route::get('circleschool', 'Admin\CircleUserController@getSchool');
    //圈圈数据报表管理
    Route::get('circleschool/{schoolid}', function($schoolid){

        return  Redirect::to('admin/circleschool'.'/'.$schoolid.'/dashboard');

    });
    Route::get('circleschool/{schoolid}/dashboard', 'Admin\CircleSchool\SchoolController@getSchoolDashboardIndex');
    //圈圈首页配置管理
    Route::get('circleschool/{schoolid}/homeconfig', 'Admin\CircleSchool\SchoolController@getSchoolHomeConfigIndex');
    Route::post('circleschool/homeconfig/create', 'Admin\CircleSchool\HomeConfigController@postCreate');
    Route::post('circleschool/homeconfig/update/{moduleId}', 'Admin\CircleSchool\HomeConfigController@postUpdate');
    Route::get('circleschool/homeconfig/delete/{moduleId}', 'Admin\CircleSchool\HomeConfigController@postDelete');
    Route::post('circleschool/module/change-status', 'Admin\CircleSchool\HomeConfigController@postForbidden');
    Route::post('circleschool/dashboard/changeday', 'Admin\CircleSchool\SchoolController@postChangeDay');
    Route::post('circleschool/dashboard/changeyear', 'Admin\CircleSchool\SchoolController@postChangeYear');
    //圈圈banner管理
    Route::get('circleschool/{schoolid}/top-adv', 'Admin\CircleSchool\SchoolController@getSchoolTopBannerAdvIndex');
    Route::post('circleschool/{schoolid}/adv/create-top', 'Admin\CircleSchool\AdvController@createTopBannerAdv');
    Route::post('circleschool/adv/update/{advId}', 'Admin\CircleSchool\AdvController@postUpdate');
    Route::get('circleschool/adv/delete/{advId}', 'Admin\CircleSchool\AdvController@getDelete');
    Route::post('circleschool/adv/change-status', 'Admin\CircleSchool\AdvController@postStatus');
    //圈圈样式广告管理
    Route::get('circleschool/{schoolid}/mul-adv', 'Admin\CircleSchool\SchoolController@getMultiStyleAdvIndex');
    Route::post('circleschool/{schoolid}/adv/create-style1', 'Admin\CircleSchool\AdvController@createAdvStyle1');
    Route::post('circleschool/{schoolid}/adv/create-style2', 'Admin\CircleSchool\AdvController@createAdvStyle2');
    Route::post('circleschool/{schoolid}/adv/create-style3', 'Admin\CircleSchool\AdvController@createAdvStyle3');
    Route::post('circleschool/{schoolid}/adv/create-style4', 'Admin\CircleSchool\AdvController@createAdvStyle4');
    Route::get('circleschool/adv/delete-multi-style/{setId}', 'Admin\CircleSchool\AdvController@delMultiStyleAdv');
    Route::post('circleadv/update/{advId}', 'Admin\CircleSchool\AdvController@postUpdate');
    //圈圈推荐会员卡管理
    Route::get('circleschool/{schoolid}/bizcard','Admin\CircleSchool\BizCardController@index');
    Route::get('circleschool/{schoolid}/bizcard/set-uni-recommend','Admin\CircleSchool\BizCardController@setUniRecommend');
    Route::get('circleschool/{schoolid}/bizcard/remove-uni-recommend','Admin\CircleSchool\BizCardController@removeUniRecommend');
    //圈圈优里短信管理
    Route::get('circleschool/{schoolid}/youlimsg', 'Admin\CircleSchool\SchoolController@getSchoolMsgIndex');
    Route::post('circleschool/{schoolid}/youlimsg/create','Admin\CircleSchool\YouliDeliveryController@postCreate');
    Route::post('circleschool/youliMsg/update/{mid}','Admin\CircleSchool\YouliDeliveryController@postUpdate');
    Route::get('circleschool/youliMsg/delete/{mid}','Admin\CircleSchool\YouliDeliveryController@getDelete');
    Route::post('circleschool/youliMsg/change-usestatus','Admin\CircleSchool\YouliDeliveryController@postuseStatus');
    //圈圈群发任务管理
    Route::get('circleschool/{schoolid}/task', 'Admin\CircleSchool\TaskController@getIndex');
    Route::post('circleschool/{schoolid}/task/create', 'Admin\CircleSchool\TaskController@postTempTaskCreate');
    Route::get('circleschool/task/delete/{tempTaskId}', 'Admin\CircleSchool\TaskController@postTempTaskDelete');
    Route::post('circleschool/task/update/{tempTaskId}', 'Admin\CircleSchool\TaskController@postTempTaskUpdate');
    Route::post('circleschool/task/send', 'Admin\CircleSchool\TaskController@postSend');
    Route::get('circleschool/task/send', 'Admin\CircleSchool\TaskController@getSend');
    //圈圈结束


    //学校管理
    Route::get('school', 'Admin\School\SchoolController@getIndex');
    Route::post('school/change-ban', 'Admin\School\SchoolController@postBan');
    Route::get('school/create', 'Admin\School\SchoolController@getCreate');
    Route::post('school/create', 'Admin\School\SchoolController@postCreate');
    Route::post('school/cities', 'Admin\School\SchoolController@postCities');
    Route::post('school/districts', 'Admin\School\SchoolController@postDistricts');
    Route::get('school/{schoolid}', function($schoolid){

        return  Redirect::to('admin/school'.'/'.$schoolid.'/dashboard');

    });

    //每个学校的数据报表
    Route::get('school/{schoolid}/dashboard', 'Admin\School\SchoolController@getSchoolDashboardIndex');
    Route::post('school/dashboard/changeday', 'Admin\School\SchoolController@postChangeDay');
    Route::post('school/dashboard/changeyear', 'Admin\School\SchoolController@postChangeYear');


    Route::get('school/{schoolid}/homeconfig', 'Admin\School\SchoolController@getSchoolHomeConfigIndex');
    Route::get('school/{schoolid}/top-adv', 'Admin\School\SchoolController@getSchoolTopBannerAdvIndex');
    Route::get('school/{schoolid}/mul-adv', 'Admin\School\SchoolController@getMultiStyleAdvIndex');

    Route::get('school/{schoolid}/youlimsg', 'Admin\School\SchoolController@getSchoolMsgIndex');
    Route::post('school/{schoolid}/youlimsg/create','Admin\School\YouliDeliveryController@postCreate');

    Route::post('school/youliMsg/update/{mid}','Admin\School\YouliDeliveryController@postUpdate');
    Route::get('school/youliMsg/delete/{mid}','Admin\School\YouliDeliveryController@getDelete');
    Route::post('school/youliMsg/change-usestatus','Admin\School\YouliDeliveryController@postuseStatus');


    Route::post('school/homeconfig/create', 'Admin\School\HomeConfigController@postCreate');
    Route::post('school/homeconfig/update/{moduleId}', 'Admin\School\HomeConfigController@postUpdate');
    Route::get('school/homeconfig/delete/{moduleId}', 'Admin\School\HomeConfigController@postDelete');
    Route::post('school/module/change-status', 'Admin\School\HomeConfigController@postForbidden');

    Route::post('school/{schoolid}/adv/create-top', 'Admin\School\AdvController@createTopBannerAdv');
    Route::post('school/{schoolid}/adv/create-style1', 'Admin\School\AdvController@createAdvStyle1');
    Route::post('school/{schoolid}/adv/create-style2', 'Admin\School\AdvController@createAdvStyle2');
    Route::post('school/{schoolid}/adv/create-style3', 'Admin\School\AdvController@createAdvStyle3');
    Route::post('school/{schoolid}/adv/create-style4', 'Admin\School\AdvController@createAdvStyle4');
    Route::post('school/adv/update/{advId}', 'Admin\School\AdvController@postUpdate');
    Route::get('school/adv/delete/{advId}', 'Admin\School\AdvController@getDelete');
    Route::get('school/adv/delete-multi-style/{setId}', 'Admin\School\AdvController@delMultiStyleAdv');
    Route::post('school/adv/change-status', 'Admin\School\AdvController@postStatus');

    Route::get('school/{schoolid}/bizcard','Admin\School\BizCardController@index');
    Route::get('school/{schoolid}/bizcard/set-uni-recommend','Admin\School\BizCardController@setUniRecommend');
    Route::get('school/{schoolid}/bizcard/remove-uni-recommend','Admin\School\BizCardController@removeUniRecommend');

    Route::get('school/{schoolid}/task', 'Admin\School\TaskController@getIndex');
    Route::post('school/{schoolid}/task/create', 'Admin\School\TaskController@postTempTaskCreate');
    Route::get('school/task/delete/{tempTaskId}', 'Admin\School\TaskController@postTempTaskDelete');
    Route::post('school/task/update/{tempTaskId}', 'Admin\School\TaskController@postTempTaskUpdate');
    Route::post('school/task/send', 'Admin\School\TaskController@postSend');
    Route::get('school/task/send', 'Admin\School\TaskController@getSend');


    //全局广告
    Route::get('adv/topbanneradv', 'Admin\AdvController@getTopBannerIndex');
    Route::get('adv/multiadv', 'Admin\AdvController@getMultiStyleAdvIndex');
    Route::post('adv/update/{advId}', 'Admin\AdvController@postUpdate');
    Route::post('adv/create-top', 'Admin\AdvController@createTopBannerAdv');
    Route::post('adv/create-style1', 'Admin\AdvController@createAdvStyle1');
    Route::post('adv/changeStyle1Status','Admin\AdvController@postStyle1Status');
    Route::post('adv/changeStyle2Status','Admin\AdvController@postStyle2Status');
    Route::post('adv/changeStyle3Status','Admin\AdvController@postStyle3Status');
    Route::post('adv/changeStyle4Status','Admin\AdvController@postStyle4Status');
    Route::post('adv/create-style2', 'Admin\AdvController@createAdvStyle2');
    Route::post('adv/create-style3', 'Admin\AdvController@createAdvStyle3');
    Route::post('adv/create-style4', 'Admin\AdvController@createAdvStyle4');
    Route::get('adv/delete/{advId}', 'Admin\AdvController@getDelete');
    Route::get('adv/delete-multi-style/{setId}', 'Admin\AdvController@delMultiStyleAdv');
    Route::post('adv/change-status', 'Admin\AdvController@postStatus');
    //icon设置
    Route::get('adv/icon/iconset','Admin\IconController@getIconIndex');
    Route::post('adv/icon/create','Admin\IconController@postCreateIcon');
    Route::post('adv/icon/update/{moduleId}','Admin\IconController@postUpdateIcon');
    Route::get('adv/icon/delete/{moduleId}','Admin\IconController@DeleteIcon');
    Route::post('adv/icon/changestatus','Admin\IconController@postForbidden');
    //全局广告（会员卡分类设置）
    Route::get('cardcategory/vipcard', 'Admin\CardcategoryController@getVipCardIndex');
    Route::post('cardcategory/create-card', 'Admin\CardcategoryController@createCardCategory');
    Route::post('cardcategory/updatecard/{cardId}', 'Admin\CardcategoryController@postUpdateCard');
    Route::get('cardcategory/deletecard/{cardId}', 'Admin\CardcategoryController@getDeleteCard');
    Route::post('cardcategory/cardstatus', 'Admin\CardcategoryController@postCardStatus');
    Route::post('cardcategory/changecategory', 'Admin\CardcategoryController@postChangecategory');

    //资金管理
    Route::get('account/balance', 'Admin\AccountController@getBalance');
    Route::get('account/charge', 'Admin\AccountController@getChargeRecords');
    Route::get('account/cash', 'Admin\AccountController@getCashRecords');
    Route::get('account/cashsel/{status}', 'Admin\AccountController@getCashRecordsByStatus');
    Route::get('account/cashoutdetail/{transaction_id}', 'Admin\AccountController@cashoutDetail');
    Route::get('account/confirm/{transaction_id}', 'Admin\AccountController@confirmCashout');

    //交易记录路由
    Route::get('account/transaction_records','Admin\AccountController@getUmiAccountTransactionInfo');
    Route::get('account/transStatu/{status}','Admin\AccountController@getTransactionByStatus');
    Route::get('account/transType/{transaction_type}','Admin\AccountController@getTransactionType');

    //投诉管理
    Route::get('complaint/p2pcomplaint', 'Admin\ComplainController@getP2PComplaintList');
    Route::get('complaint/p2pcomplaintsel/{status}', 'Admin\ComplainController@getP2PComplaintListByStatus');
    Route::get('complaint/p2pcomplaintdetail/{taskid}', 'Admin\ComplainController@getP2PComplaintDetail');
    Route::post('complaint/commentP2PComplain', 'Admin\ComplainController@commentP2PComplaint');
    Route::post('complaint/closeP2PComplain', 'Admin\ComplainController@closeP2PComplaint');
    Route::post('complaint/resetComplainTask', 'Admin\ComplainController@resetComplainTask');

    /*
     *秒杀商品管理
     */
    //品牌管理
    Route::get('flashsale/brand/brandindex', 'Admin\ProductBrandController@getBrandIndex');
    Route::post('flashsale/brand/create-brand', 'Admin\ProductBrandController@createBrand');
    Route::post('flashsale/brand/updatebrand/{brandId}', 'Admin\ProductBrandController@postUpdateBrand');
    Route::get('flashsale/brand/deletebrand/{brandId}', 'Admin\ProductBrandController@getDeleteBrand');
    Route::post('flashsale/brand/brandstatus', 'Admin\ProductBrandController@postBrandStatus');

    //分类管理
    Route::get('flashsale/category/categoryindex', 'Admin\ProductCategoryController@getCategoryIndex');
    Route::post('flashsale/category/create-category', 'Admin\ProductCategoryController@createCategory');
    Route::post('flashsale/category/updatecategory/{categoryId}', 'Admin\ProductCategoryController@postUpdateCategory');
    Route::get('flashsale/category/deletecategory/{categoryId}', 'Admin\ProductCategoryController@getDeleteCategory');
    Route::post('flashsale/category/categorystatus', 'Admin\ProductCategoryController@postCategoryStatus');

    //商品管理
    Route::get('flashsale/product/productindex', 'Admin\ProductController@getProductIndex');
    Route::post('flashsale/product/create-product', 'Admin\ProductController@createProduct');
    Route::post('flashsale/product/updateproduct/{productId}', 'Admin\ProductController@postUpdateProduct');
    Route::get('flashsale/product/deleteproduct/{productId}', 'Admin\ProductController@getDeleteProduct');
    Route::post('flashsale/product/productstatus', 'Admin\ProductController@postProductStatus');

    //商品计划
    Route::get('flashsale/plan/planindex', 'Admin\ProductPlanController@getPlanIndex');
    Route::post('flashsale/plan/create-plan', 'Admin\ProductPlanController@createPlan');
    Route::post('flashsale/plan/updateplan/{planId}', 'Admin\ProductPlanController@postUpdatePlan');
    Route::get('flashsale/plan/deleteplan/{planId}', 'Admin\ProductPlanController@getDeletePlan');
    Route::post('flashsale/plan/planstatus', 'Admin\ProductPlanController@postPlanStatus');
    //为计划设置商品
    Route::get('flashsale/p2plan/p2planindex/{planId}', 'Admin\P2PlanController@getP2PlanIndex');
    Route::post('flashsale/p2plan/create-p2plan', 'Admin\P2PlanController@createP2Plan');
    Route::post('flashsale/p2plan/updatep2plan/{p2planId}', 'Admin\P2PlanController@postUpdateP2Plan');
    Route::get('flashsale/p2plan/deletep2plan/{p2planId}', 'Admin\P2PlanController@getDeleteP2Plan');

    //用户商品订单管理详情
    Route::get('flashsale/order/orderDetail','Admin\ProductOrderController@getOrderIndex');
    Route::get('flashsale/order/orderDetail/orderStatus/{order_id}','Admin\ProductOrderController@getOrderStatusIndex');
    Route::post('flashsale/order/orderDetail/orderStatus/updateStatu/{order_id}','Admin\ProductOrderController@updateStatus');
    Route::post('flashsale/order/orderDetail/orderStatus/{order_id}/create','Admin\ProductOrderController@postCreate');

    //UserTask
    Route::get('school/usertask/index','Web\ApiController@getTaskIndex');
    Route::post('school/usertask/accepttask','Web\ApiController@accepttask');
    Route::get('school/usertask/getindex','Admin\School\UserTaskController@getIndex');
    Route::post('school/usertask/sendtask','Admin\School\UserTaskController@sendtask');
    Route::post('school/usertask/postStatus', 'Admin\School\UserTaskController@postStatus');
    Route::get('school/usertask/deletetask/{taskid}', 'Admin\School\UserTaskController@getDeleteTask');

    Route::get('school/usertask/test', 'Admin\School\UserTaskController@test');



});
