@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Delivery Order Detail</h3>

    <div class="card mb-4">
        <div class="card-body">
            <p><strong>DO Number:</strong> {{ $deliveryOrder->do_number }}</p>
            <p><strong>SO Number:</strong> {{ $deliveryOrder->salesOrder->so_number }}</p>
            <p>
                <strong>Status:</strong>
                <span class="badge bg-info">
                    {{ ucfirst($deliveryOrder->status) }}
                </span>
            </p>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <h5>Items</h5>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th class="text-center">Qty</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($deliveryOrder->items as $item)
                        <tr>
                            <td>{{ $item->product->name }}</td>
                            <td class="text-center">{{ $item->quantity }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @if ($deliveryOrder->bill)
        <a href="{{ route('bills.show', $deliveryOrder->bill->id) }}"
           class="btn btn-outline-success">
            View Bill
        </a>
    @endif

    <a href="{{ route('delivery-orders.index') }}"
       class="btn btn-secondary">
        Back
    </a>
</div>
@endsection
