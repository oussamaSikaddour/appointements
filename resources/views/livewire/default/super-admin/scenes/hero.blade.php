
<div class="form__container">
    <form class="form" wire:submit="handleSubmit">


        <div class="row center ">
            <x-default.form.input model="form.title_en" :label="__('forms.manage_hero.title_en')" type="text" html_id="FH-te" />
            <x-default.form.input model="form.title_fr" :label="__('forms.manage_hero.title_fr')" type="text" html_id="FH-tf" />
            <x-default.form.input model="form.title_ar" :label="__('forms.manage_hero.title_ar')" type="text" html_id="FH-ta" />

        </div>
        <div class="row  center">
            <x-default.form.input model="form.sub_title_en" :label="__('forms.manage_hero.sub_title_en')" type="text" html_id="FH-ste" />
            <x-default.form.input model="form.sub_title_fr" :label="__('forms.manage_hero.sub_title_fr')" type="text" html_id="FH-stf" />
            <x-default.form.input model="form.sub_title_ar" :label="__('forms.manage_hero.sub_title_ar')" type="text" html_id="FH-sta" />

        </div>


        <div class="column center"

        x-data="{ uploading: false, progress: 0 }"
        x-on:livewire-upload-start="uploading = true"
        x-on:livewire-upload-finish="uploading = false"
        x-on:livewire-upload-cancel="uploading = false"
        x-on:livewire-upload-error="uploading = false"
        x-on:livewire-upload-progress="progress = $event.detail.progress"
        >

        <x-default.form.upload-input model="form.images"
        :label="__('forms.manage_hero.images')" :multiple=true />

            <div x-show="uploading">
              <progress max="100" x-bind:value="progress"></progress>
          </div>

            </div>
        @if (is_array($temporaryImageUrls) && !empty($temporaryImageUrls))
            <div class="imgs__container">
                <div class="imgs">
                    @foreach ($temporaryImageUrls as $url)
                        <img class="img" src="{{ $url }}" alt="{{__('forms.manage_hero.images')}}" />
                    @endforeach
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
