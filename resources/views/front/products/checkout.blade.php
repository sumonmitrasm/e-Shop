<?php use App\Cart; ?>
<?php use App\Product; ?>
@extends('layouts.front_layout.front_layout')
@section('content')
<div class="span9">
<ul class="breadcrumb">
	<li><a href="index.html">Home</a> <span class="divider">/</span></li>
	<li class="active"> CHECKOUT</li>
</ul>
<h3>  CHECKOUT [ <small><span class="totalCartItems">{{totalCartItems()}}</span> Item(s) </small>]<a href="{{url('/cart')}}" class="btn btn-large pull-right"><i class="icon-arrow-left"></i> Back to Cart </a></h3>	
<hr class="soft"/>
@if(Session::has('success_message'))
<div class="alert alert-success" role="alert">
<strong>{{Session::get('success_message')}}</strong>
<button type="button" class="close" data-dismiss="alert" aria-label="close">
<span aria-hidden="true">&times;</span></span>
</button>
</div>
<?php Session::forget('success_message'); ?>
@endif
@if(Session::has('error_message'))
<div class="alert alert-danger" role="alert" style="margin-top: 10px;">
<strong>{{Session::get('error_message')}}</strong>
<button type="button" class="close" data-dismiss="alert" aria-label="close">
<span aria-hidden="true">&times;</span></span>
</button>
</div>
<?php Session::forget('error_message'); ?>
@endif

<form id="checkoutForm" method="post" action="{{url('/checkout')}}">@csrf
<table class="table table-bordered">
	<tr><th><strong> Delivery Address</strong><strong><a href="{{url('/add-edit-delivery-address')}}" style="margin-left: 700px; color: #B22802;" >Add</a></strong></th></tr>
	@foreach($DeliveryAddresses as $address)
	 <tr> 
	    <td>
			<div class="control-group" style="float:left; margin-top:-2px; margin-right: 5px;">
				<input type="radio"  id="address{{$address['id']}}" name="address_id" value="{{$address['id']}}" shipping_charges="{{$address['shipping_charges']}}" total_price="{{$total_price}}" coupan_ammount ="{{Session::get('couponAmount')}}" codpincodeCount= "{{$address['codpincodeCount']}}" prepaidpincodeCount= "{{$address['prepaidpincodeCount']}}">
			</div>
			<div class="control-group">
			  	<label class="control-label">{{$address['name']}},{{$address['address']}},{{$address['city']}},{{$address['state']}},{{$address['country']}},(M:{{$address['mobile']}}),{{$address['pincode']}}</label>
			</div>
	    </td>
	    <td><a href="{{url('/add-edit-delivery-address/'.$address['id'])}}" style="color:#FFC300">Edit</a>|<a href="{{url('/delete-delivery-address/'.$address['id'])}}" style="color:#C70039;" id="addressDelete">Delete</a></td>
	  </tr>
	  @endforeach
</table>	
<table class="table table-bordered">
          <thead>
            <tr>
              <th>Product</th>
              <th colspan="2">Description</th>
              <th>Quantity</th>
			  <th>MRP</th><!--Maximum retail price -->
              <th>Discount</th>
              <th>Total</th>
			</tr>
          </thead>
          <tbody>
          	<?php $total_price = 0?>
          	@foreach($userCartItems as $item)
          	<?php $getPrice = Product::getDiscountedAttrPrice($item['product_id'],$item['size']);?> <!--video91 -->
            <tr>
              <td> <img width="60" src="{{asset('images/product_images/small/'.$item['product']['main_image'])}}" alt=""/></td>
              <td colspan="2">{{$item['product']['product_name']}} ({{$item['product']['product_code']}})<br/>Color:{{$item['product']['product_color']}}<br/>Size:{{$item['size']}}</td><!--video86 -->
			  <td>{{$item['quantity']}}</td>
              <td>Rs.{{$getPrice['product_price'] * $item['quantity']}}</td>
              <td>Rs.{{$getPrice['discount'] * $item['quantity']}}</td>
              <td>Rs.{{$getPrice['final_price'] * $item['quantity'] }}</td>
            </tr>
            <?php $total_price =$total_price + ($getPrice['final_price'] * $item['quantity'] ); ?>
            @endforeach
            <tr>
              <td colspan="6" style="text-align:right">Sub Total Price:	</td>
              <td> Rs.{{$total_price}}</td>
            </tr>
			 <tr>
              <td colspan="6" style="text-align:right">Coupon Discount:	</td>
              <td class="couponAmount"> 
                @if(Session::has('couponAmount'))
                   -Rs.{{Session::get('couponAmount')}}
                @else
                    Rs.0
                @endif
              </td>
            </tr>
             <tr>
              <td colspan="6" style="text-align:right">Shipping Charges:	</td>
              <td class="shipping_charges">Rs.0
              </td>
            </tr>
			 <tr>
              <td colspan="6" style="text-align:right"><strong>GRAND TOTAL (Rs.{{$total_price}} - <span class="couponAmount">Rs.{{Session::get('couponAmount')}}</span> + <span class="shipping_charges">Rs.0</span>) =</strong></td>
              <td class="label label-important" style="display:block"> <strong class="grand_total"> {{$grand_total = $total_price - Session::get('couponAmount')}}
              	<?php Session::put('grand_total',$grand_total)?>
              </strong></td><!------------------------------------------------- 121 next 128 class -->
            </tr>
			</tbody>
</table>
        <table class="table table-bordered">
		<tbody>
			 <tr>
              <td> 
				<div class="control-group">
				<label class="control-label"><strong> PAYMENT METHOD: </strong> </label>
				<div class="controls">
					<span>
						<span class="codMethod">
							<input type="radio" name="payment_gateway" id="COD" value="COD">&nbsp;<b>COD</b>
						</span>
						<span class="prepaidMethod">
							<input type="radio" name="payment_gateway" id="Paypal" value="Paypal">&nbsp;<b>Paypal</b>
						</span>
						
					</span>
				</div>
				</div>
			</td>
            </tr>
		</tbody>
		</table>
		<!-- <table class="table table-bordered" checked="">
		 <tr><th>ESTIMATE YOUR SHIPPING </th></tr>
		 <tr> 
		 <td>
			<form class="form-horizontal">
			  <div class="control-group">
				<label class="control-label" for="inputCountry">Country </label>
				<div class="controls">
				  <input type="text" id="inputCountry" placeholder="Country">
				</div>
			  </div>
			  <div class="control-group">
				<label class="control-label" for="inputPost">Post Code/ Zipcode </label>
				<div class="controls">
				  <input type="text" id="inputPost" placeholder="Postcode">
				</div>
			  </div>
			  <div class="control-group">
				<div class="controls">
				  <button type="submit" class="btn">ESTIMATE </button>
				</div>
			  </div>
			</form>				  
		  </td>
		  </tr>
        </table> -->		
<a href="{{url('/cart')}}" class="btn btn-large"><i class="icon-arrow-left"></i> Back to Cart</a>
<button type="submit" class="btn btn-large pull-right">Place Orders <i class="icon-arrow-right"></i></button> 
</div>
</div>
</form>

</div>
@endsection