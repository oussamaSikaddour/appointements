<div class="table__container"
     x-on:update-trends-table.window="$wire.$refresh()">

    <div class="table__header">
        <h3>@lang('tables.trends.info')</h3>
        <div class="table__actions">
            <button class="button rounded table__filters__btn hasTooltip" id="filter">
                <span id="TT-Mf"
                      class="toolTip"
                      role="tooltip"
                      aria-label="manage Filters"
                      aria-haspopup="true"
                      aria-expanded="false"
                      aria-controls="tableFilters">
                    @lang("toolTips.common.filters")
                </span>
                <i class="fa-solid fa-filter"></i>
            </button>

            <x-default.form.selector
                htmlId="TU-upp"
                model="perPage"
                :label="__('tables.common.perPage')"
                :data="$perPageOptions"
                type="filter" />
        </div>
    </div>

    <div class="table__filters" wire:ignore>
        <x-default.form.input
            model="title"
            :label="__('tables.trends.title')"
            type="text"
            html_id="TTs-tit"
            role="filter" />

        <x-default.form.selector
            htmlId="TTs-state"
            model="state"
            :label="__('tables.trends.state')"
            :data="$stateOptions"
            type="filter" />

        <button class="button button--primary rounded table__filters__btn--reset hasTooltip"
                wire:click="resetFilters">
            <span id="trashToolTip3" class="toolTip" role="tooltip" aria-label="resest Filters">
                @lang("toolTips.common.resetFilters")
            </span>
            <i class="fa-solid fa-arrows-rotate"></i>
        </button>
    </div>

    @if(isset($this->trends) && $this->trends->isNotEmpty())
        <div class="table__body">
            <table>
                <thead>
                    <tr>
                        <th scope="column">
                            <div>@lang('tables.common.actions')</div>
                        </th>
                        <x-default.table.sortable-th
                            wire:key="mtt-TH-1"
                            model="title"
                            :label="__('tables.trends.title')"
                            :$sortDirection
                            :$sortBy
                            :appLocal=true />

                        <x-default.table.sortable-th
                            wire:key="mtt-TH-2"
                            model="state"
                            :label="__('tables.trends.state')"
                            :$sortDirection
                            :$sortBy />

                        <x-default.table.sortable-th
                            wire:key="mtt-TH-4"
                            model="created_at"
                            :label="__('tables.trends.created_at')"
                            :$sortDirection
                            :$sortBy />


                    </tr>
                </thead>

                <tbody>
                    @foreach ($this->trends as $trend)
                        <tr wire:key="{{ $trend->id }}-gt">
                                  <td>
                                <x-default.action-btn
                                    :tooltip="__('toolTips.trend.delete')"
                                    icon="trash"
                                    function="openDeleteDialog"
                                    :parameters="[$trend]" />

                                <livewire:default.open-modal-button
                                    wire:key="trend-m-{{ $trend->id }}"
                                    classes="rounded"
                                    content="<i class='fa-solid fa-pen-to-square'></i>"
                                    :toolTipMessage="__('toolTips.trend.update')"
                                    modalTitle="modals.trend.actions.update"
                                    :modalContent="[
                                        'name' => 'default.author.trend-modal',
                                        'parameters' => ['id' => $trend->id]
                                    ]" />
                            </td>
                            <td scope="row">{{ $trend->localized_title }}</td>
                            <td>
                                <livewire:default.table-selector
                                    wire:key="st-P-{{ $trend->id }}"
                                    :data="$stateOptions"
                                    :selectedValue="$trend->state"
                                    :entity="$trend"
                                    lazy />
                            </td>
                            <td>{{ $trend->created_at->format('Y-m-d') }}</td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{ $this->trends->links('components.default.pagination') }}
    @else
        <div class="table__footer">
            <h2>@lang('tables.trends.not_found')</h2>
        </div>
    @endif
</div>
