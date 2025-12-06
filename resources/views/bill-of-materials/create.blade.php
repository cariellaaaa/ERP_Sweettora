@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Add Bill of Materials</h3>

    <form action="{{ route('bill-of-materials.store') }}" method="post">
        @csrf

        <div class="mb-3">
            <label>Product</label>
            <select name="product_id" class="form-control">
                <option value="">-- Select Product --</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Reference</label>
            <input type="text" name="reference" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Quantity</label>
            <input type="number" name="quantity" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Cost</label>
            <input type="number" step="0.01" name="cost" class="form-control" required>
        </div>

        <button class="btn btn-primary">Save</button>
        <a href="{{ route('bill-of-materials.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
