<?php

use Illuminate\Database\Seeder;
use App\CmsPage;

class CmsPagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cmsPagesRecords = [
            ['id'=>1,'title'=>'About Us','description'=>'Content is comming soon','url'=>'about-us','meta_title'=>'About Us','meta_description'=>'About E-commarce website','meta_keywords'=>'about us','status'=>1],
            ['id'=>2,'title'=>'Privacy Policy','description'=>'Content is comming soon','url'=>'privacy- policy','meta_title'=>'Privacy Policy','meta_description'=>'About E-commarce website','meta_keywords'=>'Privacy Policy','status'=>1],
        ];
        CmsPage::insert($cmsPagesRecords);
    }
}
