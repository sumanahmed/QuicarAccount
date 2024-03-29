
@extends('layout.admin')
@section('title','Complete Rent')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Complete Rent</h1>
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
                      <form class="form" action="{{ route('rent.complete.index') }}" method="get" style="padding:10px 20px;">
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
                              <label for="customer_phone">Custome Phone</label>
                                <input type="text" name="customer_phone" @if(isset($_GET['customer_phone'])) value="{{ $_GET['customer_phone'] }}" @endif class="form-control">
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
                              <a href="{{ route('rent.export') }}" class="btn btn-warning btn-sm">Export <i class="fa fa-download"></i></a>
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
                                <th>Return Date & Time</th>
                                <th>Pickup Location</th>
                                <th>Drop Location</th>
                                <th>Customer</th>
                                <th>Car Type</th>
                                <th>Price</th>
                                <th>Advance</th>
                                <th>Fuel Cost</th>
                                <th>Total Cost</th>
                                <th>Total Income</th>
                                <th>Income From</th>
                                <th style="vertical-align: middle;text-align: center;">Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Travel Date & Time</th>
                                <th>Return Date & Time</th>
                                <th>Pickup Location</th>
                                <th>Drop Location</th>
                                <th>Customer</th>
                                <th>Car Type</th>
                                <th>Price</th>
                                <th>Advance</th>
                                <th>Fuel Cost</th>
                                <th>Total Cost</th>
                                <th>Total Income</th>
                                <th>Income From</th>
                              <th style="vertical-align: middle;text-align: center;">Action</th>
                          </tr>
                        </tfoot>
                        <tbody id="allRent">
                          @foreach($rents as $rent)
                            <tr class="rent-{{ $rent->id }}">
                                @php 
                                  $total_cost = $rent->outside_agent == 2 ? ($rent->driver_get + $rent->fuel_cost + $rent->other_cost + $rent->toll_charge) : 0;
                                @endphp
                              <td>{{ date('d M, Y h:i a', strtotime($rent->pickup_datetime)) }}</td>
                              <td>{{ $rent->return_datetime != null ? date('d M, Y h:i a', strtotime($rent->return_datetime)) : '' }}</td>
                              <td>{{ $rent->pickup_location }}</td>
                              <td>{{ $rent->drop_location }}</td>
                              <td>@if($rent->customer_id != null) {{ $rent->customer_name }} ({{ $rent->customer_phone }}) @endif</td>
                              <td>{{ $rent->car_type_name }}</td>
                              <td>{{ $rent->price }}</td>
                              <td>{{ $rent->advance }}</td>
                              <td>{{ $rent->outside_agent == 2 ? $rent->fuel_cost : 0 }}</td>
                              <td>{{ $total_cost }}</td>
                              <td>{{ $rent->outside_agent == 1 ? $rent->commission : ($rent->price - $total_cost) }}</td>
                              <td>{{ $rent->outside_agent == 1 ? 'Commission' : 'Company' }}</td>
                              <td style="vertical-align: middle;text-align: center;">
                                <a href="{{ route('rent.details', $rent->id) }}" class="btn btn-xs btn-warning" title="Details">Details</a>
                                <button class="btn btn-xs btn-primary" data-toggle="modal" id="sms" data-target="#smsModal" data-id="{{ $rent->id }}" title="SMS">SMS</button>                                  
                                <a href="{{ route('rent.invoice', $rent->id) }}" class="btn btn-xs btn-success" title="Edit">Invoice</a>
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
      $('.nav-rent-complete').addClass('active');
    </script>
    <script src="{{ asset('assets/js/rent.js') }}"></script>
@endsection