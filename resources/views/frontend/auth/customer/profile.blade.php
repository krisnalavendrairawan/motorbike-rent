@extends('frontend.auth.customer.index')

@section('title', 'Profile')

@section('content')
    <div class="container py-5">
        <div class="row">
            <!-- Profile Information Form -->
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <form action="{{ route('customer.profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <!-- Profile Photo Section -->
                                <div class="col-lg-4 text-center mb-4 ">
                                    <div
                                        class="profile-photo-container mb-3 d-flex align-items-center justify-content-center">
                                        <img src="{{ auth()->user()->picture ? asset('storage/' . auth()->user()->picture) : asset('assets/img/avatars/1.png') }}"
                                            class="rounded-circle img-thumbnail preview-image" id="preview"
                                            style="width: 150px; height: 150px; object-fit: cover;">
                                    </div>

                                    <div class="upload-buttons mb-3">
                                        <label for="picture" class="btn btn-primary me-2">
                                            <span class="d-none d-sm-block">Upload new photo</span>
                                            <i class="bx bx-upload d-block d-sm-none"></i>
                                            <input type="file" id="picture" name="picture" class="d-none"
                                                accept="image/png, image/jpeg" onchange="previewImage(this)" />
                                        </label>
                                        <button type="button" class="btn btn-outline-secondary" onclick="resetImage()">
                                            <i class="bx bx-reset d-block d-sm-none"></i>
                                            <span class="d-none d-sm-block">Reset</span>
                                        </button>
                                    </div>

                                    <p class="text-muted small">Allowed JPG, GIF or PNG. Max size of 800K</p>

                                    <div class="user-info">
                                        <h4 class="mb-1">{{ auth()->user()->name }}</h4>
                                        <p class="text-muted">{{ auth()->user()->email }}</p>
                                        <hr>
                                        <div class="d-flex justify-content-center gap-2">
                                            <span class="badge bg-primary-subtle text-primary">
                                                Member since {{ auth()->user()->created_at->format('M Y') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Profile Details Section -->
                                <div class="col-lg-8">
                                    <h5 class="card-title mb-4">Profile Information</h5>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <x-form.input-text name="name" :label="__('label.name')" :old="old('name', $customer->name)" />
                                        </div>
                                        <div class="col-md-6">
                                            <x-form.input-group-mask name="nik" :label="__('label.nik')" :old="old('nik', $customer->nik)"
                                                mask="nik" addon="<i class='bx bx-id-card'></i>" />
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <x-form.input-group-mask name="driverLicense" :label="__('label.driver_license')"
                                                :old="old('driverLicense', $customer->driverLicense)" mask="driverLicense"
                                                addon="<i class='bx bx-barcode'></i>" />
                                        </div>
                                        <div class="col-md-6">
                                            <x-form.input-group-mask name="phone" :label="__('label.phone_number')" :old="old('phone', $customer->phone)"
                                                mask="handphone" addon="<i class='bx bx-mobile'></i>" />
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <x-form.input-group-mask name="email" :label="__('label.email')" :old="old('email', $customer->email)"
                                                mask="email" addon="<i class='bx bxs-envelope'></i>" />
                                        </div>
                                        <div class="col-md-6">
                                            <x-form.radio name="gender" :label="__('label.gender')" :old="old('gender', $customer->gender)"
                                                :option="$genders" />
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <x-address-form name="address" label="{{ __('label.address') }}"
                                            placeholder="Enter your address" :value="$customer->address" />
                                    </div>

                                    <!-- Password Change Section -->
                                    <div class="border-top pt-4 mt-4">
                                        <h5 class="card-title mb-3">Change Password</h5>
                                        <p class="text-muted small mb-4">{{ __('string.info_only_filled_password') }}</p>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <x-form.input-group type="password" name="old_password" :label="__('label.old_password')"
                                                    addon="<i class='bx bxs-lock-alt'></i>" autocomplete="new-password" />
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <x-form.input-group type="password" name="new_password" :label="__('label.new_password')"
                                                    addon="<i class='bx bxs-lock-alt'></i>" autocomplete="new-password" />
                                            </div>
                                            <div class="col-md-6">
                                                <x-form.input-group type="password" name="new_password_confirmation"
                                                    :label="__('label.new_password_confirmation')" addon="<i class='bx bxs-lock-alt'></i>" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="text-end mt-4">
                                        <a href="{{ route('landing.index') }}" class="btn btn-outline-secondary me-2">
                                            <i class="bx bx-x d-block d-sm-none"></i>
                                            <span class="d-none d-sm-block">Cancel</span>
                                        </a>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bx bx-check d-block d-sm-none"></i>
                                            <span class="d-none d-sm-block">Save Changes</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const error =
                "@isset($errors->all()[0]) {{ $errors->all()[0] }} @endisset";

            if (error != "") {
                setNotifInfo(error);
            }

            // Initialize input masks
            $(".handphone-mask").inputmask({
                alias: "handphone"
            });
            $(".email-mask").inputmask({
                alias: "email"
            });
            $(".driverLicense-mask").inputmask({
                alias: "driverLicense"
            });
        });

        // Image preview functionality
        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Reset image functionality
        function resetImage() {
            document.getElementById('preview').src =
                "{{ auth()->user()->picture ? asset('storage/' . auth()->user()->picture) : asset('assets/img/avatars/1.png') }}";
            document.getElementById('picture').value = '';
        }
    </script>
@endpush
