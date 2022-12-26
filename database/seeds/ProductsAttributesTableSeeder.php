<?php

use Illuminate\Database\Seeder;
use App\ProductsAttribute;

class ProductsAttributesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ProductAttributesRecords = [
        	['id'=>1,'product_id'=>1,'size'=>'Small','price'=>1500,'stock'=>10,'sku'=>'BTOO1s-S','status'=>1],
        	['id'=>2,'product_id'=>1,'size'=>'Medium','price'=>1600,'stock'=>20,'sku'=>'BTOO1s-M','status'=>1],
        	['id'=>3,'product_id'=>1,'size'=>'Large','price'=>1700,'stock'=>10,'sku'=>'BTOO1s-L','status'=>1]
        ];
        ProductsAttribute::insert($ProductAttributesRecords);
    }
}
