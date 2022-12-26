@extends('layouts.front_layout.front_layout')
@section('content')
<div class="span9">
<ul class="breadcrumb">
	<li><a href="{{url('/')}}">Home</a> <span class="divider">/</span></li>
	<li class="active">Thanks</li>
</ul>
<hr class="soft"/>
<div align="center">
	<h3>YOUR ORDER HAS BEEN PLACED</h3>
	<p>Your order number is {{Session::get('order_id')}} and total payable ammount is INR {{Session::get('grand_total')}}</p>
	<p>Please click the below button for payment money </p>

	<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post"> 
		<input type="text" name="cmd" value="_cart"> 
		<input type="text" name="business" value="seller@designerfotos.com"> 
		<input type="text" name="item_name" value="{{Session::get('order_id')}}"> 
		<input type="text" name="item_number" value="{{Session::get('order_id')}}"> 
		<input type="text" name="amount" value="{{round(Session::get('grand_total'),2)}}">
		 <input type="text" name="first_name" value="{{$namearr[0]}}">
		 <input type="text" name="last_name" value="roy"> 
		 <input type="text" name="address1" value="{{$orderDetails['address']}}"> 
		 <input type="text" name="address2" value=""> 
		 <input type="text" name="city" value="{{$orderDetails['city']}}"> 
		 <input type="text" name="state" value="{{$orderDetails['state']}}"> 
		 <input type="text" name="zip" value="{{$orderDetails['pincode']}}"> 
		 <input type="text" name="email" value="{{$orderDetails['email']}}"> 
		 <input type="image" name="submit" src="https://www.paypalobjects.com/en_US/i/btn/btn_paynow_LG.gif" alt="PayPal - The safer, easier way to pay online"> 
	</form>
</div>

</div>
@endsection

<?php
//Session::forget('order_id');
//Session::forget('grand_total');
//Session::forget('couponCode');
//Session::forget('couponAmount');
?>