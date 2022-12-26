<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
	<link rel="stylesheet" href="">
</head>
<body>
	<table style="width: 700px;">
		<tr><td>&nbsp;</td></tr>
		<tr><td><img src="{{asset('images/front_images/sumon45.PNG')}}"></td></tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td>Hellow {{$name}},</td></tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td>Thank you for shopping with us. Your order details are as below:-</td></tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td>Order no: {{$order_id}}</td></tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td>
			<table style="width: 95%" callpadding="5" cellspacing="5" bgcolor="#f7f4f4">
					<tr bgcolor="$cccccc">
						<td>Product Name</td>
						<td>Product Code</td>
						<td>Product Size</td>
						<td>Product Color</td>
						<td>Product quantity</td>
						<td>Product Price</td>
					</tr>
					
					@foreach($orderDetails['orders_products'] as $order)
					<tr>
						<td>{{$order['product_name']}}</td>
						<td>{{$order['product_code']}}</td>
						<td>{{$order['product_size']}}</td>
						<td>{{$order['product_color']}}</td>
						<td>{{$order['product_qty']}}</td>
						<td>INR {{$order['product_price']}}</td>
					</tr>
					@endforeach
					<tr>
						<td colspan="5" align="right">Shipping Charges</td>
						<td>INR {{$orderDetails['shipping_charges']}}</td>
					</tr>
					<tr>
						<td colspan="5" align="right">Coupon Discount</td>
						<td>INR 
						@if($orderDetails['coupon_amount']>0)
							{{$orderDetails['coupon_amount']}}</td>
						@else
							0
						@endif
					</tr>
					<tr>
						<td colspan="5" align="right">Grand Total</td>
						<td>INR {{$orderDetails['grand_total']}}</td>
					</tr>	
			</table>
		</td></tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td>
			<table>
				<tr>
					<td><strong>Delivery Address :</strong></td>
				</tr>
				<tr>
					<td>{{$orderDetails['name']}}</td>
				</tr>
				<tr>
					<td>{{$orderDetails['address']}}</td>
				</tr>
				<tr>
					<td>{{$orderDetails['name']}}</td>
				</tr>
				<tr>
					<td>{{$orderDetails['city']}}</td>
				</tr>
				<tr>
					<td>{{$orderDetails['state']}}</td>
				</tr>
				<tr>
					<td>{{$orderDetails['pincode']}}</td>
				</tr>
				<tr>
					<td>{{$orderDetails['mobile']}}</td>
				</tr>
			</table>
		</td></tr>
		<tr><td>Contuct Us: <a href="mailto:sumonmitra1000686@gmail.com">sumonmitra1000686@gmail.com</a></td></tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td>Regards,<br>Team E-shop</td></tr>
		<tr><td>&nbsp;</td></tr>
	</table>
</body>
</html>
