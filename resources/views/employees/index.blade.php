@extends('layouts.app')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Employees List</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Employee</a></li>
                        <li class="breadcrumb-item active">Employees List</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm">
                            <div class="mb-4">
                                <a href="{{ route('employees.create') }}" type="button"
                                    class="btn btn-primary waves-effect waves-light"><i class="bx bx-plus me-1"></i> Add
                                    Employee</a>
                                <button type="button" class="btn btn-danger waves-effect waves-light btn-bulk-delete"><i
                                        class="fas fa-trash"></i> Bulk Delete</button>
                            </div>
                        </div>
                        <div class="col-sm-auto mb-4">
                            <form action="{{ route('employees.index') }}" method="GET">
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" placeholder="Search here..."
                                        value="{{ $search }}" aria-describedby="search">
                                    <select name="status" class="form-select" style="max-width: 150px;">
                                        <option value="">All Status</option>
                                        <option value="active" {{ $status == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ $status == 'inactive' ? 'selected' : '' }}>Inactive
                                        </option>
                                        <option value="terminated" {{ $status == 'terminated' ? 'selected' : '' }}>
                                            Terminated</option>
                                    </select>
                                    <input type="text" name="department" class="form-control" placeholder="Department"
                                        value="{{ $department }}" style="max-width: 150px;">
                                    <button type="submit" class="input-group-text" id="search-btn"><i
                                            class="fas fa-search"></i></button>
                                </div>
                            </form>
                        </div>
                        <div class="col-sm-auto text-end">
                            <a href="{{ route('employees.index') }}" class="btn btn-warning mb-4">Reset Filter</a>
                        </div>
                    </div>
                    <!-- end row -->

                    <div class="table-responsive">
                        {{ $data->links() }}
                        <table class="table align-middle table-check">
                            <thead>
                                <tr class="bg-transparent">
                                    <th style="width: 30px;">
                                        <div class="form-check font-size-16">
                                            <input type="checkbox" name="check" class="form-check-input" id="checkAll">
                                            <label class="form-check-label" for="checkAll"></label>
                                        </div>
                                    </th>
                                    <th>Employee Code</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Position</th>
                                    <th>Department</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <form id="formBulkDelete" action="{{ route('employees.destroy', 'id') }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    @forelse ($data as $x => $item)
                                        <tr>
                                            <td>
                                                <div class="form-check font-size-16">
                                                    <input type="checkbox" class="form-check-input bulk-delete-checkbox"
                                                        name="ids[]" value="{{ $item->id }}">
                                                    <label class="form-check-labe12"></label>
                                                </div>
                                            </td>
                                            <td>{{ $item->employee_code }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>{{ $item->phone }}</td>
                                            <td>{{ $item->position }}</td>
                                            <td>{{ $item->department }}</td>
                                            <td>
                                                @if ($item->status == 'active')
                                                    <span class="badge bg-success">Active</span>
                                                @elseif($item->status == 'inactive')
                                                    <span class="badge bg-warning">Inactive</span>
                                                @else
                                                    <span class="badge bg-danger">Terminated</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex flex-row gap-2">
                                                    <a href="{{ route('employees.show', $item->id) }}"
                                                        class="btn btn-info"><i class="fas fa-eye"></i></a>
                                                    <a href="{{ route('employees.edit', $item->id) }}"
                                                        class="btn btn-primary"><i class="fas fa-pencil-alt"></i></a>

                                                    <form action="{{ route('employees.destroy', $item->id) }}"
                                                        method="POST" class="d-inline delete-form"
                                                        data-id="{{ $item->id }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger delete-btn">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center">No data available</td>
                                        </tr>
                                    @endforelse
                                </form>
                            </tbody>
                        </table>
                        {{ $data->links() }}
                    </div>

                    <!-- end table responsive -->
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
    </div>
    <!-- end row -->
@endsection

@push('script')
    <script>
        $(function() {
            // Handle delete confirmation
            $('.delete-btn').click(function(e) {
                e.preventDefault();
                let form = $(this).closest('form');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });

            // Handle bulk delete
            $('.btn-bulk-delete').click(function() {
                let checkedBoxes = $('.bulk-delete-checkbox:checked');
                if (checkedBoxes.length === 0) {
                    Swal.fire('Warning', 'Please select at least one item to delete', 'warning');
                    return;
                }

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You are about to delete " + checkedBoxes.length + " item(s)!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete them!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#formBulkDelete').submit();
                    }
                });
            });

            // Check all checkbox
            $('#checkAll').click(function() {
                $('.bulk-delete-checkbox').prop('checked', $(this).prop('checked'));
            });
        });
    </script>
@endpush
