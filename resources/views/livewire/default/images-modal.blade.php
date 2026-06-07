<div class="modal__body">
    <!-- Form Section -->
    <form class="table__form">
        <!-- Form Inputs Container -->
        <div class="table__form__inputs__container">
            <div class="table__form__inputs">


                <!-- Image name -->
                <x-default.form.input
                    model="{{ $form }}.display_name"
                    :label="__('forms.image.display_name')"
                    type="text"
                    html_id="IM-NM"
                />

                <!-- Use case -->
                <x-default.form.input
                    model="{{ $form }}.use_case"
                    :label="__('forms.image.use_case')"
                    type="text"
                    html_id="IM-UC"
                />

                <!-- Upload -->
                <div class="column center"
                    x-data="{ uploading: false, progress: 0 }"
                    x-on:livewire-upload-start="uploading = true"
                    x-on:livewire-upload-finish="uploading = false"
                    x-on:livewire-upload-cancel="uploading = false"
                    x-on:livewire-upload-error="uploading = false"
                    x-on:livewire-upload-progress="progress = $event.detail.progress">

                    <x-default.form.upload-input
                        model="{{ $form }}.real_image"
                        :label="__('forms.image.real_image')"
                        types="img"
                    />

                    <div x-show="uploading" class="progress__bar">
                        <progress max="100" x-bind:value="progress"></progress>
                    </div>
                </div>

                <!-- Temporary preview -->
                @if ($temporaryImageUrl)
                    <div class="imgs__container">
                        <div class="imgs">
                            <img
                                class="img"
                                src="{{ $temporaryImageUrl }}"
                                alt="{{ __('forms.image.preview') }}"
                            />
                        </div>
                    </div>
                @endif

            </div>
        </div>

        <!-- Form Buttons Container -->
        <div class="table__form__buttons__container">
            <div class="table__form__buttons">
                <!-- Submit -->
                <button type="submit" class="button button--primary rounded hasTooltip" wire:click.prevent="handleSubmit">
                    @if($form === "addForm")
                        <span id="submitBtnImage" class="toolTip" role="tooltip" aria-label="@lang('toolTips.common.add')">
                            @lang('toolTips.common.add')
                        </span>
                        <i class="fa-solid fa-plus"></i>
                    @else
                        <span id="submitBtnImage" class="toolTip" role="tooltip" aria-label="@lang('toolTips.common.update')">
                            @lang('toolTips.common.update')
                        </span>
                        <i class="fa-solid fa-pen-nib"></i>
                    @endif
                </button>

                <!-- Reset -->
                <button wire:click.prevent="resetForm" class="button rounded hasTooltip">
                    <span id="resetImageForm" class="toolTip" role="tooltip" aria-label="@lang('toolTips.common.reset')">
                        @lang('toolTips.common.resetForm')
                    </span>
                    <i class="fa-solid fa-arrows-rotate"></i>
                </button>
            </div>

            <!-- Loading -->
            <div class="table__form__buttons__loading">
                <div wire:loading wire:target="handleSubmit">
                    <x-default.loading />
                </div>
            </div>
        </div>
    </form>

    <!-- Table Section -->
    <div class="table__container" x-on:update-images-table.window="$wire.$refresh()">
        <div class="table__header">
            <h3>@lang('tables.images.info')</h3>
        </div>

        @if(isset($this->images) && $this->images->isNotEmpty())
            <div class="table__body">
                <table>
                    <thead>
                        <tr>
                            <th></th>
                            <th scope="column">@lang('tables.common.actions')</th>
                            <x-default.table.sortable-th wire:key="IMG-TH-1" model="display_name" :label="__('tables.images.display_name')" :$sortDirection :$sortBy />
                            <x-default.table.sortable-th wire:key="IMG-TH-2" model="use_case" :label="__('tables.images.use_case')" :$sortDirection :$sortBy />
                            <x-default.table.sortable-th wire:key="IMG-TH-3" model="created_at" :label="__('tables.images.created_at')" :$sortDirection :$sortBy />
                            <th scope="column">@lang('tables.images.preview')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($this->images as $img)
                            <tr wire:key="img-{{ $img->id }}" scope="row">
                                <!-- Delete -->


                                <!-- Select for edit -->
                                <td>
                                    <x-default.form.radio-button
                                        model="selectedChoice"
                                        htmlId="img-id{{ $img->id }}"
                                        value="{{ $img->id }}"
                                        type="forTable"
                                        wire:key="img-key{{ $img->id }}"
                                    />
                                </td>
                                 <td>
                                    <x-default.action-btn
                                        :tooltip="__('toolTips.image.delete')"
                                        icon="trash"
                                        function="openDeleteImageDialog"
                                        :parameters="[$img]"
                                    />
                                </td>
                                <td>{{ $img->display_name }}</td>
                                <td>{{ $img->use_case }}</td>
                                <td>{{ $img->created_at->format('Y-m-d') }}</td>
                                <td>
                                    @if($img->url)
                                        <img src="{{ $img->url }}" alt="{{ $img->name }}" class="table__img__preview">
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="table__footer">
                <h2>@lang('tables.images.not_found')</h2>
            </div>
        @endif
    </div>
</div>
