<?php
/**
 * Created by PhpStorm.
 * User: whoami
 * Date: 16-4-20
 * Time: 上午9:48
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Base\BaseController;
use App\Http\Libs\YouPaiYun;
use App\Http\Models\ProductCategory;
use App\Http\Models\Product2Category;

use App\Http\Utils\Upload;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redis as Redis;

class ProductCategoryController extends BaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
        $this->redis = Redis::connection();
    }

    //商品类别列表
    public function getCategoryIndex()
    {
        $category = new ProductCategory();

        $query = \Input::get('query');
        if(!$query)
        {

            $categorys = $category->getProductCategory();

            return view('admin.flashsale.category.category_index', compact('categorys'));

        }else
        {
            $categorys = $category->getProductCategory($query);

            return view('admin.flashsale.category.category_index', compact('categorys','query'));
        }
    }
    //添加商品类别
    public function createCategory()
    {
        $route = array(
            'name' => 'required',
        );

        $validator = \Validator::make(\Input::all(), $route);

        if($validator->fails())
        {
            return \Redirect::back()->withInput()->withErrors($validator->errors());
        }

        $category = new ProductCategory();

        $category->name = \Input::get('name');
        //判断此商品类别是否添加过
        $categoryNames = $category->getProductCategory();
        foreach($categoryNames as $categoryName)
        {
            if($categoryName->name == $category->name)
            {
                return \Redirect::back()->withInput()->withErrors('您已经添加过此商品类别,请不要重复添加');
            }
        }

        $category->status = 1;
        $category->parent_id = 0;
        $category->description = \Input::get('description');
        $time = strtotime(date('Y-m-d H:i:s'));
        $category->creation_time = $time;
        $category->update_time = $time;
        $imageUrl = Upload::getInstance()->uploadImage(\Input::file('file'));
        if($imageUrl)
        {
            $category->icon = $imageUrl['imageurl'];
        }
        $category->save();

        return \Redirect::back()->with('success', '新增商品类别成功');
    }
    //修改商品类别
    public function postUpdateCategory($categoryId = NULL)
    {
        $route = array(
            'name' => 'required',
        );

        $validator = \Validator::make(\Input::all(), $route);

        if($validator->fails())
        {
            return \Redirect::back()->withInput()->withErrors($validator->errors());
        }

        $category = ProductCategory::find($categoryId);

        if(!$category)
        {
            return \Redirect::back()->with('error', '没有找到该商品类别');
        }

        $category->name = \Input::get('name');
        $category->description = \Input::get('description');
        $category->update_time = strtotime(date('Y-m-d H:i:s'));
        $imageUrl = Upload::getInstance()->uploadImage(\Input::file('file'));
        if($imageUrl)
        {
            $category->icon = $imageUrl['imageurl'];
        }

        $category->save();

        return \Redirect::back()->with('success', '修改商品类别成功');
    }
    //删除商品类别
    public function getDeleteCategory($categoryId = NULL)
    {
        $category = ProductCategory::find($categoryId);
        $p2category = new Product2Category();
        if(!$category)
        {
            return \Redirect::back()->with('error', '没有找到该商品类别');
        }
        //判断商品类别下是否有所属商品
        $products = $p2category->getProductCategory($categoryId);
        if(!empty($products)){
            return \Redirect::back()->with('error', '该商品类别下有所属商品,不能删除该类别');
        } else {
            $category->status = 2;
            $category->update_time = strtotime(date('Y-m-d H:i:s'));
            $category->save();

            return \Redirect::back()->with('success', '删除商品类别成功');
        }
    }

    public function postCategoryStatus()
    {
        $categoryId = \Input::get('categoryId');
        $status = \Input::get('status');

        $category = ProductCategory::find($categoryId);

        if(!$category)
        {
            return \Response::json(array('code' => -1));
        }

        if($status != 0)
        {
            //判断商品类别下是否有所属商品
            $p2category = new Product2Category();
            $products = $p2category->getProductCategory($categoryId);
            if(!empty($products)){
                $code = 2;
            }else {
                $category->status = 1;
                $category->update_time = strtotime(date('Y-m-d H:i:s'));
                $code = 1;
            }
        }else{
            $category->status = 0;
            $category->update_time = strtotime(date('Y-m-d H:i:s'));
            $code = 0;
        }

        $category->save();

        return \Response::json(array('code' => $code));
    }

}
