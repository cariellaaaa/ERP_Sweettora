@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Delivery Orders</h3>

    {{-- 🔔 ALERT MESSAGE --}}
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    {{-- 🔔 END ALERT --}}

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>DO Number</th>
                <th>SO Number</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($deliveryOrders as $do)
            <tr>
                <td>{{ $do->do_number }}</td>
                <td>{{ $do->salesOrder->so_number }}</td>
                <td>{{ $do->status }}</td>
                <td>
                    {{-- BELUM DELIVER --}}
                    @if ($do->status !== 'delivered')
                        <form method="POST"
                            action="{{ route('delivery-orders.deliver', $do->id) }}">
                            @csrf
                            <button class="btn btn-success btn-sm">
                                Deliver
                            </button>
                        </form>

                    {{-- SUDAH DELIVER --}}
                    @else

                        {{-- BELUM ADA BILL --}}
                        @if (!$do->bill)
                            <a href="{{ route('bills.create', $do->id) }}"
                            class="btn btn-primary btn-sm">
                                Create Bill
                            </a>

                        {{-- SUDAH ADA BILL --}}
                        @else
                            <span class="badge bg-info">Billed</span>
                        @endif

                    @endif
                    <a href="{{ route('delivery-orders.show', $do->id) }}"
                       class="btn btn-info btn-sm">
                        Detail
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
