@extends('layouts.admin_layout.admin_layout')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Category Form</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Categories Form</li>
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
        <form name="categoryForm" id="CategoryForm" @if(empty($categorydata['id'])) action="{{url('admin/add-edit-category')}}" @else action="{{url('admin/add-edit-category/'.$categorydata['id'])}}" @endif method="post" enctype="multipart/form-data">@csrf
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
                    <label for="category_name">Category Name</label>
                    <input type="text" class="form-control" id="category_name" name="category_name"placeholder="Enter Category Name" @if(!empty($categorydata['category_name'])) value="{{$categorydata['category_name']}}" @else value="{{old('category_name')}}" @endif>
                  </div>
                <div class="form-group">
                  <label>Select Section</label>
                  <select name="section_id" id="section_id" class="form-control select2" style="width: 100%;">
                    <option value="">Select</option>
                    @foreach($getSections as $section)
                    <option value="{{$section->id}}" @if(!empty($categorydata['section_id']) && $categorydata['section_id']==$section->id) selected @endif>{{$section->name}}</option>
                    @endforeach
                  </select>
                </div>
                <!-- /.form-group -->
               <div id="appendCategoriesLevel">
               	@include('admin.categories.append_categories_level')
               </div>
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
              <div class="col-md-6">
                <div class="form-group">
                    <label for="exampleInputFile">Catgory Image</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="category_image" name="category_image">
                        <label class="custom-file-label" for="category_image">Choose file</label>
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text">Upload</span>
                      </div>
                    </div>
                    @if(!empty($categorydata['category_image']))
                      <div><img style="width: 80px; height: 50px; margin-top: 5px;" src="{{asset('images/category_images/'.$categorydata['category_image'])}}" alt="">&nbsp; 
                        <a href="javascript:void(0)" class="confirmDelete" record="category-image" recordid ="{{$categorydata['id']}}" <?php /*href="{{url('admin/delete-category-image/'.$categorydata['id'])}}"*/?>>Delete Image</a>
                      </div>
                    @endif
                  </div>
                <!-- /.form-group -->
                <div class="form-group">
                    <label for="category_discount">Category Discount</label>
                    <input type="text" class="form-control" id="category_discount" name="category_discount"placeholder="Enter Category Discount" @if(!empty($categorydata['category_discount'])) value="{{$categorydata['category_discount']}}" @else value="{{old('category_discount')}}" @endif>
                  </div>
                <div class="form-group">
                    <label for="url">Category URL</label>
                    <input type="text" class="form-control" id="url" name="url"placeholder="Enter Category URL" @if(!empty($categorydata['url'])) value="{{$categorydata['url']}}" @else value="{{old('url')}}" @endif>
                  </div>
              </div>
            </div>
            <!-- /.row -->
            <div class="row">
              <div class="col-12 col-sm-6">
              	<div class="form-group">
                    <label for="meta_title">Meta Title</label>
                    <input type="text" class="form-control" id="meta_title" name="meta_title"placeholder="Enter Category Name" @if(!empty($categorydata['meta_title'])) value="{{$categorydata['meta_title']}}" @else value="{{old('meta_title')}}" @endif>
                  </div>
                <div class="form-group">
                    <label for="description">Category Description</label>
                    <textarea name="description" id="description" class="form-control" rows="3" placeholder="Enter ..." >@if(!empty($categorydata['description'])) {{$categorydata['description']}} @else {{old('description')}} @endif</textarea>
                  </div>
              </div>
              <!-- /.col -->
              <div class="col-12 col-sm-6">
                 <div class="form-group">
                    <label for="meta_keywords">Meta Keywords</label>
                    <input type="text" class="form-control" id="meta_keywords" name="meta_keywords"placeholder="Enter Category Name" @if(!empty($categorydata['meta_keywords'])) value="{{$categorydata['meta_keywords']}}" @else value="{{old('meta_keywords')}}" @endif>
                  </div>
                 <div class="form-group">
                    <label for="meta_description">Mata Description</label>
                    <textarea name="meta_description" id="meta_description" class="form-control" rows="3" placeholder="Enter ..." >@if(!empty($categorydata['meta_description'])) {{$categorydata['meta_description']}} @else {{old('meta_description')}} @endif</textarea>
                  </div>
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