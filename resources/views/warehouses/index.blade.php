@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Warehouses List</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Inventory</a></li>
                        <li class="breadcrumb-item active">Warehouses</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm">
                            <div class="mb-4">
                                <a href="{{ route('warehouses.create') }}" type="button"
                                    class="btn btn-primary waves-effect waves-light"><i class="bx bx-plus me-1"></i> Add
                                    Warehouse</a>
                            </div>
                        </div>
                        <div class="col-sm-auto mb-4">
                            <form action="{{ route('warehouses.index') }}" method="GET">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" placeholder="Search here..."
                                        value="{{ $search }}">
                                    <button type="submit" class="input-group-text"><i class="fas fa-search"></i></button>
                                </div>
                            </form>
                        </div>
                        <div class="col-sm-auto text-end">
                            <a href="{{ route('warehouses.index') }}" class="btn btn-warning mb-4">Reset Filter</a>
                        </div>
                    </div>

                    <div class="table-responsive">
                        {{ $data->links() }}
                        <table class="table align-middle table-nowrap table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>City</th>
                                    <th>Manager</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data as $item)
                                    <tr>
                                        <td><strong>{{ $item->code }}</strong></td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->type ?? '-' }}</td>
                                        <td>{{ $item->city ?? '-' }}</td>
                                        <td>{{ $item->manager_name ?? '-' }}</td>
                                        <td>
                                            @if ($item->status == 'Active')
                                                <span class="badge bg-success">{{ $item->status }}</span>
                                            @elseif($item->status == 'Inactive')
                                                <span class="badge bg-danger">{{ $item->status }}</span>
                                            @else
                                                <span class="badge bg-warning">{{ $item->status }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('warehouses.edit', $item->id) }}"
                                                    class="btn btn-primary btn-sm"><i class="fas fa-pencil-alt"></i></a>
                                                <form action="{{ route('warehouses.destroy', $item->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm delete-btn">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
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
