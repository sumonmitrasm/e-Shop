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
         @if(Session::has('error_message'))
              <div class="alert alert-warning alert-dismissible fade show" role="alert" style="margin-top: 10px;">
                <strong>{{Session::get('error_message')}}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="close">
                  <span aria-hidden="true">&times;</span></span>
                </button>
              </div>
        @endif
        <!-- SELECT2 EXAMPLE -->
        <form name="attributeForm" id="attributeForm" method="post" action="{{url('admin/add-attributes/'.$productdata['id'])}}">@csrf
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
                              <input id="size" name="size[]" type="text" name="size[]" value="" placeholder="Size" style="width: 110px;"/>
                              <input id="price" name="price[]" type="number" name="price[]" value="" placeholder="Price" style="width: 110px;" />
                              <input id="stock" name="stock[]" type="number" name="stock[]" value="" placeholder="Stock" style="width: 110px;" />
                              <input id="sku" name="sku[]" type="text" name="sku[]" value="" placeholder="SKU" style="width: 110px;"/>
                             

                              <a href="javascript:void(0);" class="add_button" style="color: orange;" title="Add field">Add</a>
                          </div>
                      </div>
                  </div>
            </div>
          </div>
          <div class="card-footer">
           <button type="submit" class="btn btn-primary">Add Attribute</button>
          </div>
        </div>
        </form>

        <!-- Secound form-->
        <form name="editattributeForm" id="editattributeForm" method="post" action="{{url('admin/edit-attributes/'.$productdata['id'])}}">@csrf
        <div class="card">
              <div class="card-header">
                <h3 class="card-title">DataTable Add Product Attributes</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="products" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Size</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>SKU</th>
                    <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($productdata['attributes'] as $attribute)
                    <input style="display: none;" type="text" name="attrId[]" value="{{$attribute['id']}}">
                  <tr>
                    <td>{{$attribute['id']}}</td>
                    <td>{{$attribute['size']}}</td>
                    <td>
                      <input type="number" name="price[]" value="{{$attribute['price']}}" required="">
                    </td>
                    <td>
                      <input type="number" name="stock[]" value="{{$attribute['stock']}}" required="">
                    </td>
                   <td>
                    <input type="text" name="sku[]" value="{{$attribute['sku']}}" required="">
                   </td>
                   <td>
                     
                       @if($attribute['status'] == 1)
                      <a class="updateAttributStatus" id="attribute-{{$attribute['id']}}" attribute_id="{{$attribute['id']}}" href="javascript:void(0)"><i class="fas fa-toggle-on" aria-hidden="true" status="Active"></i></a>
                      @else
                      <a class="updateAttributStatus" id="attribute-{{$attribute['id']}}" attribute_id="{{$attribute['id']}}" href="javascript:void(0)"><i class="fas fa-toggle-off" aria-hidden="true" status="Inactive"></i></a>
                      @endif
                       &nbsp; 
                      <a title="Delete Attribute" href="javascript:void(0)" class="confirmDelete" record="attribute" recordid ="{{$attribute['id']}}" style="color: red;"><i class="fas fa-trash"></i></a>

                   </td>
                  </tr>
                 @endforeach
                  </tbody>
                </table>
              </div>
              <div class="card-footer">
                 <button type="submit" class="btn btn-primary">Update Attributes</button>
          </div>
          </form>


        </div>
        


      </div>
    </section>
  </div>
@endsection