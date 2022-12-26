<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Order;
use App\Cart;
use Auth;
use Session;

class PaypalController extends Controller
{
    public function paypal()
    {
        if (Session::has('order_id')) {
            //Empty the user cart........................................130
            //Cart::where('user_id',Auth::user()->id)->delete();
            $orderDetails = Order::where('id',Session::get('order_id'))->first()->toArray();

            $namearr = explode(' ',$orderDetails['name']);
            //echo "<pre>"; print_r($namearr);
            return view('front.paypal.paypal')->with(compact('orderDetails','namearr'));
        }else{
            return redirect('/cart');
        }
    }
}
