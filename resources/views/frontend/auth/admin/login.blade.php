@extends('layouts.auth.index')

@section('content')
    <form class="login100-form" method="POST" action="{{ route('login') }}">
        @csrf

        <div class="header">
            <img src="{{ asset('assets/img/auth/logo.png') }}" style="height: 100px;" />
            <h1>Rental Motor</h1>
            <div class="mb-4">
                Silahkan login terlebih dahulu
            </div>
        </div>

        <div class="wrap-input100">
            <input class="input100" type="text" name="login" value="{{ old('login') }}" autocomplete="off" />
            <span class="focus-input100"></span>
            <span class="label-input100">Email or Phone</span>
        </div>


        <div class="wrap-input100">
            <input class="input100" type="password" name="password" autocomplete="new-password" />
            <span class="focus-input100"></span>
            <span class="label-input100">Password</span>
        </div>

        <div class="contact100-form-checkbox mt-3">
            <input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
            <label class="label-checkbox100" for="ckb1">
                Remember me
            </label>
        </div>

        <div class="d-grid gap-2 mt-4">
            <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">
                LOGIN
            </button>
        </div>
    </form>
    @if ($errors->any() && session('sweetalert'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Login Failed',
                    text: '{{ $errors->first('login') }}',
                    timer: 3000,
                    showConfirmButton: false
                });
            });
        </script>
    @endif
@endsection
