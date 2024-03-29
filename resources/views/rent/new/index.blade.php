
@extends('layout.admin')
@section('title','Rent')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Rent</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <a href="{{ route('rent.create') }}" class="btn btn-success float-right"><i class="fas fa-plus-circle"></i> Create </a>
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
                      <form class="form" action="{{ route('rent.index') }}" method="get" style="padding:10px 20px;">
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
                                  <input type="submit" class="btn btn-info btn-sm" value="Search" style="margin-top: 30px;" />
                                </div>
                            </div>
                            <div class="col-md-6" style="margin-top:30px;">
                                <h5>Total Price: <strong>{{ $total_price }}</strong> | Total Advance: <strong>{{ $total_advance }}</strong> | Total Remaining: <strong>{{ $total_remaining }}</strong></h5>
                            </div>
                        </div>
                      </form>
                    </div>
                    <div class="card-body">
                      <table class="table table-sm table-bordered table-striped data_table">
                        <thead>
                            <tr>
                                <th>Pickup Location</th>
                                <th>Travel Date & Time</th>
                                <th>Return Date & Time</th>
                                <th>Destination</th>
                                <th>Customer</th>
                                <th>Car Type</th>
                                <th>Price</th>
                                <th>Advance</th>
                                <th>Remaining</th>
                                <th style="vertical-align: middle;text-align: center;">Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Pickup Location</th>
                                <th>Travel Date & Time</th>
                                <th>Return Date & Time</th>
                                <th>Destination</th>
                                <th>Customer</th>
                                <th>Car Type</th>
                                <th>Price</th>
                                <th>Advance</th>
                                <th>Remaining</th>
                              <th style="vertical-align: middle;text-align: center;">Action</th>
                          </tr>
                        </tfoot>
                        <tbody id="allRent">
                          @foreach($rents as $rent)
                            <tr class="rent-{{ $rent->id }}">
                              <td>{{ $rent->pickup_location }}</td>
                              <td>{{ date('d M, Y h:i a', strtotime($rent->pickup_datetime)) }}</td>
                              <td>{{ date('d M, Y h:i a', strtotime($rent->return_datetime)) }}</td>
                              <td>{{ $rent->drop_location }}</td>
                              <td>@if($rent->customer_id != null) {{ $rent->customer_name }} ({{ $rent->customer_phone }}) @endif</td>
                              <td>{{ $rent->car_type_name }}</td>
                              <td>{{ $rent->price }}</td>
                              <td>{{ $rent->advance }}</td>
                              <td>{{ $rent->remaining }}</td>
                              <td style="vertical-align: middle;text-align: center;">
                                <a href="{{ route('rent.details', $rent->id) }}" class="btn btn-xs btn-warning" title="Details">Details</a>
                                <button class="btn btn-xs btn-primary" data-toggle="modal" id="sms" data-target="#smsModal" data-id="{{ $rent->id }}" title="SMS">SMS</button>                                  
                                <a href="{{ route('rent.invoice', $rent->id) }}" class="btn btn-xs btn-success" title="Edit">Invoice</a>
                                <button class="btn btn-xs btn-info" data-toggle="modal" id="statusChange" data-id="{{ $rent->id }}" data-status="{{ $rent->status }}" title="Status">Status</button>
                                <a href="{{ route('rent.edit', $rent->id) }}" class="btn btn-xs btn-warning" title="Edit">Edit</a>
                                <button class="btn btn-xs btn-danger" data-toggle="modal" id="rentDelete" data-target="#rentDeleteModal" data-id="{{ $rent->id }}" title="Delete">Delete</button>                                  
                              </td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                      <div class="d-felx justify-content-center mt-3">
                        {{ $rents->links('pagination::bootstrap-4') }}
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
                                <label class="col-form-label">SMS For <span class="text-danger" title="Required">*</span></label>                                                                
                                <select id="smsFor" class="form-control">
                                  <option value="1">Customer</option>
                                  <option value="2">Driver</option>
                                </select>
                                <input type="hidden" id="rentId" />
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
    <div class="modal fade" tabindex="-1" id="statusUpdateModal" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-default" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                  <h5 class="modal-title text-center w-100">Update Status</h5>
                </div>
                <div class="modal-body" id="loader" style="display: none;">
                  <div class="spinner-border" role="status">
                    <span class="sr-only">Loading...</span>
                  </div>
                </div>
                <div class="modal-body" id="hideStatusModalyBody">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label class="col-form-label">Status <span class="text-danger" title="Required">*</span></label>
                                <select id="status" class="form-control" required>
                                  <option value="1">New</option>
                                  <option value="3">Complete</option>
                                  <option value="4">Cancel</option>
                                </select>
                                <input type="hidden" id="rent_id" />
                                <span class="errorSms text-danger text-bold"></span>
                            </div>
                        </div>
                    </div>
                    <div id="showCost" style="display:none">
                      <div class="row">
                          <div class="col">
                              <div class="form-group">
                                  <label class="col-form-label">Date</label>
                                  <input type="date" id="rentDate" class="form-control" />
                                  <span class="errorRentDate text-danger text-bold"></span>
                              </div>
                          </div>
                      </div>
                      <div class="row">
                          <div class="col">
                              <div class="form-group">
                                  <label class="col-form-label">Driver Cost</label>
                                  <input type="text" id="driverCost" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" />
                                  <span class="errorDriverCost text-danger text-bold"></span>
                              </div>
                          </div>
                          <div class="col">
                              <div class="form-group">
                                  <label class="col-form-label">Fuel Cost</label>
                                  <input type="text" id="fuelCost" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" />
                                  <span class="errorFuelCost text-danger text-bold"></span>
                              </div>
                          </div>
                          <div class="col">
                              <div class="form-group">
                                  <label class="col-form-label">Other Cost</label>
                                  <input type="text" id="otherCost" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" />
                                  <span class="errorOtherCost text-danger text-bold"></span>
                              </div>
                          </div>
                      </div>
                      <div class="row">
                          <div class="col">
                              <div class="form-group">
                                  <label class="col-form-label">Toll Charge</label>
                                  <input type="text" id="tollCharge" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" />
                                  <span class="errorTollCharge text-danger text-bold"></span>
                              </div>
                          </div>
                          <div class="col">
                              <div class="form-group">
                                  <label class="col-form-label">Total Km</label>
                                  <input type="text" id="totalKm" class="form-control" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" />
                                  <span class="errorTotalKm text-danger text-bold"></span>
                              </div>
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
    <div class="modal fade" tabindex="-1" id="rentDeleteModal" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
                    <button type="button" class="btn btn-success" id="rentDestroy">Delete</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
      $('.menu-rent').addClass('menu-open');
      $('.nav-rent-new').addClass('active');
    </script>
    <script src="{{ asset('assets/js/rent.js') }}"></script>
@endsection