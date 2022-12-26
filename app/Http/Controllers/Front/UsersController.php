<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Session;
use Auth;
use App\Cart;
use App\Sms;
use App\Country;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function loginRegister()
    {
    	return view('front.users.login_register');
    }
    public function registerUser(Request $request) //98
    {
    	if ($request->isMethod('post')) {
            Session::forget('error_message');
            Session::forget('success_message');
    		$data = $request->all();
    		//echo "<pre>";print_r($data);die;
            $userCount = User::where('email',$data['email'])->count();
            if ($userCount>0) {
                $message = "Email allready exists!!";
                Session::flash('error_message',$message);
                return redirect()->back();
            }else{
                $user = new User;
                $user->name = $data['name'];
                $user->mobile = $data['mobile'];
                $user->email = $data['email'];
                $user->password = bcrypt($data['password']); //98
                $user->status = 0;
                $user->save();

                //send confirmation Email
                $email = $data['email'];
                $messageData = [
                    'email' => $data['email'],
                    'name' => $data['name'],
                    'code' => base64_encode($data['email'])
                ];
                Mail::send('emails.confirmation',$messageData,function($message) use($email){
                    $message->to($email)->subject('Please Confirm your account');
                });

                //Redirect back with successfull message
                $message = "Please confirm your email to activete your account!!";
                Session::put('success_message',$message);
                return redirect()->back();
               /*
                if(Auth::attempt(['email'=>$data['email'],'password'=>$data['password']])){
                    //echo "<pre>";print_r(Auth::user());die;
                     //update user cart with user id.........................................101
                    if (!empty(Session::get('session_id'))) {
                        $user_id = Auth::user()->id;
                        $session_id = Session::get('session_id');
                        Cart::where('session_id',$session_id)->update(['user_id'=>$user_id]);
                    }
                    
                    //send register sms 102
                    $message = "Dear Customer, You are successfully login the site";
                    $mobile = $data['mobile'];
                    Sms::sendSms($message,$mobile);
                    
                    //send mail on website......................................103
                    $email = $data['email'];
                    $messageData = ['name'=>$data['name'],'mobile'=>$data['mobile'],'email'=>$data['email']];
                    Mail::send('emails.register',$messageData,function($message) use($email){$message->to($email)->subject('Welcome to sumons website');

                    });
                    return redirect('/');
                
                }else{
                    Session::flash('error_message','Invalid email or password');
                    return redirect()->back();
                }
                */
            }
    	}
    }
    public function confirmAccount($email)
    {
        Session::forget('error_message');
        Session::forget('success_message');
        //echo $email = base64_decode($email);
        $email = base64_decode($email);
        //check user email exists
        $userCount = User::where('email',$email)->count();
        if ($userCount>0) {
            // User email is already activeed or not
            $userDetails = User::where('email',$email)->first();
            if ($userDetails->status == 1) {
                $message = "Your Email account is already activeed";
                Session::put('error_message',$message);
                return redirect('login_register');
            }else{
                //update status 
                User::where('email',$email)->update(['status'=>1]);
                //send mail on website......................................103
                $messageData = ['name'=>$userDetails['name'],'mobile'=>$userDetails['mobile'],'email'=>$email];
                Mail::send('emails.register',$messageData,function($message) use($email){$message->to($email)->subject('Welcome to sumons website');

                });
                $message = "Your Email account is activeed";
                Session::put('success_message',$message);
                return redirect('login_register');
            }
        }else{
            abort(404);
        }
    }
    public function logoutUser()
    {
        Auth::logout();
        Session::flush();
        return redirect('/');
    }
    public function checkMail(Request $request)
    {
        $data = $request->all();
        $emailCount = User::where('email',$data['email'])->count();
        if ($emailCount>0) {
            return "false";
        }else{
            return "true";
        }   
    }
    public function loginUser(Request $request)
    {
        if ($request->isMethod('post')) {
            Session::forget('error_message');
            Session::forget('success_message');
            $data = $request->all();
            //echo "<pre>";print_r($data);die;
            if(Auth::attempt(['email'=>$data['email'],'password'=>$data['password']])){
                    //echo "<pre>";print_r(Auth::user());die;
                //check email is activate or not........................................105
                $userStatus = User::where('email',$data['email'])->first();
                if($userStatus->status == 0){
                    Auth::logout();
                    $message = "Your account is not activated !! Please confirm your email to activate!";
                    Session::put('error_message',$message);
                    return redirect()->back();
                }
                //update user cart with user id.........................................101
                if (!empty(Session::get('session_id'))) {
                    $user_id = Auth::user()->id;
                    $session_id = Session::get('session_id');
                    Cart::where('session_id',$session_id)->update(['user_id'=>$user_id]);
                }
                return redirect('/');
            }else{
                $message = "Invalid email or password";
                Session::flash('error_message',$message);
                return redirect()->back();
            }
        }
    }
    public function forgotPassword(Request $request) //107 random password
    {
        if ($request->isMethod('post')) {
            Session::forget('error_message');
            Session::forget('success_message');
            $data = $request->all();
            //echo "<pre>";print_r($data);die;
            $emailCount = User::where('email',$data['email'])->count();
            if ($emailCount==0) {
                $message = "Email does not exist";
                Session::forget('error_message',"Email does not exist");
                Session::forget('success_message');
                return redirect()->back();
            }
            //echo "string"; die;
            //have to install random pacage
            $random_password = str_random(8);
            $new_password = bcrypt($random_password );
            User::where('email',$data['email'])->update(['password'=>$new_password]);
            $userName = User::select('name')->where('email',$data['email'])->first();
            $email = $data['email'];
            $name = $userName->name;
            $messageData = [
                'name'=>$name,
                'email'=>$email,
                'password'=>$random_password

            ];
             Mail::send('emails.forgot_password',$messageData,function($message) use($email){$message->to($email)->subject('Change your password');

                    });
             $message = "Please chack your email for new password ";
             Session::put('success_message',$message);
             Session::forget('error_message');
             return redirect('login_register');

        }
        return view('front.users.forgot_password');
    }
    public function account(Request $request)
    {
        $user_id = Auth::user()->id;
        $userDetails = User::find($user_id )->toArray();
        //$userDetails = json_decode(json_encode($userDetails));
        //echo "<pre>";print_r($userDetails );die;
        $countries = Country::where('status',1)->get()->toArray();
        //echo "<pre>";print_r( $countries);die;
        if ($request->isMethod('post')) {
            $data = $request->all();
            Session::forget('error_message');
            Session::forget('success_message');
            //echo "<pre>";print_r($data);die;
            $rules = [
            'name' => 'required|regex:/^[\pL\s\-]+$/u',
            'mobile' => 'required|numeric',
            ];

            $customMessages = [
            'name.required' => 'Name is required',
            'name.regex'=>'valid Name is required',
            'mobile.required'=>'Mobile number is required',
            'mobile.numeric'=>'valid mobile number is required',
            ];
            $this->validate($request,$rules,$customMessages); //109

            $user = User::find($user_id);
            $user->name = $data['name'];
            $user->address = $data['address'];
            $user->city = $data['city'];
            $user->state = $data['state'];
            $user->country = $data['country'];
            $user->pincode = $data['pincode'];
            $user->mobile = $data['mobile'];
            $user->save();
            $message = "Your account dtalis has been updated successfully";
            Session::put('success_message',$message);
            return redirect()->back();
        }
       return view('front.users.account')->with(compact('userDetails','countries'));
    }
    //checkpassword......................................................110
    public function chkUserPassword(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            //echo "<pre>";print_r($data);die;
            $user_id = Auth::user()->id;
            $chkPassword = User::select('password')->where('id',$user_id)->first();
            if (Hash::check($data['current_pwd'],$chkPassword->password)) {
                return "true";
            }else{
                return "false";
            }
        }
    }
    //Updatepassword......................................................110
     public function UpdateUserPassword(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            //echo "<pre>";print_r($data);die;
            $user_id = Auth::user()->id;
            $chkPassword = User::select('password')->where('id',$user_id)->first();
            if (Hash::check($data['current_pwd'],$chkPassword->password)) {
                //update new password.......................................
                $new_pwd = bcrypt($data['new_pwd']);
                User::where('id',$user_id)->update(['password'=>$new_pwd]);
                $message = "Password updated successfully";
                Session::put('success_message',$message);
                Session::forget('error_message');
                return redirect()->back();
            }else{
                $message = "Current passwrd is incurrect";
                Session::forget('success_message');
                Session::put('error_message',$message);
                return redirect()->back();
            }
        }
    }
}
