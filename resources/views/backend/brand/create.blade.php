@extends('layouts.backend.index')

@section('title', $title)

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
@endsection

@section('page-action')
    <x-profile />
@endsection

@section('content')

    <div class="col-xl">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">{{ __('label.create_brand') }}</h5>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('brand.store') }}" class="form-block" enctype="multipart/form-data">
                    @csrf
                    <x-form.input-text type="hidden" />

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <x-form.input-text name="name" :label="__('label.name')" :old="old('name')" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-6 col-md-6">
                            <label for="logo" class="form-label">{{ __('label.logo') }}</label>
                            <input class="form-control" type="file" id="logo" name="logo" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-6 col-md-6">
                            <x-input-text name="description" label="{{ __('label.description') }}" icon="bx bx-text"
                                placeholder="Enter your description" value="{{ old('description') }}" />
                        </div>
                    </div>

                    <div class="row mb-3">
                    </div>
                    <x-form.button-submit :cancel-route="route('brand.index')" />
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
        })
    </script>
@endpush
