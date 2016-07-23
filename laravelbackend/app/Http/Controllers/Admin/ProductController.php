<?php
/**
 * Created by PhpStorm.
 * User: whoami
 * Date: 16-4-20
 * Time: 上午9:55
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Base\BaseController;
use App\Http\Libs\YouPaiYun;
use App\Http\Models\Product;
use App\Http\Models\ProductBrand;
use App\Http\Models\ProductCategory;
use App\Http\Models\Product2Category;
use App\Http\Models\Product2Plan;

use App\Http\Utils\Upload;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redis as Redis;
use Illuminate\Support\Facades\DB;

class ProductController extends BaseController
{

    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
        $this->redis = Redis::connection();
    }

    //商品品牌列表
    public function getProductIndex()
    {
        $product = new Product();

        $brand = new ProductBrand();
        $brands = $brand->getBrandInfo();

        $category = new ProductCategory();
        $categorys = $category->getCategoryInfo();

        $query = \Input::get('query');
        if(!$query)
        {
            $products = $product->getProduct();
            if(!empty($products)){
                $products = $this->getCategoryNames($products);
            }
            return view('admin.flashsale.product.product_index', compact('products','brands','categorys'));

        }else
        {
            $products = $product->getProduct($query);
            if(!empty($products)){
                $products = $this->getCategoryNames($products);
            }
            return view('admin.flashsale.product.product_index', compact('products','query','brands','categorys'));
        }
    }

    //获取每个商品的所有类别
    private function getCategoryNames($products){
        foreach($products as $product) {
            $product->categorys = '';
            $product->categorys_id = '';
            $p2Category = new Product2Category();
            $categorynames = $p2Category->getP2C($product->id);
            foreach($categorynames as $name){
                $product->categorys .= $name->name.',';
                $product->categorys_id .= $name->category_id.',';
            }
            $product->categorys = substr($product->categorys, 0, -1);
            $product->categorys_id = substr($product->categorys_id, 0, -1);
        }
        return $products;
    }

    //添加商品品牌
    public function createProduct()
    {
        $route = array(
            'name' => 'required',
        );

        $validator = \Validator::make(\Input::all(), $route);

        if($validator->fails())
        {
            return \Redirect::back()->withInput()->withErrors($validator->errors());
        }
        DB::beginTransaction();
        try {
            $product = new Product();

            $product->status = 1;
            $time = strtotime(date('Y-m-d H:i:s'));
            $product->creation_time = $time;
            $product->update_time = $time;
            $product->product_code = \Input::get('product_code');
            $product->name = \Input::get('name');
            $product->brand_id = \Input::get('brand');
            $product->description = \Input::get('description');
            $product->description_short = \Input::get('description_short');
            $product->quantity = \Input::get('quantity');
            $product->market_price = \Input::get('market_price');
            $product->reference_price = \Input::get('reference_price');
            $product->weight = \Input::get('weight');
            $product->weight_unit = \Input::get('weight_unit');
            $product->dimension = \Input::get('dimension');
            $product->memo = \Input::get('memo');

            //对批量上传图片进行处理
            $file_name = \Input::get('file_path');
            if(!empty($file_name)) {
                $product->image = $this->batchUpload($file_name);
            }

            $imageUrl = Upload::getInstance()->uploadImage(\Input::file('file'));
            if($imageUrl)
            {
                $product->icon = $imageUrl['imageurl'];
            }
            $product->save();
            //存入多个商品类别
            $categoryarr = \Input::get('category');
            foreach($categoryarr as $category){
                $p2category = new Product2Category();
                $p2category->product_id = $product->id;
                $p2category->category_id = $category;
                $p2category->save();
            }
            DB::commit();

        }catch (\Exception $e) {
            DB::rollBack();
            return \Redirect::back()->with('error',  $e->getMessage());
        }

        return \Redirect::back()->with('success', '新增商品成功');
    }

    //修改商品
    public function postUpdateProduct($productId = NULL)
    {
        $route = array(
            'name' => 'required',
        );

        $validator = \Validator::make(\Input::all(), $route);

        if($validator->fails())
        {
            return \Redirect::back()->withInput()->withErrors($validator->errors());
        }

        $product = Product::find($productId);
        $p2c = new Product2Category();

        if(!$product)
        {
            return \Redirect::back()->with('error', '没有找到该商品');
        }
        DB::beginTransaction();
        try {
            $product->product_code = \Input::get('product_code');
            $product->name = \Input::get('name');
            $product->brand_id = \Input::get('brand');
            $product->description = \Input::get('description');
            $product->description_short = \Input::get('description_short');
            $product->quantity = \Input::get('quantity');
            $product->market_price = \Input::get('market_price');
            $product->reference_price = \Input::get('reference_price');
            $product->weight = \Input::get('weight');
            $product->weight_unit = \Input::get('weight_unit');
            $product->dimension = \Input::get('dimension');
            $product->memo = \Input::get('memo');
            $product->update_time = strtotime(date('Y-m-d H:i:s'));

            //对批量上传图片进行处理
            $file_name = \Input::get('edit_file_path');
            if($file_name) {
                $product->image = $this->batchUpload($file_name);
            }

            $imageUrl = Upload::getInstance()->uploadImage(\Input::file('file'));
            if($imageUrl)
            {
                $product->icon = $imageUrl['imageurl'];
            }
            $product->save();
            //删除之前类别
            $p2c->delP2C($productId);
            //存入多个商品类别
            $categoryarr = \Input::get('category');
            foreach($categoryarr as $category){
                $p2category = new Product2Category();
                $p2category->product_id = $product->id;
                $p2category->category_id = $category;
                $p2category->save();
            }

            DB::commit();

        }catch (\Exception $e) {
            DB::rollBack();
            return \Redirect::back()->with('error',  $e->getMessage());
        }

        return \Redirect::back()->with('success', '修改商品成功');
    }
    //删除商品
    public function getDeleteProduct($productId = NULL)
    {
        $product = Product::find($productId);

        $p2category = new Product2Category();

        if(!$product)
        {
            return \Redirect::back()->with('error', '没有找到该商品');
        }
        //判断活动计划中是否引用了该商品，如果有则不允许删除
        $p2plan = new Product2Plan();
        $p2plans = $p2plan->getPlanInfo($productId);
        if(!empty($p2plans)) {
            return \Redirect::back()->with('error', '已经有活动计划添加了该商品，不能删除');
        }else {
            DB::beginTransaction();
            try {
                $product->status = 2;
                $product->update_time = strtotime(date('Y-m-d H:i:s'));
                $product->save();

                $p2category->delP2C($productId);

                DB::commit();
            }catch (\Exception $e) {
                DB::rollBack();
                return \Redirect::back()->with('error',  $e->getMessage());
            }
        }

        return \Redirect::back()->with('success', '删除商品成功');
    }

    public function postProductStatus()
    {
        $productId = \Input::get('productId');
        $status = \Input::get('status');

        $product = Product::find($productId);

        if(!$product)
        {
            return \Response::json(array('code' => -1));
        }

        if($status != 0)
        {
            $p2plan = new Product2Plan();
            $p2plans = $p2plan->getPlanInfo($productId);
            if(!empty($p2plans)) {
                $code = 2;
            }else {
                $product->status = 1;
                $product->update_time = strtotime(date('Y-m-d H:i:s'));
                $code = 1;
            }

        }else{
            $product->status = 0;
            $product->update_time = strtotime(date('Y-m-d H:i:s'));
            $code = 0;
        }

        $product->save();

        return \Response::json(array('code' => $code));
    }

    //批量上传图片处理
    private function batchUpload($file_name)
    {
        $file_name = substr( $file_name, 1 );
        $file_arr = explode(',',$file_name);
        $file_image = '';

        foreach($file_arr as $filepath) {

            $filepath_arr = explode(";",$filepath);

            $file_image .=  $filepath_arr[0].',';
            //同步到又拍云
            $ypyouConfig = \Config::get('uni.upyun');
            $youpaiyun = new YouPaiYun($ypyouConfig);

            if($youpaiyun->upload($filepath_arr[1], $ypyouConfig['bucketname'], $filepath_arr[0]) == false)
            {
                return false;
            }

            if(file_exists($filepath_arr[1]))
            {
                unlink($filepath_arr[1]);
            }

        }
        $image = substr( $file_image, 0 , -1);
        return $image;
    }

}
