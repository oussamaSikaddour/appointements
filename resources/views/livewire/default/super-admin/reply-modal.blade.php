<div class="modal__body">
<div class="form__container">
    <form class="form" wire:submit="handleSubmit">
     <div class="row">
        <p>{{ $message['message'] }}</p>
     </div>

        <div class="column">


            <livewire:default.tiny-mce-text-area htmlId="rM-m" contentUpdatedEvent="set-message-content" wire:key="rM-m" :content="$messageContent" />
        </div>
        <div class="form__actions">
            <div wire:loading wire:target="handleSubmit">
                <x-default.loading />
            </div>
            <button type="submit" class="button button--primary rounded">
                <i class='fa-solid fa-reply'></i>
            </button>
        </div>
    </form>
</div>
<div class="modal__body">
