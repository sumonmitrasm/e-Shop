@extends('layouts.admin_layout.admin_layout')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Brand Form</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Sgipping Charges</li>
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
              <?php Session::forget('success_message');?>
        @endif
        <!-- SELECT2 EXAMPLE -->
        <form name="shippingChargesForm" id="shippingChargesForm" action="{{url('admin/update_shipping_charges/'.$shippingDetails['id'])}}" method="post" enctype="multipart/form-data">@csrf

        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title"></h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
              <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times">Update Shipping Charges</i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
              	<div class="form-group">
                    <label for="meta_title">Shipping Country</label>
                    <input readonly class="form-control" id="country" name="country" @if(!empty($shippingDetails['country'])) value="{{$shippingDetails['country']}}" @else value="{{old('country')}}" @endif>
                  </div>
              <div class="form-group">
                    <label for="meta_title">Shipping Charges(0_500g)</label>
                    <input type="text" class="form-control" id="0_500g" name="0_500g"placeholder="Enter 0_500g" @if(!empty($shippingDetails['0_500g'])) value="{{$shippingDetails['0_500g']}}" @else value="{{old('0_500g')}}" @endif>
                  </div>
                  <div class="form-group">
                    <label for="meta_title">Shipping Charges(501_1000g)</label>
                    <input type="text" class="form-control" id="501_1000g" name="501_1000g"placeholder="Enter 501_1000g" @if(!empty($shippingDetails['501_1000g'])) value="{{$shippingDetails['501_1000g']}}" @else value="{{old('501_1000g')}}" @endif>
                  </div>
                  <div class="form-group">
                    <label for="meta_title">Shipping Charges(1001_2000g)</label>
                    <input type="text" class="form-control" id="1001_2000g" name="1001_2000g"placeholder="Enter 1001_2000g" @if(!empty($shippingDetails['1001_2000g'])) value="{{$shippingDetails['1001_2000g']}}" @else value="{{old('1001_2000g')}}" @endif>
                  </div>
                  <div class="form-group">
                    <label for="meta_title">Shipping Charges(2001_5000g)</label>
                    <input type="text" class="form-control" id="2001_5000g" name="2001_5000g"placeholder="Enter 2001_5000g" @if(!empty($shippingDetails['2001_5000g'])) value="{{$shippingDetails['2001_5000g']}}" @else value="{{old('2001_5000g')}}" @endif>
                  </div>
                  <div class="form-group">
                    <label for="meta_title">Shipping Charges(above_5000g)</label>
                    <input type="text" class="form-control" id="above_5000g" name="above_5000g"placeholder="Enter above_5000g" @if(!empty($shippingDetails['above_5000g'])) value="{{$shippingDetails['above_5000g']}}" @else value="{{old('above_5000g')}}" @endif>
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
