<div class="table__container" x-on:update-fields-table.window="$wire.$refresh()">
    <div class="table__header">
        <h3>@lang('tables.fields.info')</h3>
        <div class="table__actions">
            <div wire:loading wire:target="excelFile">
                <x-default.loading />
            </div>

            <x-default.form.upload-input-with-tooltip
                :tooltip="__('toolTips.field.manage.fields')"
                icon="upload"
                model="excelFile"
                types="excel"
                wire:loading.attr="disabled"
            />

            <button class="button rounded hasTooltip" wire:click="generateEmptyFieldsExcel()">
                <span class="toolTip" aria-label="{{ __('toolTips.field.excel.empty') }}">
                    @lang('toolTips.field.excel.empty')
                </span>
                <i class="fa-solid fa-file-export"></i>
            </button>

            <button class="button button--primary rounded hasTooltip" wire:click="generateFieldsExcel()">
                <span class="toolTip" aria-label="{{ __('toolTips.field.excel.download') }}">
                    @lang('toolTips.field.excel.download')
                </span>
                <i class="fa-solid fa-file-export"></i>
            </button>

            <button class="button rounded table__filters__btn hasTooltip" id="filter">
                <span class="toolTip" aria-label="@lang('toolTips.common.filters')" aria-haspopup="true" aria-expanded="false" aria-controls="tableFilters">
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
            :label="__('tables.fields.designation')"
            type="text"
            html_id="FTDesignation"
            role="filter"
        />
        <x-default.form.input
            model="acronym"
            :label="__('tables.fields.acronym')"
            type="text"
            html_id="FTAcronym"
            role="filter"
        />

        <button class="button button--primary rounded table__filters__btn--reset hasTooltip" wire:click="resetFilters">
            <span class="toolTip" aria-label="@lang('toolTips.common.resetFilters')">
                @lang('toolTips.common.resetFilters')
            </span>
            <i class="fa-solid fa-arrows-rotate"></i>
        </button>
    </div>

    @if(isset($this->fields) && $this->fields->isNotEmpty())
        <div class="table__body">
            <table>
                <thead>
                    <tr>
                         <th><div>@lang('tables.common.actions')</div></th>
                        <x-default.table.sortable-th wire:key="FT-Th-1" model="acronym" :label="__('tables.fields.acronym')" :$sortDirection :$sortBy />
                        <x-default.table.sortable-th wire:key="FT-Th-2" model="designation_fr" :label="__('tables.fields.designation_fr')" :$sortDirection :$sortBy />
                        <x-default.table.sortable-th wire:key="FT-Th-3" model="designation_en" :label="__('tables.fields.designation_en')" :$sortDirection :$sortBy />
                        <x-default.table.sortable-th wire:key="FT-Th-4" model="designation_ar" :label="__('tables.fields.designation_ar')" :$sortDirection :$sortBy />
                        <x-default.table.sortable-th wire:key="FT-Th-5" model="created_at" :label="__('tables.fields.registration_date')" :$sortDirection :$sortBy />

                    </tr>
                </thead>
                <tbody>
                    @foreach ($this->fields as $field)
                        <tr wire:key="field-{{ $field->id }}">
                            <td>
                                <x-default.action-btn
                                    :tooltip="__('toolTips.field.delete')"
                                    icon="trash"
                                    function="openDeleteDialog"
                                    :parameters="[$field]"
                                />

                                <livewire:default.open-modal-button
                                    wire:key="edit-field-{{ $field->id }}"
                                    classes="rounded"
                                    content="<i class='fa-solid fa-pen-to-square'></i>"
                                    :toolTipMessage="__('toolTips.field.update')"
                                    modalTitle="modals.field.actions.update"
                                    :modalTitleOptions="['acronym' => $field->acronym]"
                                    :modalContent="['name' => 'default.super-admin.field-modal', 'parameters' => ['id' => $field->id]]"
                                />

                                <livewire:default.open-modal-button
                                    wire:key="manage-grades-{{ $field->id }}"
                                    classes="rounded"
                                    content="<i class='fa-solid fa-award'></i>"
                                    :toolTipMessage="__('toolTips.field.manage.grades')"
                                    modalTitle="modals.field.actions.manage.grades"
                                    :modalTitleOptions="['acronym' => $field->acronym]"
                                    :modalContent="['name' => 'default.super-admin.field-grade-modal', 'parameters' => ['field' => $field]]"
                                />

                                <livewire:default.open-modal-button
                                    wire:key="manage-specialties-{{ $field->id }}"
                                    classes="rounded"
                                    content="<i class='fa-solid fa-hurricane'></i>"
                                    :toolTipMessage="__('toolTips.field.manage.specialties')"
                                    modalTitle="modals.field.actions.manage.specialties"
                                    :modalTitleOptions="['acronym' => $field->acronym]"
                                    :modalContent="['name' => 'default.super-admin.field-specialty-modal', 'parameters' => ['field' => $field]]"
                                />
                            </td>
                            <td>{{ $field->acronym }}</td>
                            <td>{{ $field->designation_fr }}</td>
                            <td>{{ $field->designation_en }}</td>
                            <td>{{ $field->designation_ar }}</td>
                            <td>{{ $field->created_at->format('Y-m-d') }}</td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $this->fields->links('components.default.pagination') }}
    @else
        <div class="table__footer">
            <h2>@lang('tables.fields.not_found')</h2>
        </div>
    @endif
</div>
