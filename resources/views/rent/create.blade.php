@extends('layout.admin')
@section('title','Rent')

@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.15/dist/summernote-bs4.min.css" rel="stylesheet">
@endsection

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
                            <div class="card-header">Basic Information</div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="en_name">Name(En) <span class="text-danger" title="Required">*</span></label>
                                            <input type="text" id="en_name" name="en_name" value="{{ old('en_name') }}" class="form-control" placeholder="Enter product name in English" required>
                                            @if($errors->has('en_name'))
                                                <span class="text-danger">{{ $errors->first('en_name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="bn_name">Name(Bn) <span class="text-danger" title="Required">*</span></label>
                                            <input type="text" id="bn_name" name="bn_name" value="{{ old('bn_name') }}" class="form-control" placeholder="Enter product name in Bengali" required>
                                            @if($errors->has('bn_name'))
                                                <span class="text-danger">{{ $errors->first('bn_name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label for="code">Code <span class="text-danger" title="Required">*</span></label>
                                            <div class="input-group mb-3">
                                                <input type="text" name="code" id="code" class="form-control rounded-0" value="P{{ $code }}"  readonly>
                                            </div>                                            
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label for="quantity">Quantity</label>
                                            <div class="input-group mb-3">
                                                <input type="text" name="quantity" value="{{ old('quantity') }}" id="quantity" class="form-control rounded-0" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required>
                                            </div>
                                            @if($errors->has('quantity'))
                                                <span class="text-danger">{{ $errors->first('quantity') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-3" style="margin-top: 37px;">
                                        <div class="form-group">
                                            <div class="icheck-primary d-inline">
                                                <input type="checkbox" name="featured" id="featured" value="1">
                                                <label for="featured">Featured</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-3" style="margin-top: 37px;">
                                        <div class="form-group">
                                            <div class="icheck-primary d-inline">
                                                <input type="checkbox" name="new_arrival" id="new_arrival" value="1">
                                                <label for="new_arrival">New Arrival</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="master_category_id">Master Category <span class="text-danger" title="Required">*</span></label>
                                            <select id="master_category_id" name="master_category_id" class="form-control select2" required>
                                                <option selected disabled>Select</option>
                                                @foreach($master_categories as $master_category)
                                                    <option value="{{ $master_category->id }}">{{ $master_category->en_name }}</option>
                                                @endforeach
                                            </select>
                                            @if($errors->has('master_category_id'))
                                                <span class="text-danger">{{ $errors->first('master_category_id') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="category_id">Category </label>
                                            <select id="category_id" name="category_id" class="form-control select2">

                                            </select>
                                            <span class="text-danger errorCategory"></span>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="subcategory_id">Subcategory </label>
                                            <select id="subcategory_id" name="subcategory_id" class="form-control select2">

                                            </select>
                                            <span class="text-danger errorCategory"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">Price Information</div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="purchase_price">Purchase Price <span class="text-danger" title="Required">*</span></label>
                                            <input type="text" name="purchase_price" id="purchase_price" value="{{ old('purchase_price') }}" class="form-control" placeholder="Purchase Price" required oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">                                            
                                            @if($errors->has('purchase_price'))
                                                <span class="text-danger">{{ $errors->first('purchase_price') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="sale_price">Sale Price <span class="text-danger" title="Required">*</span></label>
                                            <input type="text" name="sale_price" id="sale_price" value="{{ old('sale_price') }}" class="form-control" placeholder="Sale Price" require oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                                            @if($errors->has('sale_price'))
                                                <span class="text-danger">{{ $errors->first('sale_price') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-4">
                                    <div class="form-group">
                                        <label for="status">Status  <span class="text-danger" title="Required">*</span></label>
                                        <select class="form-control" name="status" id="status">
                                            <option value="1" selected>Show</option>
                                            <option value="0">Hide</option>
                                        </select>
                                    </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-4">
                                    <div class="form-group">
                                        <label for="discount_id">Discount</label>
                                        <select class="form-control select2" name="discount_id" id="discount_id">
                                            <option value="0">Select</option>
                                            @foreach($discounts as $discount)
                                                <option value="{{ $discount->id }}">
                                                    @if($discount->type == 1)   
                                                        {{ $discount->amount." %" }}
                                                    @else
                                                        {{ $discount->amount." BDT" }}
                                                    @endif
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="vat_id">Vat</label>
                                            <select class="form-control select2" name="vat_id" id="vat_id">
                                                <option  value="0">Select</option>
                                                @foreach($vats as $vat)
                                                    <option value="{{ $vat->id }}">
                                                        @if($vat->type == 1)   
                                                            {{ $vat->amount." %" }}
                                                        @else
                                                            {{ $vat->amount." BDT" }}
                                                        @endif
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="availability">Availability  <span class="text-danger" title="Required">*</span></label>
                                            <select class="form-control" name="availability" id="availability">
                                            <option value="1" selected>In Stock</option>
                                            <option value="0">Out Stock</option>
                                        </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="card">
                            <div class="card-header">Description(En) <span class="text-danger" title="Required">*</span></div>
                            <div class="card-body">
                                <div class="form-group">
                                    <textarea name="en_description" rows="6" class="form-control textarea" placeholder="Description(En)" required></textarea>
                                    @if($errors->has('en_description'))
                                        <span class="text-danger">{{ $errors->first('en_description') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card">
                            <div class="card-header">Description(Bn) <span class="text-danger" title="Required">*</span></div>
                            <div class="card-body">
                                <div class="form-group">
                                    <textarea name="bn_description" rows="6" class="form-control textarea" placeholder="Description(Bn)" required></textarea>
                                    @if($errors->has('bn_description'))
                                        <span class="text-danger">{{ $errors->first('bn_description') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">Product Images</div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="thumbnail">Thumbnail <span class="text-danger" title="Required">*</span></label>
                                            <div class="avatar-upload">
                                                <div class="avatar-edit">
                                                    <input type='file' name="thumbnail" id="thumbnailUpload" accept=".png, .jpg, .jpeg" required/>
                                                    <label for="thumbnailUpload"><i class="fas fa-pencil-alt"></i></label>
                                                </div>
                                                <div class="avatar-preview" style="width:100%">
                                                    <div id="thumbnailPreview" style="background-image: url({{ asset('shobuj_bazar/backend/images/default_bg.jpg') }});"></div>
                                                </div>
                                                @if($errors->has('thumbnail'))
                                                    <span class="text-danger">{{ $errors->first('thumbnail') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="image_1">Image One</label>
                                            <div class="avatar-upload">
                                            <div class="avatar-edit">
                                                <input type='file' name="image_1" id="image1Upload" accept=".png, .jpg, .jpeg"/>
                                                <label for="image1Upload"><i class="fas fa-pencil-alt"></i></label>
                                            </div>
                                            <div class="avatar-preview" style="width:100%">
                                                <div id="image1Preview" style="background-image: url({{ asset('shobuj_bazar/backend/images/default_bg.jpg') }});"></div>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row" style="margin-top:30px;">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="image_2">Image Two</label>
                                            <div class="avatar-upload">
                                            <div class="avatar-edit">
                                                <input type='file' name="image_2" id="image2Upload" accept=".png, .jpg, .jpeg"/>
                                                <label for="image2Upload"><i class="fas fa-pencil-alt"></i></label>
                                            </div>
                                            <div class="avatar-preview" style="width:100%">
                                                <div id="image2Preview" style="background-image: url({{ asset('shobuj_bazar/backend/images/default_bg.jpg') }});"></div>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="image_3">Image Three </label>
                                            <div class="avatar-upload">
                                            <div class="avatar-edit">
                                                <input type='file' name="image_3" id="image3Upload" accept=".png, .jpg, .jpeg"/>
                                                <label for="image3Upload"><i class="fas fa-pencil-alt"></i></label>
                                            </div>
                                            <div class="avatar-preview" style="width:100%">
                                                <div id="image3Preview" style="background-image: url({{ asset('shobuj_bazar/backend/images/default_bg.jpg') }});"></div>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="image_4">Image Four </label>
                                            <div class="avatar-upload">
                                            <div class="avatar-edit">
                                                <input type='file' name="image_4" id="image4Upload" accept=".png, .jpg, .jpeg"/>
                                                <label for="image4Upload"><i class="fas fa-pencil-alt"></i></label>
                                            </div>
                                            <div class="avatar-preview" style="width:100%">
                                                <div id="image4Preview" style="background-image: url({{ asset('shobuj_bazar/backend/images/default_bg.jpg') }});"></div>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-success" value="Submit"/>
                                            <input type="reset" class="btn btn-danger" value="Cancel"/>
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
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.15/dist/summernote-bs4.min.js"></script>
    <script src="{{ asset('shobuj_bazar/backend/js/product.js') }}"></script>
    <script>
        $('.menu-product').addClass('menu-open');
        $('.nav-create-product').addClass('active');
    </script>
    <script>
        $('.textarea').summernote({
            placeholder: '',
            tabsize: 2,
            height: 250
        });
    </script>
@endsection