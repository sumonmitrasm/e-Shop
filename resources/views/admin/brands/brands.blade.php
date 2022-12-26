@extends('layouts.admin_layout.admin_layout')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Brands</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Brands</li>
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
                <h3 class="card-title">DataTable for Brands</h3>
                <a href="{{url('admin/add-edit-brand')}}" style="max-width: 150px; float: right; display: inline-block" class="btn btn-block btn-success">Add Brand</a>
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
                <h3 class="card-title">DataTable for Brands</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="sections" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  	@foreach($brands as $brand)
                  <tr>
                    <td>{{$brand->id}}</td>
                    <td>{{$brand->name}}</td>
                    <td>
                    	@if($brand->status == 1)
                    	<a class="updateBrandStatus" id="brand-{{$brand->id}}" brand_id="{{$brand->id}}" href="javascript:void(0)"><i class="fas fa-toggle-on" aria-hidden="true" status="Active"></i></a>
                    	@else
                    	<a class="updateBrandStatus" id="brand-{{$brand->id}}" brand_id="{{$brand->id}}" href="javascript:void(0)"><i class="fas fa-toggle-off" aria-hidden="true" status="Inactive"></i></a>
                    	@endif

                    </td>
                    <td style="width: 110px;">
                      <a title="Edit Brand" style="color: orange;" href="{{url('admin/add-edit-brand/'.$brand->id)}}"><i class="fas fa-plus"></i></a>
                      &nbsp;
                      <a title="Delete Product" href="javascript:void(0)" class="confirmDelete" record="brand" recordid ="{{$brand->id}}" style="color: red;"><i class="fas fa-trash"></i></a>
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