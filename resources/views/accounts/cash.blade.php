@extends('layout.admin')
@section('title','Income')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Income</h1>
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
                      <form class="form" action="{{ route('accounts.cash') }}" method="get" style="padding:10px 20px;">
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
                                    <label for="car_type_id">Car Type</label>
                                    <select name="car_type_id[]" id="car_type_id" class="form-control selectable" multiple>
                                        <option value="0">Select</option>
                                        @foreach($car_types as $car_type) 
                                            <option value="{{ $car_type->id }}" @if(isset($_GET['car_type_id']) && $car_type->id == $_GET['car_type_id']) selected @endif>{{ $car_type->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                <input type="submit" class="btn btn-info btn-sm" value="Search" style="margin-top: 32px;" />
                                </div>
                            </div>
                        </div>
                      </form>
                    </div>
                    <div class="card-body">
                      <table class="table table-sm table-bordered table-striped data_table">
                        <thead>
                            <tr>
                                <th style="vertical-align: middle;text-align: center;">Month</th>
                                <th style="vertical-align: middle;text-align: center;">Total Trip</th>
                                <th style="vertical-align: middle;text-align: center;">Amount</th>
                                <th style="vertical-align: middle;text-align: center;">Cost</th>
                                <th style="vertical-align: middle;text-align: center;">Maintenance</th>
                                <th style="vertical-align: middle;text-align: center;">Income</th>
                                <th style="vertical-align: middle;text-align: center;">Actual Cash</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($records as $record)
                                @php 
                                    $actual_cost  = (float)($record->total_price - ($record->total_cost + $record->total_charge));
                                @endphp
                                <tr>
                                    <td style="vertical-align: middle;text-align: center;">{{ getMonthName($record->month) }}</td>
                                    <td style="vertical-align: middle;text-align: center;">{{ $record->total_trip }}</td>
                                    <td style="vertical-align: middle;text-align: right;">{{ $record->total_price }}</td>
                                    <td style="vertical-align: middle;text-align: right;">{{ $record->total_cost }}</td>
                                    <td style="vertical-align: middle;text-align: right;">{{ $record->total_charge }}</td>
                                    <td style="vertical-align: middle;text-align: right;">{{ $actual_cost }}</td>
                                    <td style="vertical-align: middle;text-align: right;">{{ $actual_cost }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                      </table>
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
        $('.menu-accounts').addClass('active');
        $('.nav-cash').addClass('active');
    </script>
@endsection