@extends('layouts.admin_layout.admin_layout')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Coupons</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Coupons</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            
            <!-- /.card -->

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">DataTable for Coupons</h3>
                <a href="{{url('admin/add_edit_coupon')}}" style="max-width: 150px; float: right; display: inline-block" class="btn btn-block btn-success">Add Coupon</a>
              </div>
              <div class="card-header">
                @if(Session::has('success_message'))
              <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-top: 10px;">
                <strong>{{Session::get('success_message')}}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="close">
                  <span aria-hidden="true">&times;</span></span>
                </button>
              </div>
        @endif
                <h3 class="card-title">DataTable for Coupons</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="sections" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Coupon Option</th>
                    <th>Coupon Code</th>
                    
                    <th>coupon_type</th>
                    <th>amount</th>
                    <th>expiry_date</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  	@foreach($coupons as $coupon)
                  <tr>
                    <td>{{$coupon['id']}}</td>
                    <td>{{$coupon['coupon_option']}}</td>
                    <td>{{$coupon['coupon_code']}}</td>
                    
                    <td>{{$coupon['coupon_type']}}</td>
                    <td>{{$coupon['amount']}}%</td>
                    <td>{{$coupon['expiry_date']}}</td>
                     <td>
                      @if($couponsModule['edit_access']==1 || $couponsModule['full_access']==1)
                           @if($coupon['status'] == 1)
                          <a class="updateCouponsStatus" id="coupon-{{$coupon['id']}}" coupon_id="{{$coupon['id']}}" href="javascript:void(0)"><i class="fas fa-toggle-on" aria-hidden="true" status="Active"></i></a>
                          @else
                          <a class="updateCouponsStatus" id="coupon-{{$coupon['id']}}" coupon_id="{{$coupon['id']}}" href="javascript:void(0)"><i class="fas fa-toggle-off" aria-hidden="true" status="Inactive"></i></a>
                          @endif
                      @endif
                    </td>
                    <td style="width: 110px;">
                      @if($couponsModule['edit_access']==1 || $couponsModule['full_access']==1)
                          <a title="Edit Banner" style="color: orange;" href="{{url('admin/add_edit_coupon/'.$coupon['id'])}}"><i class="fas fa-plus"></i></a>
                          &nbsp;
                      @endif
                          @if($couponsModule['full_access']==1)
                          <a title="Delete Coupon" href="javascript:void(0)" class="confirmDelete" record="coupon" recordid ="{{$coupon['id']}}" style="color: red;"><i class="fas fa-trash"></i></a>
                      @endif
                    </td>
                  </tr>
                 @endforeach
                  </tbody>
                 
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
@endsection