<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Session;

class UsersController extends Controller
{
    public function users()
    {
        Session::put('page','users');
        $users = User::get()->toArray();
        //dd($users);die;
        return view('admin.users.users')->with(compact('users'));
    }
    public function updateUserStatus(Request $request)
    {
        if ($request->ajax()) {
            $data =  $request->all();
            //echo "<pre>"; print_r($data); die;
            if ($data['status']=="Active") {
                $status = 0;
            }else{
                $status = 1;
            }
            User::where('id',$data['users_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status, 'users_id' =>$data['users_id']]);
        }
    }
}
