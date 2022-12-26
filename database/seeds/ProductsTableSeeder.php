<?php

use Illuminate\Database\Seeder;
use App\Product;
class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productRecords = [
        	['id'=>1,'category_id'=>7,'section_id'=>3,'product_name'=>'Casual T-shirt','product_code'=>'BTOO1','product_color'=>'Blue','product_price'=>'1500','product_discount'=>10,'product_weight'=>200,'product_video'=>'','main_image'=>'','description'=>'Test Product','wash_care'=>'','fabric'=>'','pattern'=>'','sleeve'=>'','fit'=>'','occassion'=>'','meta_title'=>'','meta_description'=>'','meta_keywords'=>'','is_featured'=>'No','status'=>1],
        	['id'=>2,'category_id'=>6,'section_id'=>3,'product_name'=>'Red Formal Tt-shart','product_code'=>'RTOO1','product_color'=>'Blue','product_price'=>'2000','product_discount'=>10,'product_weight'=>200,'product_video'=>'','main_image'=>'','description'=>'Test Product','wash_care'=>'','fabric'=>'','pattern'=>'','sleeve'=>'','fit'=>'','occassion'=>'','meta_title'=>'','meta_description'=>'','meta_keywords'=>'','is_featured'=>'Yes','status'=>1]
        ];

        Product::insert($productRecords);
    }
}
