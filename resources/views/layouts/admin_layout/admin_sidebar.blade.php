<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{ asset('images/admin_images/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('images/admin_images/admin_photos/'.Auth::guard('admin')->user()->image)}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ucwords(Auth::guard('admin')->user()->name)}}</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
               <li class="nav-item">
                @if(Session::get('page')=="dashboard")
                  <?php $active = 'active';?>
                @else
                  <?php $active = ''; ?>
                @endif
            <a href="{{url('/admin/dashboard')}}" class="nav-link {{$active}}">
               <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                
              </p>
            </a>
          </li>
          <!--------Admin subadmin.........................................................180-->
          @if(Auth::guard('admin')->user()->type=="superadmin" || Auth::guard('admin')->user()->type=="admin")
           @if(Session::get('page')=="admins_subadmins")
                <?php $active = 'active';?>
             @else
                <?php $active = ''; ?>
              @endif
              <li class="nav-item">
                <a href="{{url('/admin/admins-subadmins')}}" class="nav-link {{$active}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Admin/Subadmin</p>
                </a>
              </li>
            @endif

            @if(Session::get('page')=="settings" || Session::get('page')=="update-admin-details")
                <?php $active = 'active';?>
             @else
                <?php $active = ''; ?>
              @endif
          <li class="nav-item menu-open">
            <a href="#" class="nav-link {{$active}}">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Settings
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
             @if(Session::get('page')=="settings")
                <?php $active = 'active';?>
             @else
                <?php $active = ''; ?>
              @endif
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{url('/admin/settings')}}" class="nav-link {{$active}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Update Admin Password</p>
                </a>
              </li>
               @if(Session::get('page')=="update-admin-details")
                <?php $active = 'active';?>
             @else
                <?php $active = ''; ?>
              @endif
              <li class="nav-item">
                <a href="{{url('/admin/update-admin-details')}}" class="nav-link {{$active}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Update Admin details</p>
                </a>
              </li>
            </ul>
          </li>

          <!---new--->

          @if(Session::get('page')=="sections" || Session::get('page')=="categories" || Session::get('page')=="products" || Session::get('page')=="brands")
                <?php $active = 'active';?>
             @else
                <?php $active = ''; ?>
              @endif
          <li class="nav-item menu-open">
            <a href="#" class="nav-link {{$active}}">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Catalogues
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
             @if(Session::get('page')=="sections")
                <?php $active = 'active';?>
             @else
                <?php $active = ''; ?>
              @endif
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{url('/admin/sections')}}" class="nav-link {{$active}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Sections</p>
                </a>
              </li>


               @if(Session::get('page')=="categories")
                <?php $active = 'active';?>
             @else
                <?php $active = ''; ?>
              @endif
              <li class="nav-item">
                <a href="{{url('/admin/categories')}}" class="nav-link {{$active}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Category</p>
                </a>
              </li>

              @if(Session::get('page')=="products")
                <?php $active = 'active';?>
             @else
                <?php $active = ''; ?>
              @endif
              <li class="nav-item">
                <a href="{{url('/admin/products')}}" class="nav-link {{$active}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>products</p>
                </a>
              </li>

               @if(Session::get('page')=="brands")
                <?php $active = 'active';?>
             @else
                <?php $active = ''; ?>
              @endif
              <li class="nav-item">
                <a href="{{url('/admin/brands')}}" class="nav-link {{$active}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Brands</p>
                </a>
              </li>

               @if(Session::get('page')=="banners")
                <?php $active = 'active';?>
             @else
                <?php $active = ''; ?>
              @endif
              <li class="nav-item">
                <a href="{{url('/admin/banners')}}" class="nav-link {{$active}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Banners</p>
                </a>
              </li>

               @if(Session::get('page')=="coupons")
                <?php $active = 'active';?>
             @else
                <?php $active = ''; ?>
              @endif
              <li class="nav-item">
                <a href="{{url('/admin/coupons')}}" class="nav-link {{$active}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Coupons</p>
                </a>
              </li>

              @if(Session::get('page')=="orders")
                <?php $active = 'active';?>
             @else
                <?php $active = ''; ?>
              @endif
              <li class="nav-item">
                <a href="{{url('/admin/orders')}}" class="nav-link {{$active}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Orders</p>
                </a>
              </li>

              @if(Session::get('page')=="users")
                <?php $active = 'active';?>
             @else
                <?php $active = ''; ?>
              @endif
              <li class="nav-item">
                <a href="{{url('/admin/users')}}" class="nav-link {{$active}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Useres</p>
                </a>
              </li>

            @if(Session::get('page')=="shipping_charges")
                <?php $active = 'active';?>
             @else
                <?php $active = ''; ?>
              @endif
              <li class="nav-item">
                <a href="{{url('/admin/view-shipping-charges')}}" class="nav-link {{$active}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Shipping Charges</p>
                </a>
              </li>


              @if(Session::get('page')=="cms_page")
                <?php $active = 'active';?>
             @else
                <?php $active = ''; ?>
              @endif
              <li class="nav-item">
                <a href="{{url('/admin/cms-pages')}}" class="nav-link {{$active}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>CMS Pages</p>
                </a>
              </li>


            </ul>
          </li>
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
