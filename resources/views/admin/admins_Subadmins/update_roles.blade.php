@extends('layouts.admin_layout.admin_layout')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{$titles}}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">{{$titles}}</li>
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
        <form name="AdminForm" id="adminForm" method="post" action="{{url('admin/update-role/'.$adminDetails['id'])}}">@csrf

        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title"></h3>
            <div class="card-tools">
              <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
              </button>
              <button type="button" class="btn btn-tool" data-card-widget="remove">
                <i class="fas fa-times">{{$titles}}</i>
              </button>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
               <?php //echo "<pre>";print_r($adminRoles) ?>
               @if(!empty($adminRoles))
                @foreach($adminRoles as $role)
                  @if($role['module']=='categories')
                    @if($role['view_access']==1)
                      @php $viewCategories = "checked"; @endphp
                    @else
                      @php $viewCategories = ""; @endphp
                    @endif
                    @if($role['edit_access']==1)
                      @php $editCategories = "checked"; @endphp
                    @else
                      @php $editCategories = ""; @endphp
                    @endif
                    @if($role['full_access']==1)
                      @php $fullCategories = "checked"; @endphp
                    @else
                      @php $fullCategories = ""; @endphp
                    @endif
                  @endif
                @endforeach
               @endif
              <div class="form-group">
                    <label for="categories" class="col-md-3">Categories</label>
                    <div class="col-md-9">
                        <input type="checkbox" name="categories[view]" value="1" @if(isset($viewCategories)) {{$viewCategories}} @endif>&nbsp;View Access &nbsp;&nbsp;

                        <input type="checkbox" name="categories[edit]" value="1" @if(isset($editCategories))  {{$editCategories}} @endif>&nbsp;View/Edit Access &nbsp;&nbsp;

                        <input type="checkbox" name="categories[full]" value="1" @if(isset($fullCategories))  {{$fullCategories}} @endif>&nbsp;Full Access &nbsp;&nbsp;
                    </div>
                  </div>
                @if(!empty($adminRoles))
                @foreach($adminRoles as $role)
                  @if($role['module']=='products')
                    @if($role['view_access']==1)
                      @php $viewproducts = "checked"; @endphp
                    @else
                      @php $viewproducts = ""; @endphp
                    @endif
                    @if($role['edit_access']==1)
                      @php $editproducts = "checked"; @endphp
                    @else
                      @php $editproducts = ""; @endphp
                    @endif
                    @if($role['full_access']==1)
                      @php $fullproducts = "checked"; @endphp
                    @else
                      @php $fullproducts= ""; @endphp
                    @endif
                  @endif
                @endforeach
               @endif
                  <div class="form-group">
                    <label for="products" class="col-md-3">Products</label>
                    <div class="col-md-9">
                        <input type="checkbox" name="products[view]" value="1" @if(isset($viewproducts)) {{$viewproducts}} @endif>&nbsp;View Access &nbsp;&nbsp;
                        <input type="checkbox" name="products[edit]" value="1" @if(isset($editproducts)) {{$editproducts}} @endif>&nbsp;View/Edit Access &nbsp;&nbsp;
                        <input type="checkbox" name="products[full]" value="1" @if(isset($fullproducts)) {{$fullproducts}} @endif>&nbsp;Full Access &nbsp;&nbsp;
                    </div>
                  </div>
              @if(!empty($adminRoles))
                @foreach($adminRoles as $role)
                  @if($role['module']=='coupons')
                    @if($role['view_access']==1)
                      @php $viewcoupons = "checked"; @endphp
                    @else
                      @php $viewcoupons = ""; @endphp
                    @endif
                    @if($role['edit_access']==1)
                      @php $editcoupons = "checked"; @endphp
                    @else
                      @php $editcoupons = ""; @endphp
                    @endif
                    @if($role['full_access']==1)
                      @php $fullcoupons = "checked"; @endphp
                    @else
                      @php $fullcoupons= ""; @endphp
                    @endif
                  @endif
                @endforeach
               @endif
                  <div class="form-group">
                    <label for="coupons" class="col-md-3">Coupons</label>
                    <div class="col-md-9">
                        <input type="checkbox" name="coupons[view]" value="1" @if(isset($viewcoupons)) {{$viewcoupons}} @endif>&nbsp;View Access &nbsp;&nbsp;
                        <input type="checkbox" name="coupons[edit]" value="1" @if(isset($editcoupons)) {{$editcoupons}} @endif>&nbsp;View/Edit Access &nbsp;&nbsp;
                        <input type="checkbox" name="coupons[full]" value="1" @if(isset($fullcoupons)) {{$fullcoupons}} @endif>&nbsp;Full Access &nbsp;&nbsp;
                    </div>
                  </div>
              @if(!empty($adminRoles))
                @foreach($adminRoles as $role)
                  @if($role['module']=='orders')
                    @if($role['view_access']==1)
                      @php $vieworders = "checked"; @endphp
                    @else
                      @php $vieworders = ""; @endphp
                    @endif
                    @if($role['edit_access']==1)
                      @php $editorders = "checked"; @endphp
                    @else
                      @php $editorders = ""; @endphp
                    @endif
                    @if($role['full_access']==1)
                      @php $fullorders = "checked"; @endphp
                    @else
                      @php $fullorders= ""; @endphp
                    @endif
                  @endif
                @endforeach
               @endif
                  <div class="form-group">
                    <label for="orders" class="col-md-3">Orders</label>
                    <div class="col-md-9">
                        <input type="checkbox" name="orders[view]" value="1" @if(isset($vieworders)) {{$vieworders}} @endif>&nbsp;View Access &nbsp;&nbsp;
                        <input type="checkbox" name="orders[edit]" value="1" @if(isset($editorders)) {{$editorders}} @endif>&nbsp;View/Edit Access &nbsp;&nbsp;
                        <input type="checkbox" name="orders[full]" value="1" @if(isset($fullorders)){{$fullorders}} @endif>&nbsp;Full Access &nbsp;&nbsp;
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