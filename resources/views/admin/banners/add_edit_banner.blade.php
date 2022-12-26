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
              <li class="breadcrumb-item active">Brand Form</li>
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
        <form name="bannerForm" id="bannerForm" @if(empty($banner['id'])) action="{{url('admin/add-edit-banner')}}" @else action="{{url('admin/add-edit-banner/'.$banner['id'])}}" @endif method="post" enctype="multipart/form-data">@csrf

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
                <div class="form-group">
                    <label for="exampleInputFile">Banner Image</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="image" name="image">
                        <label class="custom-file-label" for="image">Choose file</label>
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text">Upload</span>
                      </div>
                    </div>
                    <div>Recommended Image Size: Width:1170px; Height:480px </div>
                    @if(!empty($banner['image']))
                      <div><img style="width: 170px; height: 50px; margin-top: 5px; margin-bottom: 5px;" src="{{asset('images/banner_images/'.$banner['image'])}}" alt="">&nbsp; 
                      </div>
                    @endif
                  </div>
                <div class="form-group">
                    <label for="link">Banner link</label>
                    <input type="text" class="form-control" id="link" name="link"placeholder="Enter Banner link" @if(!empty($banner['link'])) value="{{$banner['link']}}" @else value="{{old('link')}}" @endif>
                  </div>
              </div>
              <!-- /.col -->
              <div class="col-md-6">
                
                <!-- /.form-group -->
                <div class="form-group">
                    <label for="title">Banner Title</label>
                    <input type="text" class="form-control" id="title" name="title"placeholder="Enter Banner Title" @if(!empty($banner['title'])) value="{{$banner['title']}}" @else value="{{old('title')}}" @endif>
                  </div>
                <div class="form-group">
                    <label for="alt">Bnner Alternate Text</label>
                    <input type="text" class="form-control" id="alt" name="alt"placeholder="Enter Banner Alt" @if(!empty($banner['alt'])) value="{{$banner['alt']}}" @else value="{{old('alt')}}" @endif>
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