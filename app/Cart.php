<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Session;
Use Auth;
use App\Product;
use App\ProductsAttribute;

class Cart extends Model
{
    public static function userCartItems()
    {
    	if (Auth::check()) {
    		$userCartItems = Cart::with(['product'=>function($query){
    			$query->select('id','product_name','category_id','product_code','main_image','product_color','product_weight');
    		}])->where('user_id',Auth::user()->id)->orderBy('id','Desc')->get()->toArray();
    	}else{
    		$userCartItems = Cart::with(['product'=>function($query){
    			$query->select('id','product_name','category_id','product_code','main_image','product_color','product_weight');
    		}])->where('session_id',Session::get('session_id'))->orderBy('id','Desc')->get()->toArray();
    	}
    	return $userCartItems;
    }
    public function product()//video 86......query and qsubury
    {
    	return $this->belongsTo('App\Product','product_id');
    }
    public static function getProductAttrPrice($product_id,$size)
    {
    	$attrprice = ProductsAttribute::select('price')->where(['product_id'=>$product_id,'size'=>$size])->first()->toArray();
    	return $attrprice['price'];
    }
}
