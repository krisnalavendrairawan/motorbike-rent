@extends('layouts.backend.index')

@section('title', $title)

@section('breadcrumb')
    <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
@endsection
{{-- @dd($brand) --}}
@section('page-action')
    <x-profile />
@endsection

@section('content')
    <div class="col-xl">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">{{ __('label.edit_brand') }}</h5>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('brand.update', $brand->encrypted_id) }}" class="form-block"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <x-form.input-text name="name" :label="__('label.name')" :old="old('name', $brand->name)" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-6 col-md-6">
                            <label for="logo" class="form-label">{{ __('label.logo') }}</label>
                            @if ($brand->logo)
                                <div class="mb-3">
                                    <img src="{{ asset('storage/' . $brand->logo) }}" alt="Current Logo" class="img-fluid"
                                        style="max-width: 200px">
                                    <p class="text-muted mt-2">Current logo</p>
                                </div>
                            @endif
                            <input class="form-control" type="file" id="logo" name="logo" />
                            <small class="text-muted">Leave empty to keep current logo</small>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-6 col-md-6">
                            <x-input-text name="description" label="{{ __('label.description') }}" icon="bx bx-text"
                                placeholder="Enter your description" value="{{ old('description') }}" :value="$brand->description" />
                        </div>
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
