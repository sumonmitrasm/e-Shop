<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class DeliveryAddress extends Model
{
    public static function DeliveryAddresses()
    {
    	$user_id = Auth::user()->id;
    	$DeliveryAddresses = DeliveryAddress::where('user_id',$user_id)->get()->toArray();
    	return $DeliveryAddresses;
    }
}
