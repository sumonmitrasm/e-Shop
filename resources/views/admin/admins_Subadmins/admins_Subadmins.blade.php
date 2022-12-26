@extends('layouts.admin_layout.admin_layout')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Admin/Subadmin</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Admin/Subadmin</li>
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
                <h3 class="card-title">DataTable for Admin/Subadmin</h3>
                <a href="{{url('admin/add-edit-admin-subadmin')}}" style="max-width: 150px; float: right; display: inline-block" class="btn btn-block btn-success">Admin/Subadmin</a>
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
                <h3 class="card-title">DataTable for Admin/Subadmin</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="sections" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  	@foreach($admins_Subadmins as $admin)
                  <tr>
                    <td>{{$admin['id']}}</td>
                    <td>{{$admin['name']}}</td>
                    <td>{{$admin['email']}}</td>
                    <td>{{$admin['mobile']}}</td>
                    <td>{{$admin['type']}}</td>
                    
                    <td>
                      @if($admin['type']!="superadmin")
                      @if($admin['status'] == 1)
                      <a class="updateAdminStatus" id="admin-{{$admin['id']}}" admin_id="{{$admin['id']}}" href="javascript:void(0)"><i class="fas fa-toggle-on" aria-hidden="true" status="Active"></i></a>
                      @else
                      <a class="updateAdminStatus" id="admin-{{$admin['id']}}" admin_id="{{$admin['id']}}" href="javascript:void(0)"><i class="fas fa-toggle-off" aria-hidden="true" status="Inactive"></i></a>
                      @endif
                      @endif
                    </td>
                    <td style="width: 110px;">
                      @if($admin['type']!="superadmin")
                      <a title="set role/permission" style="color: orange;" href="{{url('admin/update-role/'.$admin['id'])}}"><i class="fas fa-unlock"></i></a>
                      &nbsp;
                      <a title="Edit Admin-subadmin" style="color: orange;" href="{{url('admin/add-edit-admin-subadmin/'.$admin['id'])}}"><i class="fas fa-plus"></i></a>
                      &nbsp;
                      <a title="Delete Admin" href="javascript:void(0)" class="confirmDelete" record="admin" recordid ="{{$admin['id']}}" style="color: red;"><i class="fas fa-trash"></i></a>
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