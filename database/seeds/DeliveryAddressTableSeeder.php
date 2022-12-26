<?php

use Illuminate\Database\Seeder;
use App\DeliveryAddress;
class DeliveryAddressTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bannerRecords = [
        ['id'=>1,'user_id'=>1,'name'=>'Sumon Mitra','address'=>'Stkhira','city'=>'Satkhira','state'=>'Khulna','country'=>'Khulna','pincode'=>9400,'mobile'=>'01734845200','status'=>1]  
    ];
    DeliveryAddress::insert($bannerRecords);
    }
}
