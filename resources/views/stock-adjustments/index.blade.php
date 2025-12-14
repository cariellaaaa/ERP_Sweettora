@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Stock Adjustments</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Inventory</a></li>
                        <li class="breadcrumb-item active">Stock Adjustments</li>
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
                            <a href="{{ route('stock-adjustments.create') }}" class="btn btn-primary"><i
                                    class="bx bx-plus me-1"></i> New Adjustment</a>
                        </div>
                        <div class="col-sm-auto">
                            <form action="{{ route('stock-adjustments.index') }}" method="GET" class="row g-2">
                                <div class="col-auto">
                                    <select name="status" class="form-select">
                                        <option value="">All Status</option>
                                        <option value="Draft" {{ $status == 'Draft' ? 'selected' : '' }}>Draft</option>
                                        <option value="Approved" {{ $status == 'Approved' ? 'selected' : '' }}>Approved
                                        </option>
                                        <option value="Rejected" {{ $status == 'Rejected' ? 'selected' : '' }}>Rejected
                                        </option>
                                    </select>
                                </div>
                                <div class="col-auto">
                                    <input type="text" name="search" class="form-control" placeholder="Search..."
                                        value="{{ $search }}">
                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                                    <a href="{{ route('stock-adjustments.index') }}" class="btn btn-warning">Reset</a>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="table-responsive">
                        {{ $data->links() }}
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Code</th>
                                    <th>Date</th>
                                    <th>Type</th>
                                    <th>Warehouse</th>
                                    <th>Created By</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data as $item)
                                    <tr>
                                        <td><strong>{{ $item->code }}</strong></td>
                                        <td>{{ date('d M Y', strtotime($item->adjustment_date)) }}</td>
                                        <td><span class="badge bg-info">{{ $item->adjustment_type }}</span></td>
                                        <td>{{ $item->warehouse->name ?? '-' }}</td>
                                        <td>{{ $item->user->name ?? '-' }}</td>
                                        <td>
                                            @if ($item->status == 'Approved')
                                                <span class="badge bg-success">{{ $item->status }}</span>
                                            @elseif($item->status == 'Rejected')
                                                <span class="badge bg-danger">{{ $item->status }}</span>
                                            @else
                                                <span class="badge bg-warning">{{ $item->status }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('stock-adjustments.edit', $item->id) }}"
                                                    class="btn btn-primary btn-sm"><i class="fas fa-pencil-alt"></i></a>
                                                <form action="{{ route('stock-adjustments.destroy', $item->id) }}"
                                                    method="POST" class="d-inline">
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
                                        <td colspan="7" class="text-center">No data available</td>
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
