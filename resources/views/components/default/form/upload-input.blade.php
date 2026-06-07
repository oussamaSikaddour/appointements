<div class="upload__group" id="{{ $htmlId }}">
    <label class="button">
        <span>{{ $label }}</span>
        <input
        type="file"
      wire:model="{{ $model }}"
      @if ($multiple) multiple @endif
      @if ($typesToUpload) accept="{{$typesToUpload }}" @endif
      {{ $attributes }}
        />
    </label>

    @error($model)
        <div class="input__error">
            {{ $message }}
        </div>
    @enderror
</div>
