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
                              <label for="date">Month</label>
                              <select name="month" class="form-control">
                                <option value="0">Select</option>
                                <option value="1" @if(isset($_GET['month']) && $_GET['month'] == 1) selected @endif>January</option>
                                <option value="2" @if(isset($_GET['month']) && $_GET['month'] == 2) selected @endif>February</option>
                                <option value="3" @if(isset($_GET['month']) && $_GET['month'] == 3) selected @endif>March</option>
                                <option value="4" @if(isset($_GET['month']) && $_GET['month'] == 4) selected @endif>April</option>
                                <option value="5" @if(isset($_GET['month']) && $_GET['month'] == 5) selected @endif>May</option>
                                <option value="6" @if(isset($_GET['month']) && $_GET['month'] == 6) selected @endif>June</option>
                                <option value="7" @if(isset($_GET['month']) && $_GET['month'] == 7) selected @endif>July</option>
                                <option value="8" @if(isset($_GET['month']) && $_GET['month'] == 8) selected @endif>August</option>
                                <option value="9" @if(isset($_GET['month']) && $_GET['month'] == 9) selected @endif>September</option>
                                <option value="10" @if(isset($_GET['month']) && $_GET['month'] == 10) selected @endif>October</option>
                                <option value="11" @if(isset($_GET['month']) && $_GET['month'] == 11) selected @endif>November</option>
                                <option value="12" @if(isset($_GET['month']) && $_GET['month'] == 12) selected @endif>December</option>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="year">Year</label>
                              <select name="year" class="form-control">
                                <option value="0">Select</option>
                                <option value="2020" @if(isset($_GET['year']) && $_GET['year'] == 2020) selected @endif>2020</option>
                                <option value="2021" @if(isset($_GET['year']) && $_GET['year'] == 2021) selected @endif>2021</option>
                              </select>
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
                            <div class="col-md-6"><h5>Summary</h5></div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-sm table-bordered table-striped data_table">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Month</th>
                                            <th class="text-center">Total Rent</th>
                                            <th style="vertical-align: middle;text-align: center;">Price (Tk)</th>
                                            <th style="vertical-align: middle;text-align: center;">Cost (Tk)</th>
                                            <th style="vertical-align: middle;text-align: center;">Income (Tk)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php 
                                            $total_rent = 0; 
                                            $total_price = 0; 
                                            $total_expense = 0; 
                                            $total_income = 0; 
                                        @endphp
                                        @foreach($records as $record)
                                          @php 
                                            $net_total = ($record->total_price - $record->total_expense);
                                          @endphp
                                            <tr>
                                                <td class="text-center">{{ getMonthName($record->month) }}</td>
                                                <td class="text-center">{{ $record->total_rent }}</td>
                                                <td style="vertical-align: middle;text-align: right;">{{ number_format((float)$record->total_price, 2, '.', '') }}</td>
                                                <td style="vertical-align: middle;text-align: right;">{{ number_format((float)$record->total_expense, 2, '.', '') }}</td>
                                                <td style="vertical-align: middle;text-align: right;">{{ number_format((float)$net_total, 2, '.', '') }}</td>
                                            </tr>
                                            @php 
                                                $total_rent += $record->total_rent;
                                                $total_price += $record->total_price;
                                                $total_expense += $record->total_expense;
                                                $total_income += $net_total;
                                            @endphp
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr style="font-weight: bold;">
                                            <td class="text-center">Grand Total</td>
                                            <td class="text-center">{{ $total_rent }}</td>
                                            <td style="vertical-align: middle;text-align: right;">{{ number_format((float)$total_price, 2, '.', '') }}</td>
                                            <td style="vertical-align: middle;text-align: right;">{{ number_format((float)$total_expense, 2, '.', '') }}</td>
                                            <td style="vertical-align: middle;text-align: right;">{{ number_format((float)$total_income, 2, '.', '') }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <?php 
      function getMonthName ($month)
      {
        if ($month == 1) {
          echo "January";
        } else if ($month == 2) {
          echo "February";
        } else if ($month == 3) {
          echo "March";
        } else if ($month == 4) {
          echo "April";
        } else if ($month == 5) {
          echo "May";
        } else if ($month == 6) {
          echo "June";
        } else if ($month == 7) {
          echo "July";
        } else if ($month == 8) {
          echo "August";
        } else if ($month == 9) {
          echo "September";
        } else if ($month == 10) {
          echo "October";
        } else if ($month == 11) {
          echo "November";
        } else if ($month == 12) {
          echo "December";
        }
      }
    ?>
@endsection
@section('scripts')
    <script>
        $('.menu-accounts').addClass('menu-open');
        $('.nav-summary').addClass('active');
    </script>
@endsection