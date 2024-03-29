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
          <li class="nav-item has-treeview menu-setting">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-cog"></i>
              <p>Setting<i class="fas fa-angle-left right"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('car_type.index') }}" class="nav-link nav-car-type">
                  <p>Car Type</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('car_model.index') }}" class="nav-link nav-model">
                  <p>Model</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('car_year.index') }}" class="nav-link nav-year">
                  <p>Year</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="{{ route('reminder.index') }}" class="nav-link nav-team nav-reminder">
              <i class="nav-icon fas fa-bell"></i>
              <p>Reminder</p>
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
              <i class="nav-icon fas fa-car"></i>
              <p>Driver</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('owner.index') }}" class="nav-link nav-team nav-owner">
              <i class="nav-icon fas fa-users"></i>
              <p>Owner</p>
            </a>
          </li>
          <li class="nav-item has-treeview menu-rent">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-truck-moving"></i>
              <p>Rent<i class="fas fa-angle-left right"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('rent.index') }}" class="nav-link nav-rent-new">
                  <p>New</p>
                </a>
              </li>
              <!-- <li class="nav-item">
                <a href="{{ route('rent.upcoming.index') }}" class="nav-link nav-rent-upcoming">
                  <p>Upcoming(Confirm)</p>
                </a>
              </li> -->
              <li class="nav-item">
                <a href="{{ route('rent.cancel.index') }}" class="nav-link nav-rent-cancel">
                  <p>Cancel</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('rent.complete.index') }}" class="nav-link nav-rent-complete">
                  <p>Complete</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="{{ route('maintenance.index') }}" class="nav-link maintenance-charge">
              <i class="nav-icon fas fa-dollar-sign"></i>
              <p>Maintenance Charge</p>
            </a>
          </li>
          <li class="nav-item has-treeview menu-accounts">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-dollar-sign"></i>
              <p>Accounts<i class="fas fa-angle-left right"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('accounts.cash') }}" class="nav-link nav-cash">
                  <p>Cash</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('accounts.income') }}" class="nav-link nav-income">
                  <p>Income</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('accounts.expense') }}" class="nav-link nav-expense">
                  <p>Expense</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('accounts.maintenance') }}" class="nav-link nav-maintenance">
                  <p>Maintenance</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('accounts.summary') }}" class="nav-link nav-summary">
                  <p>Summary</p>
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