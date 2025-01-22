@extends('frontend.auth.customer.index')

@section('title', 'Login')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}" />
    <style>
        .form-card {
            box-shadow: 0 4px 24px 0 rgba(34, 41, 47, 0.1);
            border-radius: 0.428rem;
        }

        .auth-illustration {
            max-width: 140px;
            margin-bottom: 1rem;
        }

        .social-btn {
            transition: all 0.3s ease-in-out;
        }

        .social-btn:hover {
            transform: translateY(-2px);
        }
    </style>
@endpush

@section('content')
    <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner py-4">
            <div class="card form-card">
                <!-- Logo & Header -->
                <div class="card-header py-4 text-center bg-light">
                    <div class="app-brand justify-content-center mb-2">
                        <img src="{{ asset('assets/img/illustrations/login-illustration.png') }}" alt="Login"
                            class="auth-illustration">
                    </div>
                    <h4 class="mb-2">Welcome back! 👋</h4>
                    <p class="mb-0">Please sign in to your account</p>
                </div>

                <div class="card-body">
                    <!-- Login Form -->
                    <form class="mb-3" action="{{ route('customer.login') }}" method="POST">
                        @csrf

                        <!-- Email Field -->
                        <div class="mb-3">
                            <x-form.input-group-mask name="email" :label="__('label.email')" :old="old('email')" mask="email"
                                addon="<i class='bx bxs-envelope'></i>" />
                        </div>

                        <!-- Password Field -->
                        <div class="mb-3 form-password-toggle">
                            <div class="d-flex justify-content-between">
                                <label class="form-label" for="password">{{ __('label.password') }}</label>
                                {{-- <a href="{{ route('customer.forgot-password') }}">
                                    <small>Forgot Password?</small>
                                </a> --}}
                            </div>
                            <x-form.input-group type="password" name="password" :label="false"
                                addon="<i class='bx bxs-lock-alt'></i>" />
                        </div>

                        <!-- Remember Me -->
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember-me" name="remember">
                                <label class="form-check-label" for="remember-me">
                                    Remember Me
                                </label>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="mb-3">
                            <button class="btn btn-primary d-grid w-100" type="submit">
                                Sign in
                            </button>
                        </div>
                    </form>

                    <!-- Social Login -->
                    <div class="divider my-4">
                        <div class="divider-text">or</div>
                    </div>

                    <div class="d-flex justify-content-center gap-2 mb-4">
                        <button class="btn btn-icon btn-outline-secondary social-btn">
                            <i class="bx bxl-google fs-5"></i>
                        </button>
                        <button class="btn btn-icon btn-outline-secondary social-btn">
                            <i class="bx bxl-facebook-circle fs-5"></i>
                        </button>
                        <button class="btn btn-icon btn-outline-secondary social-btn">
                            <i class="bx bxl-twitter fs-5"></i>
                        </button>
                    </div>

                    <!-- Register Link -->
                    <p class="text-center">
                        <span>New on our platform?</span>
                        <a href="{{ route('customer.register') }}">
                            <span>Create an account</span>
                        </a>
                    </p>
                </div>
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

            $(".email-mask").inputmask({
                alias: "email"
            })
        })
    </script>
@endpush
