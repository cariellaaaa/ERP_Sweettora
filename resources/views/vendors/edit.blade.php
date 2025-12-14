@extends('layouts.app')

@section('css')
@endsection

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Vendors Update</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('vendors.index') }}">Vendors</a></li>
                        <li class="breadcrumb-item active">Update</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-sm">
            <div class="card">
                {{-- <div class="card-header">
            
            </div> --}}
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger">{{ $error }}</div>
                    @endforeach
                @endif

                <div class="card-content">
                    <form action="{{ route('vendors.update', $data->id) }}" method="POST" class="needs-validation"
                        novalidate enctype="multipart/form-data" >
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            name="name" value="{{ old('name', $data->name) }}" id="name"
                                            placeholder="Please enter name" required>
                                        @error('name')
                                            <span class="invalid-feedback">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            value="{{ old('email', $data->email) }}" name="email" id="email" required>
                                        @error('email')
                                            <span class="invalid-feedback">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="phone">Phone</label>
                                        <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                            value="{{ old('phone', $data->phone) }}" name="phone" id="phone" required>
                                        @error('phone')
                                            <span class="invalid-feedback">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="postal_code">Postal Code</label>
                                        <input type="text"
                                            class="form-control @error('postal_code') is-invalid @enderror"
                                            value="{{ old('postal_code', $data->postal_code) }}" name="postal_code"
                                            id="postal_code" required>
                                        @error('postal_code')
                                            <span class="invalid-feedback">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="address">Address</label>
                                        <input type="text" class="form-control @error('address') is-invalid @enderror"
                                            value="{{ old('address', $data->address) }}" name="address" id="address"
                                            required>
                                        @error('address')
                                            <span class="invalid-feedback">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="npwp">NPWP</label>
                                        <input type="text" class="form-control @error('npwp') is-invalid @enderror"
                                            value="{{ old('npwp', $data->npwp) }}" name="npwp" id="npwp" required>
                                        @error('npwp')
                                            <span class="invalid-feedback">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                {{-- <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="country_id">Country</label>
                                        <select name="country_id" id="country_id"
                                            class="form-control basic-choices @error('country_id') is-invalid @enderror"
                                            data-placeholder="Choose a Country" required>
                                            <option value="" disabled selected hidden>Choose a Country</option>
                                            @foreach ($country as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ old('country_id') == $item->id ? 'selected' : '' }}>
                                                    {{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('country_id')
                                            <span class="invalid-feedback">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div> --}}
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="province_id">Province</label>
                                        <select name="province_id" id="province_id"
                                            class="form-control basic-choices @error('province_id') is-invalid @enderror"
                                            data-placeholder="Choose a Province" required>
                                            <option value="" disabled selected hidden>Choose a Province</option>
                                            @foreach ($province as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ old('province_id', $data->province_id) == $item->id ? 'selected' : '' }}>
                                                    {{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('province_id')
                                            <span class="invalid-feedback">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="city_id">City</label>
                                        <select name="city_id" id="city_id"
                                            class="form-control basic-choices @error('city_id') is-invalid @enderror"
                                            data-placeholder="Choose a City" required>
                                            <option value="" disabled selected hidden>Choose a City</option>
                                            @foreach ($city as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ old('city_id', $data->city_id) == $item->id ? 'selected' : '' }}>
                                                    {{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('city_id')
                                            <span class="invalid-feedback">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="image">Upload Image</label>
                                        <input type="file" name="image" id="uploadImage"
                                            class="form-control dnd-files-upload"
                                            value="{{ old('image', $data->image) }}" data-browse-on-zone-click="true">
                                    </div>
                                </div>
                                {{-- <div class="col-12">
                                <div class="mb-3">
                                    <label for="image">Upload Image</label>
                                    <div class="custom-upload-file">
                                        <input name="image" class="input-custom-file" id="image" type="file">
                                        <div class="d-flex flex-column justify-content-center text-center">
                                            <div class="">
                                                <h1>
                                                    <i class="fas fa-cloud-upload-alt"></i></h1>
                                            </div>
                                            <h5>Drop file here or click to upload</h5>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                                {{-- <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label for="vendor">Vendor</label>
                                    <select name="vendor_id" id="vendor" class="form-control basic-choices" data-placeholder="Choose a Vendor" required>
                                        <option value="" disabled selected hidden>Choose a Vendor</option>
                                        @foreach ($vendors as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> --}}
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex flex-row justify-content-end gap-2">

                                <a href="{{ url()->previous() }}" class="btn btn-light">Back</a>
                                <button class="btn btn-primary" type="submit">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
@endpush
