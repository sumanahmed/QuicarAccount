
@extends('layout.admin')
@section('title','Upcoming Rent')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Upcoming Rent</h1>
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
                      <form class="form" action="{{ route('rent.upcoming.index') }}" method="get" style="padding:10px 20px;">
                        <div class="row">
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
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="phone">Model</label>
                              <select name="model_id" id="filter_model_id" class="form-control">
                                  <option value="0">Select</option>
                                  @foreach($models as $model) 
                                      <option value="{{ $model->id }}" @if(isset($_GET['model_id']) && $model->id == $_GET['model_id']) selected @endif>{{ $model->name }}</option>
                                  @endforeach
                              </select>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="year">Year</label>
                                <select name="year_id" class="form-control">
                                    <option value="0">Select</option>
                                    @foreach($years as $year) 
                                        <option value="{{ $year->id }}" @if(isset($_GET['year_id']) && $year->id == $_GET['year_id']) selected @endif>{{ $year->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                          </div>
                          <div class="col-md-3">
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
                                <th>Reg No</th>
                                <th>Price</th>
                                <th>Advance</th>
                                <th>Status</th>
                                <th style="vertical-align: middle;text-align: center;">Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Pickup Location</th>
                                <th>Drop Location</th>
                                <th>Reg No</th>
                                <th>Price</th>
                                <th>Advance</th>
                                <th>Status</th>
                              <th style="vertical-align: middle;text-align: center;">Action</th>
                          </tr>
                        </tfoot>
                        <tbody id="allRent">
                          @foreach($rents as $rent)
                            <tr class="rent-{{ $rent->id }}">
                              <td>{{ $rent->pickup_location }}</td>
                              <td>{{ $rent->drop_location }}</td>
                              <td>{{ $rent->reg_number }}</td>
                              <td>{{ $rent->price }}</td>
                              <td>{{ $rent->advance }}</td>
                              <td>{{ getStatus($rent->status) }}</td>
                              <td style="vertical-align: middle;text-align: center;">
                                <button class="btn btn-xs btn-primary" data-toggle="modal" id="sms" data-target="#smsModal" data-id="{{ $rent->id }}" title="SMS">SMS</button>                                  
                                <a href="{{ route('rent.invoice', $rent->id) }}" class="btn btn-xs btn-success" title="Edit">Invoice</a>
                                <button class="btn btn-xs btn-info" data-toggle="modal" id="statusChange" data-id="{{ $rent->id }}" data-status="{{ $rent->status }}" title="Status">Status</button>
                                <a href="{{ route('rent.upcoming.edit', $rent->id) }}" class="btn btn-xs btn-warning" title="Edit">Edit</a>
                                <button class="btn btn-xs btn-danger" data-toggle="modal" id="delete" data-target="#deleteModal" data-id="{{ $rent->id }}" title="Delete">Delete</button>                                  
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
                echo "Upcoming";
            } else if ($status == 2) {
                echo "Ongoing";
            } else if ($status == 3) {
                echo "Complete";
            } else if ($status == 4) {
                echo "Cancel";
            }
        }
    ?>
@endsection
@section('scripts')
    <script>
      $('.menu-rent').addClass('menu-open');
      $('.nav-rent-upcoming').addClass('active');
    </script>
    <script src="{{ asset('assets/js/rent.js') }}"></script>
@endsection