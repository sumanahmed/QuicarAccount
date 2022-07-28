@extends('layout.admin')
@section('title','Rent')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h4 class="m-0 text-dark">Add New Rent</h4>
          </div><!-- /.col -->
          <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="{{ route('rent.index') }}">Rent</a></li>
              <li class="breadcrumb-item active">Create Rent</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <form action="{{ route('rent.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">Rent Information</div>
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
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label for="model_id">Model <span class="text-danger" title="Required">*</span></label>
                                            <select name="model_id" id="model_id" class="form-control">
                                                <option selected disabled>Select</option>
                                            </select>
                                            @if($errors->has('model_id'))
                                                <span class="text-danger">{{ $errors->first('model_id') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="year">Year </label>
                                            <select name="year_id" class="form-control selectable">
                                                <option selected disabled>Select</option>
                                                @foreach($years as $year) 
                                                    <option value="{{ $year->id }}">{{ $year->name }}</option>
                                                @endforeach
                                            </select>
                                            @if($errors->has('year_id'))
                                                <span class="text-danger"> {{ $errors->first('year_id') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="customer_id">Customer <a href="{{ route('customer.index') }}" target="_blank">Add New</a></label>
                                            <select name="customer_id" class="form-control selectable">
                                                <option selected disabled>Select</option>
                                                @foreach($customers as $customer) 
                                                    <option value="{{ $customer->id }}" @if(old("customer_id") == $customer->id) selected @endif>{{ $customer->name }} ({{ $customer->phone}})</option>
                                                @endforeach
                                            </select>
                                            @if($errors->has('customer_id'))
                                                <span class="text-danger">{{ $errors->first('customer_id') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="driver_id">Driver</label>
                                            <select name="driver_id" class="form-control selectable">
                                                <option selected disabled>Select</option>
                                                @foreach($drivers as $driver) 
                                                    <option value="{{ $driver->id }}" @if(old("driver_id") == $driver->id) selected @endif>{{ $driver->name }} ({{ $driver->phone }})</option>
                                                @endforeach
                                            </select>
                                            @if($errors->has('driver_id'))
                                                <span class="text-danger">{{ $errors->first('driver_id') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="reg_number">Registration No</label>
                                            <input type="text" name="reg_number" value="{{ old('reg_number') }}" class="form-control" placeholder="Enter registration no" />
                                            @if($errors->has('reg_number'))
                                                <span class="text-danger">{{ $errors->first('reg_number') }}</span>
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
                                            <label for="total_day">Total Day</label>
                                            <input type="text" oninput="calculatePrice()" name="total_day" id="total_day" value="{{ old('total_day') }}" class="form-control" placeholder="Total Day" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"/>
                                            @if($errors->has('total_day'))
                                                <span class="text-danger">{{ $errors->first('total_day') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="rent_type">Rent Type</label>
                                            <select name="rent_type" class="form-control" id="rentType">
                                                <option value="1">Drop Only</option>
                                                <option value="2">Round Trip</option>
                                                <option value="3">Body Rent</option>
                                                <option value="4">Monthly</option>
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
                                            <label for="drop_location">Destination</label>
                                            <input type="text" name="drop_location" value="{{ old('drop_location') }}" id="drop_location" class="form-control" placeholder="Destination" />
                                            @if($errors->has('drop_location'))
                                                <span class="text-danger">{{ $errors->first('drop_location') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <!-- <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="drop_datetime">Drop Date Time</label>
                                            <input type="datetime-local" name="drop_datetime" value="{{ old('drop_datetime') }}" id="drop_datetime" class="form-control" />
                                            @if($errors->has('drop_datetime'))
                                                <span class="text-danger">{{ $errors->first('drop_datetime') }}</span>
                                            @endif
                                        </div>
                                    </div> -->
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
                                            <label for="price">Price</label>
                                            <input type="text" oninput="calculatePrice()" name="price" id="price" value="{{ old('price') }}" class="form-control" placeholder="Enter price" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"/>
                                            @if($errors->has('price'))
                                                <span class="text-danger">{{ $errors->first('price') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="advance">Advance</label>
                                            <input type="text" oninput="calculatePrice()" name="advance" id="advance" value="{{ old('advance') }}" class="form-control" placeholder="Enter advance" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"/>
                                            @if($errors->has('advance'))
                                                <span class="text-danger">{{ $errors->first('advance') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="commission">Commission</label>
                                            <input type="text" name="commission" id="commission" value="{{ old('commission') }}" class="form-control" placeholder="Enter commission" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"/>
                                            @if($errors->has('commission'))
                                                <span class="text-danger">{{ $errors->first('commission') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="remaining">Remaining</label>
                                            <input type="text" oninput="calculatePrice()" name="remaining" id="remaining" value="{{ old('remaining') }}" class="form-control" placeholder="Enter remaining" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"/>
                                            @if($errors->has('remaining'))
                                                <span class="text-danger">{{ $errors->first('remaining') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="referred_by">Referred By</label>
                                            <input type="text" name="referred_by" id="referred_by" value="{{ old('referred_by') }}" class="form-control" placeholder="Referred By"/>
                                            @if($errors->has('referred_by'))
                                                <span class="text-danger">{{ $errors->first('referred_by') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3" id="bodyRent" style="display: none;">
                                        <div class="form-group">
                                            <label for="body_rent">Body Rent (Per Day)</label>
                                            <input type="text" oninput="calculatePrice()" name="body_rent" id="body_rent" value="{{ old('body_rent') }}" class="form-control" placeholder="Body Rent" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"/>
                                            @if($errors->has('body_rent'))
                                                <span class="text-danger">{{ $errors->first('body_rent') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3" id="fuleCost" style="display: none;">
                                        <div class="form-group">
                                            <label for="fuel">Fuel Cost (Per Km)</label>
                                            <input type="text" name="fuel" id="fuel" value="{{ old('fuel') }}" class="form-control" placeholder="Fuel Cost" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"/>
                                            @if($errors->has('fuel'))
                                                <span class="text-danger">{{ $errors->first('fuel') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3" id="driverAccomodation" style="display: none;">
                                        <div class="form-group">
                                            <label for="driver_accomodation">Driver Accomodation (Per Day)</label>
                                            <input type="text" name="driver_accomodation" id="driver_accomodation" value="{{ old('driver_accomodation') }}" class="form-control" placeholder="Driver Accomodation" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"/>
                                            @if($errors->has('driver_accomodation'))
                                                <span class="text-danger">{{ $errors->first('driver_accomodation') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="total_vehicle">Total Vehicle</label>
                                            <input type="text" oninput="calculatePrice()" name="total_vehicle" id="total_vehicle" value="{{ old('total_vehicle') }}" class="form-control" placeholder="Total Vehicle" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"/>
                                            @if($errors->has('total_vehicle'))
                                                <span class="text-danger">{{ $errors->first('total_vehicle') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="note">Note</label>
                                            <textarea name="note" id="note" class="form-control" cols="4" placeholder="Enter note..">{{ old('note') }}</textarea>
                                            @if($errors->has('note'))
                                                <span class="text-danger">{{ $errors->first('note') }}</span>
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