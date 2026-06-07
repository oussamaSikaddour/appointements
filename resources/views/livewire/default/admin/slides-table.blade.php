<div class="table__container"
     x-on:update-slides-table.window="$wire.$refresh()">

    <div class="table__header">
        <h3>@lang('tables.slides.info')</h3>
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
            model="title"
            :label="__('tables.slides.title')"
            type="text"
            html_id="TSlid-title"
            role="filter" />

        <button class="button button--primary rounded table__filters__btn--reset hasTooltip"
                wire:click="resetFilters">
            <span id="trashToolTip3" class="toolTip" role="tooltip" aria-label="resest Filters">
                @lang("toolTips.common.resetFilters")
            </span>
            <i class="fa-solid fa-arrows-rotate"></i>
        </button>
    </div>

    @if(isset($this->slides) && count($this->slides))
        <div class="table__body">
            <table>
                <thead>
                    <tr scope="column">
                        <th><div>@lang('tables.common.actions')</div></th>
                        <x-default.table.sortable-th
                            wire:key="slid-TH-1"
                            model="title"
                            :label="__('tables.slides.title')"
                            :$sortDirection
                            :$sortBy
                            :appLocal=true />

                        <x-default.table.sortable-th
                            wire:key="slid-TH-2"
                            model="order"
                            :label="__('tables.slides.order')"
                            :$sortDirection
                            :$sortBy />

                        <x-default.table.sortable-th
                            wire:key="arT-TH-3"
                            model="created_at"
                            :label="__('tables.slides.created_at')"
                            :$sortDirection
                            :$sortBy />

                        <th><div>@lang('tables.slides.image')</div></th>

                    </tr>
                </thead>

                <tbody>
                    @foreach ($this->slides as $slide)
                        <tr wire:key="{{ $slide->id }}-gt">
                               <td>
                                <x-default.action-btn
                                    :tooltip="__('toolTips.slide.delete')"
                                    icon="trash"
                                    function="openDeleteDialog"
                                    :parameters="[$slide]" />

                                <livewire:default.open-modal-button
                                    wire:key="slide-m-{{ $slide->id }}"
                                    classes="rounded"
                                    content="<i class='fa-solid fa-pen-to-square'></i>"
                                    :toolTipMessage="__('toolTips.slide.update')"
                                    modalTitle="modals.slide.actions.update"
                                    :modalContent="[
                                        'name' => 'default.admin.slide-modal',
                                        'parameters' => [
                                            'id' => $slide->id,
                                            'sliderId' => $slide->slider_id
                                        ]
                                    ]" />
                            </td>
                            <td scope="row">{{ $slide->localized_title }}</td>
                            <td>{{ $slide->order }}</td>
                            <td>{{ $slide->created_at->format('Y-m-d') }}</td>
                            <td>
                                <img class="img" src="{{ $slide->image->url }}" alt="{{ $slide->image->use_case }}">
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{ $this->slides->links('components.default.pagination') }}
    @else
        <div class="table__footer">
            <h2>@lang('tables.slides.not_found')</h2>
        </div>
    @endif
</div>
