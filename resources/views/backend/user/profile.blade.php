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
                <img src={{ asset('assets/img/avatars/1.png') }} class="card-img-top w-50 h-50 align-self-center mt-3"
                    alt="...">
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
        <div class="col-md-6">
            <div class="card">
                <div class=card-header>
                    <div class="card-title mb-0">
                        <h3 class="text-primary">{{ __('label.profile') }}</h3>
                    </div>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('user.profile.update') }}" class="form-block">
                        @csrf
                        @method('PUT')
                        <div class="row my-2">
                            <div class="col-md-6 col-sm-6">
                                <x-form.input-text label="{{ __('label.name') }}" name="name" :old="old('name', $user->name)" />
                            </div>
                        </div>
                        <div class="row my-2">
                            <div class="col-sm-6 col-md-6">
                                <x-form.input-group-mask name="phone" :label="__('label.phone_number')" :old="old('phone', $user->phone)" mask="handphone"
                                    addon="<i class='bx bx-mobile'></i>" />
                            </div>
                        </div>
                        <div class="row my-2">
                            <div class="col-sm-6 col-md-6">
                                <x-form.input-group-mask name="email" :label="__('label.email')" :old="old('email', $user->email)" mask="email"
                                    addon="<i class='bx bxs-envelope'></i>" />
                            </div>
                        </div>
                        <div class="col-md-4 my-2">
                            <x-form.radio name="gender" :label="__('label.gender')" :old="old('gender')" :option="$genders" />
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

            $(".handphone-mask").inputmask({
                alias: "handphone"
            })
            $(".email-mask").inputmask({
                alias: "email"
            })
        })
    </script>
@endpush
