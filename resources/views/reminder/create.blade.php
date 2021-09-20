@extends('layout.admin')
@section('title','Reminder')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h4 class="m-0 text-dark">Add New Reminder</h4>
          </div><!-- /.col -->
          <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="{{ route('reminder.index') }}">Reminder</a></li>
              <li class="breadcrumb-item active">Create Reminder</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <form action="{{ route('reminder.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">Reminder Information</div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label for="name">Car Type <span class="text-danger" title="Required">*</span></label>
                                            <select name="car_type_id" id="car_type_id" class="form-control">
                                                <option selected disabled>Select</option>
                                                @foreach($car_types as $car_type) 
                                                    <option value="{{ $car_type->id }}" @if(old("car_type_id") == $car_type->id) selected @endif>{{ $car_type->name }}</option>
                                                @endforeach
                                            </select>
                                            @if($errors->has('car_type_id'))
                                                <span class="text-danger">{{ $errors->first('car_type_id') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="name">Name <span class="text-danger" title="Required">*</span></label>
                                            <input type="text" name="name" value="{{ old('name') }}" class="form-control" placeholder="Customer Name" />
                                            @if($errors->has('name'))
                                                <span class="text-danger">{{ $errors->first('name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="phone">Phone <span class="text-danger" title="Required">*</span></label>
                                            <input type="text" name="phone" value="{{ old('phone') }}" class="form-control" placeholder="Customer Phone no" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"/>
                                            @if($errors->has('phone'))
                                                <span class="text-danger">{{ $errors->first('phone') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="total_person">Total Person</label>
                                            <input type="text" name="total_person" value="{{ old('total_person') }}" class="form-control" placeholder="Total Person" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"/>
                                            @if($errors->has('total_person'))
                                                <span class="text-danger">{{ $errors->first('total_person') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select name="status" class="form-control">
                                                <option value="1">Pending</option>
                                                <option value="2">Schedule Contact</option>
                                                <option value="3">Not Agree</option>
                                            </select>
                                            @if($errors->has('status'))
                                                <span class="text-danger">{{ $errors->first('status') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="rent_type">Rent Type</label>
                                            <select name="rent_type" class="form-control" id="rentType">
                                                <option value="1">Drop Only</option>
                                                <option value="2">Round Trip</option>
                                            </select>
                                            @if($errors->has('rent_type'))
                                                <span class="text-danger">{{ $errors->first('rent_type') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="pickup_location">Pickup Location</label>
                                            <input type="text" name="pickup_location" value="{{ old('pickup_location') }}" id="pickup_location" class="form-control" placeholder="Pickup Location" />
                                            @if($errors->has('pickup_location'))
                                                <span class="text-danger">{{ $errors->first('pickup_location') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="pickup_datetime">Pickup Date Time</label>
                                            <input type="datetime-local" name="pickup_datetime" value="{{ old('pickup_datetime') }}" id="pickup_datetime" class="form-control" />
                                            @if($errors->has('pickup_datetime'))
                                                <span class="text-danger">{{ $errors->first('pickup_datetime') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="drop_location">Drop Location</label>
                                            <input type="text" name="drop_location" value="{{ old('drop_location') }}" id="drop_location" class="form-control" placeholder="Drop Location" />
                                            @if($errors->has('drop_location'))
                                                <span class="text-danger">{{ $errors->first('drop_location') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="drop_datetime">Drop Date Time</label>
                                            <input type="datetime-local" name="drop_datetime" value="{{ old('drop_datetime') }}" id="drop_datetime" class="form-control" />
                                            @if($errors->has('drop_datetime'))
                                                <span class="text-danger">{{ $errors->first('drop_datetime') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3" id="returnDateTime" style="display: none;">
                                        <div class="form-group">
                                            <label for="return_datetime">Return Date Time</label>
                                            <input type="datetime-local" name="return_datetime" value="{{ old('return_datetime') }}" id="return_datetime" class="form-control" />
                                            @if($errors->has('return_datetime'))
                                                <span class="text-danger">{{ $errors->first('return_datetime') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="asking_price">Asking Price</label>
                                            <input type="text" name="asking_price" id="asking_price" value="{{ old('asking_price') }}" class="form-control" placeholder="Enter Asking price" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" />
                                            @if($errors->has('asking_price'))
                                                <span class="text-danger">{{ $errors->first('asking_price') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="user_offered">User Offered</label>
                                            <input type="text" name="user_offered" id="user_offered" value="{{ old('user_offered') }}" class="form-control" placeholder="Enter User Offered Price" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" />
                                            @if($errors->has('user_offered'))
                                                <span class="text-danger">{{ $errors->first('user_offered') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="next_contact_datetime">Next Contact Date Time</label>
                                            <input type="datetime-local" name="next_contact_datetime" value="{{ old('next_contact_datetime') }}" id="next_contact_datetime" class="form-control" />
                                            @if($errors->has('next_contact_datetime'))
                                                <span class="text-danger">{{ $errors->first('next_contact_datetime') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <label for="note">Note</label>
                                            <input type="text" name="note" id="note" value="{{ old('note') }}" class="form-control" placeholder="Enter note.." />
                                            @if($errors->has('note'))
                                                <span class="text-danger">{{ $errors->first('note') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
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
        </form>
    </section>
@endsection
@section('scripts')
    <script>
        $('.nav-reminder').addClass('active');
    </script>
    <script src="{{ asset('assets/js/reminder.js') }}"></script>
@endsection