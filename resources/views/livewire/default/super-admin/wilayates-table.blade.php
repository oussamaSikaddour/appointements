<div class="table__container" x-on:update-wilayates-table.window="$wire.$refresh()">
    <div class="table__header">
        <h3>@lang('tables.wilayates.info')</h3>
        <div class="table__actions">
            <div wire:loading wire:target="excelFile">
                <x-default.loading />
            </div>

            <x-default.form.upload-input-with-tooltip
                :tooltip="__('toolTips.wilaya.manage.wilayates')"
                icon="upload"
                model="excelFile"
                types="excel"
                wire:loading.attr="disabled"
            />

            <button class="button rounded hasTooltip" wire:click="generateEmptyWilayatesExcel()">
                <span
                    id="TT-ued"
                    class="toolTip"
                    role="tooltip"
                    aria-label="{{ __('toolTips.wilaya.excel.empty') }}"
                >
                    @lang('toolTips.wilaya.excel.empty')
                </span>
                <i class="fa-solid fa-file-export"></i>
            </button>

            <button class="button button--primary rounded hasTooltip" wire:click="generateWilayatesExcel()">
                <span
                    id="TT-ued"
                    class="toolTip"
                    role="tooltip"
                    aria-label="{{ __('toolTips.wilaya.excel.download') }}"
                >
                    @lang('toolTips.wilaya.excel.download')
                </span>
                <i class="fa-solid fa-file-export"></i>
            </button>

            <button class="button rounded table__filters__btn hasTooltip" id="filter">
                <span
                    id="TT-Mf"
                    class="toolTip"
                    role="tooltip"
                    aria-label="@lang('toolTips.common.filters')"
                    aria-haspopup="true"
                    aria-expanded="false"
                    aria-controls="tableFilters"
                >
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
            :label="__('tables.wilayates.designation')"
            type="text"
            html_id="FTDesignation"
            role="filter"
        />

        <x-default.form.input
            model="code"
            :label="__('tables.wilayates.code')"
            type="text"
            html_id="FTCode"
            role="filter"
        />

        <button
            class="button button--primary rounded table__filters__btn--reset hasToolTip"
            wire:click="resetFilters"
        >
            <span
                id="trashToolTip3"
                class="toolTip"
                role="tooltip"
                aria-label="@lang('toolTips.common.resetFilters')"
            >
                @lang('toolTips.common.resetFilters')
            </span>
            <i class="fa-solid fa-arrows-rotate"></i>
        </button>
    </div>

    @if (isset($this->wilayates) && $this->wilayates->isNotEmpty())
        <div class="table__body">
            <table>
                <thead>
                    <tr>
                        <th scope="column">
                            <div>@lang('tables.common.actions')</div>
                        </th>
                        <x-default.table.sortable-th
                            wire:key="WT-Th-1"
                            model="code"
                            :label="__('tables.wilayates.code')"
                            :$sortDirection :$sortBy
                        />
                        <x-default.table.sortable-th
                            wire:key="WT-Th-2"
                            model="designation_fr"
                            :label="__('tables.wilayates.designation_fr')"
                            :$sortDirection :$sortBy
                        />
                        <x-default.table.sortable-th
                            wire:key="WT-Th-3"
                            model="designation_en"
                            :label="__('tables.wilayates.designation_en')"
                            :$sortDirection :$sortBy
                        />
                        <x-default.table.sortable-th
                            wire:key="WT-Th-4"
                            model="designation_ar"
                            :label="__('tables.wilayates.designation_ar')"
                            :$sortDirection :$sortBy
                        />
                        <x-default.table.sortable-th
                            wire:key="WT-Th-5"
                            model="created_at"
                            :label="__('tables.wilayates.registration_date')"
                            :$sortDirection :$sortBy
                        />

                    </tr>
                </thead>
                <tbody>
                    @foreach ($this->wilayates as $wilaya)
                        <tr wire:key="{{ $wilaya->id }}" scope="row">
                            <td>
                                <x-default.action-btn
                                    :tooltip="__('toolTips.wilaya.delete')"
                                    icon="trash"
                                    function="openDeleteDialog"
                                    :parameters="[$wilaya]"
                                />

                                <livewire:default.open-modal-button
                                    wire:key="wu-m-{{ $wilaya->id }}"
                                    classes="rounded"
                                    content="<i class='fa-solid fa-pen-to-square'></i>"
                                    :toolTipMessage="__('toolTips.wilaya.update')"
                                    modalTitle="modals.wilaya.actions.update"
                                    :modalTitleOptions="['code' => $wilaya->code]"
                                    :modalContent="[
                                        'name' => 'default.super-admin.wilaya-modal',
                                        'parameters' => ['id' => $wilaya->id],
                                    ]"
                                />

                                <x-default.table.link
                                    :toolTipMessage="__('toolTips.wilaya.manage.view')"
                                    route="wilaya"
                                    :parameters="['id' => $wilaya->id, 'code' => $wilaya->code]"
                                    icon="view"
                                />
                            </td>
                            <td>{{ $wilaya->code }}</td>
                            <td>{{ $wilaya->designation_fr }}</td>
                            <td>{{ $wilaya->designation_en }}</td>
                            <td>{{ $wilaya->designation_ar }}</td>
                            <td>{{ $wilaya->created_at->format('Y-m-d') }}</td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $this->wilayates->links('components.default.pagination') }}
    @else
        <div class="table__footer">
            <h2>@lang('tables.wilayates.not_found')</h2>
        </div>
    @endif
</div>
