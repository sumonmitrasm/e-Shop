@extends('layouts.admin_layout.admin_layout')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>product Form</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Products Form</li>
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
        <form name="productForm" id="productForm" @if(empty($productdata['id'])) action="{{url('admin/add-edit-product')}}" @else action="{{url('admin/add-edit-product/'.$productdata['id'])}}" @endif method="post" enctype="multipart/form-data">@csrf
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
                  <label>Select Category</label>
                  <select name="category_id" id="category_id" class="form-control select2" style="width: 100%;">
                    <option value="">Select</option>
                    @foreach($categories as $section)
                    <optgroup label="{{$section['name']}}"></optgroup>

                    @foreach($section['categories'] as $category)
          <option value="{{$category['id']}}"  @if(!empty(@old('category_id')) && $category['id']==@old('category_id')) selected=""

           @elseif(!empty($productdata['category_id']) && $productdata['category_id'] == $category['id']) selected="" @endif>&nbsp;&raquo;&nbsp;{{$category['category_name']}}</option>


                    @foreach($category['subcategories'] as $subcategory)
                      <option value="{{$subcategory['id']}}" @if(!empty(@old('category_id')) && $subcategory['id']==@old('category_id')) selected="" 

                      @elseif(!empty($productdata['category_id']) && $productdata['category_id'] == $subcategory['id']) selected="" @endif>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;--&nbsp;&nbsp;{{$subcategory['category_name']}}</option>
                     @endforeach
                    @endforeach
                  @endforeach
                  </select>
                </div>
                <div class="form-group">
                  <label>Select Brand</label>
                  <select name="brand_id" id="brand_id" class="form-control select2" style="width: 100%;">
                    <option value="">Select</option>
                    @foreach($brands as $brand)
                    <option value="{{$brand['id']}}" @if(!empty($productdata['brand_id']) && $productdata['brand_id']==$brand['id']) selected="" @endif>{{$brand['name']}}</option>
                    @endforeach
                  </select>
                </div> 
              	<div class="form-group">
                    <label for="product_name">product Name</label>
                    <input type="text" class="form-control" id="product_name" name="product_name"placeholder="Enter product Name" @if(!empty($productdata['product_name'])) value="{{$productdata['product_name']}}" @else value="{{old('product_name')}}" @endif>
                  </div>
                  <div class="form-group">
                    <label for="product_code">product Code</label>
                    <input type="text" class="form-control" id="product_code" name="product_code"placeholder="Enter product Code" @if(!empty($productdata['product_code'])) value="{{$productdata['product_code']}}" @else value="{{old('product_code')}}" @endif>
                  </div>
                  <div class="form-group">
                    <label for="product_color">product Color</label>
                    <input type="text" class="form-control" id="product_color" name="product_color"placeholder="Enter product Color" @if(!empty($productdata['product_color'])) value="{{$productdata['product_color']}}" @else value="{{old('product_color')}}" @endif>
                  </div>
                 <div class="form-group">
                    <label for="product_video">Products Video</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="product_video" name="product_video">
                        <label class="custom-file-label" for="product_video">Choose file</label>
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text" id="">Upload</span>
                      </div>
                    </div>
                    @if(!empty($productdata['product_video']))
                    <a href="{{asset('videos/product_videos/'.$productdata['product_video'])}}" download>Downlode</a>
                      &nbsp; |&nbsp;
                       <a href="javascript:void(0)" class="confirmDelete" record="product-video" recordid ="{{$productdata['id']}}">Delete Video</a>
                    @endif
                  </div>
                  <div class="form-group">
                    <label for="meta_title">Meta Title</label>
                    <input type="text" class="form-control" id="meta_title" name="meta_title"placeholder="Enter product Name" @if(!empty($productdata['meta_title'])) value="{{$productdata['meta_title']}}" @else value="{{old('meta_title')}}" @endif>
                  </div>
                  <div class="form-group">
                    <label for="meta_description">Mata Description</label>
                    <textarea name="meta_description" id="meta_description" class="form-control" rows="3" placeholder="Enter ..." >@if(!empty($productdata['meta_description'])) {{$productdata['meta_description']}} @else {{old('meta_description')}} @endif</textarea>
                  </div>
                
                <!-- /.form-group -->
               
                <!-- /.form-group -->
              </div>
              <!-- /.col -->
              <div class="col-md-6">
                
                 
                  <div class="form-group">
                    <label for="product_weight">product Weight</label>
                    <input type="text" class="form-control" id="product_weight" name="product_weight"placeholder="Enter product Name" @if(!empty($productdata['product_weight'])) value="{{$productdata['product_weight']}}" @else value="{{old('product_weight')}}" @endif>
                  </div>
                 

                  <div class="form-group">
                    <label for="main_image">Products Main Image</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="main_image" name="main_image">
                        <label class="custom-file-label" for="main_image">Choose file</label>
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text" id="">Upload</span>
                      </div>
                    </div>
                    <div>Recommended Image Size: Width:1040px; Height:1200px </div>
                    @if(!empty($productdata['main_image']))
                      <div><img style="width: 80px; height: 50px; margin-top: 5px;" src="{{asset('images/product_images/small/'.$productdata['main_image'])}}" alt="">&nbsp; 
                        
                        <a href="javascript:void(0)" class="confirmDelete" record="product-image" recordid ="{{$productdata['id']}}" <?php /*href="{{url('admin/delete-category-image/'.$productdata['id'])}}"*/?>>Delete Image</a>
                      </div>
                    @endif
                  </div>

                  <div class="form-group">
                    <label for="product_discount">product Discount(%)</label>
                    <input type="text" class="form-control" id="product_discount" name="product_discount"placeholder="Enter product Discount" @if(!empty($productdata['product_discount'])) value="{{$productdata['product_discount']}}" @else value="{{old('product_discount')}}" @endif>
                  </div>
                  <div class="form-group">
                    <label for="description">product Description</label>
                    <textarea name="description" id="description" class="form-control" rows="3" placeholder="Enter ..." >@if(!empty($productdata['description'])) {{$productdata['description']}} @else {{old('description')}} @endif</textarea>
                  </div>
                  <div class="form-group">
                    <label for="wash_care">Wash Care</label>
                    <textarea name="wash_care" id="wash_care" class="form-control" rows="3" placeholder="Enter ..." >@if(!empty($productdata['wash_care'])) {{$productdata['wash_care']}} @else {{old('wash_care')}} @endif</textarea>
                  </div>

            

                  <div class="form-group">
                    <label for="meta_keywords">Meta Keywords</label>
                    <input type="text" class="form-control" id="meta_keywords" name="meta_keywords"placeholder="Enter product Name" @if(!empty($productdata['meta_keywords'])) value="{{$productdata['meta_keywords']}}" @else value="{{old('meta_keywords')}}" @endif>
                  </div>
                   <div class="form-group">
                    <label for="product_price">Product Price</label>
                    <input type="text" class="form-control" id="product_price" name="product_price"placeholder="Enter product Price" @if(!empty($productdata['product_price'])) value="{{$productdata['product_price']}}" @else value="{{old('product_price')}}" @endif>
                  </div>

            </div>
            <!-- /.row -->
            <div class="col-12 col-sm-6">
              <div class="form-group">
                  <label>Select Fabric</label>
                  <select name="fabric" id="fabric" class="form-control select2" style="width: 100%;">
                    <option value="">Select</option>
                    @foreach($fabricArray as $fabric)
                    <option value="{{$fabric}}" @if(!empty($productdata['fabric']) && $productdata['fabric'] ==$fabric) selected="" @endif>{{$fabric}}</option>
                    @endforeach
                  </select>
                </div> 
            </div>
            <div class="col-12 col-sm-6">
              <div class="form-group">
                  <label>Select Sleeve</label>
                  <select name="sleeve" id="sleeve" class="form-control select2" style="width: 100%;">
                    <option value="">Select</option>
                    @foreach($sleeveArray as $sleeve)
                    <option value="{{$sleeve}}" @if(!empty($productdata['sleeve']) && $productdata['sleeve']==$sleeve) selected="" @endif>{{$sleeve}}</option>
                    @endforeach
                  </select>
                </div> 
            </div>
            <div class="col-12 col-sm-6">
              <div class="form-group">
                  <label>Select Pattern</label>
                  <select name="pattern" id="pattern" class="form-control select2" style="width: 100%;">
                    <option value="">Select</option>
                    @foreach($patternArray as $pattern)
                    <option value="{{$pattern}}"  @if(!empty($productdata['pattern']) && $productdata['pattern']==$pattern) selected="" @endif>{{$pattern}}</option>
                    @endforeach
                  </select>
                </div> 
            </div>
            <div class="col-12 col-sm-6">
              <div class="form-group">
                  <label>Select Fit</label>
                  <select name="fit" id="fit" class="form-control select2" style="width: 100%;">
                    <option value="">Select</option>
                    @foreach($fitArray as $fit)
                    <option value="{{$fit}}" @if(!empty($productdata['fit']) && $productdata['fit']==$fit) selected="" @endif>{{$fit}}</option>
                    @endforeach
                  </select>
                </div> 
            </div>
            <div class="col-12 col-sm-6">
              <div class="form-group">
                  <label>Select Occassion</label>
                  <select name="occassion" id="occassion" class="form-control select2" style="width: 100%;">
                    <option value="">Select</option>
                    @foreach($occassionArray as $occassion)
                    <option value="{{$occassion}}" @if(!empty($productdata['occassion']) && $productdata['occassion']==$occassion) selected="" @endif>{{$occassion}}</option>
                    @endforeach
                  </select>
                </div> 
            </div>
            <div class="col-12 col-sm-6">
              <div class="form-group">
                  <label>Featured Item</label>
                  <input type="checkbox" name="is_featured" id="is_featured" value="yes" @if(!empty($productdata['is_featured']) && $productdata['is_featured']=="Yes") checked="" @endif placeholder="">
                </div> 
            </div>

             <div class="form-group">
                <label for="group_code">Group Code</label>
                <input type="text" class="form-control" id="group_code" name="group_code"placeholder="Enter Group Code" @if(!empty($productdata['group_code'])) value="{{$productdata['group_code']}}" @else value="{{old('group_code')}}" @endif>
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