<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link" style="background:#f4f6f9">
      <div class="login-logo"><img style="width: 120px;" src="{{ asset('assets/images/logo.png') }}"></div>
    </a>
    <!-- Sidebar -->
    
    <div class="sidebar">
      <nav>
        <ul class="nav nav-pills nav-sidebar flex-column nav-flat" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="{{ route('dashboard') }}" class="nav-link nav-dashboard">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('customer.index') }}" class="nav-link nav-team nav-customer">
              <i class="nav-icon fas fa-users"></i>
              <p>Customer</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('driver.index') }}" class="nav-link nav-team nav-driver">
              <i class="nav-icon fas fa-users"></i>
              <p>Driver</p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>