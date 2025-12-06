@extends('layouts.app')

@section('content')
<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>BoM Structure & Cost</h3>
        <a href="{{ route('bill-of-materials.index') }}" class="btn btn-secondary">← Back</a>
    </div>

    <div class="mb-3">
        <h5>
            <strong>[{{ $bom->product->code ?? 'N/A' }}] {{ $bom->product->name }}</strong>
        </h5>
        <p><strong>Reference:</strong> {{ $bom->reference }}</p>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr class="bg-light">
                <th>Product</th>
                <th>Quantity</th>
                <th>Product Cost</th>
                <th>BoM Cost</th>
            </tr>
        </thead>
        <tbody>
            {{-- Main BOM Product --}}
            <tr>
                <td><strong>[{{ $bom->product->code ?? 'N/A' }}] {{ $bom->product->name }}</strong></td>
                <td>{{ number_format($bom->quantity, 3) }}</td>
                <td>Rp {{ number_format($bom->cost, 0) }}</td>
                <td>Rp {{ number_format($bom->total, 0) }}</td>
            </tr>

            {{-- Future children BOM details here if needed --}}
        </tbody>

        <tfoot>
            <tr class="bg-light fw-bold">
                <td colspan="3" class="text-end">Unit Cost</td>
                <td>Rp {{ number_format($bom->total, 0) }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="text-end mt-4">
        <button class="btn btn-dark">Print</button>
        <button class="btn btn-outline-secondary">Print Unfolded</button>
    </div>
</div>
@endsection
