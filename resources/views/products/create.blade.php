@extends('layouts.app')

@section('css')
@endsection

@section('content')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Product Create</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
                    <li class="breadcrumb-item active">Create</li>
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
                <form action="{{ route('products.store') }}" method="POST" class="needs-validation" novalidate enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label for="name">Code</label>
                                    <input type="text" class="form-control @error('code') is-invalid @enderror" name="code" id="code" placeholder="Leave it empty for auto-generation" required>
                                    @error('code')
                                    <span class="invalid-feedback">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" name="name" id="name" required>
                                    @error('name')
                                    <span class="invalid-feedback">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label for="type">Product Type</label>
                                    <select name="type" id="type" class="form-control basic-choices @error('type') is-invalid @enderror" data-placeholder="Choose a Product Type" required>
                                        <option value="" disabled selected hidden>Choose a Product Type</option>
                                        <option value="product" {{ old('type') == 'product' ? 'selected':'' }}>Product &#40;For Sale&#41;</option>
                                        <option value="raw" {{ old('type') == 'raw' ? 'selected':'' }}>Raw Product &#40;Material&#41;</option>
                                    </select>
                                </div>
                                @error('type')
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label for="category">Category</label>
                                    <select name="product_category_id" id="category" class="form-control basic-choices @error('product_category_id') is-invalid @enderror" data-placeholder="Choose a Category" required>
                                        <option value="" disabled selected hidden>Choose a Category</option>
                                        @foreach ($categories as $item)
                                        <option value="{{ $item->id }}" {{ old('product_category_id') == $item->id ? 'selected':'' }}>{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('product_category_id')
                                    <span class="invalid-feedback">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="mb-3 z-0">
                                    <label for="unit">Unit</label>
                                    <select name="unit_id" id="unit" class="form-control basic-choices @error('unit_id') is-invalid @enderror" data-placeholder="Choose a Unit" required>
                                        <option value="" disabled selected hidden>Choose a Unit</option>
                                        @foreach ($units as $item)
                                        <option value="{{ $item->id }}" {{ old('unit_id') == $item->id ? 'selected':'' }}>{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('unit_id')
                                    <span class="invalid-feedback">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="mb-3 z-0">
                                    <label for="tags">Tags</label>
                                    <input class="form-control choices-text @error('tags') is-invalid @enderror" name="tags" id="tags" type="text" value="{{ old('tags') }}" placeholder="" />
                                    @error('tags')
                                    <span class="invalid-feedback">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label for="cost">Cost &#40;Production Cost&#41;</label>
                                    <input type="text" class="form-control format-rupiah" value="{{ old('cost') }}" name="cost" id="cost" required>
                                    @error('cost')
                                    <span class="invalid-feedback">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="mb-3">
                                    <label for="price">Price &#40;Sale Price&#41;</label>
                                    <input type="text" class="form-control format-rupiah @error('price') is-invalid @enderror" value="{{ old('price') }}" name="price" id="price" required>
                                    @error('price')
                                    <span class="invalid-feedback">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="description">Description</label>
                                    <textarea name="description" class="form-control text-editor @error('description') is-invalid @enderror" id="description" cols="30" rows="10">{{ old('description') }}</textarea>
                                    @error('description')
                                    <span class="invalid-feedback">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="image">Upload Image</label>
                                    <input type="file" name="image" id="uploadImage" class="form-control dnd-files-upload" value="{{ old('image') }}" data-browse-on-zone-click="true">
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
