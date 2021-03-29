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
                              <label for="date">Date</label>
                              <input type="date" name="date" class="form-control" @if(isset($_GET['date'])) value="{{ date('Y-m-d', strtotime($_GET['date'])) }}" @endif />
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="user_id">Expense By</label>
                              <select name="user_id" class="form-control">
                                <option value="0">Select</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" @if(isset($_GET['user_id']) && $_GET['user_id'] == $user->id)) selected @endif>{{ $user->name }}</option>
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
                                <th>Name</th>
                                <th>Date</th>
                                <th>Expense By</th>
                                <th style="vertical-align: middle;text-align: right;">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $total_amount = 0; @endphp
                            @foreach($expenses as $expense)
                                <tr>
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
                              <th colspan="3">Total Amount</th>
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