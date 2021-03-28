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
          <li class="nav-item">
            <a href="{{ route('owner.index') }}" class="nav-link nav-team nav-owner">
              <i class="nav-icon fas fa-users"></i>
              <p>Owner</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('rent.index') }}" class="nav-link nav-team nav-rent">
              <i class="nav-icon fas fa-users"></i>
              <p>Rent</p>
            </a>
          </li>
          <li class="nav-item has-treeview menu-product">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-sitemap"></i>
              <p>Accounts<i class="fas fa-angle-left right"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link nav-income">
                  <p>Income</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link nav-expense">
                  <p>Expense</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link nav-expense">
                  <p>Report</p>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>