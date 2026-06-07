<div class="modal__body">
    <!-- Form Section -->
    <form class="table__form">
        <div class="table__form__inputs__container">
            <div class="table__form__inputs">
                <x-default.form.input model="{{ $form }}.designation_fr" :label="__('forms.commune.designation_fr')" type="text" html_id="MCM-bFR" />
                <x-default.form.input model="{{ $form }}.designation_ar" :label="__('forms.commune.designation_ar')" type="text" html_id="MCM-bAR" />
                <x-default.form.input model="{{ $form }}.designation_en" :label="__('forms.commune.designation_en')" type="text" html_id="MCM-bEN" />
                <x-default.form.input model="{{ $form }}.code" :label="__('forms.commune.code')" type="text" html_id="MCM-code" />
            </div>
        </div>

        <div class="table__form__buttons__container">
            <div class="table__form__buttons">
                <button type="submit" class="button button--primary rounded hasTooltip" wire:click.prevent="handleSubmit">
                    @if($form === "addForm")
                        <span id="submitBtnCommune" class="toolTip" aria-label="@lang('toolTips.common.add')">
                            @lang('toolTips.common.add')
                        </span>
                        <i class="fa-solid fa-plus"></i>
                    @else
                        <span id="submitBtnCommune" class="toolTip" aria-label="@lang('toolTips.common.update')">
                            @lang('toolTips.common.update')
                        </span>
                        <i class="fa-solid fa-pen-nib"></i>
                    @endif
                </button>
                <button wire:click.prevent="resetForm" class="button rounded hasTooltip">
                    <span id="resetCommuneForm" class="toolTip" aria-label="@lang('toolTips.common.reset')">
                        @lang('toolTips.common.resetForm')
                    </span>
                    <i class="fa-solid fa-arrows-rotate"></i>
                </button>
            </div>
            <div class="table__form__buttons__loading">
                <div wire:loading wire:target="handleSubmit">
                    <x-default.loading />
                </div>
            </div>
        </div>
    </form>

    <!-- Table Section -->
    <div class="table__container" x-on:update-communes-table.window="$wire.$refresh()">
        <div class="table__header">
            <h3>@lang('tables.communes.info', ['code' => $dairaCode])</h3>
            <div class="table__actions">
                <div wire:loading wire:target="excelFile">
                    <x-default.loading />
                </div>

                <x-default.form.upload-input-with-tooltip
                    :tooltip="__('toolTips.commune.excel.upload')"
                    icon="upload"
                    model="excelFile"
                    types="excel"
                    wire:loading.attr="disabled"
                />

                <button class="button rounded hasTooltip" wire:click="generateEmptyCommunesExcel()">
                    <span class="toolTip" aria-label="{{ __('toolTips.commune.excel.empty') }}">
                        @lang('toolTips.commune.excel.empty')
                    </span>
                    <i class="fa-solid fa-file-export"></i>
                </button>
                <button class="button button--primary rounded hasTooltip" wire:click="generateCommunesExcel()">
                    <span class="toolTip" aria-label="{{ __('toolTips.commune.excel.download') }}">
                        @lang('toolTips.commune.excel.download')
                    </span>
                    <i class="fa-solid fa-file-export"></i>
                </button>
                <button class="button rounded table__filters__btn hasTooltip" id="filter">
                    <span class="toolTip" aria-label="@lang('toolTips.common.filters')">
                        @lang('toolTips.common.filters')
                    </span>
                    <i class="fa-solid fa-filter"></i>
                </button>

                <x-default.form.selector
                    htmlId="TU-upp"
                    model="perPage"
                    :label="__('tables.common.perPage')"
                    :data="$perPageOptions"
                    type="filter"
                />
            </div>
        </div>

        <div class="table__filters" wire:ignore>
            <x-default.form.input
                model="designation"
                :label="__('tables.communes.designation')"
                type="text"
                html_id="CommuneDesignationFilter"
                role="filter"
            />
            <x-default.form.input
                model="code"
                :label="__('tables.communes.code')"
                type="text"
                html_id="CommuneCodeFilter"
                role="filter"
            />
            <button class="button button--primary rounded table__filters__btn--reset hasTooltip" wire:click="resetFilters">
                <span class="toolTip" aria-label="@lang('toolTips.common.resetFilters')">
                    @lang('toolTips.common.resetFilters')
                </span>
                <i class="fa-solid fa-arrows-rotate"></i>
            </button>
        </div>

        @if(isset($this->communes) && $this->communes->isNotEmpty())
            <div class="table__body">
                <table>
                    <thead>
                        <tr>
                            <th></th>
                           <th><div>@lang('tables.common.actions')</div></th>
                            <x-default.table.sortable-th model="code" :label="__('tables.communes.code')" :$sortDirection :$sortBy />
                            <x-default.table.sortable-th model="designation_fr" :label="__('tables.communes.designation_fr')" :$sortDirection :$sortBy />
                            <x-default.table.sortable-th model="designation_en" :label="__('tables.communes.designation_en')" :$sortDirection :$sortBy />
                            <x-default.table.sortable-th model="designation_ar" :label="__('tables.communes.designation_ar')" :$sortDirection :$sortBy />
                            <x-default.table.sortable-th model="created_at" :label="__('tables.communes.registration_date')" :$sortDirection :$sortBy />

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($this->communes as $commune)
                            <tr wire:key="{{ $commune->id }}">
                                <td>
                                    <x-default.form.radio-button
                                        model="selectedChoice"
                                        htmlId="communeM-id{{ $commune->id }}"
                                        value="{{ $commune->id }}"
                                        type="forTable"
                                    />
                                </td>
                                <td>
                                    <x-default.action-btn
                                        :tooltip="__('toolTips.commune.delete')"
                                        icon="trash"
                                        function="openDeleteDialog"
                                        :parameters="[$commune]"
                                    />
                                </td>
                                <td>{{ $commune->code }}</td>
                                <td>{{ $commune->designation_fr }}</td>
                                <td>{{ $commune->designation_en }}</td>
                                <td>{{ $commune->designation_ar }}</td>
                                <td>{{ $commune->created_at->format('Y-m-d') }}</td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $this->communes->links('components.default.pagination') }}
        @else
            <div class="table__footer">
                <h2>@lang('tables.communes.not_found')</h2>
            </div>
        @endif
    </div>
</div>
