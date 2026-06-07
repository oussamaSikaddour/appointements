<div class="table__container"
     x-on:update-external-links-table.window="$wire.$refresh()">

    <div class="table__header">
        <h3>@lang('tables.external_links.info')</h3>
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
            model="name"
            :label="__('tables.external_links.name')"
            type="text"
            html_id="tExName"
            role="filter" />

        <x-default.form.input
            model="url"
            :label="__('tables.external_links.url')"
            type="text"
            html_id="tExUrl"
            role="filter" />

        <button class="button button--primary rounded table__filters__btn--reset hasTooltip"
                wire:click="resetFilters">
            <span id="trashToolTip3" class="toolTip" role="tooltip" aria-label="resest Filters">
                @lang("toolTips.common.resetFilters")
            </span>
            <i class="fa-solid fa-arrows-rotate"></i>
        </button>
    </div>

    @if(isset($this->externalLinks) && $this->externalLinks->isNotEmpty())
        <div class="table__body">
            <table>
                <thead>
                    <tr>
                        <th scope="column">
                            <div>@lang('tables.common.actions')</div>
                        </th>
                        <x-default.table.sortable-th
                            wire:key="textL-TH-1"
                            model="name"
                            :label="__('tables.external_links.name')"
                            :$sortDirection
                            :$sortBy
                            :appLocal=true />

                        <x-default.table.sortable-th
                            wire:key="textL-TH-2"
                            model="url"
                            :label="__('tables.external_links.url')"
                            :$sortDirection
                            :$sortBy />

                        <x-default.table.sortable-th
                            wire:key="textL-TH-3"
                            model="created_at"
                            :label="__('tables.external_links.created_at')"
                            :$sortDirection
                            :$sortBy />


                    </tr>
                </thead>

                <tbody>
                    @foreach ($this->externalLinks as $externalLink)
                        <tr wire:key="{{ $externalLink->id }}-extl">
                                <td>
                                <x-default.action-btn
                                    :tooltip="__('toolTips.external_link.delete')"
                                    icon="trash"
                                    function="openDeleteDialog"
                                    :parameters="[$externalLink]" />

                                <livewire:default.open-modal-button
                                    wire:key="service-m-{{ $externalLink->id }}"
                                    classes="rounded"
                                    content="<i class='fa-solid fa-pen-to-square'></i>"
                                    :toolTipMessage="__('toolTips.external_link.update')"
                                    modalTitle="modals.external_link.actions.update"
                                    :modalContent="[
                                        'name' => 'default.admin.external-link-modal',
                                        'parameters' => ['id' => $externalLink->id]
                                    ]" />
                            </td>
                            <td scope="row">{{ $externalLink->localized_name }}</td>
                            <td>{{ $externalLink->url }}</td>
                            <td>{{ $externalLink->created_at->format('Y-m-d') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{ $this->externalLinks->links('components.default.pagination') }}
    @else
        <div class="table__footer">
            <h2>@lang('tables.external_links.not_found')</h2>
        </div>
    @endif
</div>
