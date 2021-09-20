
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
                                <th style="vertical-align: middle;text-align: center;">Action</th>
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
                                <th>Status</th>
                                <th style="vertical-align: middle;text-align: center;">Action</th>
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
                                <a href="{{ route('reminder.edit', $reminder->id) }}" class="btn btn-xs btn-warning" title="Edit">Edit</a>
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
        $('.nav-reminder').addClass('active');
    </script>
    <script src="{{ asset('assets/js/reminder.js') }}"></script>
@endsection