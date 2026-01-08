@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Create Sales Order</h3>

    <form method="POST" action="{{ route('sales-orders.store') }}">
        @csrf

        <!-- CUSTOMER -->
        <div class="mb-3">
            <label>Customer Name</label>
            <input type="text" name="customer_name" class="form-control" required>
        </div>

        <hr>
        <h5>Items</h5>

        @foreach ($products as $product)
            <div class="row mb-2 align-items-center">
                <div class="col-md-4">
                    <strong>{{ $product->name }}</strong>
                    <input type="hidden"
                           name="items[{{ $loop->index }}][product_id]"
                           value="{{ $product->id }}">
                </div>

                <div class="col-md-3">
                    <input type="number"
                           name="items[{{ $loop->index }}][quantity]"
                           class="form-control"
                           placeholder="Qty"
                           min="0">
                </div>

                <div class="col-md-3">
                    <input type="number"
                           name="items[{{ $loop->index }}][price]"
                           class="form-control"
                           value="{{ $product->price }}">
                </div>
            </div>
        @endforeach

        <button class="btn btn-success mt-3">
            Save Sales Order
        </button>
    </form>
</div>
@endsection
