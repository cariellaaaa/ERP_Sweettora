@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Sales Orders</h3>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>SO Number</th>
                <th>Customer</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($salesOrders as $so)
            <tr>
                <td>{{ $so->so_number }}</td>
                <td>{{ $so->customer_name }}</td>
                <td>
                    <span class="badge bg-info">
                        {{ $so->status }}
                    </span>
                </td>
                <td>
                    @if (!$so->deliveryOrder)
                        <a href="{{ route('delivery-orders.create', ['sales_order_id' => $so->id]) }}"
                           class="btn btn-sm btn-primary">
                            Buat DO
                        </a>
                    @else
                        <span class="badge bg-success">DO Dibuat</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
