@extends('layout.admin')
@section('title','Summary')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Summary</h1>
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
                      <form class="form" action="{{ route('accounts.summary') }}" method="get" style="padding:10px 20px;">
                        <div class="row">
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="date">Start Date</label>
                              <input type="date" name="start_date" class="form-control" @if(isset($_GET['start_date'])) value="{{ date('Y-m-d', strtotime($_GET['start_date'])) }}" @endif />
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="date">End Date</label>
                              <input type="date" name="end_date" class="form-control" @if(isset($_GET['end_date'])) value="{{ date('Y-m-d', strtotime($_GET['end_date'])) }}" @endif />
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
                            <div class="col-md-6"><h5>Expense Summary</h5></div>
                            <div class="col-md-6"><h5>Income Summary</h5></div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-sm table-bordered table-striped data_table">
                                    <thead>
                                        <tr>
                                            <th>Rent</th>
                                            <th style="vertical-align: middle;text-align: right;">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $total_expense = 0; @endphp
                                        @foreach($expenses as $expense)
                                            <tr>
                                                <td>{{ "Rent-".$expense->rent_id }}</td>
                                                <td style="vertical-align: middle;text-align: right;">{{ $expense->amount }}</td>
                                            </tr>
                                            @php $total_expense += $expense->amount @endphp
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Total Expense</th>
                                            <th style="vertical-align: middle;text-align: right;">{{ $total_expense }}</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-sm table-bordered table-striped data_table">
                                    <thead>
                                        <tr>
                                            <th>Rent</th>
                                            <th style="vertical-align: middle;text-align: right;">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $total_income = 0; @endphp
                                        @foreach($incomes as $income)
                                            <tr>
                                                <td>{{ "Rent-".$income->rent_id }}</td>
                                                <td style="vertical-align: middle;text-align: right;">{{ $income->amount }}</td>
                                            </tr>
                                            @php $total_income += $income->amount @endphp
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Total Income</th>
                                            <th style="vertical-align: middle;text-align: right;">{{ $total_income }}</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-10"><h5>Final Amount : {{ $total_income - $total_expense }}</h5></div>
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
        $('.nav-summary').addClass('active');
    </script>
@endsection