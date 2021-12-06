@extends('layout.admin')
@section('title','Maintenance')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h4 class="m-0 text-dark">Add New Maintenance</h4>
          </div><!-- /.col -->
          <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="{{ route('maintenance.index') }}">Maintenance</a></li>
              <li class="breadcrumb-item active">Create Maintenance</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <form action="{{ route('maintenance.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">Maintenance Information</div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="date">Date <span class="text-danger" title="Required">*</span></label>
                                            <input type="date" name="date" value="{{ old('date') }}" id="date" class="form-control" required/>
                                            @if($errors->has('date'))
                                                <span class="text-danger">{{ $errors->first('date') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="purpose">Purpose <span class="text-danger" title="Required">*</span></label>
                                            <input type="text" name="purpose" value="{{ old('purpose') }}" id="purpose" class="form-control" placeholder="Enter Purpose" required/>
                                            @if($errors->has('purpose'))
                                                <span class="text-danger">{{ $errors->first('purpose') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="amount">Amount <span class="text-danger" title="Required">*</span></label>
                                            <input type="text" name="amount" id="amount" value="{{ old('amount') }}" class="form-control" placeholder="Enter Amount" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" required/>
                                            @if($errors->has('amount'))
                                                <span class="text-danger">{{ $errors->first('amount') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="paid_to">Paid To</label>
                                            <input type="text" name="paid_to" id="paid_to" value="{{ old('paid_to') }}" class="form-control" placeholder="Paid To" />
                                            @if($errors->has('paid_to'))
                                                <span class="text-danger">{{ $errors->first('paid_to') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="paid_by">Paid By</label>
                                            <input type="text" name="paid_by" id="paid_by" value="{{ old('paid_by') }}" class="form-control" placeholder="Paid By" />
                                            @if($errors->has('paid_by'))
                                                <span class="text-danger">{{ $errors->first('paid_by') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="payment_by">Payment By</label>
                                            <select name="payment_by" id="payment_by" class="form-control">
                                                <option value="0">Select</option>
                                                <option value="1">Cash</option>
                                                <option value="2">Bank</option>
                                                <option value="3">Bkash</option>
                                                <option value="4">Rocket</option>
                                                <option value="5">Nagad</option>
                                            </select>
                                            @if($errors->has('payment_by'))
                                                <span class="text-danger">{{ $errors->first('payment_by') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-sm btn-success">Submit</button>
                                            <button type="reset" class="btn btn-sm btn-danger">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
@endsection
@section('scripts')
    <script>
        $('.nav-rent').addClass('active');
    </script>
    <script src="{{ asset('assets/js/rent.js') }}"></script>
@endsection