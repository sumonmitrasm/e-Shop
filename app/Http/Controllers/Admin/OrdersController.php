<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
Use App\Order;
Use App\User;
use Session;
Use App\OrderStatus;
use App\Sms;
use Illuminate\Support\Facades\Mail;
use App\OrdersLog;
use App\AdminsRole;
use Auth;

class OrdersController extends Controller
{
    public function orders()
    {
    	Session::put('page','orders');
    	$orders = Order::with('orders_products')->orderBy('id','Desc')->get()->toArray();
    	//dd($orders);
        //set role and permission .................................................170...27
        $ordersModuleCount = AdminsRole::where(['admin_id'=>Auth::guard('admin')->user()->id,'module'=>'orders'])->count();
        //dd($ordersModuleCount);
        if (Auth::guard('admin')->user()->type=="superadmin") {
            $ordersModule['view_access'] = 1;
            $ordersModule['edit_access'] = 1;
            $ordersModule['full_access'] = 1;
        }else if ($ordersModuleCount==0) {
            $message = "This feature is not active for you";
            Session::flash('error_message',$message);
            return redirect('admin/dashboard');
        }else{
            $ordersModule = AdminsRole::where(['admin_id'=>Auth::guard('admin')->user()->id,'module'=>'orders'])->first()->toArray();
             //dd($ordersModule);die;
        }
    	return view('admin.orders.orders')->with(compact('orders','ordersModule'));
    }
    public function orderDetails($id)
    {
    	$orderDetails = Order::with('orders_products')->where('id',$id)->first()->toArray();
    	//echo "<pre>";print_r($orderDetails); die;
    	$userDetails = User::where('id',$orderDetails['user_id'])->first()->toArray();
        $orderStatuses = OrderStatus::where('status',1)->get()->toArray();
        //echo "<pre>";print_r($orderStatuses); die; //139
        $orderLog = OrdersLog::where('order_id',$id)->orderBy('id','Desc')->get()->toArray();
        //echo "<pre>";print_r($orderLog); die; //139
    	return view('admin.orders.order_details')->with(compact('orderDetails','userDetails','orderStatuses','orderLog'));
    }

    public function updateOrderStatus(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
           //echo "<pre>"; print_r($data);die;
            Order::where('id',$data['order_id'])->update(['order_status'=>$data['order_status']]);
            Session::put('success_message','Order status has been updated successfully');
            //send email and sms to the customr for status sending................................142
            $deliveryDetails = Order::select('mobile','email','name')->where('id',$data['order_id'])->first()->toArray();
            //send order sms.........................142
            $message = "Dear Customer, Your order #".$data['order_id']." status has been updated to ".$data['order_status']." placed from E-shop";
            $mobile = $deliveryDetails['mobile'];
            Sms::sendSms($message,$mobile);

            //send order Email.......................142
            $orderDetails = Order::with('orders_products')->where('id',$data['order_id'])->first()->toArray();
            $email = $deliveryDetails['email'];
            $messageData = [
                'email' => $email,
                'name' => $deliveryDetails['name'],
                'order_id' => $data['order_id'],
                'order_status' => $data['order_status'],
                'orderDetails' => $orderDetails,
                'courier_name' => $data['courier_name'],
                'tracking_number' => $data['tracking_number']
            ];
           Mail::send('emails.order_status',$messageData,function($message) use($email){
                    $message->to($email)->subject('Order status has been updated - E-shop website');
                });

            //update order log.......................................................143
            $log = new OrdersLog;
            $log->order_id = $data['order_id'];
            $log->order_status = $data['order_status'];
            $log->save();

            //update courier_name and tracking_number.................................144
            if (!empty($data['courier_name']) && !empty($data['tracking_number'])) {
               Order::where('id',$data['order_id'])->update(['courier_name'=>$data['courier_name'],'tracking_number'=>$data['tracking_number']]);
            }
            return redirect()->back();
        }
    }
    //....................................invoice.........146
    public function viewOrderInvoice($id)
    {
        $orderDetails = Order::with('orders_products')->where('id',$id)->first()->toArray();
        //echo "<pre>";print_r($orderDetails); die;
        $userDetails = User::where('id',$orderDetails['user_id'])->first()->toArray();
        return view('admin.orders.order_invoice')->with(compact('orderDetails','userDetails'));
    }
}
