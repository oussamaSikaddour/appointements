<div class="modal__body">
    <!-- Form Section -->
    <form class="table__form">
        <!-- Form Inputs Container -->
        <div class="table__form__inputs__container">
            <div class="table__form__inputs">

                <!-- File name -->
                <x-default.form.input
                    model="{{ $form }}.display_name"
                    :label="__('forms.file.display_name')"
                    type="text"
                    html_id="FL-NM"
                />

                <!-- Use case -->
                <x-default.form.input
                    model="{{ $form }}.use_case"
                    :label="__('forms.file.use_case')"
                    type="text"
                    html_id="FL-UC"
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
                        model="{{ $form }}.real_file"
                        :label="__('forms.file.real_file')"
                        types="pdf"
                    />

                    <div x-show="uploading" class="progress__bar">
                        <progress max="100" x-bind:value="progress"></progress>
                    </div>
                </div>

                <!-- Temporary uploaded file name -->
                @if ($temporaryFileName)
                    <div class="files__container">
                        <div class="files">
                            <div class="file__preview">
                                <i class="fa-solid fa-file"></i>
                                <span>{{ $temporaryFileName }}</span>
                            </div>
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
                        <span id="submitBtnFile" class="toolTip" role="tooltip" aria-label="@lang('toolTips.common.add')">
                            @lang('toolTips.common.add')
                        </span>
                        <i class="fa-solid fa-plus"></i>
                    @else
                        <span id="submitBtnFile" class="toolTip" role="tooltip" aria-label="@lang('toolTips.common.update')">
                            @lang('toolTips.common.update')
                        </span>
                        <i class="fa-solid fa-pen-nib"></i>
                    @endif
                </button>

                <!-- Reset -->
                <button wire:click.prevent="resetForm" class="button rounded hasTooltip">
                    <span id="resetFileForm" class="toolTip" role="tooltip" aria-label="@lang('toolTips.common.reset')">
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
    <div class="table__container" x-on:update-files-table.window="$wire.$refresh()">
        <div class="table__header">
            <h3>@lang('tables.files.info')</h3>
        </div>

        @if(isset($this->files) && $this->files->isNotEmpty())
            <div class="table__body">
                <table>
                    <thead>
                        <tr>
                            <th></th>
                            <th scope="column">@lang('tables.common.actions')</th>
                            <x-default.table.sortable-th wire:key="FL-TH-1" model="display_name" :label="__('tables.files.display_name')" :$sortDirection :$sortBy />
                            <x-default.table.sortable-th wire:key="FL-TH-2" model="use_case" :label="__('tables.files.use_case')" :$sortDirection :$sortBy />
                            <x-default.table.sortable-th wire:key="FL-TH-3" model="created_at" :label="__('tables.files.created_at')" :$sortDirection :$sortBy />
                            <th scope="column">@lang('tables.files.preview')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($this->files as $file)
                            <tr wire:key="file-{{ $file->id }}" scope="row">
                                <!-- Select for edit -->
                                <td>
                                    <x-default.form.radio-button
                                        model="selectedChoice"
                                        htmlId="file-id{{ $file->id }}"
                                        value="{{ $file->id }}"
                                        type="forTable"
                                        wire:key="file-key{{ $file->id }}"
                                    />
                                </td>

                                <!-- Delete -->
                                <td>
                                    <x-default.action-btn
                                        :tooltip="__('toolTips.file.delete')"
                                        icon="trash"
                                        function="openDeleteFileDialog"
                                        :parameters="[$file]"
                                    />
                                </td>

                                <!-- File data -->
                                <td>{{ $file->display_name }}</td>
                                <td>{{ $file->use_case }}</td>
                                <td>{{ $file->created_at->format('Y-m-d') }}</td>

                                <!-- Preview (link) -->
                                <td>
                                    @if($file->url)
                                        <a href="{{ $file->url }}" target="_blank" class="button button--primary">
                                            <i class="fa-solid fa-download"></i>
                                            @lang('tables.files.download')
                                        </a>
                                    @else
                                        <span class="text-muted">@lang('tables.files.no_file')</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="table__footer">
                <h2>@lang('tables.files.not_found')</h2>
            </div>
        @endif
    </div>
</div>
