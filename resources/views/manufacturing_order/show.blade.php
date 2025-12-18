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
        <h4>Manufacturing Order Detail</h4>

        <div>
            <a href="{{ route('manufacturing-order.index') }}" class="btn btn-secondary odoo-header-btn">Back</a>
        </div>
    </div>

    <div class="d-flex mb-3">
        <button class="btn btn-light odoo-header-btn">Print</button>
        <button class="btn btn-light odoo-header-btn">Action</button>

        <span class="step-badge">{{ $mo->status }}</span>
    </div>

    <div class="odoo-card">

        <!-- INFO HEADER -->
        <div class="row">
            <div class="col-md-6">

                <div class="mb-3">
                    <div class="label-title">Product</div>
                    <input type="text" class="form-control" value="{{ $mo->product->name }}" readonly>
                </div>

                <div class="mb-3">
                    <div class="label-title">Quantity To Produce</div>
                    <input type="text" class="form-control" value="{{ $mo->quantity }}" readonly>
                </div>

                <div class="mb-3">
                    <div class="label-title">Bill of Material</div>
                    <input type="text" class="form-control" value="{{ $mo->billOfMaterial->reference }}" readonly>
                </div>

            </div>

            <div class="col-md-6">

                <div class="mb-3">
                    <div class="label-title">Schedule Date</div>
                    <input type="text" class="form-control" value="{{ $mo->schedule }}" readonly>
                </div>

                <div class="mb-3">
                    <div class="label-title">Responsible</div>
                    <input type="text" class="form-control" value="{{ $mo->user->name ?? '-' }}" readonly>
                </div>

                <div class="mb-3">
                    <div class="label-title">Total Cost</div>
                    <input type="text" class="form-control" value="Rp {{ number_format($mo->total,0,',','.') }}" readonly>
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
                    <th>Stock</th>
                    <th>To Consume</th>
                    <th>Consumed</th>
                    <th>Status Stock</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($mo->details as $d)
                <tr>
                    <td>{{ $d->product->name }}</td>
                    <td>{{ $d->unit->name ?? '-' }}</td>
                    <td>{{ $d->requirements }}</td>
                    <td>{{ $d->consumed }}</td>
                    <td>
                        @if ($d->product->stock >= $d->requirements)
                            <span class="badge bg-success">Available</span>
                        @else
                            <span class="badge bg-danger">Unavailable</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-muted">
                        No materials found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

    </div>

</div>

@endsection
