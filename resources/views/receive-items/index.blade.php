@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Receive Items List</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Receive Items</a></li>
                        <li class="breadcrumb-item active">Receive Items List</li>
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
                                <a href="{{ route('receive-items.create') }}" type="button"
                                    class="btn btn-primary waves-effect waves-light"><i class="bx bx-plus me-1"></i> Add
                                    Receive Item</a>
                                <button type="button" class="btn btn-danger waves-effect waves-light btn-bulk-delete"><i
                                        class="fas fa-trash"></i> Bulk Delete</button>
                            </div>
                        </div>
                        <div class="col-sm-auto mb-4">
                            <form action="{{ route('receive-items.index') }}" method="GET">
                                <div class="input-group datepicker-range">
                                    <input type="text" name="search" class="form-control" placeholder="Search here..."
                                        value="{{ $search }}" data-input aria-describedby="search">
                                    <button type="submit" class="input-group-text" id="date1" data-toggle><i
                                            class="fas fa-search"></i></button>
                                </div>
                            </form>
                        </div>
                        <div class="col-sm-auto text-end">
                            <a href="{{ route('receive-items.index') }}" class="btn btn-warning mb-4">Reset Filter</a>
                        </div>
                    </div>

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
                                    <th>Purchase Order</th>
                                    <th>Code</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <form id="formBulkDelete" action="{{ route('receive-items.destroy', 'id') }}"
                                    method="POST">
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
                                            <td>{{ $item->purchaseOrder->code }}</td>
                                            <td>{{ $item->code }}</td>
                                            <td>{{ formatCurrency($item->total, '') }}</td>
                                            <td>{{ enumText($item->status) }}</td>
                                            <td>
                                                <div class="d-flex flex-row gap-2">
                                                    <a href="{{ route('receive-items.edit', $item->id) }}"
                                                        class="btn btn-primary"><i class="fas fa-pencil-alt"></i></a>

                                                    <form action="{{ route('receive-items.destroy', $item->id) }}"
                                                        method="POST" class="d-inline" data-id="{{ $item->id }}">
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
                                            <td colspan="6" class="text-center">No data available</td>
                                        </tr>
                                    @endforelse
                                </form>
                            </tbody>
                        </table>
                        {{ $data->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(function() {
            $('.btn-edit').click(function() {
                let data = $(this).data('ReceiveItem');
                let form = $('#formEdit');
                let url = "{{ route('receive-items.update', ':id') }}".replace(':id', data.id);
                form.attr('action', url);
                $("#name", form).val(data.name);
                $("#description", form).val(data.description);
            });
        });
    </script>
@endpush
