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
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="date">Pickup Date</label>
                              <input type="date" name="pickup_datetime" @if(isset($_GET['pickup_datetime'])) value="{{ $_GET['pickup_datetime'] }}" @endif class="form-control">
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                                <label for="customer_id">Customer</label>
                                <select name="customer_id" id="customer_id" class="form-control selectable">
                                    <option value="0">Select</option>
                                    @foreach($customers as $customer) 
                                        <option value="{{ $customer->id }}" @if(isset($_GET['customer_id']) && $customer->id == $_GET['customer_id']) selected @endif>{{ $customer->name }}({{ $customer->phone }})</option>
                                    @endforeach
                                </select>
                            </div>
                          </div>
                          <div class="col-md-4">
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
                                <th>Travel Date & Time</th>
                                <th>Car Type</th>
                                <th>Expense For</th>
                                <th>Date</th>
                                <th>Expense By</th>
                                <th style="vertical-align: middle;text-align: right;">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $total_amount = 0; @endphp
                            @foreach($expenses as $expense)
                                <tr>
                                    <td>{{ date('d M, Y h:i:s a', strtotime($expense->pickup_datetime)) }}</td>
                                    <td>{{ $expense->car_type_name }}</td>
                                    <td>{{ $expense->name }}</td>
                                    <td>{{ $expense->date }}</td>
                                    <td>{{ $expense->expense_by }}</td>
                                    <td style="vertical-align: middle;text-align: right;">{{ $expense->amount }}</td>
                                </tr>
                                @php $total_amount += $expense->amount @endphp
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                              <th colspan="5">Total Amount</th>
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
        $('.menu-accounts').addClass('menu-open');
        $('.nav-expense').addClass('active');
    </script>
@endsection