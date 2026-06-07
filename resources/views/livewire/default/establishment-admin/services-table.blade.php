<div class="table__container"
     x-on:update-services-table.window="$wire.$refresh()">
    <div class="table__header">
        <h3>@lang('tables.services.info')</h3>
        <div class="table__actions">
            <div wire:loading wire:target="excelFile">
                <x-default.loading />
            </div>

            <x-default.form.upload-input-with-tooltip
                :tooltip="__('toolTips.service.excel.upload')"
                icon="upload"
                model="excelFile"
                types="excel"
                wire:loading.attr="disabled"
            />

            <button class="button rounded hasTooltip" wire:click="generateEmptyServicesExcel()">
                <span id="TT-ued" class="toolTip" role="tooltip" aria-label="{{ __('toolTips.service.excel.empty') }}">
                    @lang("toolTips.service.excel.empty")
                </span>
                <i class="fa-solid fa-file-export"></i>
            </button>

            <button class="button button--primary rounded hasTooltip"
            wire:click="generateServicesExcel()">
                <span id="TT-ued" class="toolTip" role="tooltip" aria-label="{{ __('toolTips.service.excel.donwload') }}">
                    @lang("toolTips.service.excel.download")
                </span>
                <i class="fa-solid fa-file-export"></i>
            </button>

            <button class="button rounded table__filters__btn hasTooltip" id="filter">
                <span id="TT-Mf" class="toolTip" role="tooltip" aria-label="manage Filters" aria-haspopup="true" aria-expanded="false" aria-controls="tableFilters">
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

    <div class="table__filters" wire:ignore.self>
        <x-default.form.input
            model="name"
            :label="__('tables.services.name')"
            type="text"
            html_id="TsSName"
            role="filter"
        />
        <x-default.form.input
            model="headOfService"
            :label="__('tables.services.head_service')"
            type="text"
            html_id="TSResponsible"
            role="filter"
        />
        <x-default.form.selector
            htmlId="TsTEb"
            model="type"
            :label="__('tables.services.type')"
            :data="$serviceTypesOptions"
            type="filter"
        />
        <x-default.form.selector
            htmlId="TTEsb"
            model="specialtyId"
            :label="__('tables.services.specialty')"
            :data="$serviceSpecialtiesOptions"
            type="filter"
        />
        <button class="button button--primary rounded table__filters__btn--reset hasTooltip" wire:click="resetFilters">
            <span id="trashToolTip3" class="toolTip" role="tooltip" aria-label="reset Filters">
                @lang("toolTips.common.resetFilters")
            </span>
            <i class="fa-solid fa-arrows-rotate"></i>
        </button>
    </div>

    @if(isset($this->services) && count($this->services))
        <div class="table__body">
            <table>
                <thead>
                    <tr>
                         <th scope="column"><div>@lang('tables.common.actions')</div></th>
                        <x-default.table.sortable-th wire:key="service-th-1" model="name_fr" :label="__('tables.services.name_fr')" :$sortDirection :$sortBy />
                        <x-default.table.sortable-th wire:key="service-th-9" model="name_ar" :label="__('tables.services.name_ar')" :$sortDirection :$sortBy />
                        <x-default.table.sortable-th wire:key="service-th-10" model="name_en" :label="__('tables.services.name_en')" :$sortDirection :$sortBy />
                        <x-default.table.sortable-th wire:key="service-th-2" model="head_of_service" :label="__('tables.services.head_service')" :$sortDirection :$sortBy />
                        <x-default.table.sortable-th wire:key="service-th-3" model="type" :label="__('tables.services.type')" :$sortDirection :$sortBy />
                        <x-default.table.sortable-th wire:key="service-th-4" model="specialty" :label="__('tables.services.specialty')" :$sortDirection :$sortBy />
                        <x-default.table.sortable-th wire:key="service-th-5" model="tel" :label="__('tables.services.tel')" :$sortDirection :$sortBy />
                        <x-default.table.sortable-th wire:key="service-th-6" model="fax" :label="__('tables.services.fax')" :$sortDirection :$sortBy />
                        <x-default.table.sortable-th wire:key="service-th-7" model="created_at" :label="__('tables.services.created_at')" :$sortDirection :$sortBy />

                    </tr>
                </thead>
                <tbody>
                    @foreach ($this->services as $service)
                        <tr wire:key="{{ $service->id }}-gt">
                            <td>
                                <x-default.action-btn
                                    :tooltip="__('toolTips.service.delete')"
                                    icon="trash"
                                    function="openDeleteDialog"
                                    :parameters="[$service]"
                                />
                                <livewire:default.open-modal-button
                                    wire:key="service-m-{{ $service->id }}"
                                    classes="rounded"
                                    content="<i class='fa-solid fa-pen-to-square'></i>"
                                    :toolTipMessage="__('toolTips.service.update')"
                                    modalTitle="modals.service.actions.update"
                                    :modalTitleOptions="['name' => $service->localized_name]"
                                    :modalContent="[
                                        'name' => 'default.establishment-admin.service-modal',
                                        'parameters' => [
                                                     'id' => $service->id,
                                                    'establishmentId'=>$service->establishment_id
                                                     ]
                                    ]"
                                    :containsTinyMce=true
                                />
                                <livewire:default.open-modal-button
                                    wire:key="service-coord-{{ $service->id }}"
                                    classes="rounded"
                                    content="<i class='fa-solid fa-user-tie'></i>"
                                    :toolTipMessage="__('toolTips.service.manage.coordinators')"
                                    modalTitle="modals.service.actions.manage_coordinators"
                                    :modalTitleOptions="['name' => $service->localized_name]"
                                    :modalContent="[
                                        'name' => 'default.establishment-admin.coordinators-modal',
                                        'parameters' => [
                                                     'serviceId' => $service->id,
                                                    'establishmentId'=>$service->establishment_id
                                                     ]
                                    ]"
                                />

                            </td>
                            <td scope="row">{{ $service->name_fr }}</td>
                            <td>{{ $service->name_ar }}</td>
                            <td>{{ $service->name_en }}</td>
                            <td>{{ $service->head_service }}</td>
                            <td>{{$serviceTypesOptions[$service->type] }}</td>
                            <td>{{ $service->specialty }}</td>
                            <td>{{ $service->tel }}</td>
                            <td>{{ $service->fax }}</td>
                            <td>{{ $service->created_at->format('d-m-Y') }}</td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $this->services->links('components.default.pagination') }}
    @else
        <div class="table__footer">
            <h2>@lang('tables.services.not_found')</h2>
        </div>
    @endif
</div>
