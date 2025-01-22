@extends('layouts.backend.index')

@section('title', $title)
{{-- @dd($brand) --}}
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
                <h5 class="mb-0">{{ __('label.create_bike') }}</h5>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('bike.store') }}" class="form-block" enctype="multipart/form-data">
                    @csrf
                    <x-form.input-text type="hidden" />

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <x-form.input-text name="name" :label="__('label.name')" :old="old('name')" />
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <x-form.input-group-mask name="plate" :label="__('label.plate')" :old="old('plate')" mask="plate"
                                addon="<i class='bx bxs-barcode'></i>" class="indonesianPlate-mask" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-6 col-md-3">
                            <label for="brand_id" class="form-label">{{ __('label.brand') }}</label>
                            <select id="brand_id" name="brand_id" class="form-select">
                                <option value="">Select Brand</option>
                                @foreach ($brand as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('brand_id') == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <label for="type" class="form-label">{{ __('label.bike_type') }}</label>
                            <select id="type" name="type" class="form-select">
                                @foreach ($type as $key => $value)
                                    <option value="{{ $key }}" {{ old('bike_type') == $key ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-6 col-md-3">
                            <label for="status" class="form-label">{{ __('label.status') }}</label>
                            <select id="status" name="status" class="form-select">
                                <option value="ready" {{ old('status') == 'ready' ? 'selected' : '' }}>Ready</option>
                                <option value="not_ready" {{ old('status') == 'not_ready' ? 'selected' : '' }}>Not Ready
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="col-md-4">
                            <x-form.input-text name="color" :label="__('label.color')" :old="old('color')" />
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="col-md-4">
                            <x-form.input-group-mask name="price" :label="__('label.price')" :old="old('price')"
                                mask="indonesianCurrency" addon="<i class='bx bx-money'></i>" class="currency-mask" />
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-6 col-md-6">
                            <label for="image" class="form-label">{{ __('label.image') }}</label>
                            <input class="form-control" type="file" id="image" name="image" />
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
                    <x-form.button-submit :cancel-route="route('bike.index')" />
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

            $(".indonesianPlate-mask").inputmask({
                alias: "indonesianPlate"
            });

            $(".currency-mask").inputmask({
                alias: "indonesianCurrency"
            });
        })

        $("#brand_search").on('input', function() {
            let val = this.value;
            let option = $('#brandOptions option').filter(function() {
                return this.value === val;
            });

            if (option.length > 0) {
                let brandId = option.data('value');
                $("#brand_id").val(brandId);
            } else {
                $("#brand_id").val('');
            }
        });
    </script>
@endpush
