@extends('layouts.app')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" rel="stylesheet" />
@endsection

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Create Employee</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('employees.index') }}">Employees</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-sm">
            <div class="card">
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger">{{ $error }}</div>
                    @endforeach
                @endif

                <div class="card-content">
                    <form action="{{ route('employees.store') }}" method="POST" class="needs-validation" novalidate
                        enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <!-- Employee Code -->
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="employee_code">Employee Code <span class="text-danger">*</span></label>
                                        <input type="text"
                                            class="form-control @error('employee_code') is-invalid @enderror"
                                            name="employee_code" value="{{ old('employee_code', $employeeCode) }}"
                                            id="employee_code" placeholder="Employee Code" required readonly>
                                        @error('employee_code')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Name -->
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="name">Full Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            name="name" value="{{ old('name') }}" id="name"
                                            placeholder="Enter full name" required>
                                        @error('name')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="email">Email <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            value="{{ old('email') }}" name="email" id="email"
                                            placeholder="employee@example.com" required>
                                        @error('email')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Phone -->
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="phone">Phone</label>
                                        <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                            value="{{ old('phone') }}" name="phone" id="phone"
                                            placeholder="08123456789">
                                        @error('phone')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- ID Number -->
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="id_number">ID Number (KTP)</label>
                                        <input type="text" class="form-control @error('id_number') is-invalid @enderror"
                                            value="{{ old('id_number') }}" name="id_number" id="id_number"
                                            placeholder="Identity card number">
                                        @error('id_number')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Birth Date -->
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="birth_date">Birth Date</label>
                                        <input type="date" class="form-control @error('birth_date') is-invalid @enderror"
                                            value="{{ old('birth_date') }}" name="birth_date" id="birth_date">
                                        @error('birth_date')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Gender -->
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="gender">Gender</label>
                                        <select name="gender" id="gender"
                                            class="form-control @error('gender') is-invalid @enderror">
                                            <option value="">Select Gender</option>
                                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male
                                            </option>
                                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female
                                            </option>
                                        </select>
                                        @error('gender')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Position -->
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="position">Position</label>
                                        <input type="text" class="form-control @error('position') is-invalid @enderror"
                                            value="{{ old('position') }}" name="position" id="position"
                                            placeholder="e.g., Manager, Staff, Supervisor">
                                        @error('position')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Department -->
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="department">Department</label>
                                        <input type="text"
                                            class="form-control @error('department') is-invalid @enderror"
                                            value="{{ old('department') }}" name="department" id="department"
                                            placeholder="e.g., IT, Finance, HR">
                                        @error('department')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Hire Date -->
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="hire_date">Hire Date</label>
                                        <input type="date"
                                            class="form-control @error('hire_date') is-invalid @enderror"
                                            value="{{ old('hire_date') }}" name="hire_date" id="hire_date">
                                        @error('hire_date')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Salary -->
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="salary">Salary</label>
                                        <input type="number" step="0.01"
                                            class="form-control @error('salary') is-invalid @enderror"
                                            value="{{ old('salary') }}" name="salary" id="salary"
                                            placeholder="0.00">
                                        @error('salary')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Employment Status -->
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="employment_status">Employment Status</label>
                                        <select name="employment_status" id="employment_status"
                                            class="form-control @error('employment_status') is-invalid @enderror">
                                            <option value="probation"
                                                {{ old('employment_status') == 'probation' ? 'selected' : '' }}>Probation
                                            </option>
                                            <option value="permanent"
                                                {{ old('employment_status') == 'permanent' ? 'selected' : '' }}>Permanent
                                            </option>
                                            <option value="contract"
                                                {{ old('employment_status') == 'contract' ? 'selected' : '' }}>Contract
                                            </option>
                                            <option value="internship"
                                                {{ old('employment_status') == 'internship' ? 'selected' : '' }}>Internship
                                            </option>
                                        </select>
                                        @error('employment_status')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Status -->
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="status">Status</label>
                                        <select name="status" id="status"
                                            class="form-control @error('status') is-invalid @enderror">
                                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>
                                                Active</option>
                                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>
                                                Inactive</option>
                                            <option value="terminated"
                                                {{ old('status') == 'terminated' ? 'selected' : '' }}>Terminated</option>
                                        </select>
                                        @error('status')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Province -->
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="province_id">Province</label>
                                        <select name="province_id" id="province_id"
                                            class="form-control basic-choices @error('province_id') is-invalid @enderror"
                                            data-placeholder="Choose a Province">
                                            @foreach ($province as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ old('province_id') == $item->id ? 'selected' : '' }}>
                                                    {{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('province_id')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- City -->
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="city_id">City</label>
                                        <select name="city_id" id="city_id"
                                            class="form-control basic-choices @error('city_id') is-invalid @enderror"
                                            data-placeholder="Choose a City">
                                            <option value="" selected disabled>Choose a City</option>
                                            @foreach ($city as $item)
                                                <option value="{{ $item->id }}"
                                                    {{ old('city_id') == $item->id ? 'selected' : '' }}>
                                                    {{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('city_id')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Postal Code -->
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="postal_code">Postal Code</label>
                                        <input type="text"
                                            class="form-control @error('postal_code') is-invalid @enderror"
                                            value="{{ old('postal_code') }}" name="postal_code" id="postal_code"
                                            placeholder="12345">
                                        @error('postal_code')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Address -->
                                <div class="col-12 col-md-6">
                                    <div class="mb-3">
                                        <label for="address">Address</label>
                                        <textarea class="form-control @error('address') is-invalid @enderror" name="address" id="address" rows="3"
                                            placeholder="Full address">{{ old('address') }}</textarea>
                                        @error('address')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Notes -->
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="notes">Notes</label>
                                        <textarea class="form-control @error('notes') is-invalid @enderror" name="notes" id="notes" rows="3"
                                            placeholder="Additional notes">{{ old('notes') }}</textarea>
                                        @error('notes')
                                            <span class="invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Image Upload -->
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="image">Upload Photo</label>
                                        <input type="file" name="image" id="uploadImage"
                                            class="form-control dnd-files-upload" value="{{ old('image') }}"
                                            data-browse-on-zone-click="true">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex flex-row justify-content-end gap-2">
                                <a href="{{ route('employees.index') }}" class="btn btn-light">Cancel</a>
                                <button class="btn btn-primary" type="submit">Save Employee</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script>
        $(document).ready(function() {
            // Store all cities data
            const allCities = @json($city);

            // Helper function to safely initialize Choices
            function initChoices(selector, options) {
                const element = document.querySelector(selector);
                if (element && !element.classList.contains('choices__input')) {
                    try {
                        return new Choices(selector, options);
                    } catch (error) {
                        console.error(`Error initializing Choices for ${selector}:`, error);
                        return null;
                    }
                }
                return null;
            }

            // Initialize Choices.js for all select dropdowns
            const genderSelect = initChoices('#gender', {
                searchEnabled: false,
                placeholder: true,
                placeholderValue: 'Select Gender',
                shouldSort: false
            });

            const employmentStatusSelect = initChoices('#employment_status', {
                searchEnabled: false,
                placeholder: true,
                placeholderValue: 'Select Employment Status',
                shouldSort: false
            });

            const statusSelect = initChoices('#status', {
                searchEnabled: false,
                placeholder: true,
                placeholderValue: 'Select Status',
                shouldSort: false
            });

            const provinceSelect = initChoices('#province_id', {
                searchEnabled: true,
                placeholder: true,
                placeholderValue: 'Choose a Province'
            });

            const citySelect = initChoices('#city_id', {
                searchEnabled: true,
                placeholder: true,
                placeholderValue: 'Choose a City'
            });

        });
    </script>
@endpush
```
