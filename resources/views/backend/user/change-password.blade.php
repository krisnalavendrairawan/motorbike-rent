@extends('layouts.backend.index')

@section('title', $title)

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
@endsection

@section('page-action')
    <li class="breadcrumb-item text-light position static">
        <x-profile />
    </li>
@endsection

@section('content')

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <img src={{ asset('assets/img/avatars/1.png') }} class="card-img-top w-50 h-50 align-self-center mt-3" alt="...">
                <div class="card-body">
                    <h5 class="card-title">{{ $user->name }}</h5>
                    <p class="card-text">{{ $user->email }}</p>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <i class="bx bx-calendar"></i> Terakhir Login Jam :
                        {{ \Carbon\Carbon::parse($user->lastlogin_at)->format('d M Y H:i') }}
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class=card-header>
                    <div class="card-title mb-0">
                        <h3 class="text-primary">{{ __('label.change_password') }}</h3>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('user.password.update') }}" class="form-block">
                        @csrf
                        @method('PUT')
                        <div class="col-sm-6 col-md-6">
                            <x-form.input-group type="password" name="old_password" :label="__('label.old_password')" :old="old('old_password', $user->old_password)"
                                addon="<i class='bx bxs-lock-alt'></i>" autocomplete="new-password" />
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <x-form.input-group type="password" name="new_password" :label="__('label.new_password')" :old="old('new_password', $user->new_password)"
                                addon="<i class='bx bxs-lock-alt'></i>" autocomplete="new-password" />
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <x-form.input-group type="password" name="new_password_confirmation" :label="__('label.new_password_confirmation')"
                                :old="old('new_password_confirmation', $user->new_password_confirmation)" addon="<i class='bx bxs-lock-alt'></i>" />
                        </div>
                        <x-form.button-submit :cancel-route="route('dashboard.index')" />
                    </form>
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
        })
    </script>
@endpush
