<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Coupon;
use Session;
use App\Section;
use App\User;
use App\AdminsRole;
use Auth;

class CouponsController extends Controller
{
    public function coupons()
    {
    	Session::put('page','coupons');
    	$coupons = Coupon::get()->toArray();
    	//$coupons = json_decode(json_encode($coupons),true);
    	//echo "<pre>"; print_r($coupons);
        //set role and permission .................................................170...27
        $couponsModuleCount = AdminsRole::where(['admin_id'=>Auth::guard('admin')->user()->id,'module'=>'coupons'])->count();
        //dd($couponsModuleCount);
        if (Auth::guard('admin')->user()->type=="superadmin") {
            $couponsModule['view_access'] = 1;
            $couponsModule['edit_access'] = 1;
            $couponsModule['full_access'] = 1;
        }else if ($couponsModuleCount==0) {
            $message = "This feature is not active for you";
            Session::flash('error_message',$message);
            return redirect('admin/dashboard');
        }else{
            $couponsModule = AdminsRole::where(['admin_id'=>Auth::guard('admin')->user()->id,'module'=>'coupons'])->first()->toArray();
             //dd($couponsModule);die;
        }
    	return view('admin.coupons.coupons')->with(compact('coupons','couponsModule'));
    }

     public function updateCouponsStatus(Request $request)
    {
    	if ($request->ajax()) {
    		$data =  $request->all();
    		//echo "<pre>"; print_r($data); die;
    		if ($data['status']=="Active") {
    			$status = 0;
    		}else{
    			$status = 1;
    		}
    		Coupon::where('id',$data['coupon_id'])->update(['status'=>$status]);
    		return response()->json(['status'=>$status, 'coupon_id' =>$data['coupon_id']]);
    	}
    }

    public function addEditCoupon(Request $request,$id=null)
    {
    	if ($id=="") {
    		$coupon = new Coupon;
    		$title = "Add Coupon";
            $selCats = array();
            $selUsers = array();
            $message = "Coupon added successully";
    	}else{
    		$coupon = Coupon::find($id);
    		$title = "Edit Coupon";
            $selCats = explode(',', $coupon['categories']);
            $selUsers = explode(',', $coupon['users']);
            $message = "Coupon Uploded successully";
    	}
    	if ($request->isMethod('post')) {
    			$data = $request->all();
    			//echo "<pre>"; print_r($data);die;

            $rules = [
            'categories' => 'required',
            'coupon_option' => 'required',
            'coupon_type' => 'required',
            'amount_type' => 'required',
            'amount' => 'required|numeric',
            'expiry_date' => 'required',
            ];
            $customMessages = [
            'categories.required'=>'Select Categories',
            'coupon_option.required' => 'Select Cupon Option',
            'coupon_type.required'=>'Select Cupon Type',
            'amount_type.required' => 'Select Amount type',
            'amount.numeric'=>'Enter valid amount',
            'expiry_date.required'=>'Enter expire date',
            ];
            $this->validate($request,$rules,$customMessages);
            if (isset($data['users'])) {
                 $users = implode(',', $data['users']);
            }else{
                $users = "";
            }
            //echo "<pre>";print_r($users);die;
            if (isset($data['categories'])) {
                 $categories = implode(',', $data['categories']);
            }
            //echo "<pre>";print_r($categories);die;
            if ($data['coupon_option']=="Automatic") {
                $coupon_code = str_random(8);
            }else{
                $coupon_code = $data['coupon_code'];
            }
            //echo "<pre>";print_r($coupon_code);die;
            $coupon->coupon_option = $data['coupon_option'];
            $coupon->coupon_code = $coupon_code;
            $coupon->categories = $categories;
            $coupon->users = $users;
            $coupon->coupon_type = $data['coupon_type'];
            $coupon->coupon_option = $data['coupon_option'];
            $coupon->amount_type = $data['amount_type'];
            $coupon->amount = $data['amount'];
            $coupon->expiry_date = $data['expiry_date'];
            $coupon->status = 1;
            $coupon->save();
            session::flash('success_message',$message);
            return redirect('admin/coupons');
    	}
    	//Section with categories and subcategories....................115
        $categories = Section::with('categories')->get();
        $categories = json_decode(json_encode($categories),true);
        //select users.................................................116
        $users = User::select('email')->where('status',1)->get()->toArray();
        //echo "<pre>";print_r($users);die;
    	return view('admin.coupons.add_edit_coupon')->with(compact('title','coupon','categories','users','selCats','selUsers'));
    }

    public function deleteCoupon($id)
    {
        Coupon::where('id',$id)->delete();
        $message = 'Coupon has been deleted successfully!';
        Session::flash('success_message',$message);
        return redirect()->back();
    }
}
