@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Bill of Materials</h3>
        <a href="{{ route('bill-of-materials.create') }}" class="btn btn-primary mb-3">Create BOM</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Reference</th>
                <th>Name</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Total Cost</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($boms as $index => $bom)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $bom->reference }}</td>
                    <td>{{ $bom->name }}</td>
                    <td>{{ $bom->product->name ?? '-' }}</td>
                    <td>{{ $bom->quantity }}</td>
                    <td>{{ number_format($bom->total, 0) }}</td>
                    <td>
                        <a href="{{ route('bill-of-materials.show', $bom) }}" class="btn btn-info btn-sm">
                        View</a>
                        <a href="{{ route('bill-of-materials.edit', $bom) }}" class="btn btn-warning btn-sm">Edit</a>

                        <form action="{{ route('bill-of-materials.destroy', $bom) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Delete</button></form>
                    </td>
                </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">No BOM data</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{ $boms->links() }}
</div>
@endsection
