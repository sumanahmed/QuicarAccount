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
                                <select name="car_type_id[]" id="car_type_id" class="form-control selectable" multiple>
                                    <option value="0">Select</option>
                                    @foreach($car_types as $car_type) 
                                      <option value="{{ $car_type->id }}" 
                                        @if(isset($_GET['car_type_id'])) {{ in_array($car_type->id, $_GET['car_type_id']) ? 'selected' : '' }} @endif>
                                          {{ $car_type->name }}
                                      </option>
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
                          <div class="col-md-2">
                            <div class="form-group">
                              <label for="outside_agent">Income From</label>
                              <select name="outside_agent" class="form-control">
                                <option value="0">Select</option>
                                <option value="1" @if(isset($_GET['outside_agent']) && $_GET['outside_agent'] == 1) selected  @endif>Commision</option>
                                <option value="2" @if(isset($_GET['outside_agent']) && $_GET['outside_agent'] == 2) selected  @endif>Company</option>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-2">
                            <div class="form-group" style="margin-top: 30px;">
                              <input type="submit" class="btn btn-info btn-sm" value="Search" />
                            </div>
                          </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h5>Total Price: <strong>{{ $total_price }}</strong> | Total Cost: <strong>{{ $total_cost }}</strong> | Total Commission: <strong>{{ $commission_income }}</strong> | Total Company Income: <strong>{{ $company_income }}</strong>  | Net Income: <strong>{{ $total_income }}</strong></h5>
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
                                <th>Return Date & Time</th>
                                <th>Car Type</th>
                                <th><strong>Income From</strong></th>
                                <th>Price</th>
                                <th>Cost</th>
                                <th style="vertical-align: middle;text-align: right;">Net Income</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($incomes as $income)
                                @php 
                                    $price = $income->price;
                                    $cost  = $income->outside_agent == 2 ? (float)($income->fuel_cost + $income->other_cost + $income->driver_get + $income->toll_charge) : 0;
                                @endphp
                                <tr>
                                    <td>
                                        <a target="_blank" href="{{ route('rent.details', $income->rent_id) }}">
                                            {{ "Rent-".$income->rent_id }}
                                        </a>
                                    </td>
                                    <td>{{ $income->pickup_location }}</td>
                                    <td>{{ $income->drop_location }}</td>
                                    <td>{{ date('d M, Y h:i a', strtotime($income->pickup_datetime)) }}</td>
                                    <td>{{ $income->return_datetime != null ? date('d M, Y h:i a', strtotime($income->return_datetime)) : '' }}</td>
                                    <td>{{ $income->car_type_name }}</td>
                                    <td><strong>{{ $income->outside_agent == 1 ? 'Commission' : 'Company' }}</strong></td>
                                    <td style="vertical-align: middle;text-align: right;">{{ $income->price }}</td>
                                    <td style="vertical-align: middle;text-align: right;">{{$income->outside_agent == 2 ? $cost : '' }}</td>
                                    <td style="vertical-align: middle;text-align: right;">{{ $income->amount }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                      </table>
                      <div class="d-felx justify-content-center mt-3">
                        {{ $incomes->links('pagination::bootstrap-4') }}
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
        $('.menu-accounts').addClass('active');
        $('.nav-income').addClass('active');
    </script>
@endsection