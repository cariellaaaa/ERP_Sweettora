@extends('layouts.app')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Employee Details</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('employees.index') }}">Employees</a></li>
                        <li class="breadcrumb-item active">Details</li>
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
                    <div class="row mb-4">
                        <div class="col-sm">
                            <div class="d-flex gap-2">
                                <a href="{{ route('employees.index') }}" class="btn btn-light">
                                    <i class="fas fa-arrow-left me-1"></i> Back to List
                                </a>
                                <a href="{{ route('employees.edit', $data->id) }}" class="btn btn-primary">
                                    <i class="fas fa-pencil-alt me-1"></i> Edit
                                </a>
                                <form action="{{ route('employees.destroy', $data->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"
                                        onclick="return confirm('Are you sure you want to delete this employee?')">
                                        <i class="fas fa-trash me-1"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- Employee Photo -->
                        <div class="col-lg-3 col-md-4">
                            <div class="text-center mb-4">
                                @if ($data->image)
                                    <img src="{{ asset('storage/' . $data->image) }}" alt="{{ $data->name }}"
                                        class="img-thumbnail rounded-circle"
                                        style="width: 200px; height: 200px; object-fit: cover;">
                                @else
                                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mx-auto"
                                        style="width: 200px; height: 200px;">
                                        <i class="fas fa-user fa-5x text-muted"></i>
                                    </div>
                                @endif
                                <h4 class="mt-3 mb-1">{{ $data->name }}</h4>
                                <p class="text-muted mb-2">{{ $data->position ?? 'N/A' }}</p>
                                <p class="text-muted">{{ $data->department ?? 'N/A' }}</p>

                                @if ($data->status == 'active')
                                    <span class="badge bg-success fs-6">Active</span>
                                @elseif($data->status == 'inactive')
                                    <span class="badge bg-warning fs-6">Inactive</span>
                                @else
                                    <span class="badge bg-danger fs-6">Terminated</span>
                                @endif
                            </div>
                        </div>

                        <!-- Employee Details -->
                        <div class="col-lg-9 col-md-8">
                            <div class="row">
                                <!-- Personal Information -->
                                <div class="col-12">
                                    <h5 class="mb-3 border-bottom pb-2">Personal Information</h5>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="text-muted mb-1">Employee Code</label>
                                    <p class="fw-bold">{{ $data->employee_code }}</p>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="text-muted mb-1">Full Name</label>
                                    <p class="fw-bold">{{ $data->name }}</p>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="text-muted mb-1">Email</label>
                                    <p class="fw-bold">{{ $data->email }}</p>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="text-muted mb-1">Phone</label>
                                    <p class="fw-bold">{{ $data->phone ?? 'N/A' }}</p>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="text-muted mb-1">ID Number (KTP)</label>
                                    <p class="fw-bold">{{ $data->id_number ?? 'N/A' }}</p>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="text-muted mb-1">Birth Date</label>
                                    <p class="fw-bold">{{ $data->birth_date ? $data->birth_date->format('d M Y') : 'N/A' }}
                                    </p>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="text-muted mb-1">Gender</label>
                                    <p class="fw-bold">{{ $data->gender ? ucfirst($data->gender) : 'N/A' }}</p>
                                </div>

                                <!-- Employment Information -->
                                <div class="col-12 mt-3">
                                    <h5 class="mb-3 border-bottom pb-2">Employment Information</h5>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="text-muted mb-1">Position</label>
                                    <p class="fw-bold">{{ $data->position ?? 'N/A' }}</p>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="text-muted mb-1">Department</label>
                                    <p class="fw-bold">{{ $data->department ?? 'N/A' }}</p>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="text-muted mb-1">Hire Date</label>
                                    <p class="fw-bold">{{ $data->hire_date ? $data->hire_date->format('d M Y') : 'N/A' }}
                                    </p>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="text-muted mb-1">Salary</label>
                                    <p class="fw-bold">
                                        {{ $data->salary ? 'Rp ' . number_format($data->salary, 2, ',', '.') : 'N/A' }}</p>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="text-muted mb-1">Employment Status</label>
                                    <p class="fw-bold">
                                        {{ $data->employment_status ? ucfirst($data->employment_status) : 'N/A' }}</p>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="text-muted mb-1">Status</label>
                                    <p class="fw-bold">{{ $data->status ? ucfirst($data->status) : 'N/A' }}</p>
                                </div>

                                <!-- Address Information -->
                                <div class="col-12 mt-3">
                                    <h5 class="mb-3 border-bottom pb-2">Address Information</h5>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="text-muted mb-1">Province</label>
                                    <p class="fw-bold">{{ $data->province->name ?? 'N/A' }}</p>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="text-muted mb-1">City</label>
                                    <p class="fw-bold">{{ $data->city->name ?? 'N/A' }}</p>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="text-muted mb-1">Postal Code</label>
                                    <p class="fw-bold">{{ $data->postal_code ?? 'N/A' }}</p>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="text-muted mb-1">Address</label>
                                    <p class="fw-bold">{{ $data->address ?? 'N/A' }}</p>
                                </div>

                                <!-- Additional Information -->
                                @if ($data->notes)
                                    <div class="col-12 mt-3">
                                        <h5 class="mb-3 border-bottom pb-2">Additional Notes</h5>
                                    </div>

                                    <div class="col-12 mb-3">
                                        <p>{{ $data->notes }}</p>
                                    </div>
                                @endif

                                <!-- Timestamps -->
                                <div class="col-12 mt-3">
                                    <h5 class="mb-3 border-bottom pb-2">Record Information</h5>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="text-muted mb-1">Created At</label>
                                    <p class="fw-bold">{{ $data->created_at->format('d M Y H:i') }}</p>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="text-muted mb-1">Last Updated</label>
                                    <p class="fw-bold">{{ $data->updated_at->format('d M Y H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
