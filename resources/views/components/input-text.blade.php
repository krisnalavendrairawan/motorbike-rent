<div class="mb-3">
    <label class="form-label" for="text-{{ $name }}">{{ $label }}</label>
    <div class="input-group input-group-merge">
        <span id="text-{{ $name }}-icon" class="input-group-text">
            <i class="{{ $icon }}"></i>
        </span>
        <textarea id="text-{{ $name }}" name="{{ $name }}" class="form-control @error($name) is-invalid @enderror"
            placeholder="{{ $placeholder }}" aria-label="{{ $label }}" aria-describedby="text-{{ $name }}-icon"
            rows="3">{{ old($name, $value) }}</textarea>
        @error($name)
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>
