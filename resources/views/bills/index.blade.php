@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Bill / Invoice</h3>

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
                <th>Bill Number</th>
                <th>DO Number</th>
                <th>SO Number</th>
                <th>Total</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($bills as $bill)
            <tr>
                <td>{{ $bill->bill_number ?? '-' }}</td>
                <td>{{ $bill->deliveryOrder->do_number ?? '-' }}</td>
                <td>{{ $bill->deliveryOrder->salesOrder->so_number ?? '-' }}</td>
                <td>
                    Rp {{ number_format($bill->total_amount ?? 0, 0, ',', '.') }}
                </td>
                <td>
                    @if ($bill->status === 'paid')
                        <span class="badge bg-success">Paid</span>
                    @elseif ($bill->status === 'partial')
                        <span class="badge bg-warning text-dark">Partial</span>
                    @else
                        <span class="badge bg-secondary">Unpaid</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('bills.show', $bill->id) }}"
                       class="btn btn-info btn-sm">
                        Detail
                    </a>

                    @if ($bill->status === 'unpaid')
                        <span class="badge bg-warning text-dark">
                            Unpaid
                        </span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">
                    Belum ada bill
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
