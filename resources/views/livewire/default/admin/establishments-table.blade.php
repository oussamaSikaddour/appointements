<div class="table__container"
     x-on:update-establishments-table.window="$wire.$refresh()">

    <div class="table__header">
        <h3>@lang('tables.establishments.info')</h3>
        <div class="table__actions">
            <div wire:loading wire:target="excelFile">
                <x-default.loading />
            </div>

            <x-default.form.upload-input-with-tooltip
                :tooltip="__('toolTips.establishment.excel.upload')"
                icon="upload"
                model="excelFile"
                types="excel"
                wire:loading.attr="disabled" />

            <button class="button rounded hasTooltip" wire:click="generateEmptyEstablishmentsExcel()">
                <span id="TT-ued" class="toolTip" role="tooltip" aria-label="{{ __('toolTips.establishment.excel.empty') }}">
                    @lang("toolTips.establishment.excel.empty")
                </span>
                <i class="fa-solid fa-file-export"></i>
            </button>

            <button class="button button--primary rounded hasTooltip" wire:click="generateEstablishmentsExcel()">
                <span id="TT-ued" class="toolTip" role="tooltip" aria-label="{{ __('toolTips.establishment.excel.donwload') }}">
                    @lang("toolTips.establishment.excel.download")
                </span>
                <i class="fa-solid fa-file-export"></i>
            </button>

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
            model="acronym"
            :label="__('tables.establishments.acronym')"
            type="text"
            html_id="TEst-acronym"
            role="filter" />

        <x-default.form.input
            model="name"
            :label="__('tables.establishments.name')"
            type="text"
            html_id="TEst-name"
            role="filter" />

        <x-default.form.selector
            htmlId="Est-daira"
            model="daira"
            :label="__('tables.establishments.daira')"
            :data="$dairasOptions"
            type="filter" />

        <button class="button button--primary rounded table__filters__btn--reset hasTooltip"
                wire:click="resetFilters">
            <span id="trashToolTip3" class="toolTip" role="tooltip" aria-label="resest Filters">
                @lang("toolTips.common.resetFilters")
            </span>
            <i class="fa-solid fa-arrows-rotate"></i>
        </button>
    </div>

    @if(isset($this->establishments) && count($this->establishments))
        <div class="table__body">
            <table>
                <thead>
                    <tr>

                        <th scope="column">
                            <div>@lang('tables.common.actions')</div>
                        </th>
                        <x-default.table.sortable-th
                            wire:key="est-TH-1"
                            model="acronym"
                            :label="__('tables.establishments.acronym')"
                            :$sortDirection
                            :$sortBy />

                        <x-default.table.sortable-th
                            wire:key="est-TH-2"
                            model="name_fr"
                            :label="__('tables.establishments.name_fr')"
                            :$sortDirection
                            :$sortBy />

                        <x-default.table.sortable-th
                            wire:key="est-TH-8"
                            model="name_ar"
                            :label="__('tables.establishments.name_ar')"
                            :$sortDirection
                            :$sortBy />

                        <x-default.table.sortable-th
                            wire:key="est-TH-9"
                            model="name_en"
                            :label="__('tables.establishments.name_en')"
                            :$sortDirection
                            :$sortBy />

                        <x-default.table.sortable-th
                            wire:key="est-TH-3"
                            model="email"
                            :label="__('tables.establishments.email')"
                            :$sortDirection
                            :$sortBy />

                        <x-default.table.sortable-th
                            wire:key="est-TH-4"
                            model="tel"
                            :label="__('tables.establishments.tel')"
                            :$sortDirection
                            :$sortBy />

                        <x-default.table.sortable-th
                            wire:key="est-TH-5"
                            model="fax"
                            :label="__('tables.establishments.fax')"
                            :$sortDirection
                            :$sortBy />

                        <x-default.table.sortable-th
                            wire:key="est-TH-6"
                            model="daira"
                            :label="__('tables.establishments.daira')"
                            :$sortDirection
                            :$sortBy />

                        <x-default.table.sortable-th
                            wire:key="est-TH-7"
                            model="created_at"
                            :label="__('tables.establishments.created_at')"
                            :$sortDirection
                            :$sortBy />

                    </tr>
                </thead>

                <tbody>
                    @foreach ($this->establishments as $establishment)
                        <tr wire:key="{{ $establishment->id }}-gt">
                              <td>
                                <x-default.action-btn
                                    :tooltip="__('toolTips.establishment.delete')"
                                    icon="trash"
                                    function="openDeleteDialog"
                                    :parameters="[$establishment]" />

                                <livewire:default.open-modal-button
                                    wire:key="establishment-m-{{ $establishment->id }}"
                                    classes="rounded"
                                    content="<i class='fa-solid fa-pen-to-square'></i>"
                                    :toolTipMessage="__('toolTips.establishment.update')"
                                    modalTitle="modals.establishment.actions.update"
                                    :modalTitleOptions="['acronym' => $establishment->acronym]"
                                    :modalContent="[
                                        'name' => 'default.admin.establishment-modal',
                                        'parameters' => ['id' => $establishment->id]
                                    ]"
                                    :containsTinyMce=true />

                                <x-default.table.link
                                    :toolTipMessage="__('toolTips.establishment.manage.view')"
                                    route="establishment_route"
                                    :parameters='["id" => $establishment->id, "acronym" => $establishment->acronym]'
                                    icon="view" />

                                <x-default.action-btn
                                    :tooltip="__('toolTips.establishment.map')"
                                    icon="map"
                                    function="openGoogleMap"
                                    :parameters='[$establishment->longitude, $establishment->latitude]' />
                            </td>
                            <td scope="row">{{ $establishment->acronym }}</td>
                            <td>{{ $establishment->name_fr }}</td>
                            <td>{{ $establishment->name_ar }}</td>
                            <td>{{ $establishment->name_en }}</td>
                            <td>{{ $establishment->email }}</td>
                            <td>{{ $establishment->tel }}</td>
                            <td>{{ $establishment->fax }}</td>
                            <td>{{ $establishment->daira_name }}</td>
                            <td>{{ $establishment->created_at->format('d-m-Y') }}</td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{ $this->establishments->links('components.default.pagination') }}
    @else
        <div class="table__footer">
            <h2>@lang('tables.establishments.not_found')</h2>
        </div>
    @endif
</div>

@script
<script>
    Livewire.on('open-google-map', url => {
        window.open(url, '_blank'); // opens in new tab
    });
</script>
@endscript
