@extends('layout.admin')
@section('title','Expense')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Expense</h1>
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
                      <form class="form" action="{{ route('accounts.expense') }}" method="get" style="padding:10px 20px;">
                        <div class="row">
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="start_date">Start Date</label>
                              <input type="date" name="start_date" @if(isset($_GET['start_date'])) value="{{ $_GET['start_date'] }}" @endif class="form-control">
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="end_date">End Date</label>
                              <input type="date" name="end_date" @if(isset($_GET['end_date'])) value="{{ $_GET['end_date'] }}" @endif class="form-control">
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                                <label for="car_type_id">Car Type</label>
                                <select name="car_type_id" id="car_type_id" class="form-control selectable">
                                    <option value="0">Select</option>
                                    @foreach($car_types as $car_type) 
                                        <option value="{{ $car_type->id }}" @if(isset($_GET['car_type_id']) && $car_type->id == $_GET['car_type_id']) selected @endif>{{ $car_type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <input type="submit" class="btn btn-info btn-sm" value="Search" style="margin-top: 32px;" />
                              <h4 style="float:right;margin-top:35px">Net Cost: {{ $total_expense }}</h4>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                    <div class="card-body">
                      <table class="table table-sm table-bordered table-striped data_table">
                        <thead>
                            <tr>
                                <th>Rent</th>
                                <th>Pickup Location</th>
                                <th>Drop Location</th>
                                <th>Travel Date & Time</th>
                                <th>Car Type</th>
                                <th>Fule Cost</th>
                                <th>Other Cost</th>
                                <th>Driver Cost</th>
                                <th>Toll Charge</th>
                                <th style="vertical-align: middle;text-align: right;">Total Cost</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($expenses as $expense)
                                <tr>
                                    <td>
                                      <a target="_blank" href="{{ route('rent.details', $expense->id) }}">
                                        {{ "Rent-".$expense->id }}
                                      </a>
                                    </td>
                                    <td>{{ $expense->pickup_location }}</td>
                                    <td>{{ $expense->drop_location }}</td>
                                    <td>{{ date('d M, Y h:i:s a', strtotime($expense->pickup_datetime)) }}</td>
                                    <td>{{ $expense->car_type_name }}</td>
                                    <td>{{ $expense->fuel_cost }}</td>
                                    <td>{{ $expense->other_cost }}</td>
                                    <td>{{ $expense->driver_get }}</td>
                                    <td>{{ $expense->toll_charge }}</td>
                                    <td style="vertical-align: middle;text-align: right;">{{ ($expense->fuel_cost + $expense->other_cost + $expense->driver_get + $expense->toll_charge) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                      </table>
                      <div class="d-felx justify-content-center mt-3">
                        {{ $expenses->links('pagination::bootstrap-4') }}
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
        $('.nav-expense').addClass('active');
    </script>
@endsection