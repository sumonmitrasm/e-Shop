<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use App\Product;
use App\ProductsAttribute;
use Session;
use App\Cart;
use Auth;
use App\Coupon;
use App\User;
use App\DeliveryAddress;
use App\Country;
use App\Order;
use App\OrdersProduct;
use DB;
use App\Sms;
use Illuminate\Support\Facades\Mail;
use App\ShippingCharge;

class ProductsController extends Controller
{
    public function listing(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            //echo "<pre>";print_r($data);
            $url = $data['url'];
            $categoryCount = Category::where(['url'=>$url,'status'=>1])->count();
             if ($categoryCount>0) {
                //echo "Category exit";die;
                $categoryDetails = Category::catDetails($url);
                //echo "<pre>";print_r($categoryDetails);die;
                $categoryProducts = Product::with('brand')->whereIn('category_id',$categoryDetails['catIDs'])->where('status',1);
                //if fabric filter is selected
                if (isset($data['fabric']) && !empty($data['fabric'])) {
                   $categoryProducts->whereIn('products.fabric',$data['fabric']);
                }
                //if sl sleeve is selected
                if (isset($data['sleeve']) && !empty($data['sleeve'])) {
                   $categoryProducts->whereIn('products.sleeve',$data['sleeve']);
                }
                if (isset($data['pattern']) && !empty($data['pattern'])) {
                   $categoryProducts->whereIn('products.pattern',$data['pattern']);
                }
                if (isset($data['fit']) && !empty($data['fit'])) {
                   $categoryProducts->whereIn('products.fit',$data['fit']);
                }
                if (isset($data['occassion']) && !empty($data['occassion'])) {
                   $categoryProducts->whereIn('products.occassion',$data['occassion']);
                }
             // If Sort option selected by User
                if (isset($data['sort']) && !empty($data['sort'])) {
                    if ($data['sort']=="product_latest") {
                        $categoryProducts->orderBy('id','Desc');
                    }else if
                        ($data['sort']=="product_name_a_z") {
                        $categoryProducts->orderBy('id','Asc');
                    }else if
                        ($data['sort']=="product_name_z_a") {
                        $categoryProducts->orderBy('id','Desc');
                    }else if
                        ($data['sort']=="price_lowest") {
                        $categoryProducts->orderBy('id','Desc');
                    }else if
                        ($data['sort']=="price_highest") {
                        $categoryProducts->orderBy('id','Asc');
                    }
                }else{
                    $categoryProducts->orderBy('id','Desc');
                }
                 $categoryProducts = $categoryProducts->paginate(10);
                //echo "<pre>";print_r($categoryProducts);die;
                return view('front.products.ajax_products_listing')->with(compact('categoryDetails','categoryProducts','url'));
            }else{
                abort(404);
            }
        }else{
            $url = Route::getFacadeRoot()->current()->uri();
            $categoryCount = Category::where(['url'=>$url,'status'=>1])->count();
            if (isset($_REQUEST['search']) && !empty($_REQUEST['search'])) {
                // Search function.........................................................173
                $search_product = $_REQUEST['search'];
                $categoryDetails['breadcrumb'] = $search_product;
                $categoryDetails['catDetails']['category_name'] = $search_product;
                $categoryDetails['catDetails']['description'] = "Search result for".$search_product;
                $categoryProducts = Product::with('brand')->where(function($query)use($search_product){
                    $query->where('product_name','like','%'.$search_product.'%')
                    ->orWhere('product_code','like','%'.$search_product.'%')
                    ->orWhere('product_color','like','%'.$search_product.'%')
                    ->orWhere('description','like','%'.$search_product.'%');
                })->where('status',1);
                $categoryProducts = $categoryProducts->get();
                $page_name = "Search result";
                return view('front.products.listing')->with(compact('categoryDetails','categoryProducts','page_name'));

            }else if ($categoryCount>0) {
                //echo "Category exit";die;
                $categoryDetails = Category::catDetails($url);
                //echo "<pre>";print_r($categoryDetails);die;
                $categoryProducts = Product::with('brand')->whereIn('category_id',$categoryDetails['catIDs'])->where('status',1);
                $categoryProducts = $categoryProducts->paginate(10);
                //echo "<pre>";print_r($categoryProducts);die;

                 //Product Filter.........................................................................
                $productFilters = Product::productFilters();
                //echo "<pre>";print_r($productFilters);die;
                $fabricArray = $productFilters['fabricArray'];
                $sleeveArray = $productFilters['sleeveArray'];
                $patternArray = $productFilters['patternArray'];
                $fitArray = $productFilters['fitArray'];
                $occassionArray = $productFilters['occassionArray'];
                //page name
                $page_name = "listing";
                return view('front.products.listing')->with(compact('categoryDetails','categoryProducts','url','fabricArray','sleeveArray','patternArray','fitArray','occassionArray','page_name'));
            }else{
                abort(404);
            }
        }
    	
    }
    public function details($id)
    {
        $productDetails = Product::with(['category','brand','attributes'=>function($query){
            $query->where('status',1);
        },'images'])->find($id)->toArray();
        //$productDetails = json_decode(json_encode($productDetails));
        //echo "<pre>";print_r($productDetails);die;
         $total_stock = ProductsAttribute::where('product_id',$id)->sum('stock');
        //echo $total_stock = ProductsAttribute::where('product_id',$id)->sum('stock');die;
         $relatdProduct = Product::where('category_id',$productDetails['category']['id'])->where('id','!=',$id)->limit(3)->inRandomOrder()->get()->toArray();
         //echo "<pre>";print_r($relatdProduct);die;
         //,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,,...........................171
         $groupProduct = array();
         if (!empty($productDetails['group_code'])) {
           $groupProduct = Product::select('id','main_image')->where('id','!=',$id)->where(['group_code'=>$productDetails['group_code'],'status'=>1])->get()->toArray();
           //dd($groupProduct);die;
         }
        return view('front.products.detail')->with(compact('productDetails','total_stock','relatdProduct','groupProduct'));
    }
    public function getProductPrice(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            //echo "<pre>";print_r($data);die;
            //$getProductPrice = ProductsAttribute::where(['product_id'=>$data['product_id'],'size'=>$data['size']])->first();
            //return $getProductPrice->price;
            $getDiscountedAttrPrice = Product::getDiscountedAttrPrice($data['product_id'],$data['size']);//video89
            return $getDiscountedAttrPrice;
        }
    }

    public function addtocart(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            //echo "<pre>";print_r($data);die;
            if ($data['quantity']<=0) {
                $data['quantity']=1;
            }
            if (empty($data['size'])) {
                $message = "Please select size";
                session::flash('error_message',$message);
                return redirect()->back();
            }
            //check products stock available or not//////////////....................................
            $getProductStock = ProductsAttribute::where(['product_id'=>$data['product_id'],'size'=>$data['size']])->first()->toArray();
            //echo $getProductStock['sku'];die; //video 84
            if ($getProductStock['stock']<$data['quantity']) {
                $message = "Required quantity is not available";
                session::flash('error_message',$message);
                return redirect()->back();
            }
            // Products does not cart less thne Zero......Invald Cart!!!!.............................
            if ($data['quantity']<0) {
                $message = "Products does not cart lass then Zero!!";
                session::flash('error_message',$message);
                return redirect()->back();
            }
            // Session Create code....................................................................
             $session_id = Session::get('session_id');
            if (empty($session_id)) {
                $session_id = Session::getId();
                Session::put('session_id',$session_id);
            }
            //Check Product if alrady exists in Cart..................................................
            if (Auth::check()) {
                //user is logged in.....................................
                $countProducts = Cart::where(['product_id'=>$data['product_id'],'size'=>$data['size'],'user_id'=>Auth::user()->id])->count();
            }else{
                //user is not logged in.................................
                $countProducts = Cart::where(['product_id'=>$data['product_id'],'size'=>$data['size'],'session_id'=>Session::get('session_id')])->count();
            }
           // $countProducts = Cart::where(['product_id'=>$data['product_id'],'size'=>$data['size']])->count();
            if ($countProducts>0) {
                $message = "Product Already in exists in cart";
                session::flash('error_message',$message);
                return redirect()->back();
            }
            //Save product in cart....................................................................
            /*
            Cart::insert(['session_id'=>$session_id,'product_id'=>$data['product_id'],'size'=>$data['size'],'quantity'=>$data['quantity']]);*/

            //if user are login see 101
            if (Auth::check()) {
                $user_id = Auth::user()->id;
            }else{
                $user_id = 0;
            }
            $cart = New Cart;
            $cart->session_id = $session_id;
            $cart->user_id = $user_id;
            $cart->product_id = $data['product_id'];
            $cart->size = $data['size'];
            $cart->quantity = $data['quantity'];
            $cart->save();

            $message = "Product has been added in Cart";
            Session::flash('success_message',$message);
            return redirect('cart'); 
        }
    }
    public function cart()
    {
        $userCartItems = Cart::userCartItems();
        //echo "<pre>";print_r($userCartItems);die;
        return view('front.products.cart')->with(compact('userCartItems'));
    }
    public function updateCartItemQty(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            //echo "<pre>";print_r($data);die;
            //stock is available or not
            $cartDetails = Cart::find($data['cartid']); //94
            $availableStock = ProductsAttribute::select('stock')->where(['product_id'=>$cartDetails['product_id'],'size'=>$cartDetails['size']])->first()->toArray();

            //echo "Demanded Stock".$data['qty'];
            //echo "</br>";
            //echo "availableStock".$availableStock['stock'];die;
            if ($data['cartid']<$availableStock['stock']) {
                $userCartItems = Cart::userCartItems();//see bellow or 94 20min
                return response()->json([
                    'status'=>false,
                    'message'=>'Product Stock is not available',
                    'view'=>(String)View::make('front.products.cart_items')->with(compact('userCartItems'))
                ]);
            }
            //size and status is available or not........
            $availableSize = ProductsAttribute::where(['product_id'=>$cartDetails['product_id'],'size'=>$cartDetails['size'],'status'=>1])->count();
             if ($availableSize==0) {
                $userCartItems = Cart::userCartItems();//see bellow or 94 20min
                return response()->json([
                    'status'=>false,
                    'message'=>'Product Size is not available',
                    'view'=>(String)View::make('front.products.cart_items')->with(compact('userCartItems'))
                ]);
            }

            Cart::where('id',$data['cartid'])->update(['quantity'=>$data['qty']]);
            $userCartItems = Cart::userCartItems();
            $totalCartItems = totalCartItems();//112...17.59
            return response()->json([
                'status'=>true,
                'totalCartItems'=>$totalCartItems,
                'view'=>(String)View::make('front.products.cart_items')->with(compact('userCartItems'))
            ]);
        }
    }
    //delete cart items........................................................
    public function deleteCartItem(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            //echo "<pre>";print_r($data);die;
            Cart::where('id',$data['cartid'])->delete();
            $userCartItems = Cart::userCartItems();
            $totalCartItems = totalCartItems();//112...17.59
            return response()->json([
                'view'=>(String)View::make('front.products.cart_items')->with(compact('userCartItems'))
            ]);
        }
    }
    public function applyCoupon(Request $request)
    {
      if ($request->ajax()) {
          $data = $request->all();
          //echo "<pre>";print_r($data);die;
          $userCartItems = Cart::userCartItems();
          $couponCount = Coupon::where('coupon_code',$data['code'])->count();
          if ($couponCount==0) {
             $userCartItems = Cart::userCartItems();//119...34
             $totalCartItems = totalCartItems();
             Session::forget('couponCode');
             Session::forget('couponAmount');
              return response()->json([
                'status'=>false,
                'messages'=>'This coupon is not valid!',
                'totalCartItems'=>$totalCartItems,
                'view'=>(String)View::make('front.products.cart_items')->with(compact('userCartItems'))
            ]);
          }else{
             //get coupon details................................................120
            
             $couponDetails = Coupon::where('coupon_code',$data['code'])->first();
              //if coupon is inactive
            if ($couponDetails->status==0) {
                $messages = 'This coupon is not active';
            }
            // coupon is expaire or not
            $expairy_date = $couponDetails->expairy_date;
            $current_date = date('y-m-d');
            if ($expairy_date>$current_date) {
                $messages = 'Coupon offer is expaired';
            }
            //check if coupon is singel time or multipel time.................151
            if ($couponDetails->coupon_type = "Single Times") {
                $couponCount = Order::where(['coupon_code'=>$data['code'],'user_id'=>Auth::user()->id])->count();
                if ($couponCount >= 1) {
                    $messages = 'This coupon code is alrady availed you!';
                }
            }
            //Check if coupon is from selected categories
            //get all selected categories from coupon
            $catArr = explode(",", $couponDetails->categories);
            //get cart items
            $userCartItems = Cart::userCartItems();//120...21
            //echo "<pre>";print_r($userCartItems);

            //get all selected users............................................120
            if (!empty($couponDetails->users)) {
               $userArr = explode(",", $couponDetails->users);
            //get users id's of all selected users...............................120.30.34
                 foreach ($userArr as $key => $user) {
                     $getUserID = User::select('id')->where('email',$user)->first()->toArray();
                     $userID[] = $getUserID['id'];
                } 
            }//122
            
            //Get cart total amount.....121
            $total_amount = 0;
           foreach ($userCartItems as $key => $item) {
                    //check if any Item belong to coupon catgory..........120
                if (!in_array($item['product']['category_id'], $catArr)) {
                    $messages = 'This coupon code is not for one of the selected products!';
                }
                if (!empty($couponDetails->users)) {
                    if (!in_array($item['user_id'], $userID)) {
                         $messages = 'This coupon is not for you!';
                    }
                }//122

                $attrPrice = Product::getDiscountedAttrPrice($item['product_id'],$item['size']);
                $total_amount = $total_amount+($attrPrice['final_price']*$item['quantity']);
            }
            //echo "<pre>";print_r($total_amount);die;
           if (isset($messages)) {
                 $userCartItems = Cart::userCartItems();//119...34
                 $totalCartItems = totalCartItems();
                 return response()->json([
                    'status'=>false,
                    'messages'=>$messages,
                    'totalCartItems'=>$totalCartItems,
                    'view'=>(String)View::make('front.products.cart_items')->with(compact('userCartItems'))
                ]);
            }else{
                //echo "Coupon can be successufully redeemed";
                //check ammout type is fixd or percentage.................121
                if ($couponDetails->amount_type=="Fixed") {
                    $couponAmount = $couponDetails->amount;
                }else{
                    $couponAmount = $total_amount * ($couponDetails->amount/100);
                }
                //grandtotal............................................121
                $grand_total = $total_amount - $couponAmount;

                Session::put('couponAmount',$couponAmount);
                Session::put('couponCode',$data['code']);
                $messages = "Coupon code successfully applied";
                $userCartItems = Cart::userCartItems();//121
                $totalCartItems = totalCartItems();
                return response()->json([
                    'status'=>true,
                    'messages'=>$messages,
                    'totalCartItems'=>$totalCartItems,
                    'couponAmount'=>$couponAmount,
                    'grand_total'=>$grand_total,
                    'view'=>(String)View::make('front.products.cart_items')->with(compact('userCartItems'))
                ]);
            }
          }
      }
    }

    public function checkout(Request $request)
    {
        $userCartItems = Cart::userCartItems();
        if (count($userCartItems)==0) {
            $message = "Shopping cart is empty..Please add products.";
            Session::put('error_message',$message);
            return redirect('cart');
        }
       
        //dd($DeliveryAddresses);die;
        $total_price = 0;
        $total_weight = 0;
        foreach($userCartItems as $item){
        //echo "<pre>"; print_r($item);die;//.....c.....157\172
        $product_weight = $item['product']['product_weight'];
        $total_weight = $total_weight + ($product_weight * $item['quantity']);
        $getPrice = Product::getDiscountedAttrPrice($item['product_id'],$item['size']);
        $total_price =$total_price + ($getPrice['final_price'] * $item['quantity'] );
        }
        //echo $total_weight;die;//......c....157

         $DeliveryAddresses = DeliveryAddress::DeliveryAddresses();
        //dd($DeliveryAddresses);die();
        foreach ($DeliveryAddresses as $key => $value) {
        $shippingCharges = ShippingCharge::getShippingCharges($total_weight,$value['country']);
           $DeliveryAddresses[$key]['shipping_charges'] = $shippingCharges;
           //check delevery address pincode for cod address.......................................166
           $DeliveryAddresses[$key]['codpincodeCount'] = DB::table('cod_pincodes')->where('pincode',$value['pincode'])->count();
           $DeliveryAddresses[$key]['prepaidpincodeCount'] = DB::table('prepaid_pincodes')->where('pincode',$value['pincode'])->count();
        }
        //echo "<pre>";print_r($DeliveryAddresses);die;

        if ($request->isMethod('post')) {
            $data = $request->all();
            //echo Session::get('grand_total');

            //print_r($data);die;//.............................................130
            //echo "<pre>";print_r($userCartItems);die; //-------------------168

            foreach ($userCartItems as $cart) {
                $product_status = Product::getProductStatus($cart['product_id']);
                if ($product_status==0) {
                    Product::deleteCartProduct($cart['product_id']);
                    $messages = $cart['product']['product_name']." is not available from the cart";
                    Session::flash('error_message',$messages);
                    return redirect('/cart');
                }

                 //prevent out of the stock from the cart......................168
                $getProductStock = Product::getProductStock($cart['product_id'],$cart['size']);
                //echo "<pre>";print_r($getProductStock);
                if ($getProductStock==0) {
                    //Product::deleteCartProduct($cart['product_id']);
                    $messages = $cart['product']['product_name']." is not available from the cart. Please remove from the cart";
                    Session::flash('error_message',$messages);
                    return redirect('/cart');
                }

                //prevent inactive product can't buy.............................169
                $getAttrebuteCount = Product::getAttrebuteCount($cart['product_id'],$cart['size']);
                if ($getAttrebuteCount==0) {
                    //Product::deleteCartProduct($cart['product_id']);
                    $messages = $cart['product']['product_name']." is not available from the cart. Please remove from the cart";
                    Session::flash('error_message',$messages);
                    return redirect('/cart');
                }
            }
           

            if (empty($data['address_id'])) {
                $messages = "Please confirm your delivary address";
                Session::flash('error_message',$messages);
                return redirect()->back();
            }

            if (empty($data['payment_gateway'])) {
                $messages = "Please Enter your payment method";
                Session::flash('error_message',$messages);
                return redirect()->back();
            }
            //print_r($data);die;
            if ($data['payment_gateway']=="COD") {
                $payment_method = "COD";
            }else{
                $payment_method = "Prepaid";
            }
            //print_r($data);die;
            $deliveryAddress = DeliveryAddress::where('id',$data['address_id'])->first()->toArray();
            //echo "<pre>";print_r($deliveryAddress);die;

            //get shipping charges...................................155 see group join
            $shipping_charges = ShippingCharge::getShippingCharges($total_weight,$deliveryAddress['country']);
            $grand_total = $total_price + $shipping_charges - Session::get('couponAmount');
            Session::put('grand_total',$grand_total);

            DB::beginTransaction();
            $order = new Order;
            $order->user_id = Auth::user()->id;
            $order->name = $deliveryAddress['name'];
            $order->address = $deliveryAddress['address'];
            $order->city = $deliveryAddress['city'];
            $order->state = $deliveryAddress['state'];
            $order->country = $deliveryAddress['country'];
            $order->pincode = $deliveryAddress['pincode'];
            $order->mobile = $deliveryAddress['mobile'];
            $order->email = Auth::user()->email;
            $order->shipping_charges = $shipping_charges; //155
            $order->coupon_code = Session::get('couponCode');
            $order->coupon_amount = Session::get('couponAmount');
            $order->order_status = "New";
            $order->payment_method = $payment_method;
            $order->payment_gateway = $data['payment_gateway'];
            $order->grand_total = Session::get('grand_total');
            $order->save();

            //get last Inserted Order Id...............................130
            $order_id = DB::getPdo()->lastInsertId();

            //Get User Itemss..........................................130
            $cartItems = Cart::where('user_id',Auth::user()->id)->get()->toArray();
            foreach ($cartItems as $key => $item) {
                $cartItem = new OrdersProduct;
                $cartItem->order_id = $order_id;
                $cartItem->user_id = Auth::user()->id;

                $getProductDetails = Product::select('product_code','product_name','product_color')->where('id',$item['product_id'])->first()->toArray();
                $cartItem->product_id = $item['product_id'];
                $cartItem->product_code = $getProductDetails['product_code'];
                $cartItem->product_name = $getProductDetails['product_name'];
                $cartItem->product_color = $getProductDetails['product_color'];
                $cartItem->product_size = $item['size'];
                $getDiscountedAttrPrice = Product::getDiscountedAttrPrice($item['product_id'],$item['size']);
                $cartItem->product_price = $getDiscountedAttrPrice['final_price'];
                $cartItem->product_qty = $item['quantity'];
                $cartItem->save();

                if ($data['payment_gateway']=="COD") {
                    //reduce stock and show..................................165
                    $getProductStock = ProductsAttribute::where(['product_id'=>$item['product_id'],'size'=>$item['size']])->first()->toArray();
                    $newStock = $getProductStock['stock'] - $item['quantity'];
                        ProductsAttribute::where(['product_id'=>$item['product_id'],'size'=>$item['size']])->update(['stock'=>$newStock]);
                }
            }
            
            DB::commit();
            Session::put('order_id',$order_id);

            if ($data['payment_gateway']=="COD") {
                //send order sms script...........................................140
                $message = "Dear Coustomer, Your order ".$order_id." hasbeen successfully plased with E-shop. We will intimate you  once your order is shipped";
                $mobile = Auth::user()->mobile;
                Sms::sendSms($message,$mobile);

                $orderDetails = Order::with('orders_products')->where('id',$order_id)->first()->toArray();
                //dd($orderDetails);
                $userDetails = User::where('id',$orderDetails['user_id'])->first()->toArray();
                //dd($userDetails);
                $email = Auth::user()->email;
                $messageData = [
                    'email' => $email,
                    'name' => Auth::user()->name,
                    'order_id' => $order_id,
                    'orderDetails' => $orderDetails,
                    'userDetails' => $userDetails
                ];
                Mail::send('emails.order',$messageData,function($message) use($email){
                    $message->to($email)->subject('Order Placed - E-shop website');
                });
                return redirect('/thanks');
            }else if ($data['payment_gateway']=="paypal"){
                    // return redirect user to paypel page.......after157
                
            }else{
                return redirect('/paypal');
                echo " Other Prepaid Method coming soon";die;
            }
            echo "Order Placed";die;

        }
        
        
        return view('front.products.checkout')->with(compact('userCartItems','DeliveryAddresses','total_price'));
    }
    public function thanks()
    {
        if (Session::has('order_id')) {
            //Empty the user cart........................................130
            Cart::where('user_id',Auth::user()->id)->delete();
            return view('front.products.thanks');
        }else{
            return redirect('/cart');
        }
       
    }
    public function addEditDeliveryAddress(Request $request,$id=null)
    {
        if ($id=="") {
            $title = "Add Delivery Address";
            $address = New DeliveryAddress;
            $message = "Delivery Address added successfully";
        }else{
            $title = "Edit Delivery Address";
            $address = DeliveryAddress::find($id);
            $message = "Delivery Address updated successfully";

        }
        if ($request->isMethod('post')) {
            $data = $request->all();
            //echo "<pre>";print_r($data );

             $rules = [
            'name' => 'required|regex:/^[\pL\s\-]+$/u',
            'address'=>'required',
            'pincode'=>'required|numeric',
            'mobile' => 'required|numeric',
            ];

            $customMessages = [
            'name.required' => 'Name is required',
            'name.regex'=>'valid Name is required',
            'address.required'=>'Address is required',
            'pincode.digits'=>'Pincode Must be of 8 digits',
            'mobile.required'=>'Mobile number is required',
            'mobile.numeric'=>'valid mobile number is required',
            ];
            $this->validate($request,$rules,$customMessages); //109
            $address->user_id = Auth::user()->id;
            $address->name = $data['name'];
            $address->address = $data['address'];
            $address->city = $data['city'];
            $address->state = $data['state'];
            $address->country = $data['country'];
            $address->pincode = $data['pincode'];
            $address->mobile = $data['mobile'];
            $address->save();
            Session::put('success_message',$message);
            return redirect('checkout');
        }
         $countries = Country::where('status',1)->get()->toArray();
         return view('front.products.add-edit-delivery-address')->with(compact('title','countries','address'));
    }

     public function deleteDeliveryAddress($id)
    {
        DeliveryAddress::where('id',$id)->delete();
        $message = 'Delivery Address has been deleted successfully!';
        Session::flash('success_message',$message);
        return redirect()->back();
    }
    //check pincode for detailse page ...............................167
    public function checkPincode(Request $request)
    {
       if ($request->isMethod('post')) {
           $data = $request->all();
           //echo "<pre>";print_r($data);die;
           $codpincodeCount = DB::table('cod_pincodes')->where('pincode',$data['pincode'])->count();
           $prepaidpincodeCount = DB::table('prepaid_pincodes')->where('pincode',$data['pincode'])->count();
           if ($codpincodeCount==0 && $prepaidpincodeCount==0) {
               echo "This pincode is not available for Delivery";
           }else{
            echo "This pincode is available for Delivery";
           }
       }
    }
    
   
}
