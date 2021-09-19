
@extends('layout.admin')
@section('title','Reminder')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Reminder</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <a href="{{ route('reminder.create') }}" class="btn btn-success float-right"><i class="fas fa-plus-circle"></i> Create </a>
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
                      <form class="form" action="{{ route('reminder.index') }}" method="get" style="padding:10px 20px;">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="customer_id">Customer</label>
                                    <select name="customer_id" id="customer_id" class="form-control select2">
                                        <option value="0">Select</option>
                                        @foreach($customers as $customer) 
                                            <option value="{{ $customer->id }}" @if(isset($_GET['customer_id']) && $customer->id == $_GET['customer_id']) selected @endif>{{ $customer->name }}({{ $customer->phone }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="name">Car Type</label>
                                    <select name="car_type_id" id="filter_car_type_id" class="form-control select2">
                                        <option value="0">Select</option>
                                        @foreach($car_types as $car_type) 
                                            <option value="{{ $car_type->id }}" @if(isset($_GET['car_type_id']) && $car_type->id == $_GET['car_type_id']) selected @endif>{{ $car_type->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
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
                                <th>Pickup Location</th>
                                <th>Drop Location</th>
                                <th>Customer</th>
                                <th>Asking Price</th>
                                <th>User Offered Price</th>
                                <th>Status</th>
                                <th style="vertical-align: middle;text-align: center;">Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Pickup Location</th>
                                <th>Drop Location</th>
                                <th>Customer</th>
                                <th>Asking Price</th>
                                <th>User Offered Price</th>
                                <th>Status</th>
                              <th style="vertical-align: middle;text-align: center;">Action</th>
                          </tr>
                        </tfoot>
                        <tbody id="allRent">
                          @foreach($reminders as $reminder)
                            <tr class="rent-{{ $reminder->id }}">
                              <td>{{ $reminder->pickup_location }}</td>
                              <td>{{ $reminder->drop_location }}</td>
                              <td>11</td>
                              <td>{{ $reminder->asking_price }}</td>
                              <td>{{ $reminder->user_offered }}</td>
                              <td>{{ getStatus($reminder->status) }}</td>
                              <td style="vertical-align: middle;text-align: center;">
                                <button class="btn btn-xs btn-info" data-toggle="modal" id="statusChange" data-id="{{ $reminder->id }}" data-status="{{ $reminder->status }}" title="Status">Status</button>
                                <a href="{{ route('reminder.edit', $reminder->id) }}" class="btn btn-xs btn-warning" title="Edit">Edit</a>
                                <button class="btn btn-xs btn-success" data-toggle="modal" id="sms" data-target="#smsModal" data-id="{{ $reminder->id }}" title="SMS">SMS</button>                                  
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
    <div class="modal fade" tabindex="-1" id="statusUpdateModal" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-default" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                  <h5 class="modal-title text-center w-100">Update Status</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label class="col-form-label">Status <span class="text-danger" title="Required">*</span></label>
                                <select id="status" class="form-control" required>
                                  <option value="1">Upcoming</option>
                                  <option value="2">Ongoing</option>
                                  <option value="3">Complete</option>
                                  <option value="4">Cancel</option>
                                </select>
                                <input type="hidden" id="rent_id" />
                                <span class="errorSms text-danger text-bold"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="changeRentStatus">Send</button>
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
        $('.nav-reminder').addClass('active');
    </script>
    <script src="{{ asset('assets/js/reminder.js') }}"></script>
@endsection