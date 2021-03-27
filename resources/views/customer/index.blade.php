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
            <button class="btn btn-success float-right" data-toggle="modal" data-target="#addNew><i class="fas fa-plus-circle"></i> Create</button>
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
                    <div class="card-body">
                      <table id="masterCategory" class="table table-sm table-bordered table-striped data_table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Name</th>
                                <th>Phone</th>
                              <th>Action</th>
                          </tr>
                        </tfoot>
                        <tbody id="allCustomer">
                          @foreach($customers as $customer)
                            <tr class="customer-{{ $customer->id }}">
                              <td>{{ $customer->name }}</td>
                              <td>{{ $customer->phone }}</td>
                              <td>
                                  <button class="btn btn-warning" data-toggle="modal" id="edit" data-id="{{ $customer->id }}" data-name="{{ $customer->name }}" data-customer="{{ $customer->phone }}" title="Edit"><i class="fa fa-pencil-alt"></i></button>
                                  <button class="btn btn-danger" data-toggle="modal" id="delete" data-id="{{ $customer->id }}" title="Delete"><i class="fa fa-trash"></i></button>
                              </td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                      {{ $customers->links() }}
                    </div>
                </div>
            </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <div class="modal fade" tabindex="-1" id="addNew" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-default" role="document">
          <form id="createCategoryForm" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }} {{ method_field('POST') }}
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                  <h5 class="modal-title text-center w-100">Create New Category</h5>
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
                  <h5 class="modal-title text-center w-100">Edit Category</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                      <label class="col-form-label">Name(En) <span class="text-danger" title="Required">*</span></label>
                      <input type="text" class="form-control" name="en_name" id="edit_en_name" placeholder="Name(en)" required>
                      <span class="errorEnName text-danger text-bold"></span>
                    </div>

                    <div class="form-group">
                      <label class="col-form-label">Name(Bn) <span class="text-danger" title="Required">*</span></label>
                      <input type="text" class="form-control" name="bn_name" id="edit_bn_name" placeholder="Name(bn)" required>
                      <span class="errorBnName text-danger text-bold"></span>
                    </div>
                    <div class="form-group">
                      <label class="col-form-label">Description(En) </label>
                      <textarea class="form-control" name="en_description"  id="edit_en_description" placeholder="Description(en)"></textarea>
                      <span class="errorEnDescription text-danger text-bold"></span>
                    </div>

                    <div class="form-group">
                      <label class="col-form-label">Description(Bn) </label>
                      <textarea class="form-control" name="bn_description" id="edit_bn_description" placeholder="Description(bn)"></textarea>
                      <span class="errorBnDescription text-danger text-bold"></span>
                    </div>

                    <div class="form-group">
                      <label class="col-form-label">Previous Image <span class="text-danger" title="Required">*</span></label>
                      <img class="form-control" id="categoryPreviousImage" src="" style="width:60px" />
                    </div>

                    <div class="form-group">
                      <label class="col-form-label">Update Image <span class="text-danger" title="Required">*</span></label>
                      <input type="file" name="image" id="edit_image" required>
                      <span class="errorImage text-danger text-bold"></span>
                    </div>

                    <div class="form-group">
                      <label class="col-form-label">Status <span class="text-danger" title="Required">*</span></label>
                     <div>
                        <select id="edit_status" name="status" class="form-control">
                          <option value="1">Active</option>
                          <option value="0">Inactive</option>
                        </select>
                        <span class="errorStatus text-danger text-bold"></span>
                      </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="updateCategory">Update</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
            </div>
          </form>
        </div>
    </div>
    <div class="modal fade" tabindex="-1" id="deleteCategoryModal" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
                    <button type="button" class="btn btn-success" id="destroyCategory">Delete</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('shobuj_bazar/backend/js/customer.js') }}"></script>
    <script>
        $('.nav-customer').addClass('active');
    </script>
@endsection