<div class="modal__body">
<div class="form__container">
    <form class="form" wire:submit="handleSubmit">

        <div class="row center">
            <x-default.form.input model="{{$form}}.name_fr" :label="__('forms.our_quality.name_fr')" type="text" html_id="Moq-nfr" />
            <x-default.form.input model="{{$form}}.name_ar" :label="__('forms.our_quality.name_ar')" type="text" html_id="Moq-nAr" />
            <x-default.form.input model="{{$form}}.name_en" :label="__('forms.our_quality.name_en')" type="text" html_id="Moq-nEN" />
        </div>

        <div class="column center"

        x-data="{ uploading: false, progress: 0 }"
        x-on:livewire-upload-start="uploading = true"
        x-on:livewire-upload-finish="uploading = false"
        x-on:livewire-upload-cancel="uploading = false"
        x-on:livewire-upload-error="uploading = false"
        x-on:livewire-upload-progress="progress = $event.detail.progress"
        >

        <x-default.form.upload-input model="{{ $form }}.image"
        :label="__('forms.our_quality.image')"  />

            <div x-show="uploading">
              <progress max="100" x-bind:value="progress"></progress>


          </div>

            </div>
        @if ($temporaryImageUrl !=="")
            <div class="imgs__container">
                <div class="imgs">
                        <img class="img" src="{{ $temporaryImageUrl }}" alt="{{__('forms.our_quality.image')}}" />
                </div>
            </div>
        @endif

        <div class="form__actions">
            <div wire:loading wire:target="handleSubmit">
                <x-default.loading />
            </div>
            <button type="submit" class="button button--primary">@lang('forms.common.actions.submit')</button>
        </div>
    </form>
</div>
</div>
