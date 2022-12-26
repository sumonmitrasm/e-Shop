<?php

use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->delete();
        $adminRecords=[
        	['id'=>1,'name'=>'admin','type'=>'admin','mobile'=>'01734845200','email'=>'admin@gmail.com','password'=>'$2y$10$CNZNBJm/ydlVceb9sy125uTJPH1HrzlYZB.GO9UC0yv8cfgtX/nVe','image'=>'','status'=>1
        	],
        	['id'=>2,'name'=>'sumon','type'=>'user','mobile'=>'01734845200','email'=>'sumon@gmail.com','password'=>'$2y$10$CNZNBJm/ydlVceb9sy125uTJPH1HrzlYZB.GO9UC0yv8cfgtX/nVe','image'=>'','status'=>0
        	],
        	['id'=>3,'name'=>'mitra','type'=>'user','mobile'=>'01734845200','email'=>'mitra@gmail.com','password'=>'$2y$10$CNZNBJm/ydlVceb9sy125uTJPH1HrzlYZB.GO9UC0yv8cfgtX/nVe','image'=>'','status'=>0
        	],
        	['id'=>4,'name'=>'mon','type'=>'user','mobile'=>'01734845200','email'=>'mon@gmail.com','password'=>'$2y$10$CNZNBJm/ydlVceb9sy125uTJPH1HrzlYZB.GO9UC0yv8cfgtX/nVe','image'=>'','status'=>0
        	],
        ];
        DB::table('admins')->insert($adminRecords);
    }
}
