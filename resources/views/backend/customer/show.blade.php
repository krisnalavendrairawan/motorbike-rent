@extends('layouts.backend.index')

@section('title', $title)
{{-- @dd($customer) --}}
@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
@endsection

@section('page-action')
    <x-profile />
@endsection

@section('content')
    <div class="card mb-4">
        <h5 class="card-header">Profile Details</h5>
        <!-- Account -->
        <div class="card-body">
            <div class="d-flex align-items-start align-items-sm-center gap-4">
                <img src="../assets/img/avatars/1.png" alt="user-avatar" class="d-block rounded" height="100" width="100"
                    id="uploadedAvatar" />
                {{-- <div class="button-wrapper">
                    <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                        <span class="d-none d-sm-block">Upload new photo</span>
                        <i class="bx bx-upload d-block d-sm-none"></i>
                        <input type="file" id="upload" class="account-file-input" hidden
                            accept="image/png, image/jpeg" />
                    </label>
                    <button type="button" class="btn btn-outline-secondary account-image-reset mb-4">
                        <i class="bx bx-reset d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Reset</span>
                    </button>

                    <p class="text-muted mb-0">Allowed JPG, GIF or PNG. Max size of 800K</p>
                </div> --}}
            </div>
        </div>
        <hr class="my-0" />
        <div class="card-body">
            <form id="formAccountSettings" method="POST" onsubmit="return false">
                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label for="name" class="form-label">{{ __('label.name') }}</label>
                        <input class="form-control" type="text" id="name" name="name"
                            value="{{ $customer->name }}" autofocus disabled />
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="nik" class="form-label">{{ __('label.nik') }}</label>
                        <input class="form-control" type="text" name="nik" id="nik"
                            value="{{ $customer->nik }}" disabled />
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="email" class="form-label">{{ __('label.email') }}</label>
                        <input class="form-control" type="text" id="email" name="email"
                            value="{{ $customer->email }}" placeholder="email@example.com" disabled />
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="driverLicense" class="form-label">{{ __('label.driver_license') }}</label>
                        <input type="text" class="form-control" id="driverLicense" name="driverLicense"
                            value="{{ $customer->driverLicense }}" disabled />
                    </div>
                    <div class="mb-3 col-md-6">
                        <label class="form-label" for="phone">{{ __('label.phone_number') }}</label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text">ID (+62)</span>
                            <input type="text" id="phone" name="phone" class="form-control" placeholder="+62....."
                                value="{{ $customer->phone }}" disabled />
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="address">{{ __('label.address') }}</label>
                        <div class="input-group input-group-merge">
                            <span id="address" class="input-group-text">
                                <i class='bx bxs-location-plus'></i>
                            </span>
                            <textarea id="address" name="address" class="form-control" placeholder="Jl. angkasa"
                                aria-label="{{ __('label.phone_number') }}" aria-describedby="address-icon" rows="3" disabled>{{ $customer->address }}</textarea>
                        </div>
                    </div>
                </div>
        </div>

        <!-- Rental History Section -->
        <div class="card mb-4">
            <h5 class="card-header bg-primary text-white">Rental History</h5>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="badge bg-dark mt-3 mb-3">
                            Total Spent on Rentals: Rp {{ number_format($totalSpent, 0, ',', '.') }}
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Motor</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Total Price</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($rentalHistory as $rental)
                                        <tr>
                                            <td>{{ $rental->motor->name }}</td>
                                            <td>{{ \Carbon\Carbon::parse($rental->start_date)->format('d M Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($rental->end_date)->format('d M Y') }}</td>
                                            <td>Rp {{ number_format($rental->total_price, 0, ',', '.') }}</td>
                                            <td>
                                                <span
                                                    class="badge 
                                                @if ($rental->status == 'rent') bg-label-success
                                                @elseif($rental->status == 'pending') bg-label-warning
                                                @else bg-label-danger @endif">
                                                    {{ ucfirst($rental->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">No rental history found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class=" p-4">
            <button type="submit" class="btn btn-primary me-2">Save changes</button>
            <button type="reset" class="btn btn-outline-secondary">Cancel</button>
        </div> --}}
        </form>
    @endsection
