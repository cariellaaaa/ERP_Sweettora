@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Create Warehouse</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('warehouses.index') }}">Warehouses</a></li>
                        <li class="breadcrumb-item active">Create</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form action="{{ route('warehouses.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="code" class="form-label">Code <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('code') is-invalid @enderror"
                                    name="code" id="code" value="{{ old('code') }}" required>
                                @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    name="name" id="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="type" class="form-label">Type</label>
                                <input type="text" class="form-control @error('type') is-invalid @enderror"
                                    name="type" id="type" value="{{ old('type') }}">
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="status" id="status"
                                    class="form-select @error('status') is-invalid @enderror" required>
                                    <option value="">Choose Status</option>
                                    <option value="Active" {{ old('status') == 'Active' ? 'selected' : '' }}>Active</option>
                                    <option value="Inactive" {{ old('status') == 'Inactive' ? 'selected' : '' }}>Inactive
                                    </option>
                                    <option value="Maintenance" {{ old('status') == 'Maintenance' ? 'selected' : '' }}>
                                        Maintenance</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <label for="address" class="form-label">Address</label>
                                <textarea name="address" id="address" rows="2" class="form-control @error('address') is-invalid @enderror">{{ old('address') }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="province" class="form-label">Province</label>
                                <select name="province" id="province"
                                    class="form-select @error('province') is-invalid @enderror">
                                    <option value="">Choose Province</option>
                                    @foreach ($provinces as $prov)
                                        <option value="{{ $prov->name }}" data-code="{{ $prov->code }}"
                                            {{ old('province') == $prov->name ? 'selected' : '' }}>{{ $prov->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('province')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="city" class="form-label">City</label>
                                <select name="city" id="city"
                                    class="form-select @error('city') is-invalid @enderror">
                                    <option value="">Choose City</option>
                                    @foreach ($cities as $ct)
                                        <option value="{{ $ct->name }}" data-province="{{ $ct->province_code }}"
                                            {{ old('city') == $ct->name ? 'selected' : '' }}>{{ $ct->name }}</option>
                                    @endforeach
                                </select>
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="postal_code" class="form-label">Postal Code</label>
                                <input type="text" class="form-control @error('postal_code') is-invalid @enderror"
                                    name="postal_code" id="postal_code" value="{{ old('postal_code') }}">
                                @error('postal_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                    name="phone" id="phone" value="{{ old('phone') }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" id="email" value="{{ old('email') }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4">
                                <label for="manager_name" class="form-label">Manager Name</label>
                                <input type="text" class="form-control @error('manager_name') is-invalid @enderror"
                                    name="manager_name" id="manager_name" value="{{ old('manager_name') }}">
                                @error('manager_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="capacity" class="form-label">Capacity</label>
                                <input type="number" step="0.01"
                                    class="form-control @error('capacity') is-invalid @enderror" name="capacity"
                                    id="capacity" value="{{ old('capacity') }}">
                                @error('capacity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" id="description" rows="3"
                                    class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('warehouses.index') }}" class="btn btn-light">Back</a>
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
            const choicesStatus = new Choices('#status', {
                searchEnabled: false,
                itemSelectText: '',
                shouldSort: false
            });

            const choicesProvince = new Choices('#province', {
                searchEnabled: true,
                itemSelectText: '',
                shouldSort: false
            });

            const choicesCity = new Choices('#city', {
                searchEnabled: true,
                itemSelectText: '',
                shouldSort: false
            });

            const provinceSelect = document.getElementById('province');
            provinceSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const provinceCode = selectedOption.getAttribute('data-code');

                if (provinceCode) {
                    fetch(`/api/cities/${provinceCode}`)
                        .then(response => response.json())
                        .then(cities => {
                            choicesCity.clearStore();
                            choicesCity.setChoices([{
                                value: '',
                                label: 'Choose City',
                                selected: true
                            }], 'value', 'label', true);

                            const cityChoices = cities.map(city => ({
                                value: city.name,
                                label: city.name
                            }));

                            choicesCity.setChoices(cityChoices, 'value', 'label', false);
                        });
                } else {
                    choicesCity.clearStore();
                    choicesCity.setChoices([{
                        value: '',
                        label: 'Choose City',
                        selected: true
                    }], 'value', 'label', true);
                }
            });
        });
    </script>
@endpush
