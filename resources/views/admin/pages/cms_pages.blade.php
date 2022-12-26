@extends('layouts.admin_layout.admin_layout')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>CMS PAGES</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">CMS PAGES</li>
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
                <h3 class="card-title">DataTable for CMS PAGES</h3>
                <a href="{{url('admin/add-edit-cms-page')}}" style="max-width: 150px; float: right; display: inline-block" class="btn btn-block btn-success">Add CMS PAGE</a>
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
                <h3 class="card-title">DataTable for CMS PAGES</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="sections" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>title</th>
                    <th>url</th>
                    <th>meta_title</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  	@foreach($cms_pages as $cms)
                  <tr>
                    <td>{{$cms['id']}}</td>
                    <td>{{$cms['title']}}</td>
                    <td>{{$cms['url']}}</td>
                    <td>{{$cms['meta_title']}}</td>
                    <td>
                    	@if($cms['status'] == 1)
                    	<a class="updateSmsPageStatus" id="cms-{{$cms['id']}}" cms_id="{{$cms['id']}}" href="javascript:void(0)"><i class="fas fa-toggle-on" aria-hidden="true" status="Active"></i></a>
                    	@else
                    	<a class="updateSmsPageStatus" id="cms-{{$cms['id']}}" cms_id="{{$cms['id']}}" href="javascript:void(0)"><i class="fas fa-toggle-off" aria-hidden="true" status="Inactive"></i></a>
                    	@endif

                    </td>
                    <td style="width: 110px;">
                      <a title="Edit cms" style="color: orange;" href="{{url('admin/add-edit-cms-page/'.$cms['id'])}}"><i class="fas fa-plus"></i></a>
                      &nbsp;
                      <a title="Delete cmspage" href="javascript:void(0)" class="confirmDelete" record="cms" recordid ="{{$cms['id']}}" style="color: red;"><i class="fas fa-trash"></i></a>
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