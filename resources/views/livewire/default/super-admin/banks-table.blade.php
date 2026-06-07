<div class="table__container"
     x-on:update-banks-table.window="$wire.$refresh()">
    <div class="table__header">
        <h3>@lang('tables.banks.info')</h3>
        <div class="table__actions">
            <button class="button rounded table__filters__btn hasTooltip" id="filter">
                <span
                    id="TT-Mf"
                    class="toolTip"
                    role="tooltip"
                    aria-label="manage Filters"
                    aria-haspopup="true"
                    aria-expanded="false"
                    aria-controls="tableFilters"
                >
                    @lang("toolTips.common.filters")
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
            model="acronym"
            :label="__('tables.banks.acronym')"
            type="text"
            html_id="bAcro"
            role="filter"
        />
        <x-default.form.input
            model="code"
            :label="__('tables.banks.code')"
            type="text"
            html_id="bCode"
            role="filter"
        />
        <x-default.form.input
            model="designation"
            :label="__('tables.banks.designation')"
            type="text"
            html_id="bDesignation"
            role="filter"
        />
        <button
            class="button button--primary rounded table__filters__btn--reset hasTooltip"
            wire:click="resetFilters"
        >
            <span
                id="trashToolTip3"
                class="toolTip"
                role="tooltip"
                aria-label="reset Filters"
            >
                @lang("toolTips.common.resetFilters")
            </span>
            <i class="fa-solid fa-arrows-rotate"></i>
        </button>
    </div>

    @if(isset($this->banks) && $this->banks->isNotEmpty())
        <div class="table__body">
            <table>
                <thead>
                    <tr>
                         <th scope="column">
                            <div>@lang('tables.common.actions')</div>
                        </th>
                        <x-default.table.sortable-th
                            wire:key="bT-TH-1"
                            model="acronym"
                            :label="__('tables.banks.acronym')"
                            :$sortDirection :$sortBy
                        />
                        <x-default.table.sortable-th
                            wire:key="bT-TH-2"
                            model="code"
                            :label="__('tables.banks.code')"
                            :$sortDirection :$sortBy
                        />
                        <x-default.table.sortable-th
                            wire:key="bT-TH-3"
                            model="designation_fr"
                            :label="__('tables.banks.designation_fr')"
                            :$sortDirection :$sortBy
                        />
                        <x-default.table.sortable-th
                            wire:key="bT-TH-4"
                            model="designation_ar"
                            :label="__('tables.banks.designation_ar')"
                            :$sortDirection :$sortBy
                        />
                        <x-default.table.sortable-th
                            wire:key="bT-TH-5"
                            model="designation_en"
                            :label="__('tables.banks.designation_en')"
                            :$sortDirection :$sortBy
                        />
                        <x-default.table.sortable-th
                            wire:key="bt-TH-6"
                            model="created_at"
                            :label="__('tables.banks.created_at')"
                            :$sortDirection :$sortBy
                        />

                    </tr>
                </thead>
                <tbody>
                    @foreach ($this->banks as $bank)
                        <tr wire:key="{{ $bank->id }}-pr">
                            <td>
                                <x-default.action-btn
                                    :tooltip="__('toolTips.bank.delete')"
                                    icon="trash"
                                    function="openDeleteDialog"
                                    :parameters="[$bank]"
                                />
                                <livewire:default.open-modal-button
                                    wire:key="pr-m-{{ $bank->id }}"
                                    classes="rounded"
                                    content="<i class='fa-solid fa-pen-to-square'></i>"
                                    :toolTipMessage="__('toolTips.bank.update')"
                                    modalTitle="modals.bank.actions.update"
                                    :modalContent="[
                                        'name' => 'default.super-admin.bank-modal',
                                        'parameters' => ['id' => $bank->id]
                                    ]"
                                />
                            </td>
                            <td scope="row">{{ $bank->acronym }}</td>
                            <td>{{ $bank->code }}</td>
                            <td>{{ $bank->designation_fr }}</td>
                            <td>{{ $bank->designation_ar }}</td>
                            <td>{{ $bank->designation_en }}</td>
                            <td>{{ $bank->created_at->format('Y-m-d') }}</td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $this->banks->links('components.default.pagination') }}
    @else
        <div class="table__footer">
            <h2>@lang('tables.banks.not_found')</h2>
        </div>
    @endif
</div>
