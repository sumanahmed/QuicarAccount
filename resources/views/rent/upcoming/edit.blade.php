@extends('layout.admin')
@section('title','Rent')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h4 class="m-0 text-dark">Update Rent</h4>
          </div><!-- /.col -->
          <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
              <li class="breadcrumb-item"><a href="{{ route('rent.index') }}">Rent</a></li>
              <li class="breadcrumb-item active">Edit Rent</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <form action="{{ route('rent.upcoming.update', $rent->id) }}" method="post" enctype="multipart/form-data">
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
                                                <option value="0">Select</option>
                                                @foreach($car_types as $car_type) 
                                                    <option value="{{ $car_type->id }}" @if($rent->car_type_id == $car_type->id) selected @endif>{{ $car_type->name }}</option>
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
                                                <option value="0">Select</option>
                                                @foreach($models as $model) 
                                                    <option value="{{ $model->id }}" @if($rent->model_id == $model->id) selected @endif>{{ $model->name }}</option>
                                                @endforeach
                                            </select>
                                            @if($errors->has('model_id'))
                                                <span class="text-danger">{{ $errors->first('model_id') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="year">Year</label>
                                            <select name="year_id" class="form-control">
                                                <option value="0">Select</option>
                                                @foreach($years as $year) 
                                                    <option value="{{ $year->id }}" @if($rent->year_id == $year->id) selected @endif>{{ $year->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="customer_id">Customer</label>
                                            <select name="customer_id" class="form-control selectable">
                                                <option value="0">Select</option>
                                                @foreach($customers as $customer) 
                                                    <option value="{{ $customer->id }}" @if($rent->customer_id == $customer->id) selected @endif>{{ $customer->name }} ({{ $customer->phone}})</option>
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
                                                <option value="0">Select</option>
                                                @foreach($drivers as $driver) 
                                                    <option value="{{ $driver->id }}" @if($rent->driver_id == $driver->id) selected @endif>{{ $driver->name }} ({{ $driver->phone }})</option>
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
                                            <input type="text" name="reg_number" class="form-control" value="{{ $rent->reg_number }}" placeholder="Enter registration no" />
                                            @if($errors->has('reg_number'))
                                                <span class="text-danger">{{ $errors->first('reg_number') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="total_person">Total Person</label>
                                            <input type="text" name="total_person" class="form-control" value="{{ $rent->total_person }}" placeholder="Total Person" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"/>
                                            @if($errors->has('total_person'))
                                                <span class="text-danger">{{ $errors->first('total_person') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="rent_type">Rent Type</label>
                                            <select name="rent_type" class="form-control">
                                                <option value="1" @if($rent->rent_type == 1) selected @endif>Drop Only</option>
                                                <option value="2" @if($rent->rent_type == 2) selected @endif>Round Trip</option>
                                                <option value="3" @if($rent->rent_type == 3) selected @endif>Body Rent</option>
                                                <option value="4" @if($rent->rent_type == 4) selected @endif>Monthly</option>
                                            </select>
                                            @if($errors->has('rent_type'))
                                                <span class="text-danger">{{ $errors->first('rent_type') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select name="status" class="form-control">
                                                <option value="1" @if($rent->status == 1) selected @endif>New</option>
                                                <option value="2" @if($rent->status == 2) selected @endif>Upcoming</option>
                                                <option value="3" @if($rent->status == 3) selected @endif>Complete</option>
                                                <option value="4" @if($rent->status == 4) selected @endif>Cancel</option>
                                            </select>
                                            @if($errors->has('status'))
                                                <span class="text-danger">{{ $errors->first('status') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="pickup_location">Pickup Location</label>
                                            <input type="text" name="pickup_location" id="pickup_location" value="{{ $rent->pickup_location }}" class="form-control" placeholder="Pickup Location" />
                                            @if($errors->has('pickup_location'))
                                                <span class="text-danger">{{ $errors->first('pickup_location') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="pickup_datetime">Pickup Date Time</label>
                                            <input type="datetime-local" name="pickup_datetime" @if($rent->pickup_datetime != null) value="{{ date('Y-m-d\TH:i:s', strtotime($rent->pickup_datetime)) }}" @endif id="pickup_datetime" class="form-control" />
                                            @if($errors->has('pickup_datetime'))
                                                <span class="text-danger">{{ $errors->first('pickup_datetime') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="drop_location">Drop Location</label>
                                            <input type="text" name="drop_location" id="drop_location" value="{{ $rent->drop_location }}" class="form-control" placeholder="Drop Location" />
                                            @if($errors->has('drop_location'))
                                                <span class="text-danger">{{ $errors->first('drop_location') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="drop_datetime">Drop Date Time</label>
                                            <input type="datetime-local" name="drop_datetime" @if($rent->drop_datetime != null) value="{{ date('Y-m-d\TH:i:s', strtotime($rent->drop_datetime)) }}" @endif id="drop_datetime" class="form-control" />
                                            @if($errors->has('drop_datetime'))
                                                <span class="text-danger">{{ $errors->first('drop_datetime') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3" id="returnDateTime" @if($rent->rent_type == 1) style="display: none;" @endif>
                                        <div class="form-group">
                                            <label for="return_datetime">Return Date Time</label>
                                            <input type="datetime-local" name="return_datetime" @if($rent->return_datetime != null) value="{{ date('Y-m-d\TH:i:s', strtotime($rent->return_datetime)) }}" @endif id="return_datetime" class="form-control" />
                                            @if($errors->has('return_datetime'))
                                                <span class="text-danger">{{ $errors->first('return_datetime') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="price">Price</label>
                                            <input type="text" name="price" id="price" value="{{ $rent->price }}" class="form-control" placeholder="Enter price" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"/>
                                            @if($errors->has('price'))
                                                <span class="text-danger">{{ $errors->first('price') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="advance">Advance</label>
                                            <input type="text" name="advance" id="advance" value="{{ $rent->advance }}" class="form-control" placeholder="Enter advance" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"/>
                                            @if($errors->has('advance'))
                                                <span class="text-danger">{{ $errors->first('advance') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="commission">Commission</label>
                                            <input type="text" name="commission" id="commission" value="{{ $rent->commission }}" class="form-control" placeholder="Enter commission" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"/>
                                            @if($errors->has('commission'))
                                                <span class="text-danger">{{ $errors->first('commission') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="remaining">Remaining</label>
                                            <input type="text" name="remaining" id="remaining" value="{{ $rent->remaining }}" class="form-control" placeholder="Enter remaining" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"/>
                                            @if($errors->has('remaining'))
                                                <span class="text-danger">{{ $errors->first('remaining') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="fuel_cost">Fuel Cost</label>
                                            <input type="text" name="fuel_cost" id="fuel_cost" value="{{ $rent->fuel_cost }}" class="form-control" placeholder="Fuel Cost" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"/>
                                            @if($errors->has('fuel_cost'))
                                                <span class="text-danger">{{ $errors->first('fuel_cost') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="other_cost">Others Cost</label>
                                            <input type="text" name="other_cost" id="other_cost" value="{{ $rent->other_cost }}" class="form-control" placeholder="Others Cost" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"/>
                                            @if($errors->has('other_cost'))
                                                <span class="text-danger">{{ $errors->first('other_cost') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="driver_get">Driver get</label>
                                            <input type="text" name="driver_get" id="driver_get" value="{{ $rent->driver_get }}" class="form-control" placeholder="Driver get" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"/>
                                            @if($errors->has('driver_get'))
                                                <span class="text-danger">{{ $errors->first('driver_get') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="driver_accomodation">Driver Accomodation</label>
                                            <input type="text" name="driver_accomodation" id="driver_accomodation" value="{{ $rent->driver_accomodation }}" class="form-control" placeholder="Driver Accomodation" />
                                            @if($errors->has('driver_accomodation'))
                                                <span class="text-danger">{{ $errors->first('driver_accomodation') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="start_date">Start Date</label>
                                            <input type="date" name="start_date" value="{{ $rent->start_date }}" id="start_date" class="form-control"/>
                                            @if($errors->has('start_date'))
                                                <span class="text-danger">{{ $errors->first('start_date') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="billing_date">Billing Date</label>
                                            <input type="date" name="billing_date" value="{{ $rent->billing_date }}" id="billing_date" class="form-control" />
                                            @if($errors->has('billing_date'))
                                                <span class="text-danger">{{ $errors->first('billing_date') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <label for="note">Note</label>
                                            <input type="text" name="note" id="note" value="{{ $rent->note }}" class="form-control" placeholder="note.." />
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
        $('.nav-rent').addClass('active');
    </script>
@endsection