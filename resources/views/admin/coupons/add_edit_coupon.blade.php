@extends('layouts.admin_layout.admin_layout')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Coupon Form</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Coupon Form</li>
            </ol>
          </div>
        </div>
      </div>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
      	@if ($errors->any())
    		<div class="alert alert-danger" style="margin-top: 10px;">
	        <ul>
	            @foreach ($errors->all() as $error)
	                <li>{{ $error }}</li>
	            @endforeach
	        </ul>
	    </div>
	    @endif

      @if(Session::has('success_message'))
              <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-top: 10px;">
                <strong>{{Session::get('success_message')}}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="close">
                  <span aria-hidden="true">&times;</span></span>
                </button>
              </div>
        @endif
        <!-- SELECT2 EXAMPLE -->
        <form name="couponForm" id="couponForm" @if(empty($coupon['id'])) action="{{url('admin/add_edit_coupon')}}" @else action="{{url('admin/add_edit_coupon/'.$coupon['id'])}}" @endif method="post" enctype="multipart/form-data">@csrf

        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title"></h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
              <button type="button" class="btn btn-tool" data-card-widget="remove"><br>
                <i class="fas fa-times">{{$title}}</i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                @if(empty($coupon['coupon_code']))
                <div class="form-group">
                    <label for="coupon_option">Coupon Option</label>&nbsp;<br>
                    <span><input type="radio" checked="" id="AutomaticCoupon" name="coupon_option" value="Automatic">&nbsp;Automatic&nbsp;&nbsp;
                    <span><input type="radio" id="ManualCoupon" name="coupon_option" value="Manual">&nbsp;Manual&nbsp;&nbsp;
                  </div>
                  <div class="form-group" style="display:none;" id="couponFild">
                    <label for="coupon_code">Coupon Code</label>
                    <input type="text" class="form-control" id="coupon_code" name="coupon_code"placeholder="Enter Coupon Code">
                  </div>
                  @else
                  <div class="form-group">
                    <input type="hidden" name="coupon_option" value="{{$coupon['coupon_option']}}">
                    <input type="hidden" name="coupon_code" value="{{$coupon['coupon_code']}}">
                    <label for="coupon_code">Coupon Code</label>
                    <span>{{$coupon['coupon_code']}}</span>
                  </div>
                  @endif
                 

                  <div class="form-group">
                    <label for="coupon_option">Coupon Type</label>&nbsp;<br>
                    <span><input type="radio" name="coupon_type" value="Multiple Times" @if(isset($coupon['coupon_type'])&& $coupon['coupon_type']=="Multiple Times") checked="" @elseif(!isset($coupon['coupon_type'])) checked="" @endif>&nbsp;Multiple Times&nbsp;&nbsp;
                    <span><input type="radio"  name="coupon_type" value="Single Times"  @if(isset($coupon['coupon_type'])&& $coupon['coupon_type']=="Single Times") checked="" @endif>&nbsp;Single Times&nbsp;&nbsp;
                  </div>

                  <div class="form-group">
                    <label for="amount_type">Amount Type</label>&nbsp;<br>
                    <span><input type="radio" name="amount_type" value="Percentage" @if(isset($coupon['amount_type'])&& $coupon['amount_type']=="Percentage") checked="" @elseif(!isset($coupon['amount_type'])) checked="" @endif>&nbsp;Percentage&nbsp;(in %)&nbsp;
                    <span><input type="radio"  name="amount_type" value="Fixed" @if(isset($coupon['amount_type'])&& $coupon['amount_type']=="Fixed") checked="" @endif>&nbsp;Fixed&nbsp;(in INR or USD)&nbsp;
                  </div>

                   <div class="form-group" id="couponFild">
                    <label for="amount">Amount</label>
                    <input type="number" class="form-control" id="amount" name="amount" placeholder="Enter Amount" @if(isset($coupon['amount'])) value="{{$coupon['amount']}}" @endif>
                  </div>
              
              <!-- /.col -->
               <div class="form-group">
                    <label for="users">Select Users</label>
                    <select name="users[]" class="form-control select2" multiple="" data-live-search="true"> <!--data-live-search -->
                    <option value="">Select</option>
                    @foreach($users as $user)
                    <option value="{{$user['email']}}" @if (in_array($user['email'],$selUsers)) selected="" @endif>{{$user['email']}}</option>}
                  @endforeach
                  </select>
                  </div>
                
                <!-- /.form-group 115-->
                <div class="form-group">
                    <label for="categories">Select Categories</label>
                    <select name="categories[]"  class="form-control select2" multiple="">
                    <option value="">Select</option>
                    @foreach($categories as $section)
                    <optgroup label="{{$section['name']}}"></optgroup>

                    @foreach($section['categories'] as $category)
                      <option value="{{$category['id']}}" @if (in_array($category['id'],$selCats)) selected="" @endif>&nbsp;&raquo;&nbsp;{{$category['category_name']}}</option>
                    @foreach($category['subcategories'] as $subcategory)
                      <option value="{{$subcategory['id']}}" @if (in_array($subcategory['id'],$selCats)) selected="" @endif>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;--&nbsp;&nbsp;{{$subcategory['category_name']}}</option>
                     @endforeach
                    @endforeach
                  @endforeach
                  </select>
                  </div>

                <div class="form-group">
                    <label for="expiry_date">Expiry Date</label>
                     <input type="date" class="form-control" id="expiry_date" name="expiry_date" placeholder="Enter Expiry Date" data-inputmask-alias="datetime" data-inputmask-inputformat="yyyy/mm/dd/" data-mask @if(isset($coupon['expiry_date'])) value="{{$coupon['expiry_date']}}" @endif>
                  </div>
             </div>
          </div>
          <div class="card-footer">
           <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </div>
        </form>
      </div>
    </section>
  </div>
@endsection