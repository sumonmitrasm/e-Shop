@extends('layouts.admin_layout.admin_layout')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>CMS PAGE Form</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">CMS PAGE Form</li>
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
        <form name="cmspageForm" id="cmspageForm" @if(empty($cmspage['id'])) action="{{url('admin/add-edit-cms-page')}}" @else action="{{url('admin/add-edit-cms-page/'.$cmspage['id'])}}" @endif method="post" enctype="multipart/form-data">@csrf

        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title"></h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
              <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times">{{$title}}</i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
              <div class="form-group">
                    <label for="meta_title">Title</label>
                    <input type="text" class="form-control" id="title" name="title"placeholder="Enter CMS PAGE Title" @if(!empty($cmspage['title'])) value="{{$cmspage['title']}}" @else value="{{old('title')}}" @endif>
                  </div>
                  
                  <div class="form-group">
                    <label for="meta_title">Discription</label>
                    <input type="text" class="form-control" id="description" name="description"placeholder="Enter CMS PAGE Title" @if(!empty($cmspage['description'])) value="{{$cmspage['description']}}" @else value="{{old('description')}}" @endif>
                  </div>

                  <div class="form-group">
                    <label for="meta_title">URL</label>
                    <input type="text" class="form-control" id="url" name="url"placeholder="Enter CMS PAGE Title" @if(!empty($cmspage['url'])) value="{{$cmspage['url']}}" @else value="{{old('url')}}" @endif>
                  </div>
              </div>
              <div class="col-md-6">
              <div class="form-group">
                    <label for="meta_title">Meta Title</label>
                    <input type="text" class="form-control" id="meta_title" name="meta_title"placeholder="Enter CMS PAGE Title" @if(!empty($cmspage['meta_title'])) value="{{$cmspage['meta_title']}}" @else value="{{old('meta_title')}}" @endif>
                  </div>
                  <div class="form-group">
                    <label for="meta_title">Meta Description</label>
                    <input type="text" class="form-control" id="meta_description" name="meta_description"placeholder="Enter CMS PAGE Title" @if(!empty($cmspage['meta_description'])) value="{{$cmspage['meta_description']}}" @else value="{{old('meta_description')}}" @endif>
                  </div>
                  <div class="form-group">
                    <label for="meta_title">Meta Keywords</label>
                    <input type="text" class="form-control" id="meta_keywords" name="meta_keywords"placeholder="Enter CMS PAGE Title" @if(!empty($cmspage['meta_keywords'])) value="{{$cmspage['meta_keywords']}}" @else value="{{old('meta_keywords')}}" @endif>
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