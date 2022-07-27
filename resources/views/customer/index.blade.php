@extends('layout.admin')
@section('title','Customer')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Customer</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <button class="btn btn-warning float-right" data-toggle="modal" data-target="#bulkUploadModal"><i class="fas fa-upload"></i> Bulk Customer Import</button>
            <button class="btn btn-success float-right mr-2" data-toggle="modal" data-target="#createModal"><i class="fas fa-plus-circle"></i> Create</button>
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
                      <form class="form" action="{{ route('customer.index') }}" method="get" style="padding:10px 20px;">
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
                            <div class="form-group" style="margin-top: 30px;">
                              <input type="submit" class="btn btn-info btn-sm" value="Search" />
                              <a href="{{ route('customer.export') }}" class="btn btn-warning btn-sm">Export <i class="fa fa-download"></i></a>
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
                                <th style="vertical-align: middle;text-align: center;">Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                              <th>Name</th>
                              <th>Phone</th>
                              <th style="vertical-align: middle;text-align: center;">Action</th>
                          </tr>
                        </tfoot>
                        <tbody id="allCustomer">
                          @foreach($customers as $customer)
                            <tr class="customer-{{ $customer->id }}">
                              <td>{{ $customer->name }}</td>
                              <td>{{ $customer->phone }}</td>
                              <td style="vertical-align: middle;text-align: center;">
                                  <button class="btn btn-xs btn-warning" data-toggle="modal" id="edit" data-target="#editModal" data-id="{{ $customer->id }}" data-name="{{ $customer->name }}" data-phone="{{ $customer->phone }}" title="Edit">Edit</button>
                                  <button class="btn btn-xs btn-danger" data-toggle="modal" id="delete" data-target="#deleteModal" data-id="{{ $customer->id }}" title="Delete">Delete</button>
                              </td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                      <div class="d-felx justify-content-center mt-3">
                        {{ $customers->links('pagination::bootstrap-4') }}
                      </div>
                    </div>
                </div>
            </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <div class="modal fade" tabindex="-1" id="bulkUploadModal" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-default" role="document">
          <form id="customerForm" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }} {{ method_field('POST') }}
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                  <h5 class="modal-title text-center w-100">Bulk Upload Customer</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                      <label class="col-form-label">Excel File <span class="text-danger" title="Required">*</span></label>
                      <input type="file" class="form-control" name="excel_file" id="excel_file" required>
                      <span class="errorName text-danger text-bold"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="assets/customer_bulk_upload_format.xlsx" class="btn btn-warning">Download Sample File</a>
                    <button type="submit" class="btn btn-success" id="bulkUpload">Upload</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
            </div>
          </form>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="createModal" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-default" role="document">
          <form id="createCategoryForm" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }} {{ method_field('POST') }}
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                  <h5 class="modal-title text-center w-100">Add New</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                      <label class="col-form-label">Name <span class="text-danger" title="Required">*</span></label>
                      <input type="text" class="form-control" name="name" id="name" placeholder="Name" required>
                      <span class="errorName text-danger text-bold"></span>
                    </div>

                    <div class="form-group">
                      <label class="col-form-label">Phone <span class="text-danger" title="Required">*</span></label>
                      <input type="text" class="form-control" name="phone" id="phone" placeholder="Phone" required>
                      <span class="errorPhone text-danger text-bold"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="create">Save</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
            </div>
          </form>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="editModal" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-default" role="document">
          <form id="editCategoryForm" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }} {{ method_field('POST') }}
            <input type="hidden" id="edit_category_id" />
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                  <h5 class="modal-title text-center w-100">Edit</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                      <label class="col-form-label">Name <span class="text-danger" title="Required">*</span></label>
                      <input type="text" class="form-control" id="edit_name" placeholder="Name" required>
                      <input type="hidden" id="edit_id" />
                      <span class="nameError text-danger text-bold"></span>
                    </div>

                    <div class="form-group">
                      <label class="col-form-label">Phone <span class="text-danger" title="Required">*</span></label>
                      <input type="text" class="form-control" id="edit_phone" placeholder="Phone" required>
                      <span class="errorBnName text-danger text-bold"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="update">Update</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
            </div>
          </form>
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
    <script src="{{ asset('assets/js/customer.js') }}"></script>
    <script>
        $('.nav-customer').addClass('active');
    </script>
@endsection