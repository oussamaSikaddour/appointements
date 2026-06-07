<div class="table__container" x-on:update-dairates-table.window="$wire.$refresh()">
    <div class="table__header">
        <h3>@lang('tables.dairates.info', ['code' => $wilayaCode])</h3>
        <div class="table__actions">
            <div wire:loading wire:target="excelFile">
                <x-default.loading />
            </div>

            <x-default.form.upload-input-with-tooltip
                :tooltip="__('toolTips.daira.manage.dairates')"
                icon="upload"
                model="excelFile"
                types="excel"
                wire:loading.attr="disabled"
            />

            <button class="button rounded hasTooltip" wire:click="generateEmptydairatesExcel()">
                <span class="toolTip" aria-label="{{ __('toolTips.daira.excel.empty') }}">
                    @lang('toolTips.daira.excel.empty')
                </span>
                <i class="fa-solid fa-file-export"></i>
            </button>

            <button class="button button--primary rounded hasTooltip" wire:click="generatedairatesExcel()">
                <span class="toolTip" aria-label="{{ __('toolTips.daira.excel.download') }}">
                    @lang('toolTips.daira.excel.download')
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
            :label="__('tables.dairates.designation')"
            type="text"
            html_id="FTDesignation"
            role="filter"
        />
        <x-default.form.input
            model="code"
            :label="__('tables.dairates.code')"
            type="text"
            html_id="FTCode"
            role="filter"
        />

        <button class="button button--primary rounded table__filters__btn--reset hasTooltip" wire:click="resetFilters">
            <span class="toolTip" aria-label="@lang('toolTips.common.resetFilters')">
                @lang('toolTips.common.resetFilters')
            </span>
            <i class="fa-solid fa-arrows-rotate"></i>
        </button>
    </div>

    @if(isset($this->dairates) && $this->dairates->isNotEmpty())
        <div class="table__body">
            <table>
                <thead>
                    <tr>
                         <th><div>@lang('tables.common.actions')</div></th>
                        <x-default.table.sortable-th wire:key="DT-Th-1" model="code" :label="__('tables.dairates.code')" :$sortDirection :$sortBy />
                        <x-default.table.sortable-th wire:key="DT-Th-2" model="designation_fr" :label="__('tables.dairates.designation_fr')" :$sortDirection :$sortBy />
                        <x-default.table.sortable-th wire:key="DT-Th-3" model="designation_en" :label="__('tables.dairates.designation_en')" :$sortDirection :$sortBy />
                        <x-default.table.sortable-th wire:key="DT-Th-4" model="designation_ar" :label="__('tables.dairates.designation_ar')" :$sortDirection :$sortBy />
                        <x-default.table.sortable-th wire:key="DT-Th-5" model="created_at" :label="__('tables.dairates.registration_date')" :$sortDirection :$sortBy />

                    </tr>
                </thead>
                <tbody>
                    @foreach ($this->dairates as $daira)
                        <tr wire:key="daira-{{ $daira->id }}">
                            <td>
                                <x-default.action-btn
                                    :tooltip="__('toolTips.daira.delete')"
                                    icon="trash"
                                    function="openDeleteDialog"
                                    :parameters="[$daira]"
                                />

                                <livewire:default.open-modal-button
                                    wire:key="edit-daira-{{ $daira->id }}"
                                    classes="rounded"
                                    content="<i class='fa-solid fa-pen-to-square'></i>"
                                    :toolTipMessage="__('toolTips.daira.update')"
                                    modalTitle="modals.daira.actions.update"
                                    :modalTitleOptions="['code' => $daira->code]"
                                    :modalContent="['name' => 'default.super-admin.daira-modal', 'parameters' => ['id' => $daira->id]]"
                                />

                                <livewire:default.open-modal-button
                                    wire:key="manage-communes-{{ $daira->id }}"
                                    classes="rounded"
                                    content="<i class='fa-solid fa-landmark'></i>"
                                    :toolTipMessage="__('toolTips.daira.manage.communes')"
                                    modalTitle="modals.daira.actions.manage.communes"
                                    :modalTitleOptions="['code' => $daira->code]"
                                    :modalContent="['name' => 'default.super-admin.commune-modal', 'parameters' => ['daira' => $daira]]"
                                />
                            </td>
                            <td>{{ $daira->code }}</td>
                            <td>{{ $daira->designation_fr }}</td>
                            <td>{{ $daira->designation_en }}</td>
                            <td>{{ $daira->designation_ar }}</td>
                            <td>{{ $daira->created_at->format('Y-m-d') }}</td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $this->dairates->links('components.default.pagination') }}
    @else
        <div class="table__footer">
            <h2>@lang('tables.dairates.not_found')</h2>
        </div>
    @endif
</div>
