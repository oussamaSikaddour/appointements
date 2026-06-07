<div class="modal__body">
<div class="form__container">
    <form class="form" wire:submit="handleSubmit">

        <div class="row center">
            <x-default.form.input model="{{$form}}.title_fr" :label="__('forms.article.title_fr')" type="text" html_id="MArticle-aFr" />
            <x-default.form.input model="{{$form}}.title_ar" :label="__('forms.article.title_ar')" type="text" html_id="MArticle-aFr" />
            <x-default.form.input model="{{$form}}.title_en" :label="__('forms.article.title_en')" type="text" html_id="MArticle-aEn" />
        </div>

        <div class="column">

                <p>@lang('forms.article.content_fr') :</p>
        <livewire:default.tiny-mce-text-area
        htmlId="MAContentfr"
        contentUpdatedEvent="set-content-fr"
        wire:key="MaContentFr"
        :content="$contentFr"
        />
        <p>@lang('forms.article.content_ar') :</p>
        <livewire:default.tiny-mce-text-area
        htmlId="MAContentAr"
        contentUpdatedEvent="set-content-ar"
        wire:key="MaContentAr"
        :content="$contentAr"
        />
        <p>@lang('forms.article.content_en') :</p>
        <livewire:default.tiny-mce-text-area
        htmlId="MAContentEn"
        contentUpdatedEvent="set-content-en"
        wire:key="MaContentEn"
        :content="$contentEn"
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

        <x-default.form.upload-input model="{{ $form }}.images"
        :label="__('forms.article.images')" types="img"  multiple="true"/>

            <div x-show="uploading">
              <progress max="100" x-bind:value="progress"></progress>


          </div>

            </div>

     @if (is_array($temporaryImageUrls) && !empty($temporaryImageUrls))
          <div class="imgs__container">
              <div class="imgs">
                  @foreach ($temporaryImageUrls as $url)
                      <img class="img" src="{{ $url }}" alt="{{ __('modals.article.images') }}">
                  @endforeach
              </div>
          </div>
      @endif

            <div class="row center">
                    <x-default.form.selector
                        htmlId="MAAT"
                        model="{{$form}}.articleable_type"
                       :label="__('forms.article.articleable_type')"
                        :data="$articleableTypesOptions"
                        :showError="true"
                        type="filter"
                        />
                    <x-default.form.selector
                        htmlId="MAAI"
                        model="{{$form}}.articleable_id"
                       :label="__('forms.article.articleable_id')"
                        :data="$articleableIdsOptions"
                        :showError="true"
                        />

                          <x-default.form.input model="{{$form}}.published_at" :label="__('forms.article.published_at')" type="date" html_id="MaPat" />

                    </div>

        <div class="form__actions">
            <div wire:loading wire:target="handleSubmit">
                <x-default.loading />
            </div>
            <button type="submit" class="button button--primary">@lang('forms.common.actions.submit')</button>
        </div>
    </form>
</div>
</div>
