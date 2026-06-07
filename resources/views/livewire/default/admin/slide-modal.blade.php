<div class="modal__body"  >
    <div class="form__container">
        <form class="form" wire:submit="handleSubmit">
            <!-- Titles Section -->
            <div class="row center">
                <x-default.form.input
                    model="{{$form}}.title_fr"
                    :label="__('forms.slide.title_fr')"
                    type="text"
                    html_id="MSlide-aFr"
                />
                <x-default.form.input
                    model="{{$form}}.title_ar"
                    :label="__('forms.slide.title_ar')"
                    type="text"
                    html_id="MSlide-aFr"
                />
                <x-default.form.input
                    model="{{$form}}.title_en"
                    :label="__('forms.slide.title_en')"
                    type="text"
                    html_id="MSlide-aEn"
                />
            </div>

            <!-- Order Selector (Conditional) -->
            @if (count($this->orders()) > 0)
                <div class="row">
                    <x-default.form.selector
                        htmlId="MsSlideOr"
                        model="{{$form}}.order"
                        :label="__('forms.slide.order')"
                        :data="$orderOptions"
                        :showError="true"
                        type="filter"
                    />
                </div>
            @endif

            <!-- Content Editors Section -->
            <div class="column">
                <!-- French Content -->
                <p>@lang('forms.slide.content_fr') :</p>
                <livewire:default.tiny-mce-text-area
                    htmlId="MaSlidefr"
                    contentUpdatedEvent="set-content-fr"
                    wire:key="MaSlideFr"
                    :content="$contentFr"
                />

                <!-- Arabic Content -->
                <p>@lang('forms.slide.content_ar') :</p>
                <livewire:default.tiny-mce-text-area
                    htmlId="MaSlideAr"
                    contentUpdatedEvent="set-content-ar"
                    wire:key="MaSlideAr"
                    :content="$contentAr"
                />

                <!-- English Content -->
                <p>@lang('forms.slide.content_en') :</p>
                <livewire:default.tiny-mce-text-area
                    htmlId="MaSlideEn"
                    contentUpdatedEvent="set-content-en"
                    wire:key="MaSlideEn"
                    :content="$contentEn"
                />
            </div>

            <!-- File Upload Section -->
            <div class="column center"
                x-data="{ uploading: false, progress: 0 }"
                x-on:livewire-upload-start="uploading = true"
                x-on:livewire-upload-finish="uploading = false"
                x-on:livewire-upload-cancel="uploading = false"
                x-on:livewire-upload-error="uploading = false"
                x-on:livewire-upload-progress="progress = $event.detail.progress"
            >
                <x-default.form.upload-input
                    model="{{ $form }}.image"
                    :label="__('forms.slide.image')"
                    types="img"
                />

                <!-- Upload Progress -->
                <div x-show="uploading">
                    <progress max="100" x-bind:value="progress"></progress>
                </div>
            </div>

            <!-- Preview Image -->
            @if ($temporaryImageUrl)
                <div class="imgs__container">
                    <div class="imgs">
                        <img
                            class="img"
                            src="{{ $temporaryImageUrl }}"
                            alt="{{ __('modals.slide.images') }}"
                        >
                    </div>
                </div>
            @endif

            <!-- Form Actions -->
            <div class="form__actions">
                <div wire:loading wire:target="handleSubmit">
                    <x-default.loading />
                </div>
                <button type="submit" class="button button--primary">
                    @lang('forms.common.actions.submit')
                </button>
            </div>
        </form>
    </div>
</div>
