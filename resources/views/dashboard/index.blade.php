@extends('layout.admin')
@section('title','Dashboard')
@section('content')
    <div class="container-fluid pt-25">
        <div class="content-header">
          <div class="container-fluid">
            <div class="row mb-2">
              <div class="col-sm-6">
                <h1 class="m-0 text-dark">Dashboard</h1>
              </div><!-- /.col -->
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active">Dashboard</li>
                </ol>
              </div><!-- /.col -->
            </div><!-- /.row -->
          </div><!-- /.container-fluid -->
        </div>

        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                  <div class="inner">
                    <h3>{{ $data['new_rent'] }}</h3>
                    <p>New Rent</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-bag"></i>
                  </div>
                  <a href="{{ route('rent.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                  <div class="inner">
                    <h3>{{ $data['complete_rent'] }}</h3>
                    <p>Complete Rent</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                  </div>
                  <a href="{{ route('rent.complete.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <!-- ./col -->
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                  <div class="inner">
                    <h3>{{ $data['today_reminder'] }}</h3>
                    <p>Today Reminder</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-person-add"></i>
                  </div>
                  <a href="{{ route('reminder.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <!-- ./col -->
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                  <div class="inner">
                    <h3>{{ $data['tomorrow_reminder'] }}</h3>
                    <p>Tomorrow Reminder</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-person-add"></i>
                  </div>
                  <a href="{{ route('reminder.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
            </div>

            <div class="row">
              <h4 class="mt-4 ml-4">Previous Month History</h4>
            </div>
            <div class="row">
              <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                  <div class="inner">
                    <h3>{{ $data['prev_month_income'] }}</h3>
                    <p>Previous Month Income</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-bag"></i>
                  </div>
                  <a href="{{ route('accounts.income') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                  <div class="inner">
                    <h3>{{ $data['prev_month_expense'] }}</h3>
                    <p>Previous Month Expense</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-bag"></i>
                  </div>
                  <a href="{{ route('accounts.expense') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                  <div class="inner">
                    <h3>{{ $data['prev_month_maintenance'] }}</h3>
                    <p>Previous Month Maintenance</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-bag"></i>
                  </div>
                  <a href="{{ route('maintenance.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                  <div class="inner">
                    <h3>{{ $data['prev_month_earn'] }}</h3>
                    <p>Previous Month Earning</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                  </div>
                  <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
            </div>

            
            <div class="row">
              <h4 class="mt-4 ml-4">Current Month History</h4>
            </div>
            <div class="row">
              <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                  <div class="inner">
                    <h3>{{ $data['current_month_income'] }}</h3>
                    <p>Current Month Income</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-bag"></i>
                  </div>
                  <a href="{{ route('accounts.income') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                  <div class="inner">
                    <h3>{{ $data['current_month_expense'] }}</h3>
                    <p>Current Month Expense</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-bag"></i>
                  </div>
                  <a href="{{ route('accounts.expense') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                  <div class="inner">
                    <h3>{{ $data['current_maintenance'] }}</h3>
                    <p>Current Month Maintenance</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-bag"></i>
                  </div>
                  <a href="{{ route('maintenance.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                  <div class="inner">
                    <h3>{{ $data['current_month_earn'] }}</h3>
                    <p>This Month Earning</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                  </div>
                  <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
            </div>

            <div class="row">
              <h4 class="mt-4 ml-4">Total History</h4>
            </div>
            <div class="row">
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                  <div class="inner">
                    <h3>{{ $data['total_income'] }}</h3>
                    <p>Total Income</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                  </div>
                  <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                  <div class="inner">
                    <h3>{{ $data['total_expense'] }}</h3>
                    <p>Total Expense</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                  </div>
                  <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                  <div class="inner">
                    <h3>{{ $data['total_maintenance'] }}</h3>
                    <p>Total Maintenance</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-bag"></i>
                  </div>
                  <a href="{{ route('maintenance.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>              
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                  <div class="inner">
                    <h3>{{ $data['net_cash'] }}</h3>
                    <p>Net Cash</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                  </div>
                  <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
            </div>
            <!-- /.row -->
          </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="container-fluid">
            <div class="row">
              <div class="col-12">
                  <div class="card">
                      <div class="car-header">
                        <h4 class="mt-4 ml-4">Reminder List</h4>
                        <form class="form" action="{{ route('dashboard') }}" method="get" style="padding:10px 20px;">
                          <div class="row">
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
                              <div class="col-md-3">
                                  <div class="form-group">
                                      <label for="name">Day </label>
                                      <select name="day" id="day" class="form-control">
                                          <option value="0">Select</option>
                                          <option value="100" @if(isset($_GET['day']) && $_GET['day'] == 100) selected @endif>ToDay</option>
                                          <option value="1" @if(isset($_GET['day']) && $_GET['day'] == 1) selected @endif>Next Day</option>
                                          <option value="3" @if(isset($_GET['day']) && $_GET['day'] == 3) selected @endif>3 days</option>
                                          <option value="7" @if(isset($_GET['day']) && $_GET['day'] == 7) selected @endif>7 days</option>
                                          <option value="15" @if(isset($_GET['day']) && $_GET['day'] == 15) selected @endif>15 days</option>
                                          <option value="31" @if(isset($_GET['day']) && $_GET['day'] == 31) selected @endif>31 days</option>
                                      </select>
                                  </div>
                              </div>
                              <div class="col-md-2">
                                  <div class="form-group">
                                  <input type="submit" class="btn btn-info btn-sm" value="Search" style="margin-top: 30px;" />
                                  </div>
                              </div>
                          </div>
                        </form>
                      </div>
                      <div class="card-body">
                        <table class="table table-sm table-bordered table-striped data_table">
                          <thead>
                              <tr>
                                  <th>Next Contact</th>
                                  <th>Customer</th>
                                  <th>Travel Date</th>
                                  <th>Pickup Location</th>
                                  <th>Drop Location</th>
                                  <th>Asking Price</th>
                                  <th>User Offered Price</th>
                                  <th>Status</th>
                                  <th>Action</th>
                              </tr>
                          </thead>
                          <tfoot>
                              <tr>
                                  <th>Next Contact</th>
                                  <th>Customer</th>
                                  <th>Travel Date</th>
                                  <th>Pickup Location</th>
                                  <th>Drop Location</th>
                                  <th>Asking Price</th>
                                  <th>User Offered Price</th>
                                  <th>Status</th><th>Action</th>
                            </tr>
                          </tfoot>
                          <tbody id="allReminder">
                            @foreach($reminders as $reminder)
                              <tr class="reminder-{{ $reminder->id }}">
                                <td>{{ date('d M, Y H:i:s a', strtotime($reminder->next_contact_datetime)) }}</td>
                                <td>{{ $reminder->name }}({{ $reminder->phone }})</td>
                                <td>{{ date('d M, Y H:i:s a', strtotime($reminder->pickup_datetime)) }}</td>
                                <td>{{ $reminder->pickup_location }}</td>
                                <td>{{ $reminder->drop_location }}</td>
                                <td>{{ $reminder->asking_price }}</td>
                                <td>{{ $reminder->user_offered }}</td>
                                <td>{{ getStatus($reminder->status) }}</td>                                
                                <td style="vertical-align: middle;text-align: center;">
                                <a href="{{ route('reminder.details', $reminder->id) }}" target="_blank" class="btn btn-xs btn-secondary" title="Edit">Details</a>
                                  <a target="_blank" href="{{ route('reminder.edit', $reminder->id) }}" class="btn btn-xs btn-warning" title="Edit">Edit</a>
                                  <button class="btn btn-xs btn-success" data-toggle="modal" id="sms" data-target="#smsModal" data-id="{{ $reminder->id }}" data-name="{{ $reminder->name }}" data-phone="{{ $reminder->phone }}" title="SMS">SMS</button>                                  
                                  <button class="btn btn-xs btn-danger" data-toggle="modal" id="delete" data-target="#deleteModal" data-id="{{ $reminder->id }}" title="Delete">Delete</button>                                  
                                </td>
                              </tr>
                            @endforeach
                          </tbody>
                        </table>
                        <div class="d-felx justify-content-center mt-3">
                          {{ $reminders->links('pagination::bootstrap-4') }}
                        </div>
                      </div>
                  </div>
              </div>
          </div>
          </div><!-- /.container-fluid -->
        </section>
    </div>
    
    <div class="modal fade" tabindex="-1" id="smsModal" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-default" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                  <h5 class="modal-title text-center w-100">Send SMS</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="col-form-label">Customer Name <span class="text-danger" title="Required">*</span></label>                                
                                <input type="text" id="customerName" class="form-control" readonly/>
                                <input type="hidden" id="reminderId" />
                                <span class="errorCustomerName text-danger text-bold"></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="col-form-label">Customer Phone <span class="text-danger" title="Required">*</span></label>                                                                
                                <input type="text" id="customerPhone" class="form-control" readonly/>
                                <span class="errorCustomerPhone text-danger text-bold"></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="col-form-label">Message <span class="text-danger" title="Required">*</span></label>                                                                
                                <textarea class="form-control" id="message"></textarea>
                                <span class="errorCustomerPhone text-danger text-bold"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="sendSMS">Send</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="deleteModal" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-default" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                  <h5 class="modal-title text-center w-100">Delete Confirmation</h5>
                  <input type="hidden" name="del_id" />
                </div>
                <div class="modal-body">
                    <h3 class="text-center">Are you sure to delete ?</h3>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="destroy">Delete</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    <?php
        function getStatus ($status) {
            if ($status == 1) {
                echo "Pending";
            } else if ($status == 2) {
                echo "Schedule Contact";
            } else if ($status == 3) {
                echo "Not Agree";
            }
        }
    ?>
@endsection
@section('scripts')
    <script>
      $('.nav-dashboard').addClass('active');
    </script>
    <script src="{{ asset('assets/js/reminder.js') }}"></script>
@endsection
