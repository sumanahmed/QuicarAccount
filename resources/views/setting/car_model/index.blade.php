@extends('layout.admin')
@section('title','Car Model')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Car Model</h1>
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
                      <form class="form" action="{{ route('car_model.index') }}" method="get" style="padding:10px 20px;">
                        <div class="row">
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="name">Name</label>
                              <input type="text" name="name" class="form-control" @if(isset($_GET['name'])) value="{{ $_GET['name'] }}" @endif placeholder="Enter name" />
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="name">Car Type</label>                              
                              <select name="car_type_id" class="form-control" required>
                                <option value="0">Select</option>
                                @foreach($car_types as $type)
                                  <option value="{{ $type->id }}" @if(isset($_GET['car_type_id']) && $_GET['car_type_id'] == $type->id) selected @endif>{{ $type->name }}</option>
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
                                <th>Car Type</th>
                                <th>Name</th>
                                <th style="vertical-align: middle;text-align: center;">Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                              <th>Car Type</th>
                              <th>Name</th>
                              <th style="vertical-align: middle;text-align: center;">Action</th>
                          </tr>
                        </tfoot>
                        <tbody id="allModel">
                          @foreach($car_models as $model)
                            <tr class="model-{{ $model->id }}">
                              <td>{{ $model->car_type_name }}</td>
                              <td>{{ $model->name }}</td>
                              <td style="vertical-align: middle;text-align: center;">
                                  <button class="btn btn-xs btn-warning" data-toggle="modal" id="edit" data-target="#editModal" data-id="{{ $model->id }}" data-name="{{ $model->name }}" data-car_type_id="{{ $model->car_type_id }}" title="Edit">Edit</button>
                                  <button class="btn btn-xs btn-danger" data-toggle="modal" id="delete" data-target="#deleteModal" data-id="{{ $model->id }}" title="Delete">Delete</button>
                              </td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                      <div class="d-felx justify-content-center mt-3">
                        {{ $car_models->links('pagination::bootstrap-4') }}
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
                    <div class="form-group">
                      <label class="col-form-label">Car Type <span class="text-danger" title="Required">*</span></label>
                      <select id="car_type_id" class="form-control" required>
                        <option selected disabled>Select</option>
                        @foreach($car_types as $type)
                          <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                      </select>
                      <span class="errorCarType text-danger text-bold"></span>
                    </div>                    
                    <div class="form-group">
                      <label class="col-form-label">Name <span class="text-danger" title="Required">*</span></label>
                      <input type="text" class="form-control" name="name" id="name" placeholder="Name" required>
                      <span class="errorName text-danger text-bold"></span>
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
                    <div class="form-group">
                      <label class="col-form-label">Car Type <span class="text-danger" title="Required">*</span></label>
                      <select id="edit_car_type_id" class="form-control" required>
                        <option selected disabled>Select</option>
                        @foreach($car_types as $type)
                          <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                        <input type="hidden" id="edit_id" />
                      </select>
                      <span class="errorCarType text-danger text-bold"></span>
                    </div>                    
                    <div class="form-group">
                      <label class="col-form-label">Name <span class="text-danger" title="Required">*</span></label>
                      <input type="text" class="form-control" name="edit_name" id="edit_name" placeholder="Name" required>
                      <span class="errorName text-danger text-bold"></span>
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
    <script src="{{ asset('assets/js/car-model.js') }}"></script>
    <script>
        $('.nav-model').addClass('active');
    </script>
@endsection