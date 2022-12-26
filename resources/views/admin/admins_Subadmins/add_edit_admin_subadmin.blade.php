@extends('layouts.admin_layout.admin_layout')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Admin/Subadmin Form</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Admin/Subadmin Form</li>
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
      @if(Session::has('error_message'))
              <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-top: 10px;">
                <strong>{{Session::get('error_message')}}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="close">
                  <span aria-hidden="true">&times;</span></span>
                </button>
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
    <form name="adminForm" id="adminForm" @if(empty($admindata['id'])) action="{{url('admin/add-edit-admin-subadmin')}}" @else action="{{url('admin/add-edit-admin-subadmin/'.$admindata['id'])}}" @endif method="post" enctype="multipart/form-data">@csrf
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">{{$title}}</h3>

            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
              <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
              	<div class="form-group">
                    <label for="name">Admin Name</label>
                    <input type="text" class="form-control" id="name" name="name"placeholder="Enter Admin/Subadmin Name" @if(!empty($admindata['name'])) value="{{$admindata['name']}}" @else value="{{old('name')}}" @endif>
                  </div>
                   <div class="form-group">
                  <label>Admin Type</label>
                  <select name="admin_type" id="admin_type" class="form-control select2" style="width: 100%;">
                    <option value="">Select</option>
                    <option value="admin" @if(!empty($admindata['type']) && $admindata['type']=="admin") selected="" @endif>Admin</option>
                    <option value="subadmin" @if(!empty($admindata['type']) && $admindata['type']=="subadmin") selected="" @endif>Sub-Admin</option>
                  </select>
                </div> 
                <div class="form-group">
                    <label for="mobile">Mobile</label>
                    <input type="text" class="form-control" id="mobile" name="mobile"placeholder="Enter admin mobile" @if(!empty($admindata['mobile'])) value="{{$admindata['mobile']}}" @else value="{{old('mobile')}}" @endif>
                  </div>
                  
              </div>
              <!-- /.col -->
              <div class="col-md-6">
                  <div class="form-group">
                    <label for="password">Admin Passward</label>
                    <input type="password" class="form-control" id="password" name="password"placeholder="Enter password">
                  </div>
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input @if($admindata['id']!="") disabled="" @else required="" @endif type="text" class="form-control" id="email" name="email"placeholder="Enter product Discount" @if(!empty($admindata['email'])) value="{{$admindata['email']}}" @else value="{{old('email')}}" @endif>
                  </div>
                  <div class="form-group">
                    <label for="admin_image">Admin Image</label>
                    <input type="file" class="form-control" id="admin_image" name="admin_image" placeholder="Please enter admin Image">
                    @if(!empty($admindata['image']))
                    <a target="_blank" href="{{url('images/admin_images/admin_photos/'.$admindata['image'])}}">View Image</a>
                    <input type="hidden" name="current_admin_image" value="{{$admindata['image']}}">
                    @endif
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