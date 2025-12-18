@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Edit Inventory Stock</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('inventories.index') }}">Inventories</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <form action="{{ route('inventories.update', $inventory->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Product <span class="text-danger">*</span></label>
                                <select name="product_id" id="product_id" class="form-select" required>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}"
                                            {{ $inventory->product_id == $product->id ? 'selected' : '' }}>
                                            {{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Warehouse</label>
                                <select name="warehouse_id" id="warehouse_id" class="form-select">
                                    <option value="">Choose Warehouse</option>
                                    @foreach ($warehouses as $wh)
                                        <option value="{{ $wh->id }}"
                                            {{ $inventory->warehouse_id == $wh->id ? 'selected' : '' }}>{{ $wh->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Batch Number</label>
                                <input type="text" name="batch_number" class="form-control"
                                    value="{{ $inventory->batch_number }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Quantity <span class="text-danger">*</span></label>
                                <input type="number" name="quantity" class="form-control"
                                    value="{{ $inventory->quantity }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Reserved</label>
                                <input type="number" name="reserved" class="form-control"
                                    value="{{ $inventory->reserved }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Unit Cost <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" name="unit_cost" class="form-control"
                                    value="{{ $inventory->unit_cost }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Expiry Date</label>
                                <input type="date" name="expiry_date" class="form-control"
                                    value="{{ $inventory->expiry_date }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="status" id="status" class="form-select" required>
                                    <option value="Active" {{ $inventory->status == 'Active' ? 'selected' : '' }}>Active
                                    </option>
                                    <option value="Inactive" {{ $inventory->status == 'Inactive' ? 'selected' : '' }}>
                                        Inactive</option>
                                    <option value="Expired" {{ $inventory->status == 'Expired' ? 'selected' : '' }}>Expired
                                    </option>
                                    <option value="Damaged" {{ $inventory->status == 'Damaged' ? 'selected' : '' }}>Damaged
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Location</label>
                                <input type="text" name="location" class="form-control"
                                    value="{{ $inventory->location }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Reorder Level</label>
                                <input type="number" name="reorder_level" class="form-control"
                                    value="{{ $inventory->reorder_level }}">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Max Stock</label>
                                <input type="number" name="max_stock" class="form-control"
                                    value="{{ $inventory->max_stock }}">
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Notes</label>
                                <textarea name="notes" class="form-control" rows="2">{{ $inventory->notes }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('inventories.index') }}" class="btn btn-light">Back</a>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new Choices('#product_id', {
                searchEnabled: true,
                itemSelectText: '',
                shouldSort: false
            });

            new Choices('#warehouse_id', {
                searchEnabled: true,
                itemSelectText: '',
                shouldSort: false
            });

            new Choices('#status', {
                searchEnabled: false,
                itemSelectText: '',
                shouldSort: false
            });
        });
    </script>
@endpush
