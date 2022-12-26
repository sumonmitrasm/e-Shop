@extends('layouts.front_layout.front_layout')
@section('content')
<div class="span9">
<ul class="breadcrumb">
	<li><a href="{{url('/')}}">Home</a> <span class="divider">/</span></li>
	<li class="active">Delivery Addresses</li>
</ul>
<h3> {{$title}}</h3>	
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
 @if ($errors->any())
    <div class="alert alert-danger" style="margin-top: 10px;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
<div class="row">
	<div class="span4">
			
		<div class="well">
		<h5>Delivery Address</h5><br/>
		Enter your Delivery Address.<br/><br/>
		<form id="DeliveryAddressForm" @if(empty($address['id'])) action="{{url('/add-edit-delivery-address')}}" @else action="{{url('/add-edit-delivery-address/'.$address['id'])}}" @endif method="post">@csrf
			<div class="control-group">
			<label class="control-label" for="name">Name</label>
			<div class="controls">
			  <input class="span3" type="text" id="name" name="name" placeholder="Enter Name" required="" @if(isset($address['name'])) value="{{$address['name']}}" @else value="{{old('name')}}" @endif>
			</div>
		  </div>
		  <div class="control-group">
			<label class="control-label" for="address">Address</label>
			<div class="controls">
			  <input class="span3" type="text" id="address" name="address" placeholder="Enter Address" required="" @if(isset($address['address'])) value="{{$address['address']}}" @else value="{{old('address')}}" @endif>
			</div>
		  </div>
		  <div class="control-group">
			<label class="control-label" for="city">City</label>
			<div class="controls">
			  <input class="span3" type="text" id="city" name="city" placeholder="Enter City" required="" @if(isset($address['city'])) value="{{$address['city']}}" @else value="{{old('city')}}" @endif>
			</div>
		  </div>
		  <div class="control-group">
			<label class="control-label" for="name">State</label>
			<div class="controls">
			  <input class="span3" type="text" id="state" name="state" placeholder="Enter State" required="" @if(isset($address['state'])) value="{{$address['state']}}" @else value="{{old('state')}}" @endif>
			</div>
		  </div>
		  <div class="control-group">
			<label class="control-label" for="country">Country</label>
			<div class="controls">
			  <select name="country" class="span3" id="country" name="country">
			  	<option value="">Select</option>
			  	@foreach($countries as $country)
			  	<option value="{{$country['country_name']}}" @if($country['country_name']==$address['country']) selected="" @elseif($country['country_name']==old('country')) selected="" @endif>{{$country['country_name']}}</option>
			  	
			  	@endforeach
			  </select>
			</div>
		  </div>
		  <div class="control-group">
			<label class="control-label" for="pincode">Pincode</label>
			<div class="controls">
			  <input class="span3" type="text" id="pincode" name="pincode" placeholder="Enter Pincode" @if(isset($address['pincode'])) value="{{$address['pincode']}}" @else value="{{old('pincode')}}" @endif>
			</div>
		  </div>
		  <div class="control-group">
			<label class="control-label" for="mobile">Mobile</label>
			<div class="controls">
			  <input class="span3" type="text" id="mobile" name="mobile" placeholder="Enter Mobile" @if(isset($address['mobile'])) value="{{$address['mobile']}}" @else value="{{old('mobile')}}" @endif>
			</div>
		  </div>
		  <div class="controls">
		  <button type="submit" class="btn block">Submit</button>
		  <a class="btn block" style="float: right;" href="{{url('/checkout')}}">Back</a>
		  </div>
		</form>
	</div>
	</div>
	</div>
	</div>
</div>	
</div>
@endsection