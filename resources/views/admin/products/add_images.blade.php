@extends('layouts.admin_layout.admin_layout')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Product Image Form</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Product Images Form</li>
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
         @if(Session::has('error_message'))
              <div class="alert alert-warning alert-dismissible fade show" role="alert" style="margin-top: 10px;">
                <strong>{{Session::get('error_message')}}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="close">
                  <span aria-hidden="true">&times;</span></span>
                </button>
              </div>
        @endif
        <!-- SELECT2 EXAMPLE -->
        <form name="addImageForm" id="addImageForm" method="post" action="{{url('admin/add-images/'.$productdata['id'])}}" enctype="multipart/form-data">@csrf
          <!--<input type="hidden" name="product_id" value="{{$productdata['id']}}">-->

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
                    <label for="product_name">product Name: </label> &nbsp;{{$productdata['product_name']}}
                    
                  </div>
                  <div class="form-group">
                    <label for="product_code">product Code: </label> &nbsp;{{$productdata['product_code']}}
                  </div>
                  <div class="form-group">
                    <label for="product_color">product Color: </label> &nbsp;{{$productdata['product_color']}}
                  </div>
              </div>
              <!-- /.col -->
              <div class="col-md-6">
                  <div class="form-group">
                      <div><img style="width: 170px; height: 170px;" src="{{asset('images/product_images/small/'.$productdata['main_image'])}}" alt="">&nbsp; 
                  </div>
                  </div>
            </div>
            <div class="col-md-6">
                  <div class="form-group">
                      <div class="field_wrapper">
                          <div>
                              <input multiple="" id="images" name="images[]" type="file" name="images[]" value=""/>
                          </div>
                      </div>
                  </div>
            </div>
          </div>
          <div class="card-footer">
           <button type="submit" class="btn btn-primary">Add Images</button>
          </div>
        </div>
        </form>

        <!-- Secound form-->
        <form name="editimageForm" id="editimageForm" method="post" action="{{url('admin/edit-images/'.$productdata['id'])}}">@csrf
        <div class="card">
              <div class="card-header">
                <h3 class="card-title">DataTable Add Addisional Images Attributes</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="sections" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Images</th>
                    <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($productdata['images'] as $image)
                    <input style="display: none;" type="text" name="attrId[]" value="{{$image['id']}}">
                  <tr>
                    <td>{{$image['id']}}</td>
                    <td>
                      <img style="width: 140px; height: 140px;" src="{{asset('images/product_images/small/'.$image['image'])}}" alt="">
                    </td>
                   <td>
                     @if($image['status'] == 1)
                      <a class="updateImageStatus" id="image-{{$image['id']}}" image_id="{{$image['id']}}" href="javascript:void(0)"><i class="fas fa-toggle-on" aria-hidden="true" status="Active"></i></a>
                      @else
                      <a class="updateImageStatus" id="image-{{$image['id']}}" image_id="{{$image['id']}}" href="javascript:void(0)"><i class="fas fa-toggle-off" aria-hidden="true" status="Inactive"></i></a>
                      @endif
                       &nbsp; 
                      <a title="Delete Attribute" href="javascript:void(0)" class="confirmDelete" record="image" recordid ="{{$image['id']}}" style="color: red;"><i class="fas fa-trash"></i></a>
                   </td>
                  </tr>
                 @endforeach
                  </tbody>
                </table>
              </div>
              <div class="card-footer">
                 <button type="submit" class="btn btn-primary">Update Images</button>
          </div>
          </form>


        </div>
        


      </div>
    </section>
  </div>
@endsection