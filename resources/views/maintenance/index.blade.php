
@extends('layout.admin')
@section('title','Maintenance')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Maintenance Charge</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <a href="{{ route('maintenance.create') }}" class="btn btn-success float-right"><i class="fas fa-plus-circle"></i> Create </a>
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
                      <form class="form" action="{{ route('maintenance.index') }}" method="get" style="padding:10px 20px;">
                        <div class="row">
                          <div class="col-md-2">
                            <div class="form-group">
                              <label for="purpose">Purpose</label>
                                <input type="text" name="purpose" @if(isset($_GET['purpose'])) value="{{ $_GET['purpose'] }}" @endif class="form-control">
                            </div>
                          </div>
                          <div class="col-md-2">
                            <div class="form-group">
                              <label for="start_date">Start Date</label>
                              <input type="date" name="start_date" value="{{ $start_date }}" class="form-control">
                            </div>
                          </div>
                          <div class="col-md-2">
                            <div class="form-group">
                              <label for="end_date">End Date</label>
                              <input type="date" name="end_date" value="{{ $end_date }}" class="form-control">
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <input type="submit" class="btn btn-info btn-sm" value="Search" style="margin-top: 30px;" />
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group" style='margin-top:30px;'>
                              <h5>Total Maintenace Charge: <strong>{{ $total_maintenace_charge }}</strong></h5>
                            </div>
                          </div>
                        </div>
                      </form>
                    </div>
                    <div class="card-body">
                      <table class="table table-sm table-bordered table-striped data_table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Purpose</th>
                                <th>Amount</th>
                                <th>Paid To</th>
                                <th>Paid By</th>
                                <th>Payment By</th>
                                <th style="vertical-align: middle;text-align: center;">Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Date</th>
                                <th>Purpose</th>
                                <th>Amount</th>
                                <th>Paid To</th>
                                <th>Paid By</th>
                                <th>Payment By</th>
                              <th style="vertical-align: middle;text-align: center;">Action</th>
                          </tr>
                        </tfoot>
                        <tbody id="allMaintenance">
                          @foreach($maintenances as $maintenance)
                            <tr class="maintenance-{{ $maintenance->id }}">
                              <td>{{ date('d M, Y', strtotime($maintenance->date)) }}</td>
                              <td>{{ $maintenance->purpose }}</td>
                              <td>{{ $maintenance->amount }}</td>
                              <td>{{ $maintenance->paid_to }}</td>
                              <td>{{ $maintenance->paid_by }}</td>
                              <td>{{ getPaymentBy($maintenance->payment_by) }}</td>
                              <td style="vertical-align: middle;text-align: center;">
                                <a href="{{ route('maintenance.edit', $maintenance->id) }}" class="btn btn-xs btn-warning" title="Edit">Edit</a>
                                <button class="btn btn-xs btn-danger" data-toggle="modal" id="maintenanceDelete" data-target="#rentDeleteModal" data-id="{{ $maintenance->id }}" title="Delete">Delete</button>                                  
                              </td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                      <div class="d-felx justify-content-center mt-3">
                        {{ $maintenances->links('pagination::bootstrap-4') }}
                      </div>
                    </div>
                </div>
            </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <?php
      function getPaymentBy ($paymentBy) {
        if ($paymentBy == 1) {
          echo "Cash";
        } else if ($paymentBy == 2) {
          echo "Bank";
        } else if ($paymentBy == 3) {
          echo "Bkash";
        } else if ($paymentBy == 4) {
          echo "Rocket";
        } else if ($paymentBy == 5) {
          echo "Nagad";
        }
      }
    ?>
    <div class="modal fade" tabindex="-1" id="maintenanceDeleteModal" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
                    <button type="button" class="btn btn-success" id="maintenanceDestroy">Delete</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
      $('.maintenance-charge').addClass('active');
    </script>
    <script>
      $(document).on('click', '#maintenanceDelete', function () {
        $('#maintenanceDeleteModal').modal('show');
        $('input[name=del_id]').val($(this).data('id'));
      });

      $("#maintenanceDestroy").click(function(){
        $.ajax({
            type: 'POST',
            url: '/maintenance/destroy',
            headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
            data: {
              id: $('input[name=del_id]').val()
            },
            success: function (data) {
                $('#maintenanceDeleteModal').modal('hide');
                $('.maintenance-' + $('input[name=del_id]').val()).remove();
                toastr.success('Maintenance Deleted')
            }
        });
      });
    </script>
@endsection