<div class="upload__group__container hasTooltip" id='htmlId'>
    <div class="upload__group" role="input" tabindex="0">
      <button class="button rounded ">
        {!! $iconHtml !!}
      </button>
      <input
      type="file"
      wire:model="{{ $model }}"
      @if ($multiple) multiple @endif
      @if ($typesToUpload) accept="{{$typesToUpload }}" @endif
      {{ $attributes }}
      />
    </div>
    <span
    id="trashToolTip1"
    class="toolTip"
    role="tooltip"
    aria-label="{{ $tooltip }}"
  >
  {{ $tooltip }}
  </span>
    </div>
