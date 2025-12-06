@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Bill of Materials</h3>

    <form action="{{ route('bill-of-materials.update', $bom->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Reference</label>
            <input type="text" name="reference" value="{{ $bom->reference }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" value="{{ $bom->name }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Quantity</label>
            <input type="number" name="quantity" value="{{ $bom->quantity }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Cost</label>
            <input type="number" step="0.01" name="cost" value="{{ $bom->cost }}" class="form-control" required>
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="{{ route('bill-of-materials.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
