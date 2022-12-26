<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use App\Product;

class ProductsController extends Controller
{
    public function listing($url,Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            echo "<pre>";print_r($data);
        }else{
                $categoryCount = Category::where(['url'=>$url,'status'=>1])->count();
            if ($categoryCount>0) {
                //echo "Category exit";die;
                $categoryDetails = Category::catDetails($url);
                //echo "<pre>";print_r($categoryDetails);die;
                $categoryProducts = Product::with('brand')->whereIn('category_id',$categoryDetails['catIDs'])->where('status',1);
                // If Sort option selected by User
                if (isset($_GET['sort']) && !empty($_GET['sort'])) {
                    if ($_GET['sort']=="product_latest") {
                        $categoryProducts->orderBy('id','Desc');
                    }else if
                        ($_GET['sort']=="product_name_a_z") {
                        $categoryProducts->orderBy('id','Asc');
                    }else if
                        ($_GET['sort']=="product_name_z_a") {
                        $categoryProducts->orderBy('id','Desc');
                    }else if
                        ($_GET['sort']=="price_lowest") {
                        $categoryProducts->orderBy('id','Desc');
                    }else if
                        ($_GET['sort']=="price_highest") {
                        $categoryProducts->orderBy('id','Asc');
                    }
                }else{
                    $categoryProducts->orderBy('id','Desc');
                }
                $categoryProducts = $categoryProducts->paginate(2);
                //echo "<pre>";print_r($categoryProducts);die;
                return view('front.products.listing')->with(compact('categoryDetails','categoryProducts','url'));
            }else{
                abort(404);
            }
        }
    	
    }
}
