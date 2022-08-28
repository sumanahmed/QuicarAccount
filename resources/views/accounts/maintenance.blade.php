@extends('layout.admin')
@section('title','Income Summary')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Income Summary</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="car-header">
                      <form class="form" action="{{ route('accounts.maintenance') }}" method="get" style="padding:10px 20px;">
                        <div class="row">
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="start_date">Start Date</label>
                              <input type="date" name="start_date"  value="{{ $start_date }}" class="form-control">
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="end_date">End Date</label>
                              <input type="date" name="end_date" value="{{ $end_date }}" class="form-control">
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <input type="submit" class="btn btn-info btn-sm" value="Search" style="margin-top: 32px;" />
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                    <div class="card-body">
                      <div class="row">
                            <div class="col-lg-3 col-6">
                                <div class="small-box bg-warning">
                                  <div class="inner">
                                    <h3>{{ $total_rent }}</h3>
                                    <p>Total Rent</p>
                                  </div>
                                  <div class="icon">
                                    <i class="ion ion-bag"></i>
                                  </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <div class="small-box bg-danger">
                                  <div class="inner">
                                    <h3>{{ $total_expense }}</h3>
                                    <p>Total Expense</p>
                                  </div>
                                  <div class="icon">
                                    <i class="ion ion-bag"></i>
                                  </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <div class="small-box bg-warning">
                                  <div class="inner">
                                    <h3>{{ $total_income }}</h3>
                                    <p>Total Income</p>
                                  </div>
                                  <div class="icon">
                                    <i class="ion ion-bag"></i>
                                  </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <div class="small-box bg-info">
                                  <div class="inner">
                                    <h3>{{ $total_maintenance }}</h3>
                                    <p>Total Maintenance Charge</p>
                                  </div>
                                  <div class="icon">
                                    <i class="ion ion-bag"></i>
                                  </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <div class="small-box bg-success">
                                  <div class="inner">
                                    <h3>{{ $net_cash }}</h3>
                                    <p>Net Cash</p>
                                  </div>
                                  <div class="icon">
                                    <i class="ion ion-bag"></i>
                                  </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <div class="small-box bg-warning">
                                  <div class="inner">
                                    <h3>{{ $company_income }}</h3>
                                    <p>Company Income</p>
                                  </div>
                                  <div class="icon">
                                    <i class="ion ion-bag"></i>
                                  </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <div class="small-box bg-danger">
                                  <div class="inner">
                                    <h3>{{ $commission }}</h3>
                                    <p>Commisssion</p>
                                  </div>
                                  <div class="icon">
                                    <i class="ion ion-bag"></i>
                                  </div>
                                </div>
                            </div>
                      </div>
                    </div>
                </div>
            </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
@endsection
@section('scripts')
    <script>
        $('.menu-accounts').addClass('menu-open');
        $('.nav-maintenance').addClass('active');
    </script>
@endsection