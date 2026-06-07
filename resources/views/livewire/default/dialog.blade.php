
<div role="dialog"
     aria-labelledby="dialog_box"
     class="box"
     x-data="{ isOpen: @entangle('isOpen') }"
     x-bind:class="{ 'open': isOpen }"
     id="box">
    <h3 id="dialog_box" class="sr-only">@lang('Help about the box')</h3>

    <div class="box__header">
        <h3>{{ __($question) }}</h3>
    </div>
    <div class="box__body">
            {{ $questionDetails }}
    </div>

    <div class="box__footer">
           <div wire:loading >
                    <x-default.loading />
           </div>
        <button class="button box__closer" wire:click="closeDialog">@lang('Non')</button>
        <button class="button button--primary" wire:click="confirmAction">@lang('Oui')</button>
    </div>
</div>

@script
<script>
    document.addEventListener('close-dialog', () => {
        @this.closeDialog();
    });

    $wire.on("user-chose-yes", () => {
        @this.closeDialog();

        // Dispatch a custom event for external logic
        const closeDialogBoxEvent = new CustomEvent('dialog-will-be-close');
        document.dispatchEvent(closeDialogBoxEvent);
    });
</script>
@endscript
