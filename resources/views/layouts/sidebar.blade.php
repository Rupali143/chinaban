<!-- Main Sidebar Container -->

  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="" class="brand-link">
      <img src="{{asset('dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Chinaban App</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="{{ route('admin.category') }}" class="nav-link">
            <i class="nav-icon far fa-image"></i>
            <p>
             Manage Categories
            </p>
          </a>
        </li>
          <li class="nav-item">
            <a href="{{ route('product.index') }}" class="nav-link">
              <i class="nav-icon far fa-image"></i>
              <p>
                Manage Products
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('admin.user') }}" class="nav-link">
              <i class="nav-icon far fa-image"></i>
              <p>
                Manage Users
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('search.index') }}" class="nav-link">
              <i class="nav-icon far fa-image"></i>
              <p>
                Search Manufacturer
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

