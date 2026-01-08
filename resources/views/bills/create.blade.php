@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Create Bill</h3>

    {{-- 🔔 ALERT --}}
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- 📄 INFO DELIVERY ORDER --}}
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Delivery Order</h5>
            <p class="mb-1"><strong>DO Number:</strong> {{ $deliveryOrder->do_number }}</p>
            <p class="mb-0"><strong>SO Number:</strong> {{ $deliveryOrder->salesOrder->so_number }}</p>
        </div>
    </div>

    {{-- 📦 ITEM TABLE --}}
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Items</h5>

            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Product</th>
                        <th class="text-end">Price</th>
                        <th class="text-center">Qty</th>
                        <th class="text-end">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @php $subtotal = 0; @endphp
                    @foreach ($deliveryOrder->items as $item)
                        @php
                            $subtotal += $item->subtotal;
                        @endphp
                        <tr>
                            <td>{{ $item->product->name }}</td>
                            <td class="text-end">
                                {{ number_format($item->price, 0, ',', '.') }}
                            </td>
                            <td class="text-center">{{ $item->quantity }}</td>
                            <td class="text-end">
                                {{ number_format($item->subtotal, 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- 💰 SUMMARY --}}
    @php
        $tax = $subtotal * 0.11;
        $total = $subtotal + $tax;
    @endphp

    <div class="card mb-4">
        <div class="card-body">
            <table class="table">
                <tr>
                    <th>Subtotal</th>
                    <td class="text-end">{{ number_format($subtotal, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th>Tax (11%)</th>
                    <td class="text-end">{{ number_format($tax, 0, ',', '.') }}</td>
                </tr>
                <tr class="table-success">
                    <th>Total</th>
                    <td class="text-end fw-bold">{{ number_format($total, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>
    </div>

    {{-- ✅ ACTION --}}
    <form method="POST" action="{{ route('bills.store', $deliveryOrder->id) }}">
        @csrf
        <button class="btn btn-primary">
            Create Bill
        </button>
        <a href="{{ route('delivery-orders.index') }}" class="btn btn-secondary">
            Cancel
        </a>
    </form>

</div>
@endsection
