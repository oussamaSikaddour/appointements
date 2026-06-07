<div class="table__container"
     x-on:update-menus-table.window="$wire.$refresh()">

    <div class="table__header">
        <h3>@lang('tables.menus.info')</h3>
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
            :label="__('tables.menus.title')"
            type="text"
            html_id="TMt-tit"
            role="filter" />

        <x-default.form.selector
            htmlId="tmt-type"
            model="type"
            :label="__('tables.menus.type')"
            :data="$menuTypesOptions"
            type="filter" />

        <x-default.form.selector
            htmlId="tmt-state"
            model="state"
            :label="__('tables.menus.state')"
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

    @if(isset($this->menus) && $this->menus->isNotEmpty())
        <div class="table__body">
            <table>
                <thead>
                    <tr>
                        <th scope="column">
                            <div>@lang('tables.common.actions')</div>
                        </th>
                        <x-default.table.sortable-th
                            wire:key="mt-TH-1"
                            model="title"
                            :label="__('tables.menus.title')"
                            :$sortDirection
                            :$sortBy
                            :appLocal=true />

                        <x-default.table.sortable-th
                            wire:key="mt-TH-2"
                            model="state"
                            :label="__('tables.menus.state')"
                            :$sortDirection
                            :$sortBy />

                        <x-default.table.sortable-th
                            wire:key="mt-TH-3"
                            model="type"
                            :label="__('tables.menus.type')"
                            :$sortDirection
                            :$sortBy />

                        <x-default.table.sortable-th
                            wire:key="gtT-TH-4"
                            model="created_at"
                            :label="__('tables.menus.created_at')"
                            :$sortDirection
                            :$sortBy />


                    </tr>
                </thead>

                <tbody>
                    @foreach ($this->menus as $menu)
                        <tr wire:key="{{ $menu->id }}-gt">
                            <td>
                                <x-default.action-btn
                                    :tooltip="__('toolTips.menu.delete')"
                                    icon="trash"
                                    function="openDeleteDialog"
                                    :parameters="[$menu]" />

                                <livewire:default.open-modal-button
                                    wire:key="menu-m-{{ $menu->id }}"
                                    classes="rounded"
                                    content="<i class='fa-solid fa-pen-to-square'></i>"
                                    :toolTipMessage="__('toolTips.menu.update')"
                                    modalTitle="modals.menu.actions.update"
                                    :modalContent="[
                                        'name' => 'default.admin.menu-modal',
                                        'parameters' => ['id' => $menu->id]
                                    ]" />

                                <x-default.table.link
                                    :toolTipMessage="__('toolTips.menu.manage')"
                                    route="menu_route"
                                    :parameters='["id" => $menu->id, "title" => $menu->localized_title]'
                                    icon="view" />
                            </td>
                            <td scope="row">{{ $menu->localized_title }}</td>
                            <td>{{ config('constants')['MENU_TYPES'][$this->local][$menu->type] }}</td>
                            <td>
                                <livewire:default.table-selector
                                    wire:key="st-P-{{ $menu->id }}"
                                    :data="$stateOptions"
                                    :selectedValue="$menu->state"
                                    :entity="$menu"
                                    lazy />
                            </td>
                            <td>{{ $menu->created_at->format('Y-m-d') }}</td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{ $this->menus->links('components.default.pagination') }}
    @else
        <div class="table__footer">
            <h2>@lang('tables.menus.not_found')</h2>
        </div>
    @endif
</div>
