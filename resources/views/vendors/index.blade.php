@extends('layouts.app')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Vendors List</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Vendor</a></li>
                        <li class="breadcrumb-item active">Vendors List</li>
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
                                <a href="{{ route('vendors.create') }}" type="button"
                                    class="btn btn-primary waves-effect waves-light"><i class="bx bx-plus me-1"></i> Add
                                    Vendor</a>
                                <button type="button" class="btn btn-danger waves-effect waves-light btn-bulk-delete"><i
                                        class="fas fa-trash"></i> Bulk Delete</button>
                            </div>
                        </div>
                        {{-- <div class="col-sm">
                        <div class="mb-4">
                            <button type="button" class="btn btn-danger waves-effect waves-light"><i class="fas fa-trash"></i> Bulk Delete</button>
                        </div>
                    </div> --}}
                        <div class="col-sm-auto mb-4">
                            <form action="{{ route('vendors.index') }}" method="GET">
                                <div class="input-group datepicker-range">
                                    <input type="text" name="search" class="form-control" placeholder="Search here..."
                                        value="{{ $search }}" data-input aria-describedby="search">
                                    <button type="submit" class="input-group-text" id="date1" data-toggle><i
                                            class="fas fa-search"></i></button>
                                </div>
                            </form>
                        </div>
                        <div class="col-sm-auto text-end">
                            <a href="{{ route('vendors.index') }}" class="btn btn-warning mb-4">Reset Filter</a>
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
                                    <th>Name</th>
                                    <th>Postal Code</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>NPWP</th>
                                    <th>Address</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <form id="formBulkDelete" action="{{ route('products.destroy', 'id') }}" method="POST">
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
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->postal_code }}</td>
                                            <td>{{ $item->email }}</td>
                                            <td>{{ $item->phone }}</td>
                                            <td>{{ $item->npwp }}</td>
                                            <td>{{ $item->address }}</td>
                                            {{-- <td>{{ $item->description }}</td> --}}
                                            <td>
                                                <div class="d-flex flex-row gap-2">
                                                    <a href="{{ route('vendors.edit', $item->id) }}"
                                                        class="btn btn-primary"><i class="fas fa-pencil-alt"></i></a>

                                                    <form action="{{ route('vendors.destroy', $item->id) }}" method="POST"
                                                        class="d-inline delete-form" data-id="{{ $item->id }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger delete-btn">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                                {{-- <div class="row">
                                            <div class="col-12 col-md-2">
                                                <a href="{{ route('products.edit', $item->id) }}" class="btn btn-primary">Edit</a>
                                            </div>
                                            <div class="col-12 col-md-2">
                                                <form action="{{ route('products.destroy', $item->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger" data-confirm-delete="true">Delete</button>
                                                </form>
                                            </div>
                                        </div> --}}
                                                {{-- <div class="dropdown">
                                            <button class="btn btn-link font-size-16 shadow-none py-0 text-muted dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bx bx-dots-horizontal-rounded"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <a class="dropdown-item btn-edit" href="{{ route('products.edit', $item->id) }}" >Edit</a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('products.destroy', $item->id) }}" class="dropdown-item" data-confirm-delete="true">Delete</a>
                                                </li>
                                            </ul>
                                        </div> --}}
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
            $('.btn-edit').click(function() {
                let data = $(this).data('Product');
                // console.log(data.id);
                let form = $('#formEdit');
                let url = "{{ route('vendors.update', ':id') }}".replace(':id', data.id);
                form.attr('action', url);
                $("#name", form).val(data.name);
                $("#description", form).val(data.description);
            });
        });
    </script>
@endpush
