@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Bill Detail</h3>

    <div class="card mb-4">
        <div class="card-body">
            <p><strong>Bill Number:</strong> {{ $bill->bill_number }}</p>
            <p><strong>DO Number:</strong> {{ $bill->deliveryOrder->do_number }}</p>
            <p><strong>SO Number:</strong> {{ $bill->deliveryOrder->salesOrder->so_number }}</p>
            <p><strong>Status:</strong>
                <span class="badge bg-secondary">{{ ucfirst($bill->status) }}</span>
            </p>
        </div>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Product</th>
                <th class="text-end">Price</th>
                <th class="text-center">Qty</th>
                <th class="text-end">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bill->deliveryOrder->items as $item)
            <tr>
                <td>{{ $item->product->name }}</td>
                <td class="text-end">{{ number_format($item->price, 0, ',', '.') }}</td>
                <td class="text-center">{{ $item->quantity }}</td>
                <td class="text-end">{{ number_format($item->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4 text-end">
        <p><strong>Subtotal:</strong> {{ number_format($bill->subtotal, 0, ',', '.') }}</p>
        <p><strong>Tax (11%):</strong> {{ number_format($bill->tax, 0, ',', '.') }}</p>
        <h5><strong>Total:</strong> {{ number_format($bill->total, 0, ',', '.') }}</h5>
    </div>

    <a href="{{ route('bills.index') }}" class="btn btn-secondary mt-3">
        Back
    </a>
</div>
@endsection
