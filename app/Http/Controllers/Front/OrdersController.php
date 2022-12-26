<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Order;
use Auth;

class OrdersController extends Controller
{
    public function orders(Request $request)
    {
    	$orders = Order::with('orders_products')->where('user_id',Auth::user()->id)->orderBy('id','Desc')->get()->toArray();
    	//echo "<pre>";print_r($orders); die;//132
    	return view('front.orders.orders')->with(compact('orders'));
    }
//between to ..........................................uporer query user koto gulo product by korse tsr list and nichar query user j product kinase  tar details quser.......must be follow.....
    public function orderDetails($id)
    {
    	$orderDetails = Order::with('orders_products')->where('id',$id)->first()->toArray();
    	//echo "<pre>";print_r($orderDetails); die;//133
    	return view('front.orders.order_details')->with(compact('orderDetails'));
    }

}
