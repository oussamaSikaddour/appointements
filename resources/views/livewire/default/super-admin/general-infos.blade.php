<div class="form__container">
    <form class="form" wire:submit.prevent="handleSubmit">
        <div class="row center">
            <x-default.form.input
                model="form.email"
                :label="__('forms.general_infos.email')"
                type="email"
                html_id="FL-e"
            />
            <x-default.form.input
                model="form.phone"
                :label="__('forms.general_infos.phone')"
                type="text"
                html_id="FL-phone"
            />
        </div>

        <div class="row center">
            <x-default.form.input
                model="form.landline"
                :label="__('forms.general_infos.landline')"
                type="text"
                html_id="FL-ll"
            />
            <x-default.form.input
                model="form.fax"
                :label="__('forms.general_infos.fax')"
                type="text"
                html_id="FL-f"
            />
        </div>

        <div class="column center">
            <x-default.form.textarea
                model="form.map"
                :label="__('forms.general_infos.map')"
                html_id="FL-m"
            />
        </div>

        <div
            class="column center"
            x-data="{ uploading: false, progress: 0 }"
            x-on:livewire-upload-start="uploading = true"
            x-on:livewire-upload-finish="uploading = false"
            x-on:livewire-upload-cancel="uploading = false"
            x-on:livewire-upload-error="uploading = false"
            x-on:livewire-upload-progress="progress = $event.detail.progress"
        >
            <x-default.form.upload-input
                model="form.logo"
                :label="__('forms.general_infos.logo')"
            />

            <div x-show="uploading" class="upload__progress">
                <progress max="100" x-bind:value="progress"></progress>
            </div>
        </div>

        @if ($temporaryImageUrl !== "")
            <div class="imgs__container">
                <div class="imgs">
                    <img
                        class="img"
                        src="{{ $temporaryImageUrl }}"
                        alt="{{ __('forms.general_infos.logo') }}"
                    />
                </div>
            </div>
        @endif

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
