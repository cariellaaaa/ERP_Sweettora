@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Receive Item Edit</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('receive-items.index') }}">Receive Items</a></li>
                        <li class="breadcrumb-item active">Edit</li>
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

                <form action="{{ route('receive-items.update', $receiveItem->id) }}" method="POST" class="needs-validation"
                    novalidate>
                    @csrf
                    @method('PUT')

                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label for="code" class="form-label">Code</label>
                                <input type="text" class="form-control @error('code') is-invalid @enderror"
                                    name="code" id="code" placeholder="Leave empty for auto-generation"
                                    value="{{ old('code', $receiveItem->code) }}">
                                @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="trx_date" class="form-label">Transaction Date <span
                                        class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('trx_date') is-invalid @enderror"
                                    name="trx_date" id="trx_date" value="{{ old('trx_date', $receiveItem->trx_date) }}"
                                    required>
                                @error('trx_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="purchase_order_id" class="form-label">Purchase Order <span
                                        class="text-danger">*</span></label>
                                <select name="purchase_order_id" id="purchase_order_id"
                                    class="form-control basic-choices @error('purchase_order_id') is-invalid @enderror"
                                    required>
                                    <option value="" disabled>Choose a Purchase Order</option>
                                    @foreach ($purchaseOrders as $po)
                                        <option value="{{ $po->id }}"
                                            {{ old('purchase_order_id', $receiveItem->purchase_order_id) == $po->id ? 'selected' : '' }}>
                                            {{ $po->code }} - {{ $po->vendor->name ?? 'N/A' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('purchase_order_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="total" class="form-label">Total <span class="text-danger">*</span></label>
                                <input type="number" step="0.01"
                                    class="form-control @error('total') is-invalid @enderror" name="total" id="total"
                                    value="{{ old('total', $receiveItem->total) }}" required>
                                <small class="text-muted">Masukkan total secara manual</small>
                                @error('total')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="status" id="status"
                                    class="form-control basic-choices @error('status') is-invalid @enderror" required>
                                    <option value="" disabled>Choose a Status</option>
                                    <option value="Draft"
                                        {{ old('status', $receiveItem->status) == 'Draft' ? 'selected' : '' }}>Draft
                                    </option>
                                    <option value="Quotation"
                                        {{ old('status', $receiveItem->status) == 'Quotation' ? 'selected' : '' }}>
                                        Quotation</option>
                                    <option value="Confirmed"
                                        {{ old('status', $receiveItem->status) == 'Confirmed' ? 'selected' : '' }}>
                                        Confirmed</option>
                                    <option value="Done"
                                        {{ old('status', $receiveItem->status) == 'Done' ? 'selected' : '' }}>Done</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" id="description" rows="5"
                                    class="form-control @error('description') is-invalid @enderror">{{ old('description', $receiveItem->description) }}</textarea>
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
                                                <th>Product Name</th>
                                                <th>Quantity</th>
                                                <th>Received</th>
                                                <th>Unit</th>
                                                <th>Price</th>
                                                <th>Tax (%)</th>
                                                <th>Subtotal</th>
                                                <th>Total</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="empty-row">
                                                <td colspan="9" class="text-center text-muted">No products added yet.
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
                            <button type="submit" class="btn btn-primary">Update</button>
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
                            <label for="modal_received" class="form-label">Received</label>
                            <input type="number" class="form-control" id="modal_received" value="0"
                                min="0" step="1">
                        </div>

                        <div class="col-md-6">
                            <label for="modal_price" class="form-label">Price</label>
                            <input type="number" step="0.01" class="form-control" id="modal_price" value="0">
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
            new Choices('#purchase_order_id', {
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

            // Load existing items from database
            let orderItems = [
                @foreach ($receiveItem->receiveItemDetails as $detail)
                    {
                        product_id: {{ $detail->product_id }},
                        product_name: "{{ $detail->product->name ?? 'N/A' }}",
                        unit_id: {{ $detail->unit_id }},
                        unit_name: "{{ $detail->unit->name ?? 'N/A' }}",
                        quantity: {{ $detail->quantity }},
                        received: {{ $detail->received }},
                        price: {{ $detail->price }},
                        paid: {{ $detail->paid }},
                        subtotal: {{ $detail->subtotal }},
                        tax: {{ $detail->tax }},
                        tax_value: {{ $detail->tax_value }},
                        total: {{ $detail->total }}
                    }
                    {{ !$loop->last ? ',' : '' }}
                @endforeach
            ];

            const tbody = document.querySelector('#orderItemsTable tbody');
            const itemsContainer = document.getElementById('orderItemsContainer');
            const btnAddToTable = document.getElementById('btnAddToTable');

            function renderTable() {
                tbody.innerHTML = '';

                if (orderItems.length === 0) {
                    tbody.innerHTML =
                        `<tr class="empty-row"><td colspan="9" class="text-center text-muted">No products added yet.</td></tr>`;
                    return;
                }

                orderItems.forEach((item, index) => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${item.product_name}</td>
                        <td>${item.quantity}</td>
                        <td>${item.received}</td>
                        <td>${item.unit_name}</td>
                        <td>${parseFloat(item.price).toLocaleString('id-ID')}</td>
                        <td>${item.tax}%</td>
                        <td>${parseFloat(item.subtotal).toLocaleString('id-ID')}</td>
                        <td>${parseFloat(item.total).toLocaleString('id-ID')}</td>
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
                        <input type="hidden" name="items[${index}][received]" value="${item.received}">
                        <input type="hidden" name="items[${index}][price]" value="${item.price}">
                        <input type="hidden" name="items[${index}][paid]" value="${item.paid}">
                        <input type="hidden" name="items[${index}][subtotal]" value="${item.subtotal}">
                        <input type="hidden" name="items[${index}][tax]" value="${item.tax}">
                        <input type="hidden" name="items[${index}][tax_value]" value="${item.tax_value}">
                        <input type="hidden" name="items[${index}][total]" value="${item.total}">
                    `;
                });
            }
            btnAddToTable.addEventListener('click', function() {
                const productId = document.getElementById('modal_product_id').value;
                const productName = choicesProduct.getValue(true) ? choicesProduct.getValue().label : '';
                const unitId = document.getElementById('modal_unit_id').value;
                const unitName = choicesUnit.getValue(true) ? choicesUnit.getValue().label : '';
                const quantity = parseInt(document.getElementById('modal_quantity').value) || 1;
                const received = parseInt(document.getElementById('modal_received').value) || 0;
                const price = parseFloat(document.getElementById('modal_price').value) || 0;
                const tax = parseFloat(document.getElementById('modal_tax').value) || 0;

                if (!productId || !unitId) {
                    alert('Please select both Product and Unit!');
                    return;
                }

                // Calculate values
                const subtotal = quantity * price;
                const tax_value = subtotal * (tax / 100);
                const total = subtotal + tax_value;
                const paid = received * price;

                orderItems.push({
                    product_id: productId,
                    product_name: productName,
                    unit_id: unitId,
                    unit_name: unitName,
                    quantity: quantity,
                    received: received,
                    price: price,
                    paid: paid,
                    subtotal: subtotal,
                    tax: tax,
                    tax_value: tax_value,
                    total: total
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
                document.getElementById('modal_received').value = '0';
                document.getElementById('modal_price').value = '0';
                document.getElementById('modal_tax').value = '0';
            });

            document.querySelector('form').addEventListener('submit', function() {
                generateHiddenInputs();
            });

            // Initial render
            renderTable();
            generateHiddenInputs();
        });
    </script>
@endpush
