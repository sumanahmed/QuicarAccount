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
                      <form class="form" action="{{ route('accounts.income') }}" method="get" style="padding:10px 20px;">
                        <div class="row">
                          <div class="col-md-2">
                            <div class="form-group">
                              <label for="start_date">Start Date</label>
                              <input type="date" name="start_date" @if(isset($_GET['start_date'])) value="{{ $_GET['start_date'] }}" @endif class="form-control">
                            </div>
                          </div>
                          <div class="col-md-2">
                            <div class="form-group">
                              <label for="end_date">End Date</label>
                              <input type="date" name="end_date" @if(isset($_GET['end_date'])) value="{{ $_GET['end_date'] }}" @endif class="form-control">
                            </div>
                          </div>
                          <div class="col-md-2">
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
                          <div class="col-md-2">
                            <div class="form-group">
                                <label for="search_type">Search Type</label>
                                <select name="search_type" id="search_type" class="form-control selectable">
                                    <option value="1" @if(isset($_GET['search_type']) && $_GET['search_type'] == 1) selected @endif>Travel Date</option>
                                    <option value="2" @if(isset($_GET['search_type']) && $_GET['search_type'] == 2) selected @endif>Income Date</option>
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
                      <table class="table table-sm table-bordered table-striped data_table">
                        <thead>
                            <tr>
                                <th>Rent</th>
                                <th>Travel Date & Time</th>
                                <th>Income Date</th>
                                <th>Car Type</th>
                                <th>Income From</th>
                                <th>Price</th>
                                <th>Cost</th>
                                <th style="vertical-align: middle;text-align: right;">Net Income</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php 
                                $total_price = 0; 
                                $total_cost = 0; 
                                $total_amount = 0; 
                            @endphp
                            @foreach($incomes as $income)
                                @php 
                                    $price = $income->price;
                                    $cost  = (float)($income->fuel_cost + $income->other_cost + $income->driver_get + $income->toll_charge);
                                    $netincome = ($price - $cost);
                                @endphp
                                <tr>
                                    <td>
                                        <a target="_blank" href="{{ route('rent.details', $income->rent_id) }}">
                                            {{ "Rent-".$income->rent_id }}
                                        </a>
                                    </td>
                                    <td>{{ date('d M, Y h:i a', strtotime($income->pickup_datetime)) }}</td>
                                    <td>{{ date('d M, Y h:i a', strtotime($income->date)) }}</td>
                                    <td>{{ $income->car_type_name }}</td>
                                    <td>{{ $income->name }}</td>
                                    <td style="vertical-align: middle;text-align: right;">{{ $income->price }}</td>
                                    <td style="vertical-align: middle;text-align: right;">{{ $cost }}</td>
                                    <td style="vertical-align: middle;text-align: right;">{{ $netincome }}</td>
                                </tr>
                                @php 
                                    $total_price += $income->price;
                                    $total_cost += $cost;
                                    $total_amount += $netincome;
                                @endphp
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                              <th colspan="5">Total Net Income Amount</th>
                              <th style="vertical-align: middle;text-align: right;">{{ $total_price }}</th>
                              <th style="vertical-align: middle;text-align: right;">{{ $total_cost }}</th>
                              <th style="vertical-align: middle;text-align: right;">{{ $total_amount }}</th>
                          </tr>
                        </tfoot>
                      </table>
                    </div>
                </div>
            </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
@endsection
@section('scripts')
    <script>
        $('.menu-accounts').addClass('active');
        $('.nav-income').addClass('active');
    </script>
@endsection