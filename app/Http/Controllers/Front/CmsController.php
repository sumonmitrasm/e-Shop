<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\CmsPage;
use Illuminate\Support\Facades\Mail;
use Session;
use Validator;

class CmsController extends Controller
{
    public function cmsPage()
    {
        //echo $currentUrl = url()->current();die; //-------------------177
        $currentRoute = url()->current();
        $currentRoute = str_replace("http://127.0.0.1:8000/","",$currentRoute);
        //dd($currentRoute);
        $cmsRoutes = CmsPage::where('status',1)->get()->pluck('url')->toArray();
        //dd($cmsRoutes);
        //for matching current route and smsroute.........................
        if (in_array($currentRoute,$cmsRoutes)) {
            $cmsPageDetails = CmsPage::where('url',$currentRoute)->first()->toArray();
            return view('front.pages.cms_page')->with(compact('cmsPageDetails'));
        }else{
            abort(404);
        }
    }

    public function contact(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            //echo "<pre>";print_r($data);
            $rules = [
                'name' => "required",
                'email' => "required|email",
                'subject' => "required",
                'message' => "required"
            ];
            $customMessages = [
                'name.required' => 'Name is required',
                'email.required' => 'Email is required',
                'subject.required' => 'Subject is required',
                'message.required' => 'Message is required',
            ];
            $validator = Validator::make($data,$rules,$customMessages);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $email = "sumonmitra1000686@gmail.com";
            $messageData = [
                'name' => $data['name'],
                'email' => $data['email'],
                'subject' => $data['subject'],
                'comment' => $data['message']
            ];
            //echo "test";die;
            Mail::send('emails.enquiry',$messageData,function($message)use($email){
                $message->to($email)->subject('Enquiry for e-shop website');
            });
            //echo "test";die;
            $message = "Thanks for your query. We are contuct soon....";
            Session::flash('success_message',$message);
            return redirect()->back();
        }
        return view('front.pages.contact');
    }
}
