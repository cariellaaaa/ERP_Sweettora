@extends('layouts.app')

@section('content')
<style>
    .odoo-card { background:#fff; padding:25px; border:1px solid #ddd; }
    .odoo-header-btn { margin-right:5px; }
    .step-badge {
        background:#6c63ff;
        padding:6px 15px;
        color:white;
        border-radius:20px;
        font-size:13px;
        margin-left:15px;
    }
    .odoo-tabs a {
        padding:10px 20px;
        display:inline-block;
        border-bottom:3px solid transparent;
        font-weight:600;
        color:#666;
        cursor:pointer;
    }
    .odoo-tabs a.active {
        color:#6c63ff;
        border-bottom:3px solid #6c63ff;
    }
    .label-title { font-weight:600; margin-bottom:5px; color:#444; }
</style>

<div class="container">

    <!-- HEADER -->
    <div class="d-flex justify-content-between mb-3">
        <h4>Create Manufacturing Order</h4>

        <div>
            <button form="moForm" class="btn btn-primary odoo-header-btn">Save</button>
            <a href="{{ route('manufacturing-order.index') }}" class="btn btn-secondary odoo-header-btn">Discard</a>
        </div>
    </div>

    <div class="d-flex mb-3">
        <button class="btn btn-light odoo-header-btn">Print</button>
        <button class="btn btn-light odoo-header-btn">Action</button>

        <span class="step-badge">Draft</span>
    </div>

    <div class="odoo-card">

        <form id="moForm" action="{{ route('manufacturing-order.store') }}" method="POST">
            @csrf

            <div class="row">
                <!-- LEFT COLUMN -->
                <div class="col-md-6">

                    <div class="mb-3">
                        <div class="label-title">Product</div>
                        <select name="product_id" class="form-control" required>
                            @foreach($products as $p)
                                <option value="{{ $p->id }}">{{ $p->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <div class="label-title">Quantity To Produce</div>
                        <input type="number" name="quantity" class="form-control" min="1" required>
                    </div>

                    <div class="mb-3">
                        <div class="label-title">Bill of Material</div>
                        <select name="bill_of_material_id" class="form-control" required>
                            @foreach($boms as $b)
                                <option value="{{ $b->id }}">{{ $b->reference }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>

                <!-- RIGHT COLUMN -->
                <div class="col-md-6">

                    <div class="mb-3">
                        <div class="label-title">Schedule Date</div>
                        <input type="datetime-local" class="form-control" value="{{ now()->format('Y-m-d\TH:i') }}">
                    </div>

                    <div class="mb-3">
                        <div class="label-title">Responsible</div>
                        <input type="text" class="form-control" value="{{ auth()->user()->name }}" readonly>
                    </div>

                    <div class="mb-3">
                        <div class="label-title">Source</div>
                        <input type="text" class="form-control" placeholder="-">
                    </div>

                </div>
            </div>

            <!-- TABS -->
            <div class="odoo-tabs mt-4">
                <a class="active">Consumed Materials</a>
                <a>Finished Products</a>
                <a>Miscellaneous</a>
            </div>

            <!-- TABLE -->
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Unit</th>
                        <th>To Consume</th>
                        <th>Consumed</th>
                    </tr>
                </thead>
                <tbody id="bomItemsTable">
                    <tr>
                        <td colspan="4" class="text-center text-muted">
                            Select a BOM to view its components.
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
</div>

<script>
document.querySelector('select[name="bill_of_material_id"]').addEventListener('change', function () {
    let bomId = this.value;

    fetch(`/ajax/bom-items/${bomId}`)
        .then(res => res.json())
        .then(data => {
            let table = document.getElementById('bomItemsTable');
            table.innerHTML = '';

            if (data.length === 0) {
                table.innerHTML = `
                    <tr>
                        <td colspan="4" class="text-center text-muted">No BOM items found.</td>
                    </tr>
                `;
                return;
            }

            data.forEach(item => {
                table.innerHTML += `
                    <tr>
                        <td>${item.product.name}</td>
                        <td>${item.product.unit ? item.product.unit.name : '-'}</td>
                        <td>${item.quantity}</td>
                        <td>0</td>
                    </tr>
                `;
            });
        });
});
</script>

@endsection
