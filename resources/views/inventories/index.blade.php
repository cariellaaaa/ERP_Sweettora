@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Inventories List</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Inventory</a></li>
                        <li class="breadcrumb-item active">Stock</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm">
                            <a href="{{ route('inventories.create') }}" class="btn btn-primary"><i
                                    class="bx bx-plus me-1"></i> Add Stock</a>
                        </div>
                        <div class="col-sm-auto">
                            <form action="{{ route('inventories.index') }}" method="GET" class="row g-2">
                                <div class="col-auto">
                                    <select name="warehouse_id" class="form-select">
                                        <option value="">All Warehouses</option>
                                        @foreach ($warehouses as $wh)
                                            <option value="{{ $wh->id }}"
                                                {{ $warehouse_id == $wh->id ? 'selected' : '' }}>{{ $wh->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-auto">
                                    <select name="status" class="form-select">
                                        <option value="">All Status</option>
                                        <option value="Active" {{ $status == 'Active' ? 'selected' : '' }}>Active</option>
                                        <option value="Inactive" {{ $status == 'Inactive' ? 'selected' : '' }}>Inactive
                                        </option>
                                        <option value="Expired" {{ $status == 'Expired' ? 'selected' : '' }}>Expired
                                        </option>
                                        <option value="Damaged" {{ $status == 'Damaged' ? 'selected' : '' }}>Damaged
                                        </option>
                                    </select>
                                </div>
                                <div class="col-auto">
                                    <input type="text" name="search" class="form-control" placeholder="Search..."
                                        value="{{ $search }}">
                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                                    <a href="{{ route('inventories.index') }}" class="btn btn-warning">Reset</a>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="table-responsive">
                        {{ $data->links() }}
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Product</th>
                                    <th>Warehouse</th>
                                    <th>Batch</th>
                                    <th>Quantity</th>
                                    <th>Available</th>
                                    <th>Unit Cost</th>
                                    <th>Total Value</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data as $item)
                                    <tr>
                                        <td><strong>{{ $item->product->name ?? 'N/A' }}</strong></td>
                                        <td>{{ $item->warehouse->name ?? '-' }}</td>
                                        <td>{{ $item->batch_number ?? '-' }}</td>
                                        <td>{{ number_format($item->quantity) }}</td>
                                        <td>{{ number_format($item->available) }}</td>
                                        <td>{{ formatCurrency($item->unit_cost, '') }}</td>
                                        <td>{{ formatCurrency($item->total_value, '') }}</td>
                                        <td>
                                            @if ($item->status == 'Active')
                                                <span class="badge bg-success">{{ $item->status }}</span>
                                            @else
                                                <span class="badge bg-danger">{{ $item->status }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('inventories.edit', $item->id) }}"
                                                    class="btn btn-primary btn-sm"><i class="fas fa-pencil-alt"></i></a>
                                                <form action="{{ route('inventories.destroy', $item->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i
                                                            class="fas fa-trash"></i></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">No data available</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $data->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
