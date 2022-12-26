@extends('layouts.admin_layout.admin_layout')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Catalogue</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Shipping</li>
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
             @if(Session::has('success_message'))
              <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-top: 10px;">
                <strong>{{Session::get('success_message')}}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="close">
                  <span aria-hidden="true">&times;</span></span>
                </button>
              </div>
              <?php Session::forget('success_message');?>
              @endif

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">DataTable for Shipping</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="sections" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Shipping ID</th>
                    <th>Country</th>
                    <th>0-500g</th>
                    <th>501-1000g</th>
                    <th>1001-2000g</th>
                    <th>2001-5000g</th>
                    <th>Above-5000g</th>
                    <th>Status</th>
                    <th>Updated At</th>
                    <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody>
                  	@foreach($shipping_charges as $shipping)
                  <tr>
                    <td>{{$shipping['id']}}</td>
                    <td>{{$shipping['country']}}</td>
                    <td>INR:{{$shipping['0_500g']}}</td>
                    <td>INR:{{$shipping['501_1000g']}}</td>
                    <td>INR:{{$shipping['1001_2000g']}}</td>
                    <td>INR:{{$shipping['2001_5000g']}}</td>
                    <td>INR:{{$shipping['above_5000g']}}</td>
                    <td>
                      @if($shipping['status'] == 1)
                      <a class="updateShippingStatus" id="shipping-{{$shipping['id']}}" shipping_id ="{{$shipping['id']}}" href="javascript:void(0)"><i class="fas fa-toggle-on" aria-hidden="true" status="Active"></i></a>
                      @else
                      <a class="updateShippingStatus" id="shipping-{{$shipping['id']}}" shipping_id ="{{$shipping['id']}}" href="javascript:void(0)"><i class="fas fa-toggle-off" aria-hidden="true" status="Inactive"></i></a>
                      @endif
                    </td>
                    <td>{{ date('d-m-y', strtotime($shipping['updated_at']))}}</td>
                    </td>
                    <td style="width: 110px;">
                      <a title="Update Shipping Charges" style="color: orange;" href="{{url('admin/update_shipping_charges/'.$shipping['id'])}}"><i class="fas fa-edit"></i></a>
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