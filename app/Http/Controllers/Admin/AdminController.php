<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Session;
use App\Admin;
use Hash;
use Image;
use Validator;
use App\AdminsRole;

class AdminController extends Controller
{
    public function dashboard()
    {
        //for active pagess
        Session::put('page','dashboard');
    	return view('admin.admin_dashboard');
    }

    public function settings()
    {
        Session::put('page','settings');
       $adminDetails = Admin::where('email', Auth::guard('admin')->user()->email)->first();
        return view('admin.admin_settings')->with(compact('adminDetails'));
    }
    public function chkCurrentPassword(Request $request)
    {
        $data=$request->all();
       // echo "<pre>"; print_r($data);
        //echo "<pre>"; print_r(Auth::guard('admin')->user()->password); die;
        if(Hash::check($data['current_pwd'],Auth::guard('admin')->user()->password)){
            echo "true";
        }else{
            echo "false";
        }
    }
     public function updateCurrentPassword(Request $request)
    {
        if ($request->isMethod('post')) {
            $data=$request->all();
           // echo "<pre>"; print_r($data); die;
            //check if current password is correct
            if(Hash::check($data['current_pwd'],Auth::guard('admin')->user()->password)){
            //check if new confirm password is matching
                if ($data['new_pwd']==$data['confirm_pwd']) {
                    Admin::where('id', Auth::guard('admin')->user()->id)->update(['password'=>bcrypt($data['new_pwd'])]);
                    Session::flash('success_message','Password has been uplodeed successfully');
                }else{
                    Session::flash('error_message','New password and Confirm password does not match');
                }
        }else{
            Session::flash('error_message','Your current password is Incurrect');
            return redirect()->back();
        }
        return redirect()->back();
        }
    }
    public function login(Request $request)
    {
    	if ($request->isMethod('POST')) {
    		$data = $request->all();

             $rules = [
            'email' => 'required|email|max:255|',
            'password' => 'required',
            ];

            $customMessages = [
            'email.required' => 'Email is required',
            'email.email'=>'valid email is required',
            'password.required' => 'pass word required',
            ];
            $this->validate($request,$rules,$customMessages);
            
            if(Auth::guard('admin')->attempt(['email'=>$data['email'],'password'=>$data['password'],'status'=>1])){
    			return redirect('admin/dashboard');
    		}else{
                Session::flash('error_message','Invalid email or password');
    			return redirect()->back();
    		}

    	}
    	return view('admin.admin_login');
    }
    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/admin');
    }
    public function updateAdminDetails(Request $request)
    {
        Session::put('page','update-admin-details');
        if ($request->isMethod('post')) {
            $data=$request->all();
            //echo "<pre>"; print_r($data); die;

            $rules = [
            'admin_name' => 'required|regex:/^[\pL\s\-]+$/u',
            'admin_mobile' => 'required|numeric',
            'admin_image' => 'image',
            ];

            $customMessages = [
            'admin_name.required' => 'Name is required',
            'admin_name.regex'=>'valid Name is required',
            'admin_mobile.required'=>'Mobile number is required',
            'admin_mobile.numeric'=>'valid mobile number is required',
            'admin_image.image'=>'Valid image is required',
            ];
            $this->validate($request,$rules,$customMessages);
            //die;
            //Uplode images
            if ($request->hasFile('admin_image')) {
                $image_tmp = $request->file('admin_image');
                if ($image_tmp->isValid()) {
                    # get Image Extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    //Generate New Image
                    $imageName = rand(111, 99999).'.'.$extension;
                    $imagePath = 'images/admin_images/admin_photos/'.$imageName;
                    //Uplode the Image
                    Image::make($image_tmp)->save($imagePath);
                }else if(!empty($data['current_admin_image'])){
                    $imageName = $data['current_admin_image'];
                }else{

                    $imageName = "";
                }
            }
            Admin::where('email', Auth::guard('admin')->user()->email)->update(['name'=>$data['admin_name'],'mobile'=>$data['admin_mobile'],'image'=>$imageName]);
            Session::flash('success_message','Admin details updated successfully!');
            return redirect()->back();
        }
        return view('admin.update-admin-details');
    }

    public function adminsSubadmins()
    {
        if (Auth::guard('admin')->user()->type=="subadmin") {
            Session::flash('error_message','This feature is restricted');
            return redirect('admin/dashboard');
        }
        Session::put('page','admins-subadmins');
        $admins_Subadmins = Admin::get()->toArray();
        //dd($admins_Subadmins);die;
        return view('admin.admins_Subadmins.admins_Subadmins')->with(compact('admins_Subadmins'));
    }

    public function updateAdminStatus(Request $request)
    {
        if ($request->ajax()) {
            $data =  $request->all();
            //echo "<pre>"; print_r($data); die;
            if ($data['status']=="Active") {
                $status = 0;
            }else{
                $status = 1;
            }
            Admin::where('id',$data['admin_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status, 'admin_id'=>$data['admin_id']]);
        }
    }

    public function deleteAdmin($id)
    {
        Admin::where('id',$id)->delete();
        $message = 'Deleted successfully!';
        Session::flash('success_message',$message);
        return redirect()->back();
    }

    public function addEditAdminSubadmin(Request $request, $id=null)
    {
        //echo "test"; die;
        if ($id=="") {
            $title = "Add Admin/Sub-admin";
            $admindata = new Admin;
            $message = "Admin/Subadmin addedd successfully"; 
        }else{
            $title = "Edit Admin/Sub-admin";
            $admindata = Admin::find($id);
            $message = "Admin/Subadmin addedd successfully"; 
        }
           if ($request->isMethod('post')) {
            $data = $request->all();
           //echo "<pre>"; print_r($data);die;
            if ($id=="") {
                $adminCount = Admin::where('email',$data['email'])->count();
                if ($adminCount>0) {
                    Session::flash('error_message','Admin/subadmin allready exist');
                    return redirect('admin/admins-subadmins');
                }
            }
            $rules = [
            'name' => 'required|regex:/^[\pL\s\-]+$/u',
            //'admin_mobile' => 'required|numeric',
            'admin_image' => 'image',
            ];

            $customMessages = [
            'name.required' => 'Name is required',
            'name.regex'=>'valid Name is required',
            //'admin_mobile.required'=>'Mobile number is required',
            //'admin_mobile.numeric'=>'valid mobile number is required',
            'admin_image.image'=>'Valid image is required',
            ];
            $this->validate($request,$rules,$customMessages);
            if ($request->hasFile('admin_image')) {
                $image_tmp = $request->file('admin_image');
                if ($image_tmp->isValid()) {
                    # get Image Extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    //Generate New Image
                    $imageName = rand(111, 99999).'.'.$extension;
                    $imagePath = 'images/admin_images/admin_photos/'.$imageName;
                    //Uplode the Image
                    Image::make($image_tmp)->save($imagePath);
                }else if(!empty($data['current_admin_image'])){
                    $imageName = $data['current_admin_image'];
                }else{

                    $imageName = "";
                }
                //echo $imageName;die;
                //$imageName = json_encode(json_decode($imageName),true);
                $admindata->image = $imageName;
            }
            $admindata->name = $data['name'];
            //$admindata->type = $data['admin_type'];
            $admindata->mobile = $data['mobile'];
            //$admindata->password = bcrypt($data['password']);
            if ($data['password']!="") {
                $admindata->password = bcrypt($data['password']);
            }
            if ($id=="") {
                $admindata->email = $data['email'];
                $admindata->type = $data['admin_type'];
            }
            //$admindata->image = $imageName;
            $admindata->save();
            session::flash('success_message',$message);
            return redirect('admin/admins-subadmins');
    }
         
        
        return view('admin.admins_Subadmins.add_edit_admin_subadmin')->with(compact('title','admindata',));
    }

    public function updateRole(Request $request,$id)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            unset($data['_token']);
            //echo "<pre>"; print_r($data); die; //..................................................1:00:42min
            AdminsRole::where('admin_id',$id)->delete();
            //echo "<pre>"; print_r($data); die;
            foreach ($data as $key => $value) {
                //echo "<pre>";print_r($data);die;
                if (isset($value['view'])) {
                    $view = $value['view'];
                }else{
                    $view = 0;
                }
                if (isset($value['edit'])) {
                    $edit = $value['edit'];
                }else{
                    $edit = 0;
                }
                if (isset($value['full'])) {
                    $full = $value['full'];
                }else{
                    $full = 0;
                }
                AdminsRole::where('admin_id',$id)->insert(['admin_id'=>$id,'module'=>$key,'view_access'=>$view,'edit_access'=>$edit,'full_access'=>$full]);
            }
            $message = "Roles updated successfully";
            Session::flash('success_message',$message);
            return redirect()->back();
        }
        //echo $id;
       $adminDetails = Admin::where('id',$id)->first()->toArray();
       //dd($adminDetails);
       $adminRoles = AdminsRole::where('admin_id',$id)->get()->toArray();
       $titles = "Update (".$adminDetails['name']."),".$adminDetails['type']." Roles/Permissions";
       return view('admin.admins_Subadmins.update_roles')->with(compact('titles','adminDetails','adminRoles'));
    }

}
