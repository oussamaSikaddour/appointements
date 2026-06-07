
<div class="form__container ">
    <form class="form" wire:submit="handleSubmit">

        <div class="row center">
            <x-default.form.input model="form.title_fr" :label="__('forms.manage_about_us.title_fr')" type="text" html_id="FAU-tf" />
            <x-default.form.input model="form.title_ar" :label="__('forms.manage_about_us.title_ar')" type="text" html_id="FAU-ta" />
            <x-default.form.input model="form.title_en" :label="__('forms.manage_about_us.title_en')" type="text" html_id="FAU-te" />
        </div>


        <div class="column">
            <x-default.form.textarea
            model="form.description_fr"
            :label="__('forms.manage_about_us.description_fr')"
            html_id="FAU-df"
            />
            <x-default.form.textarea
            model="form.description_ar"
            :label="__('forms.manage_about_us.description_ar')"
            html_id="FAU-da"
            />
            <x-default.form.textarea
            model="form.description_en"
            :label="__('forms.manage_about_us.description_en')"
            html_id="FAU-de"
            />
        </div>

        <div class="column center"
        x-data="{ uploading: false, progress: 0 }"
        x-on:livewire-upload-start="uploading = true"
        x-on:livewire-upload-finish="uploading = false"
        x-on:livewire-upload-cancel="uploading = false"
        x-on:livewire-upload-error="uploading = false"
        x-on:livewire-upload-progress="progress = $event.detail.progress"
        >

        <x-default.form.upload-input model="form.image"
        :label="__('forms.manage_about_us.image')" />
            <div x-show="uploading">
              <progress max="100" x-bind:value="progress"></progress>
          </div>
            </div>
        @if ($temporaryImageUrl !=="")
            <div class="imgs__container">
                <div class="imgs">
                    <img class="img" src="{{ $temporaryImageUrl }}" alt="{{__('forms.manage_about_us.image')}}" />
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
