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
              <li class="breadcrumb-item active">Orders</li>
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
              @endif

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">DataTable for Orders</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="sections" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Order ID</th>
                    <th>Order Date</th>
                    <th>Customer Name</th>
                    
                    <th>Ordered Product</th>
                    <th>Order Ammount</th>
                    <th>Order Status</th>
                    <th>Payment Method</th>
                    <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody>
                  	@foreach($orders as $order)
                  <tr>
                    <td>{{$order['id']}}</td>
                    <td>{{ date('d-m-y', strtotime($order['created_at']))}}</td>
                    <td>{{$order['name']}}</td>
                    
                    <td>@foreach($order['orders_products'] as $pro)
                          {{$pro['product_code']}} ({{$pro['product_qty']}})<br>
                        @endforeach
                    </td>
                    <td>{{$order['grand_total']}}</td>
                    <td>{{$order['order_status']}}</td>
                    <td>{{$order['payment_method']}}</td>
                    <td>
                      @if($ordersModule['edit_access']==1 || $ordersModule['full_access']==1)
                      <a title="view Order details" href="{{url('admin/orders/'.$order['id'])}}"><i class="fas fa-file"></i></a>&nbsp;&nbsp;
                    
                      @if($order['order_status'] == "Shipped" || $order['order_status']=="Delivered")
                      <a title="view Order Invoice" href="{{url('admin/view-order-invoice/'.$order['id'])}}"><i class="fas fa-print"></i></a>
                      @endif
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