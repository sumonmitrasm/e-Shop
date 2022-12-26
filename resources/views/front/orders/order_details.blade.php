<?php use App\Product; ?>
@extends('layouts.front_layout.front_layout')
@section('content')
<div class="span9">
<ul class="breadcrumb">
	<li><a href="index.html">Home</a> <span class="divider">/</span></li>
	<li class="active"><a href="{{url('/orders')}}">Order</a></li>
</ul>
<h3> Order #{{$orderDetails['id']}}</h3>	
<hr class="soft"/>
<div class="row">
	<div class="span4">	
		<table class="table table-striped table-bordered">
			<tr>
				<td colspan="2"><strong>Order</strong></td>
			</tr>
			<tr>
				<td>Order Date</td>
				<td>{{ date('d-m-y', strtotime($orderDetails['created_at']))}}</td>
			</tr>
			<tr>
				<td>Order Status</td>
				<td>{{$orderDetails['order_status']}}</td>
			</tr>
			@if(!empty($orderDetails['courier_name']))
			<tr>
				<td>Courier Name</td>
				<td>{{$orderDetails['courier_name']}}</td>
			</tr>
			@endif
			@if(!empty($orderDetails['tracking_number']))
			<tr>
				<td>Tracking Number</td>
				<td>{{$orderDetails['tracking_number']}}</td>
			</tr>
			@endif
			<tr>
				<td>Order Total</td>
				<td>{{$orderDetails['grand_total']}}</td>
			</tr>
			<tr>
				<td>Shipping Charges</td>
				<td>{{$orderDetails['shipping_charges']}}</td>
			</tr>
			<tr>
				<td>Coupon Code</td>
				<td>{{$orderDetails['coupon_code']}}</td>
			</tr>
			<tr>
				<td>Coupon Ammount</td>
				<td>{{$orderDetails['coupon_amount']}}</td>
			</tr>
			<tr>
				<td>Payment Method</td>
				<td>{{$orderDetails['payment_method']}}</td>
			</tr>
		</table>
	</div>
	<div class="span4">	
		<table class="table table-striped table-bordered">
			<tr>
				<td colspan="2"><strong>Delivary Address</strong></td>
			</tr>
			<tr>
				<td>Name</td>
				<td>{{$orderDetails['name']}}</td>
			</tr>
			<tr>
				<td>Address</td>
				<td>{{$orderDetails['address']}}</td>
			</tr>
			<tr>
				<td>City</td>
				<td>{{$orderDetails['city']}}</td>
			</tr>
			<tr>
				<td>State</td>
				<td>{{$orderDetails['state']}}</td>
			</tr>
			<tr>
				<td>Country</td>
				<td>{{$orderDetails['country']}}</td>
			</tr>
			<tr>
				<td>Pincode</td>
				<td>{{$orderDetails['pincode']}}</td>
			</tr>
			<tr>
				<td>Mobile</td>
				<td>{{$orderDetails['mobile']}}</td>
			</tr>
		</table>
	</div>
</div>
<div class="row">
	<div class="span8">	
		<table class="table table-striped table-bordered">
			<tr>
				<th>Product Image</th>
				<th>Product Code</th>
				<th>Product Name</th>
				<th>Product Size</th>
				<th>Product Color</th>
				<th>Product qty</th>
			</tr>
			@foreach($orderDetails['orders_products'] as $product)
			<tr>
				<td><?php $getProductImage = Product::getProductImage($product['product_id']) ?>
					<a href="{{url('product/'.$product['product_id'])}}"><img style="width: 80px;" src="{{asset('images/product_images/small/'.$getProductImage)}}"></a>
				</td>
				<td>{{$product['product_code']}}</td>
				<td>{{$product['product_name']}}</td>
				<td>{{$product['product_size']}}</td>
				<td>{{$product['product_color']}}</td>
				<td>{{$product['product_qty']}}</td>
			</tr>
			@endforeach
		</table>
	</div>
</div>	
</div>
@endsection