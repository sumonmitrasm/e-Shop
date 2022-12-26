<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    public static function getBanners()
    {
    	//get banners
    	$getBanners = Banner::where('status',1)->get();
    	$getBanners = json_decode(json_encode($getBanners),true);
    	//echo "<pre>";print_r($getBanners); die;
    	return $getBanners;
    }
}
