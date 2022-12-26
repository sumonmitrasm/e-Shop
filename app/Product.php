<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function category()
    {
    	return $this->belongsTo('App\Category','category_id');
    }
    public function section()
    {
    	return $this->belongsTo('App\Section','section_id');
    }
    public function brand()
    {
        return $this->belongsTo('App\Brand','brand_id');
    }
    public function attributes()
    {
    	return $this->hasMany('App\ProductsAttribute');
    }
    public function images()
    {
        return $this->hasMany('App\ProductsImage');
    }
    public static function productFilters()
    {
        //product filters
        $productFilters['fabricArray'] = array('Cotton','Polyester','Wool');
        $productFilters['sleeveArray'] = array('Full Sleeve','Half Sleeve','Short Sleeve','Sleeveless');
        $productFilters['patternArray'] = array('Checked','Plain','Printed','Self','Solid');
        $productFilters['fitArray'] = array('Regular','Slim');
        $productFilters['occassionArray'] = array('Casual','Formal');
        return $productFilters;
    }
    public static function getDiscountedPrice($product_id) //88video
    {
        $proDetails = Product::select('product_price','product_discount','category_id')->where('id',$product_id)->first()->toArray();
        //echo "<pre>";print_r($proDetails);die;
        $catDetails = Category::select('category_discount')->where('id',$proDetails['category_id'])->first()->toArray();
        //echo "<pre>";print_r($catDetails);die;
        if ($proDetails['product_discount']>0) {
            //if product discount id added from admin panel.........
            $discounted_price = $proDetails['product_price'] - ($proDetails['product_price']*$proDetails['product_discount']/100);
            //sele Price = Cost Price - Discount price
            //450        = 500        -(500*10/100 = 50)
        }elseif ($catDetails['category_discount']>0) {
            //if product discount is not added and category discount added from admin panel
            $discounted_price =  $proDetails['product_price'] - ($proDetails['product_price']*$catDetails['category_discount']/100);
        }else{
            $discounted_price = 0;
        }
        return $discounted_price;
    }
    public static function getDiscountedAttrPrice($product_id,$size)
    {
        $proAttrPrice = ProductsAttribute::where(['product_id'=>$product_id,'size'=>$size])->first()->toArray();
        $proDetails = Product::select('product_discount','category_id')->where('id',$product_id)->first()->toArray();
        //echo "<pre>";print_r($proDetails);die;
        $catDetails = Category::select('category_discount')->where('id',$proDetails['category_id'])->first()->toArray();
        //echo "<pre>";print_r($catDetails);die;
        if ($proDetails['product_discount']>0) {
            //if product discount id added from admin panel.........
            $final_price = $proAttrPrice['price'] - ($proAttrPrice['price']*$proDetails['product_discount']/100);
            $discount = $proAttrPrice['price'] - $final_price;
            //sele Price = Cost Price - Discount price
            //450        = 500        -(500*10/100 = 50)
        }elseif ($catDetails['category_discount']>0) {
            //if product discount is not added and category discount added from admin panel
            $final_price =  $proAttrPrice['price'] - ($proAttrPrice['price']*$catDetails['category_discount']/100);
        	$discount = $proAttrPrice['price'] - $final_price;
        }else{
            $final_price = $proAttrPrice['price'];
            $discount = 0;
        }
        return array('product_price'=>$proAttrPrice['price'],'final_price'=> $final_price,'discount'=>$discount);//video89
    }

    //paramitter solve..............$how to echo this lavel...........................................................134
    public static function getProductImage($product_id)
    {
        $getProductImage = Product::select('main_image')->where('id',$product_id)->first()->toArray();
        //echo $getProductImage['main_image'];
        return $getProductImage['main_image'];
    }
    //--------------------------------------------------------------------168
    public static function getProductStatus($product_id)
    {
        $getProductStatus = Product::select('status')->where('id',$product_id)->first()->toArray();
        return $getProductStatus['status'];
    }
    public static function deleteCartProduct($product_id)
    {
        Cart::where('product_id',$product_id)->delete();
    }
    public static function getProductStock($product_id,$product_size)
    {
        $getProductStock = ProductsAttribute::select('stock')->where(['product_id'=>$product_id,'size'=>$product_size])->first()->toArray();
        return $getProductStock['stock'];
    }
    //inactive product can't to cart........................................169
    public static function getAttrebuteCount($product_id,$product_size)
    {
        //echo $getAttrebuteCount = ProductsAttribute::where(['product_id'=>$product_id,'size'=>$product_size,'status'=>1])->count();die;
        $getAttrebuteCount = ProductsAttribute::where(['product_id'=>$product_id,'size'=>$product_size,'status'=>1])->count();
        return $getAttrebuteCount;
    }
}
