<div class="table__container"
     x-on:update-sliders-table.window="$wire.$refresh()">

    <div class="table__header">
        <h3>@lang('tables.sliders.info')</h3>
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

    <div class="table__filters" wire:ignore.self>
        <x-default.form.input
            model="creator"
            :label="__('tables.sliders.creator')"
            type="text"
            html_id="TSlid-creator"
            role="filter" />

        <x-default.form.input
            model="name"
            :label="__('tables.sliders.name')"
            type="text"
            html_id="TSlid-name"
            role="filter" />

        <x-default.form.selector
            htmlId="Slid-type"
            model="sliderableType"
            :label="__('tables.sliders.sliderable_type')"
            :data="$sliderTypesOptions"
            type="filter" />

        <x-default.form.selector
            htmlId="Slid-id"
            model="sliderableId"
            :label="__('tables.sliders.sliderable_id')"
            :data="$sliderableIdsOptions"
            type="filter" />

        <button class="button button--primary rounded table__filters__btn--reset hasTooltip"
                wire:click="resetFilters">
            <span id="trashToolTip3" class="toolTip" role="tooltip" aria-label="resest Filters">
                @lang("toolTips.common.resetFilters")
            </span>
            <i class="fa-solid fa-arrows-rotate"></i>
        </button>
    </div>

    @if(isset($this->sliders) && count($this->sliders))
        <div class="table__body">
            <table>
                <thead>
                    <tr>
                        <th scope="column">
                            <div>@lang('tables.common.actions')</div>
                        </th>
                        <x-default.table.sortable-th
                            wire:key="slid-TH-1"
                            model="name"
                            :label="__('tables.sliders.name')"
                            :$sortDirection
                            :$sortBy />

                        <x-default.table.sortable-th
                            wire:key="slid-TH-2"
                            model="creator"
                            :label="__('tables.sliders.creator')"
                            :$sortDirection
                            :$sortBy />

                        <x-default.table.sortable-th
                            wire:key="slid-TH-3"
                            model="location"
                            :label="__('tables.sliders.location')"
                            :$sortDirection
                            :$sortBy />

                        <x-default.table.sortable-th
                            wire:key="slid-TH-4"
                            model="state"
                            :label="__('tables.sliders.state')"
                            :$sortDirection
                            :$sortBy />

                        <x-default.table.sortable-th
                            wire:key="arT-TH-5"
                            model="created_at"
                            :label="__('tables.sliders.created_at')"
                            :$sortDirection
                            :$sortBy />

                    </tr>
                </thead>

                <tbody>
                    @foreach ($this->sliders as $slider)
                        <tr wire:key="{{ $slider->id }}-gt">
                            <td>
                                <x-default.action-btn
                                    :tooltip="__('toolTips.slider.delete')"
                                    icon="trash"
                                    function="openDeleteDialog"
                                    :parameters="[$slider]" />

                                <livewire:default.open-modal-button
                                    wire:key="slider-m-{{ $slider->id }}"
                                    classes="rounded"
                                    content="<i class='fa-solid fa-pen-to-square'></i>"
                                    :toolTipMessage="__('toolTips.slider.update')"
                                    modalTitle="modals.slider.actions.update"
                                    :modalContent="[
                                        'name' => 'default.admin.slider-modal',
                                        'parameters' => ['id' => $slider->id]
                                    ]" />

                                <x-default.table.link
                                    :toolTipMessage="__('toolTips.slider.manage')"
                                    route="slider_route"
                                    :parameters='["id" => $slider->id, "name" => $slider->name]'
                                    icon="view" />
                            </td>
                            <td scope="row">{{ $slider->name }}</td>
                            <td>{{ $slider->creator }}</td>
                            <td>{{ $slider->location }}</td>
                            <td>
                                <livewire:default.table-selector
                                    wire:key="slid-P-{{ $slider->id }}"
                                    :data="$stateOptions"
                                    :selectedValue="$slider->state"
                                    :entity="$slider"
                                    lazy />
                            </td>
                            <td>{{ $slider->created_at->format('Y-m-d') }}</td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{ $this->sliders->links('components.default.pagination') }}
    @else
        <div class="table__footer">
            <h2>@lang('tables.sliders.not_found')</h2>
        </div>
    @endif
</div>
