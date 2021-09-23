@extends('layout.admin')
@section('title','Reminder')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h4 class="m-0 text-dark">Reminder Details</h4>
          </div><!-- /.col -->
          <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="{{ route('reminder.index') }}">Reminder</a></li>
              <li class="breadcrumb-item active">Reminder Details</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <form action="#" method="post" enctype="multipart/form-data">
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
                                            <select name="car_type_id" id="car_type_id" class="form-control" readonly>
                                                <option selected disabled>Select</option>
                                                @foreach($car_types as $car_type) 
                                                    <option value="{{ $car_type->id }}" @if($reminder->car_type_id == $car_type->id) selected @endif>{{ $car_type->name }}</option>
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
                                            <input type="text" name="name" value="{{ $customer->name }}" class="form-control" placeholder="Customer Name" readonly/>
                                            @if($errors->has('name'))
                                                <span class="text-danger">{{ $errors->first('name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="phone">Phone <span class="text-danger" title="Required">*</span></label>
                                            <input type="text" name="phone" value="{{ $customer->phone }}" class="form-control" placeholder="Customer Phone no" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" readonly/>
                                            @if($errors->has('phone'))
                                                <span class="text-danger">{{ $errors->first('phone') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="total_person">Total Person</label>
                                            <input type="text" name="total_person" value="{{ $reminder->total_person }}" class="form-control" placeholder="Total Person" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" readonly/>
                                            @if($errors->has('total_person'))
                                                <span class="text-danger">{{ $errors->first('total_person') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="total_day">Total Day</label>
                                            <input type="text" name="total_day" value="{{ $reminder->total_day }}" class="form-control" placeholder="Total Day" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" readonly/>
                                            @if($errors->has('total_day'))
                                                <span class="text-danger">{{ $errors->first('total_day') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select name="status" class="form-control" readonly>
                                                <option value="1" @if($reminder->status == 1) selected @endif>Pending</option>
                                                <option value="2" @if($reminder->status == 2) selected @endif>Schedule Contact</option>
                                                <option value="3" @if($reminder->status == 3) selected @endif>Not Agree</option>
                                            </select>
                                            @if($errors->has('status'))
                                                <span class="text-danger">{{ $errors->first('status') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="rent_type">Rent Type</label>
                                            <select name="rent_type" class="form-control" readonly>
                                                <option value="1" @if($reminder->rent_type == 1) selected @endif>Drop Only</option>
                                                <option value="2" @if($reminder->rent_type == 2) selected @endif>Round Trip</option>
                                                <option value="3" @if($reminder->rent_type == 3) selected @endif>Body Rent</option>
                                            </select>
                                            @if($errors->has('rent_type'))
                                                <span class="text-danger">{{ $errors->first('rent_type') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="pickup_location">Pickup Location</label>
                                            <input type="text" name="pickup_location" value="{{ $reminder->pickup_location }}" id="pickup_location" class="form-control" placeholder="Pickup Location" readonly/>
                                            @if($errors->has('pickup_location'))
                                                <span class="text-danger">{{ $errors->first('pickup_location') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="pickup_datetime">Pickup Date Time</label>
                                            <input type="datetime-local" name="pickup_datetime" @if($reminder->pickup_datetime != null) value="{{ date('Y-m-d\TH:i:s', strtotime($reminder->pickup_datetime)) }}" @endif id="pickup_datetime" class="form-control" readonly/>
                                            @if($errors->has('pickup_datetime'))
                                                <span class="text-danger">{{ $errors->first('pickup_datetime') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="drop_location">Drop Location</label>
                                            <input type="text" name="drop_location" value="{{ $reminder->drop_location }}" id="drop_location" class="form-control" placeholder="Drop Location" readonly/>
                                            @if($errors->has('drop_location'))
                                                <span class="text-danger">{{ $errors->first('drop_location') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="drop_datetime">Drop Date Time</label>
                                            <input type="datetime-local" name="drop_datetime" @if($reminder->drop_datetime != null) value="{{ date('Y-m-d\TH:i:s', strtotime($reminder->drop_datetime)) }}" @endif id="drop_datetime" class="form-control" readonly/>
                                            @if($errors->has('drop_datetime'))
                                                <span class="text-danger">{{ $errors->first('drop_datetime') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3" id="returnDateTime" @if($reminder->rent_type == 1) style="display: none;" @endif>
                                        <div class="form-group">
                                            <label for="return_datetime">Return Date Time</label>
                                            <input type="datetime-local" name="return_datetime" @if($reminder->return_datetime != null) value="{{ date('Y-m-d\TH:i:s', strtotime($reminder->return_datetime)) }}" @endif id="return_datetime" class="form-control" readonly/>
                                            @if($errors->has('return_datetime'))
                                                <span class="text-danger">{{ $errors->first('return_datetime') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="asking_price">Asking Price</label>
                                            <input type="text" name="asking_price" id="asking_price" value="{{ $reminder->asking_price }}" class="form-control" placeholder="Enter Asking price" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" readonly/>
                                            @if($errors->has('asking_price'))
                                                <span class="text-danger">{{ $errors->first('asking_price') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="user_offered">User Offered</label>
                                            <input type="text" name="user_offered" id="user_offered" value="{{ $reminder->user_offered }}" class="form-control" placeholder="Enter User Offered Price" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" readonly/>
                                            @if($errors->has('user_offered'))
                                                <span class="text-danger">{{ $errors->first('user_offered') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="driver_accomodation">Driver Accomodation</label>
                                            <input type="text" name="driver_accomodation" id="driver_accomodation" value="{{ $reminder->driver_accomodation }}" class="form-control" placeholder="Driver Accomodation" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" readonly/>
                                            @if($errors->has('driver_accomodation'))
                                                <span class="text-danger">{{ $errors->first('driver_accomodation') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="interested">Interested</label>
                                            <select name="interested" class="form-control" readonly>
                                                <option value="1" @if($reminder->interested == 1) selected @endif>Yes</option>
                                                <option value="2" @if($reminder->interested == 2) selected @endif>No</option>
                                            </select>
                                            @if($errors->has('interested'))
                                                <span class="text-danger">{{ $errors->first('interested') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="contact_date">Contact Date</label>
                                            <input type="date" name="contact_date" value="{{ $reminder->contact_date }}" id="contact_date" class="form-control" readonly/>
                                            @if($errors->has('contact_date'))
                                                <span class="text-danger">{{ $errors->first('contact_date') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="next_contact_datetime">Next Contact Date Time</label>
                                            <input type="datetime-local" name="next_contact_datetime" @if($reminder->next_contact_datetime != null) value="{{ date('Y-m-d\TH:i:s', strtotime($reminder->next_contact_datetime)) }}" @endif id="pickup_datetime" class="form-control"  readonly/>
                                            @if($errors->has('next_contact_datetime'))
                                                <span class="text-danger">{{ $errors->first('next_contact_datetime') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <label for="note">Note</label>
                                            <input type="text" name="note" id="note" value="{{ $reminder->note }}" class="form-control" placeholder="Enter note.." readonly/>
                                            @if($errors->has('note'))
                                                <span class="text-danger">{{ $errors->first('note') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
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