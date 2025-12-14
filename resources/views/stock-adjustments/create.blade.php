@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Create Stock Adjustment</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('stock-adjustments.index') }}">Stock Adjustments</a>
                        </li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <form action="{{ route('stock-adjustments.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Code</label>
                                <input type="text" name="code" class="form-control" placeholder="Auto-generated">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Adjustment Date <span class="text-danger">*</span></label>
                                <input type="date" name="adjustment_date" class="form-control"
                                    value="{{ date('Y-m-d') }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Warehouse</label>
                                <select name="warehouse_id" id="warehouse_id" class="form-select">
                                    <option value="">Choose Warehouse</option>
                                    @foreach ($warehouses as $wh)
                                        <option value="{{ $wh->id }}">{{ $wh->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Adjustment Type <span class="text-danger">*</span></label>
                                <select name="adjustment_type" id="adjustment_type" class="form-select" required>
                                    <option value="">Choose Type</option>
                                    <option value="Increase">Increase</option>
                                    <option value="Decrease">Decrease</option>
                                    <option value="Damage">Damage</option>
                                    <option value="Loss">Loss</option>
                                    <option value="Found">Found</option>
                                    <option value="Correction">Correction</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="status" id="status" class="form-select" required>
                                    <option value="Draft">Draft</option>
                                    <option value="Approved">Approved</option>
                                    <option value="Rejected">Rejected</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Reason</label>
                                <textarea name="reason" class="form-control" rows="2"></textarea>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Notes</label>
                                <textarea name="notes" class="form-control" rows="2"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('stock-adjustments.index') }}" class="btn btn-light">Back</a>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new Choices('#warehouse_id', {
                searchEnabled: true,
                itemSelectText: '',
                shouldSort: false
            });

            new Choices('#adjustment_type', {
                searchEnabled: false,
                itemSelectText: '',
                shouldSort: false
            });

            new Choices('#status', {
                searchEnabled: false,
                itemSelectText: '',
                shouldSort: false
            });
        });
    </script>
@endpush
