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
                            <div class="col-md-6"><h5>Summary</h5></div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-sm table-bordered table-striped data_table">
                                    <thead>
                                        <tr>
                                            <th>Rent</th>
                                            <th style="vertical-align: middle;">Travel Date</th>
                                            <th style="vertical-align: middle;text-align: right;">Price</th>
                                            <th style="vertical-align: middle;text-align: right;">Income</th>
                                            <th style="vertical-align: middle;text-align: right;">Expense</th>
                                            <th style="vertical-align: middle;text-align: right;">Net Income</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php 
                                            $total_price = 0; 
                                            $total_income = 0; 
                                            $total_expense = 0; 
                                        @endphp
                                        @foreach($records as $record)
                                            <tr>
                                                <td>{{ "Rent-".$record->rent_id }}</td>
                                                <td>{{ date('d M, Y h:i a', strtotime($record->pickup_datetime)) }}</td>
                                                <td style="vertical-align: middle;text-align: right;">{{ $record->price }}</td>
                                                <td style="vertical-align: middle;text-align: right;">{{ $record->income }}</td>
                                                <td style="vertical-align: middle;text-align: right;">{{ $record->expense }}</td>
                                                <td style="vertical-align: middle;text-align: right;">{{ $record->price - $record->expense }}</td>
                                            </tr>
                                            @php 
                                                $total_price += $record->price;
                                                $total_income += $record->income;
                                                $total_expense += $record->expense;
                                            @endphp
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2">Grand Total</td>
                                            <td style="vertical-align: middle;text-align: right;">{{ $total_price }}</td>
                                            <td style="vertical-align: middle;text-align: right;">{{ $total_income }}</td>
                                            <td style="vertical-align: middle;text-align: right;">{{ $total_expense }}</td>
                                            <td style="vertical-align: middle;text-align: right;">{{ $total_price - $total_expense }}</td>
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
@endsection
@section('scripts')
    <script>
        $('.menu-accounts').addClass('menu-open');
        $('.nav-summary').addClass('active');
    </script>
@endsection