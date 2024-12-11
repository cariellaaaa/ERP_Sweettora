@extends('layouts.app')

@include('units.create')
@include('units.edit')
@section('content')
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Units List</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Product</a></li>
                    <li class="breadcrumb-item active">Units List</li>
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
                            <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#addUnit"><i class="bx bx-plus me-1"></i> Add Unit</button>
                            <button type="button" class="btn btn-danger waves-effect waves-light btn-bulk-delete"><i class="fas fa-trash"></i> Bulk Delete</button>
                        </div>
                    </div>
                    {{-- <div class="col-sm">
                        <div class="mb-4">
                            <button type="button" class="btn btn-danger waves-effect waves-light"><i class="fas fa-trash"></i> Bulk Delete</button>
                        </div>
                    </div> --}}
                    <div class="col-sm-auto">
                        <form action="{{ route('units.index') }}" method="GET">
                            <div class="input-group datepicker-range">
                                <input type="text" name="search" class="form-control" placeholder="Search here..." value="{{ $search }}" data-input aria-describedby="search">
                                <button type="submit" class="input-group-text" id="date1" data-toggle><i class="fas fa-search"></i></button>
                            </div>
                        </form>
                    </div>
                    <div class="col-sm-auto text-end">
                        <a href="{{ route('units.index') }}" class="btn btn-warning mb-4">Reset Filter</a>
                    </div>
                </div>
                <!-- end row -->

                <div class="table-responsive" style="overflow-y: auto">
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
                                <th>Description</th>
                                <th style="width: 90px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <form id="formBulkDelete" action="{{ route('units.destroy', 'id') }}" method="POST">
                                @csrf
                                @method("DELETE")
                                @forelse ($data as $x => $item)
                                <tr>
                                    <td>
                                        <div class="form-check font-size-16">
                                            <input type="checkbox" class="form-check-input bulk-delete-checkbox" name="ids[]" value="{{ $item->id }}">
                                            <label class="form-check-labe12"></label>
                                        </div>
                                    </td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->description }}</td>
                                    <td>
                                        {{-- <div class="row">
                                            <div class="col-12 col-md-2">
                                                <a href="{{ route('units.edit', $item->id) }}" class="btn btn-primary">Edit</a>
                                            </div>
                                            <div class="col-12 col-md-2">
                                                <form action="{{ route('units.destroy', $item->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger" data-confirm-delete="true">Delete</button>
                                                </form>
                                            </div>
                                        </div> --}}
                                        <div class="dropdown">
                                            <button class="btn btn-link font-size-16 shadow-none py-0 text-muted dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bx bx-dots-horizontal-rounded"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <a class="dropdown-item btn-edit" href="#" data-bs-toggle="modal" data-bs-target="#editUnit" data-unit="{{ $item }}">Edit</a>
                                                </li>
                                                <li>
                                                    <a href="{{ route('units.destroy', $item->id) }}" class="dropdown-item" data-confirm-delete="true">Delete</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">No data available</td>
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
        $(function(){
            $('.btn-edit').click(function(){
                let data = $(this).data('unit');
                // console.log(data.id);
                let form = $('#formEdit');
                let url = "{{ route('units.update', ':id') }}".replace(':id', data.id);
                form.attr('action', url);
                $("#name", form).val(data.name);
                $("#description", form).val(data.description);
            });
        });
    </script>
@endpush