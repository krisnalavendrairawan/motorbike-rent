@extends('layouts.backend.index')

@section('title', 'Create New Service')

@section('breadcrumb')
    <li class="breadcrumb-item">
        <a href="{{ route('service.index') }}">{{ __('label.service') }}</a>
    </li>
    <li class="breadcrumb-item active" aria-current="page">Create New Service</li>
@endsection

@section('page-action')
    <li class="breadcrumb-item text-light">
        <x-profile />
    </li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-lg-8 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title mb-4">Service Information</h5>

                        <form action="{{ route('service.store') }}" method="POST">
                            @csrf

                            <div class="row g-4">
                                <!-- Motor Selection -->
                                <div class="col-12">
                                    <label class="form-label">Motor</label>
                                    <select name="motor_id" class="form-select @error('motor_id') is-invalid @enderror"
                                        required>
                                        <option value="">Select Motor</option>
                                        @foreach ($motor as $bike)
                                            <option value="{{ $bike->id }}"
                                                {{ old('motor_id') == $bike->id ? 'selected' : '' }}>
                                                {{ $bike->name }} - {{ $bike->plate }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('motor_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Service Date -->
                                <div class="col-12">
                                    <label class="form-label">Service Date</label>
                                    <input type="datetime-local" name="service_date"
                                        class="form-control @error('service_date') is-invalid @enderror"
                                        value="{{ old('service_date') }}" required>
                                    @error('service_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Service Type -->
                                <div class="col-12">
                                    <label class="form-label">Service Type</label>
                                    <select name="service_type"
                                        class="form-select @error('service_type') is-invalid @enderror" required>
                                        <option value="">Select Service Type</option>
                                        @foreach ($serviceTypes as $value => $label)
                                            <option value="{{ $value }}"
                                                {{ old('service_type') == $value ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('service_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Cost -->
                                <div class="col-12">
                                    <label class="form-label">Service Cost</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" name="cost"
                                            class="form-control @error('cost') is-invalid @enderror"
                                            value="{{ old('cost') }}" required>
                                        @error('cost')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Service Description -->
                                <div class="col-12">
                                    <label class="form-label">Service Details</label>
                                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="3"
                                        placeholder="Describe the service details, issues found, or repairs needed...">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Form Actions -->
                                <div class="col-12 mt-4">
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary">
                                            <i class='bx bxs-save'></i> Create Service Record
                                        </button>
                                        <a href="{{ route('service.index') }}" class="btn btn-outline-secondary">
                                            <i class='bx bx-x'></i> Cancel
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Motor Information Card -->
            <div class="col-12 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Service Types Information</h5>

                        <div class="mb-3">
                            <span class="badge bg-primary mb-2">Regular Service</span>
                            {{-- <p class="small text-muted">Routine maintenance and checkup</p> --}}
                            <p class="small text-muted">Perawatan dan pemeriksaan rutin</p>
                        </div>

                        <div class="mb-3">
                            <span class="badge bg-info mb-2">Repair/Fix</span>
                            <p class="small text-muted">Memperbaiki masalah atau kerusakan tertentu</p>
                        </div>

                        <div class="mb-3">
                            <span class="badge bg-warning mb-2">Spare Part Replacement</span>
                            {{-- <p class="small text-muted">Replacing worn out or damaged parts</p> --}}
                            <p class="small text-muted">Mengganti bagian yang sudah lama atau rusak</p>
                        </div>

                        <div class="mb-3">
                            <span class="badge bg-danger mb-2">Emergency Service</span>
                            {{-- <p class="small text-muted">Urgent repairs or maintenance</p> --}}
                            <p class="small text-muted">Perbaikan atau pemeliharaan Mendadak</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .card {
            border: none;
            box-shadow: 0 0 0.875rem 0 rgba(33, 37, 41, .05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #696cff;
            box-shadow: 0 0 0 0.25rem rgba(105, 108, 255, 0.1);
        }

        .btn-primary {
            background-color: #696cff;
            border-color: #696cff;
        }

        .btn-primary:hover {
            background-color: #5f65e8;
            border-color: #5f65e8;
        }
    </style>
@endsection
