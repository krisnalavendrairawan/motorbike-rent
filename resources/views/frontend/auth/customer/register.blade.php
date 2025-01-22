@extends('frontend.auth.customer.index')

@section('title', 'Register')


@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}" />
    <style>
        .form-card {
            box-shadow: 0 4px 24px 0 rgba(34, 41, 47, 0.1);
            border-radius: 0.428rem;
        }

        .form-section {
            padding: 1.5rem;
            border-bottom: 1px solid #eee;
        }

        .form-section:last-child {
            border-bottom: none;
        }
    </style>
@endpush

@section('content')
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
            <div class="card form-card">

                <div class="card-header py-3 text-center bg-light">
                    <h4 class="mb-2">{{ __('label.create_customer') }} 🚀</h4>
                    <p class="text-muted mb-0">Please fill in your information below</p>
                </div>

                <form method="post" action="{{ route('customer.register.create') }}" class="form-block">
                    @csrf
                    <x-form.input-text type="hidden" />

                    <div class="form-section">
                        <h5 class="text-primary mb-3">Personal Information</h5>
                        <div class="row g-3">
                            <x-form.input-text name="name" :label="__('label.name')" :old="old('name')" />


                            <x-form.input-group-mask name="nik" :label="__('label.nik')" :old="old('nik')" mask="nik"
                                addon="<i class='bx bx-id-card'></i>" />


                            <x-form.input-group-mask name="driverLicense" :label="__('label.driver_license')" :old="old('driverLicense')"
                                mask="driverLicense" addon="<i class='bx bx-barcode'></i>" />

                            <x-form.radio name="gender" :label="__('label.gender')" :old="old('gender')" :option="$genders" />
                        </div>
                    </div>

                    <div class="form-section">
                        <h5 class="text-primary mb-3">Contact Information</h5>
                        <div class="row g-3">

                            <x-form.input-group-mask name="phone" :label="__('label.phone_number')" :old="old('phone')" mask="handphone"
                                addon="<i class='bx bx-mobile'></i>" />


                            <x-form.input-group-mask name="email" :label="__('label.email')" :old="old('email')" mask="email"
                                addon="<i class='bx bxs-envelope'></i>" />

                        </div>
                    </div>

                    <div class="form-section">
                        <h5 class="text-primary mb-3">Account Security</h5>
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <x-form.input-group type="password" name="password" :label="__('label.password')" :old="old('password')"
                                    addon="<i class='bx bxs-lock-alt'></i>" autocomplete="new-password" />
                            </div>
                            <div class="col-12 col-md-6">
                                <x-form.input-group type="password" name="password_confirm" :label="__('label.confirm_password')"
                                    :old="old('password_confirm')" addon="<i class='bx bxs-lock-alt'></i>" />
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h5 class="text-primary mb-3">Address Details</h5>
                        <div class="row">
                            <div class="col-12">
                                <x-address-form name="address" label="{{ __('label.address') }}"
                                    placeholder="Enter your address" />
                            </div>
                        </div>
                    </div>

                    <div class="form-section bg-light">
                        <div class="d-flex justify-content-end gap-2">
                            <x-form.button-submit :cancel-route="route('landing.index')" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const error =
            "@isset($errors->all()[0]) {{ $errors->all()[0] }} @endisset"

        $(document).ready(function() {
            if (error != "")
                setNotifInfo(error)

            $(".handphone-mask").inputmask({
                alias: "handphone"
            })
            $(".email-mask").inputmask({
                alias: "email"
            })
            $(".nik-mask").inputmask({
                alias: "nik"
            })
            $(".driverLicense-mask").inputmask({
                alias: "driverLicense"
            })
        })
    </script>
@endpush
