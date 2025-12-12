@extends('layouts.app')

@section('content')
<div class="container">

    <div class="d-flex justify-content-between mb-3">
        <h4>Manufacturing Orders</h4>
        <a href="{{ route('manufacturing-order.create') }}" class="btn btn-primary">+ Create</a>
    </div>

    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>MO Number</th>
                <th>Product</th>
                <th>BOM</th>
                <th>Qty</th>
                <th>Total Cost</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            @foreach($orders as $o)
            <tr>
                <td>MO/{{ str_pad($o->id, 5, '0', STR_PAD_LEFT) }}</td>
                <td>{{ $o->product->name }}</td>
                <td>{{ $o->billOfMaterial->code }}</td>
                <td>{{ $o->quantity }}</td>
                <td>Rp {{ number_format($o->total) }}</td>
                <td>{{ $o->status }}</td>
                <td>
                    <a href="{{ route('manufacturing-order.show', $o->id) }}" class="btn btn-sm btn-info">
                        Detail
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection
