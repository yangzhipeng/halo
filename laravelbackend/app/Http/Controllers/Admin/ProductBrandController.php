<?php
/**
 * Created by PhpStorm.
 * User: wangyang
 * Date: 16-4-20
 * Time: 上午9:19
 */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Base\BaseController;
use App\Http\Libs\YouPaiYun;
use App\Http\Models\ProductBrand;
use App\Http\Models\Product;

use App\Http\Utils\Upload;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redis as Redis;

class ProductBrandController extends BaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
        $this->redis = Redis::connection();
    }

    //商品品牌列表
    public function getBrandIndex()
    {
        $brand = new ProductBrand();

        $query = \Input::get('query');
        if(!$query)
        {

            $brands = $brand->getProductBrand();

            return view('admin.flashsale.brand.brand_index', compact('brands'));

        }else
        {
            $brands = $brand->getProductBrand($query);

            return view('admin.flashsale.brand.brand_index', compact('brands','query'));
        }
    }
    //添加商品品牌
    public function createBrand()
    {
        $route = array(
            'name' => 'required',
        );

        $validator = \Validator::make(\Input::all(), $route);

        if($validator->fails())
        {
            return \Redirect::back()->withInput()->withErrors($validator->errors());
        }

        $brand = new ProductBrand();

        $brand->name = \Input::get('name');
        //判断此商品品牌是否添加过
        $brandNames = $brand->getProductBrand();
        foreach($brandNames as $brandName)
        {
            if($brandName->name == $brand->name)
            {
                return \Redirect::back()->withInput()->withErrors('您已经添加过此品牌,请不要重复添加');
            }
        }

        $brand->status = 1;
        $brand->manufacture = \Input::get('manufacture');
        $brand->description = \Input::get('description');
        $time = strtotime(date('Y-m-d H:i:s'));
        $brand->creation_time = $time;
        $brand->update_time = $time;
        $imageUrl = Upload::getInstance()->uploadImage(\Input::file('file'));
        if($imageUrl)
        {
            $brand->icon = $imageUrl['imageurl'];
        }
        $brand->save();

        return \Redirect::back()->with('success', '新增商品品牌成功');
    }
    //修改商品品牌
    public function postUpdateBrand($brandId = NULL)
    {
        $route = array(
            'name' => 'required',
        );

        $validator = \Validator::make(\Input::all(), $route);

        if($validator->fails())
        {
            return \Redirect::back()->withInput()->withErrors($validator->errors());
        }

        $brand = ProductBrand::find($brandId);

        if(!$brand)
        {
            return \Redirect::back()->with('error', '没有找到该品牌');
        }

        $brand->name = \Input::get('name');
        $brand->manufacture = \Input::get('manufacture');
        $brand->description = \Input::get('description');
        $brand->update_time = strtotime(date('Y-m-d H:i:s'));
        $imageUrl = Upload::getInstance()->uploadImage(\Input::file('file'));
        if($imageUrl)
        {
            $brand->icon = $imageUrl['imageurl'];
        }

        $brand->save();

        return \Redirect::back()->with('success', '修改商品品牌成功');
    }
    //删除商品品牌
    public function getDeleteBrand($brandId = NULL)
    {
        $product = new Product();
        $brand = ProductBrand::find($brandId);

        if(!$brand)
        {
            return \Redirect::back()->with('error', '没有找到该品牌');
        }

        $products = $product->getProductBrand($brandId);

        if(!empty($products)) {
            return \Redirect::back()->with('error', '该商品品牌下有所属商品,不能删除');
        }else {
            $brand->status = 2;
            $brand->update_time = strtotime(date('Y-m-d H:i:s'));
            $brand->save();

            return \Redirect::back()->with('success', '删除商品品牌成功');
        }
    }

    public function postBrandStatus()
    {
        $brandId = \Input::get('brandId');
        $status = \Input::get('status');

        $brand = ProductBrand::find($brandId);

        if(!$brand)
        {
            return \Response::json(array('code' => -1));
        }
        if($status != 0)
        {
            $product = new Product();
            $products = $product->getProductBrand($brandId);
            if(!empty($products)) {
                $code = 2;
            }else {
                $brand->status = 1;
                $brand->update_time = strtotime(date('Y-m-d H:i:s'));
                $code = 1;
            }

        }else{
            $brand->status = 0;
            $brand->update_time = strtotime(date('Y-m-d H:i:s'));
            $code = 0;
        }

        $brand->save();

        return \Response::json(array('code' => $code));
    }

}
