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
        <div class=" p-4">
            <button type="submit" class="btn btn-primary me-2">Save changes</button>
            <button type="reset" class="btn btn-outline-secondary">Cancel</button>
        </div>
        </form>
@endsection
