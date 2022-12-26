@extends('layouts.front_layout.front_layout')
@section('content')
<div class="span9">
<ul class="breadcrumb">
	<li><a href="index.html">Home</a> <span class="divider">/</span></li>
	<li class="active">Login</li>
</ul>
<h3> Login</h3>	
<hr class="soft"/>
@if(Session::has('success_message'))
<div class="alert alert-success" role="alert">
<strong>{{Session::get('success_message')}}</strong>
<button type="button" class="close" data-dismiss="alert" aria-label="close">
<span aria-hidden="true">&times;</span></span>
</button>
</div>
@endif
@if(Session::has('error_message'))
<div class="alert alert-danger" role="alert" style="margin-top: 10px;">
<strong>{{Session::get('error_message')}}</strong>
<button type="button" class="close" data-dismiss="alert" aria-label="close">
<span aria-hidden="true">&times;</span></span>
</button>
</div>
@endif
<div class="row">
	<div class="span4">
			
		<div class="well">
		<h5>CREATE YOUR ACCOUNT</h5><br/>
		Enter your information to create an account.<br/><br/>
		<form id="registerForm" action="{{url('/register')}}" method="post">@csrf
			<div class="control-group">
			<label class="control-label" for="name">Name</label>
			<div class="controls">
			  <input class="span3" type="text" id="name" name="name" placeholder="Enter Name">
			</div>
		  </div>
		  <div class="control-group">
			<label class="control-label" for="mobile">Mobile</label>
			<div class="controls">
			  <input class="span3" type="text" id="mobile" name="mobile" placeholder="Enter Mobile">
			</div>
		  </div>
		  <div class="control-group">
			<label class="control-label" for="email">E-mail address</label>
			<div class="controls">
			  <input class="span3" type="text" id="email" name="email" placeholder="Enter Email">
			</div>
		  </div>
		  <div class="control-group">
			<label class="control-label" for="password">Password</label>
			<div class="controls">
			  <input class="span3" type="password" id="password" name="password" placeholder="Enter Password">
			</div>
		  </div>
		  <div class="controls">
		  <button type="submit" class="btn block">Create Your Account</button>
		  </div>
		</form>
	</div>
	</div>
	<div class="span1"> &nbsp;</div>
	<div class="span4">
		<div class="well">
		<h5>ALREADY REGISTERED ?</h5>
		<form id="loginForm" action="{{url('/login')}}" method="post">@csrf
		  <div class="control-group">
			<label class="control-label" for="email">E-mail</label>
			<div class="controls">
			  <input class="span3" type="text" id="email" name="email" placeholder="Enter Email">
			</div>
		  </div>
		  <div class="control-group">
			<label class="control-label" for="password">Password</label>
			<div class="controls">
			  <input class="span3" type="password" id="password" name="password" placeholder="Enter Password">
			</div>
		  </div>
		  <div class="control-group">
			<div class="controls">
			  <button type="submit" class="btn">Sign in</button> <a href="{{url('forgot-password')}}">Forgot password?</a>
			</div>
		  </div>
		</form>
	</div>
	</div>
</div>	

</div>
@endsection