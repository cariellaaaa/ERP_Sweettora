@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Create Delivery Order</h3>

    <p><strong>Sales Order:</strong> {{ $salesOrder->so_number }}</p>
    <p><strong>Customer:</strong> {{ $salesOrder->customer_name }}</p>

    <form method="POST" action="{{ route('delivery-orders.store') }}">
        @csrf
        <input type="hidden" name="sales_order_id" value="{{ $salesOrder->id }}">

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Ordered Qty</th>
                    <th>Deliver Qty</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($salesOrder->items as $index => $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>
                        <input type="hidden"
                               name="items[{{ $index }}][product_id]"
                               value="{{ $item->product_id }}">

                        <input type="number"
                               name="items[{{ $index }}][quantity]"
                               class="form-control"
                               max="{{ $item->quantity }}"
                               min="0">
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <button class="btn btn-primary">
            Save Delivery Order
        </button>
    </form>
</div>
@endsection
