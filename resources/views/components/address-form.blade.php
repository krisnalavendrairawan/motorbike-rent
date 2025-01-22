<div class="mb-3">
    <label class="form-label" for="address-{{ $name }}">{{ $label }}</label>
    <div class="input-group input-group-merge">
        <span id="address-{{ $name }}-icon" class="input-group-text">
            <i class='bx bxs-location-plus'></i>
        </span>
        <textarea id="address-{{ $name }}" name="{{ $name }}"
            class="form-control @error($name) is-invalid @enderror" placeholder="{{ $placeholder }}"
            aria-label="{{ $label }}" aria-describedby="address-{{ $name }}-icon" rows="3">{{ old($name, $value) }}</textarea>
        @error($name)
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>
