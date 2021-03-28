
@extends('layout.admin')
@section('title','Owner')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Owner</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <button class="btn btn-success float-right" data-toggle="modal" data-target="#createModal"><i class="fas fa-plus-circle"></i> Create</button>
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
                      <form class="form" action="{{ route('owner.index') }}" method="get" style="padding:10px 20px;">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" class="form-control" @if(isset($_GET['name'])) value="{{ $_GET['name'] }}" @endif placeholder="Enter name" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="text" name="phone" class="form-control" @if(isset($_GET['phone'])) value="{{ $_GET['phone'] }}" @endif placeholder="Enter phone no" />
                                </div>
                            </div>
                          <div class="col-md-3">
                            <div class="form-group">
                                <label for="name">Car Type</label>
                                <select name="car_type_id" class="form-control">
                                    @foreach($car_types as $car_type) 
                                        <option value="{{ $car_type->id }}" @if(isset($_GET['car_type_id']) && $car_type->id == $_GET['car_type_id']) selected @endif>{{ $car_type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="phone">Model</label>
                                <select name="model_id" class="form-control">
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
                                    @foreach($years as $year) 
                                        <option value="{{ $year->id }}" @if(isset($_GET['year_id']) && $year->id == $_GET['year_id']) selected @endif>{{ $year->name }}</option>
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
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Car Type</th>
                                <th>Model</th>
                                <th>Year</th>
                                <th>Contract Amount</th>
                                <th style="vertical-align: middle;text-align: center;">Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Car Type</th>
                                <th>Model</th>
                                <th>Year</th>
                                <th>Contract Amount</th>
                              <th style="vertical-align: middle;text-align: center;">Action</th>
                          </tr>
                        </tfoot>
                        <tbody id="allOwner">
                          @foreach($owners as $owner)
                            <tr class="owner-{{ $owner->id }}">
                              <td>{{ $owner->name }}</td>
                              <td>{{ $owner->phone }}</td>
                              <td>{{ $owner->car_type_name }}</td>
                              <td>{{ $owner->model_name }}</td>
                              <td>{{ $owner->year_name }}</td>
                              <td>{{ $owner->contract_amount }}</td>
                              <td style="vertical-align: middle;text-align: center;">
                                  <button class="btn btn-xs btn-warning" data-toggle="modal" id="edit" data-target="#editModal" data-id="{{ $owner->id }}" data-name="{{ $owner->name }}" data-phone="{{ $owner->phone }}"
                                    data-car_type_id="{{ $owner->car_type_id }}" data-model_id="{{ $owner->model_id }}" data-year_id="{{ $owner->year_id }}"  data-contract_amount="{{ $owner->contract_amount }}"
                                    data-address="{{ $owner->address }}" title="Edit">Edit</button>
                                  <button class="btn btn-xs btn-danger" data-toggle="modal" id="delete" data-target="#deleteModal" data-id="{{ $owner->id }}" title="Delete">Delete</button>
                              </td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                      <div class="d-felx justify-content-center mt-3">
                        {{ $owners->links('pagination::bootstrap-4') }}
                      </div>
                    </div>
                </div>
            </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <div class="modal fade" tabindex="-1" id="createModal" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-default" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                  <h5 class="modal-title text-center w-100">Add New</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label class="col-form-label">Name <span class="text-danger" title="Required">*</span></label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="Name" required>
                                <span class="errorName text-danger text-bold"></span>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label class="col-form-label">Phone <span class="text-danger" title="Required">*</span></label>
                                <input type="text" class="form-control" name="phone" id="phone" placeholder="Phone" required>
                                <span class="errorPhone text-danger text-bold"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label class="col-form-label">Address <span class="text-danger" title="Required">*</span></label>
                                <input type="text" class="form-control" name="address" id="address" placeholder="Enter Address" required>
                                <span class="errorName text-danger text-bold"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                          <div class="form-group">
                            <label for="name">Car Type</label>
                            <select name="car_type_id" id="car_type_id" class="form-control">
                              <option selected disabled>Select</option>
                              @foreach($car_types as $car_type) 
                                  <option value="{{ $car_type->id }}">{{ $car_type->name }}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                              <label for="name">Model</label>
                              <select name="model_id" id="model_id" class="form-control">
                                <option selected disabled>Select</option>
                                  @foreach($models as $model) 
                                      <option value="{{ $model->id }}">{{ $model->name }}</option>
                                  @endforeach
                              </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="name">Year</label>
                                <select name="year_id" id="year_id" class="form-control">
                                    <option selected disabled>Select</option>
                                    @foreach($years as $year) 
                                        <option value="{{ $year->id }}" @if(isset($_GET['year_id']) && $year->id == $_GET['year_id']) selected @endif>{{ $year->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="contract_amount">Conract Amount</label>
                                <input type="text" id="contract_amount" class="form-control" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="create">Save</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="editModal" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-default" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                  <h5 class="modal-title text-center w-100">Edit</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label class="col-form-label">Name <span class="text-danger" title="Required">*</span></label>
                                <input type="text" class="form-control" name="name" id="edit_name" placeholder="Name" required>
                                <input type="hidden" id="edit_id"/>
                                <span class="errorName text-danger text-bold"></span>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label class="col-form-label">Phone <span class="text-danger" title="Required">*</span></label>
                                <input type="text" class="form-control" name="phone" id="edit_phone" placeholder="Phone" required>
                                <span class="errorPhone text-danger text-bold"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label class="col-form-label">Address <span class="text-danger" title="Required">*</span></label>
                                <input type="text" class="form-control" name="address" id="edit_address" placeholder="Enter Address" required>
                                <span class="errorName text-danger text-bold"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                          <div class="form-group">
                            <label for="name">Car Type</label>
                            <select name="car_type_id" id="edit_car_type_id" class="form-control">
                              <option selected disabled>Select</option>
                              @foreach($car_types as $car_type) 
                                  <option value="{{ $car_type->id }}">{{ $car_type->name }}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                              <label for="name">Model</label>
                              <select name="model_id" id="edit_model_id" class="form-control">
                                <option selected disabled>Select</option>
                                  @foreach($models as $model) 
                                      <option value="{{ $model->id }}">{{ $model->name }}</option>
                                  @endforeach
                              </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="name">Year</label>
                                <select name="year_id" id="edit_year_id" class="form-control">
                                    <option selected disabled>Select</option>
                                    @foreach($years as $year) 
                                        <option value="{{ $year->id }}" @if(isset($_GET['year_id']) && $year->id == $_GET['year_id']) selected @endif>{{ $year->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="contract_amount">Conract Amount</label>
                                <input type="text" id="edit_contract_amount" class="form-control" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="update">Update</button>
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
@endsection
@section('scripts')
    <script src="{{ asset('assets/js/owner.js') }}"></script>
    <script>
        $('.nav-driver').addClass('active');
    </script>
@endsection