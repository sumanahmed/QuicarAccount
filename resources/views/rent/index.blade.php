
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
                          <div class="col-md-3">
                            <div class="form-group">
                                <label for="name">Car Type</label>
                                <select name="car_type_id" class="form-control select2">
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
                              <select name="model_id" class="form-control">
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
                                <th>Reg No</th>
                                <th>Price</th>
                                <th>Advance</th>
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
                              <td style="vertical-align: middle;text-align: center;">
                                  <a href="{{ route('rent.edit', $rent->id) }}" class="btn btn-xs btn-warning" title="Edit">Edit</a>
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
    <script>
        $('.nav-rent').addClass('active');
    </script>
    <script src="{{ asset('assets/js/rent.js') }}"></script>
@endsection