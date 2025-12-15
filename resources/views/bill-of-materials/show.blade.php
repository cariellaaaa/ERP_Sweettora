@extends('layouts.app')

@section('content')
<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">BoM Structure & Cost</h3>
        <a href="{{ route('bill-of-materials.index') }}" class="btn btn-outline-secondary">← Back</a>
    </div>

    <!-- Header Info -->
    <div class="mb-4">
        <h5 class="mb-0 fw-bold">[{{ $bom->reference }}] {{ $bom->name }}</h5>
        <small class="text-muted">Reference: {{ $bom->reference }}</small>
    </div>

    <!-- Table Section -->
    <div class="card shadow-sm">
        <div class="card-body p-0">

            <table class="table table-bordered mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Product</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-end">Product Cost</th>
                        <th class="text-end">BoM Cost</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($bom->items as $item)
                    <tr>
                        <td>[{{ $item->product->sku ?? '-' }}] {{ $item->product->name }}</td>
                        <td class="text-center">{{ number_format($item->quantity, 3) }}</td>
                        <td class="text-end">Rp {{ number_format($item->cost, 0, ',', '.') }}</td>
                        <td class="text-end">Rp {{ number_format($item->total, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>

                <tfoot>
                    <tr class="fw-bold">
                        <td colspan="3" class="text-end">Unit Cost</td>
                        <td class="text-end text-primary">Rp {{ number_format($bom->total, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>

            </table>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="mt-4 d-flex gap-2">
        <button class="btn btn-dark">Print</button>
        <button class="btn btn-outline-dark">Print Unfolded</button>
    </div>

</div>
@endsection
