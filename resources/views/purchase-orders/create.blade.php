@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Purchase Order Create</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('purchase-orders.index') }}">Purchase Orders</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('purchase-orders.store') }}" method="POST" class="needs-validation" novalidate>
                    @csrf

                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label for="code" class="form-label">Code</label>
                                <input type="text" class="form-control @error('code') is-invalid @enderror"
                                    name="code" id="code" placeholder="Leave empty for auto-generation"
                                    value="{{ old('code') }}">
                                @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="vendor_id" class="form-label">Vendor <span class="text-danger">*</span></label>
                                <select name="vendor_id" id="vendor_id"
                                    class="form-control basic-choices @error('vendor_id') is-invalid @enderror" required>
                                    <option value="" disabled {{ old('vendor_id') ? '' : 'selected' }}>Choose a Vendor
                                    </option>
                                    @foreach ($vendors as $vendor)
                                        <option value="{{ $vendor->id }}"
                                            {{ old('vendor_id') == $vendor->id ? 'selected' : '' }}>
                                            {{ $vendor->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('vendor_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="total" class="form-label">Total <span class="text-danger">*</span></label>
                                <input type="number" step="0.01"
                                    class="form-control @error('total') is-invalid @enderror" name="total" id="total"
                                    value="{{ old('total', 0) }}" required>
                                <small class="text-muted">Masukkan total secara manual</small>
                                @error('total')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="status" id="status"
                                    class="form-control basic-choices @error('status') is-invalid @enderror" required>
                                    <option value="" disabled {{ old('status') ? '' : 'selected' }}>Choose a Status
                                    </option>
                                    <option value="Draft" {{ old('status') == 'Draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="Quotation" {{ old('status') == 'Quotation' ? 'selected' : '' }}>
                                        Quotation</option>
                                    <option value="Confirmed" {{ old('status') == 'Confirmed' ? 'selected' : '' }}>
                                        Confirmed</option>
                                    <option value="Done" {{ old('status') == 'Done' ? 'selected' : '' }}>Done</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" id="description" rows="5"
                                    class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mt-4">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="card-title mb-0">Order Items</h5>
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#addProductModal">
                                        <i class="fas fa-plus me-1"></i> Add Product
                                    </button>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped" id="orderItemsTable">
                                        <thead class="table-light">
                                            <tr>
                                                <th width="35%">Product Name</th>
                                                <th width="15%">Quantity</th>
                                                <th width="15%">Unit</th>
                                                <th width="15%">Tax (%)</th>
                                                <th width="20%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="empty-row">
                                                <td colspan="5" class="text-center text-muted">No products added yet.
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div id="orderItemsContainer"></div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ url()->previous() }}" class="btn btn-light">Back</a>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductModalLabel">Add Product to Order</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="modal_product_id" class="form-label">Product <span
                                    class="text-danger">*</span></label>
                            <select class="form-select modal-choices" id="modal_product_id">
                                <option value="" selected disabled>Select Product</option>
                                @foreach ($products as $product)
                                    <option value="{{ $product->id }}" data-price="{{ $product->price ?? 0 }}">
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="modal_unit_id" class="form-label">Unit <span class="text-danger">*</span></label>
                            <select class="form-select modal-choices" id="modal_unit_id">
                                <option value="" selected disabled>Select Unit</option>
                                @foreach ($units as $unit)
                                    <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="modal_quantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="modal_quantity" value="1"
                                min="1" step="1">
                        </div>

                        <div class="col-md-6">
                            <label for="modal_tax" class="form-label">Tax (%)</label>
                            <input type="number" step="0.01" class="form-control" id="modal_tax" value="0">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btnAddToTable">Add to Order</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new Choices('#vendor_id', {
                searchEnabled: true,
                itemSelectText: '',
                shouldSort: false
            });
            new Choices('#status', {
                searchEnabled: true,
                itemSelectText: '',
                shouldSort: false
            });
            const choicesProduct = new Choices('#modal_product_id', {
                searchEnabled: true,
                itemSelectText: '',
                shouldSort: false
            });
            const choicesUnit = new Choices('#modal_unit_id', {
                searchEnabled: true,
                itemSelectText: '',
                shouldSort: false
            });

            let orderItems = [];

            const tbody = document.querySelector('#orderItemsTable tbody');
            const itemsContainer = document.getElementById('orderItemsContainer');
            const btnAddToTable = document.getElementById('btnAddToTable');

            function renderTable() {
                tbody.innerHTML = '';

                if (orderItems.length === 0) {
                    tbody.innerHTML =
                        `<tr class="empty-row"><td colspan="5" class="text-center text-muted">No products added yet.</td></tr>`;
                    return;
                }

                orderItems.forEach((item, index) => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${item.product_name}</td>
                        <td>${item.quantity}</td>
                        <td>${item.unit_name}</td>
                        <td>${item.tax}%</td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm remove-item" data-index="${index}">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </td>
                    `;
                    tbody.appendChild(row);
                });
            }

            function generateHiddenInputs() {
                itemsContainer.innerHTML = '';
                orderItems.forEach((item, index) => {
                    itemsContainer.innerHTML += `
                        <input type="hidden" name="items[${index}][product_id]" value="${item.product_id}">
                        <input type="hidden" name="items[${index}][unit_id]" value="${item.unit_id}">
                        <input type="hidden" name="items[${index}][quantity]" value="${item.quantity}">
                        <input type="hidden" name="items[${index}][tax]" value="${item.tax}">
                    `;
                });
            }
            btnAddToTable.addEventListener('click', function() {
                const productId = document.getElementById('modal_product_id').value;
                const productName = choicesProduct.getValue(true) ? choicesProduct.getValue().label : '';
                const unitId = document.getElementById('modal_unit_id').value;
                const unitName = choicesUnit.getValue(true) ? choicesUnit.getValue().label : '';
                const quantity = parseInt(document.getElementById('modal_quantity').value) || 1;
                const tax = parseFloat(document.getElementById('modal_tax').value) || 0;

                if (!productId || !unitId) {
                    alert('Please select both Product and Unit!');
                    return;
                }

                orderItems.push({
                    product_id: productId,
                    product_name: productName,
                    unit_id: unitId,
                    unit_name: unitName,
                    quantity: quantity,
                    tax: tax
                });

                renderTable();
                generateHiddenInputs();

                const modal = bootstrap.Modal.getInstance(document.getElementById('addProductModal'));
                modal.hide();
            });
            tbody.addEventListener('click', function(e) {
                const btn = e.target.closest('.remove-item');
                if (btn) {
                    const index = parseInt(btn.dataset.index);
                    orderItems.splice(index, 1);
                    renderTable();
                    generateHiddenInputs();
                }
            });

            document.getElementById('addProductModal').addEventListener('hidden.bs.modal', function() {
                choicesProduct.setChoiceByValue('');
                choicesUnit.setChoiceByValue('');
                document.getElementById('modal_quantity').value = '1';
                document.getElementById('modal_tax').value = '0';
            });

            document.querySelector('form').addEventListener('submit', function() {
                generateHiddenInputs();
            });
            renderTable();
        });
    </script>
@endpush
