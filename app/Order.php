<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function orders_products()
    {
    	return $this->hasMany('App\OrdersProduct','order_id');
    }
}
