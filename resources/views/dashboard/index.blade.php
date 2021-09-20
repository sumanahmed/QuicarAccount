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
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
          <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                  <div class="inner">
                    <h3>150</h3>
                    <p>New Orders</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-bag"></i>
                  </div>
                  <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <!-- ./col -->
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                  <div class="inner">
                    <h3>53<sup style="font-size: 20px">%</sup></h3>
                    <p>Bounce Rate</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                  </div>
                  <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <!-- ./col -->
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-warning">
                  <div class="inner">
                    <h3>44</h3>
                    <p>User Registrations</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-person-add"></i>
                  </div>
                  <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <!-- ./col -->
              <div class="col-lg-3 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                  <div class="inner">
                    <h3>65</h3>
                    <p>Unique Visitors</p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                  </div>
                  <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <!-- ./col -->
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
                        <h4 class="mt-4 ml-4">Last 3 Days Reminder List</h4>
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
                                  <a target="_blank" href="{{ route('reminder.edit', $reminder->id) }}" class="btn btn-xs btn-warning" title="Edit">Edit</a>
                                  <button class="btn btn-xs btn-success" data-toggle="modal" id="sms" data-target="#smsModal" data-id="{{ $reminder->id }}" data-name="{{ $reminder->name }}" data-phone="{{ $reminder->phone }}" title="SMS">SMS</button>                                  
                                  <button class="btn btn-xs btn-danger" data-toggle="modal" id="delete" data-target="#deleteModal" data-id="{{ $reminder->id }}" title="Delete">Delete</button>                                  
                                </td>
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
