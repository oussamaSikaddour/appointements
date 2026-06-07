<div
  role="dialog"
  aria-labelledby="dialog_label"
  class="modal"
  id="defaultModal"
  x-data="{ isOpen: @entangle('isOpen') }"
  x-bind:class="{ 'open': isOpen }"
>
  <div class="modal__content">
    <div class="modal__header">
      <!-- Accessible title for screen readers -->
      <h2 id="dialog_label" class="sr-only">Info Modal</h2>
      <!-- Visible title -->
      <h2>@lang($title ,$titleOptions)</h2>
      <button class="modal__closer" >
        <span></span>
        <span></span>
      </button>
    </div>

        @switch($type)

               @case("for_image")
               <div class="form__container">
                   <img src="{{ $component }}" alt="lettre ">
                </div>
                @break
            @default
            @if(isset($component) && is_array($component) && count($component) > 0)
               @livewire($component['name'], $component['parameters'])
             @endif
        @endswitch

  </div>
</div>

@script
<script>
  document.addEventListener('model-will-be-close', function () {
    @this.closeModal();


    if (@this.containsTinyMce) {
      setTimeout(() => {
        window.location.reload();
      }, 300); // Optional delay for smoother UX
    }
  });

</script>
@endscript
