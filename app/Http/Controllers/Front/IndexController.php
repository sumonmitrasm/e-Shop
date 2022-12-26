<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;

class IndexController extends Controller
{
    public function index()
    {
        //get featured products.......................................................
    	//echo $featuredItemsCount = Product::where('is_featured','Yes')->count();die;
    	$featuredItemsCount = Product::where('is_featured','Yes')->where('status',1)->count();
    	$featuredItems = Product::where('is_featured','Yes')->where('status',1)->get()->toArray();
    	//dd($featuredItems);die;
    	$featuredItemsChunk = array_chunk($featuredItems, 4);
    	//echo "<pre>"; print_r($featuredItemsChunk);die;

        //get latest and new products.......................................................
        $newProducts = Product::orderBy('id','Desc')->where('status',1)->limit(6)->get()->toArray();
        //$newProducts = json_decode(json_encode($newProducts),true);
        //echo "<pre>";print_r($newProducts);
        
    	$page_name = "index";
    	return view('front.index')->with(compact('page_name','featuredItemsChunk','featuredItemsCount','newProducts'));
    }
}
