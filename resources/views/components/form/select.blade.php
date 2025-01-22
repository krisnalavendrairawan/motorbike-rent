@if ($label !== false)
    @php
    $divclose = '</div>';
    $optional = ($optional) ? ' <small class="text-muted">( ' . __('label.optional') . ' )</small>' : '';
    @endphp

    <div class="form-group">
        <label>{!! $label !!}{!! $optional !!}</label>
@endif

<select {{ $attributes->merge(['class' => 'set-select2']) }}>
    <option value=""></option>

    @foreach ($option as $value => $label)
        @php
        $selected = ($value == $old) ? ' selected' : '';
        @endphp

        <option value="{{ $value }}"{{ $selected }}>{{ $label }}</option>
    @endforeach
</select>

@if (!empty($info))
    <small class="text-muted">{{ $info }}</small>
@endif

@if ($loading)
    <div class="loading-option" id="loading-{{ $attributes->get('id') }}">
        <img src="{{ asset('images/loading.gif') }}">
    </div>
@endif

{!! @$divclose !!}

@push('styles')
    @once
    <link rel="stylesheet" href="{{ asset('vendors/select2/css/select2.min.css') }}">
    @endonce
@endpush

@push('scripts')
    @once
    <script src="{{ asset('vendors/select2/js/select2.full.min.js') }}"></script>

    @if ($init == 'true')
        <script>
        setSelect2()
        </script>
    @endif
    @endonce
@endpush
