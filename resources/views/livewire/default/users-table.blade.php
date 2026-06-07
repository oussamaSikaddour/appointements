<div class="table__container" x-on:update-users-table.window="$wire.$refresh()">
    <div class="table__header">
        <h3>{{ $usersTableInfoMsg }}</h3>
        <div class="table__actions">
            @canany(['super-admin-access','admin-access','establishment-admin-access'])
                <div wire:loading wire:target="excelFile">
                    <x-default.loading />
                </div>

                <x-default.form.upload-input-with-tooltip
                    :tooltip="__('toolTips.user.manage.users')"
                    icon="upload"
                    model="excelFile"
                    types="excel"
                    wire:loading.attr="disabled"
                />

                <button class="button rounded hasTooltip" wire:click="generateEmptyStaffExcel()">
                    <span class="toolTip">@lang('toolTips.user.excel.empty')</span>
                    <i class="fa-solid fa-file-export"></i>
                </button>

                <button class="button button--primary rounded hasTooltip" wire:click="generateStaffExcel()">
                    <span class="toolTip">@lang('toolTips.user.excel.download')</span>
                    <i class="fa-solid fa-file-export"></i>
                </button>
            @endcanany

            <button class="button rounded table__filters__btn hasTooltip" id="filter">
                <span class="toolTip">@lang('toolTips.common.filters')</span>
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
        <x-default.form.input model="employeeNumber" :label="__('tables.users.employee_number')" type="text" html_id="employeeNumberUT" role="filter"/>
        <x-default.form.input model="fullName" :label="__('tables.users.full_name')" type="text" html_id="fullNameUT" role="filter"/>
        <x-default.form.input model="email" :label="__('tables.users.email')" type="text" html_id="usersEmailUT" role="filter"/>

        <button class="button button--primary rounded table__filters__btn--reset hasTooltip" wire:click="resetFilters">
            <span class="toolTip">@lang('toolTips.common.resetFilters')</span>
            <i class="fa-solid fa-arrows-rotate"></i>
        </button>
    </div>

    @if ($this->users->isNotEmpty())
        <div class="table__body">
            <table>
                <thead>
                    <tr>
                        <th scope="column"><div>@lang('tables.common.actions')</div></th>
                        <x-default.table.sortable-th wire:key="U-TH-1" model="employee_number" :label="__('tables.users.employee_number')" :$sortDirection :$sortBy />
                        <x-default.table.sortable-th wire:key="U-TH-2" model="name_fr" :label="__('tables.users.full_name_fr')" :$sortDirection :$sortBy />
                        <x-default.table.sortable-th wire:key="U-TH-11" model="name_ar" :label="__('tables.users.full_name_ar')" :$sortDirection :$sortBy />
                        <x-default.table.sortable-th wire:key="U-TH-3" model="email" :label="__('tables.users.email')" :$sortDirection :$sortBy />
                        <x-default.table.sortable-th wire:key="U-TH-13" model="social_number" :label="__('tables.users.social_number')" :$sortDirection :$sortBy />

                        @isset($establishmentId)
                            <x-default.table.sortable-th wire:key="U-TH-12" model="establishment_name" :label="__('tables.users.establishment')" :$sortDirection :$sortBy />
                        @endisset

                        @isset($serviceId)
                            <x-default.table.sortable-th wire:key="U-TH-13" model="service_name" :label="__('tables.users.service')" :$sortDirection :$sortBy />
                        @endisset

                        <x-default.table.sortable-th wire:key="U-TH-4" model="created_at" :label="__('tables.users.registration_date')" :$sortDirection :$sortBy />
                        <x-default.table.sortable-th wire:key="U-TH-5" model="phone" :label="__('tables.users.phone')" :$sortDirection :$sortBy />
                        <x-default.table.sortable-th wire:key="U-TH-6" model="card_number" :label="__('tables.users.card_number')" :$sortDirection :$sortBy />
                        <x-default.table.sortable-th wire:key="U-TH-7" model="birth_date" :label="__('tables.users.birth_date')" :$sortDirection :$sortBy />
                        <x-default.table.sortable-th wire:key="U-TH-8" model="birth_place_fr" :label="__('tables.users.birth_place_fr')" :$sortDirection :$sortBy />
                        <x-default.table.sortable-th wire:key="U-TH-9" model="birth_place_ar" :label="__('tables.users.birth_place_ar')" :$sortDirection :$sortBy />
                        <x-default.table.sortable-th wire:key="U-TH-10" model="birth_place_en" :label="__('tables.users.birth_place_en')" :$sortDirection :$sortBy />


                    </tr>
                </thead>
                <tbody>
                    @foreach ($this->users as $u)
                        <tr wire:key="user-{{ $u->id }}">
                             <td>
                                <x-default.action-btn :tooltip="__('toolTips.user.delete')" icon="trash" function="openDeleteUserDialog" :parameters="[$u]" />

                                <livewire:default.open-modal-button
                                    wire:key="edit-{{ $u->id }}"
                                    classes="rounded"
                                    content="<i class='fa-solid fa-pen-to-square'></i>"
                                    :toolTipMessage="__('toolTips.user.update')"
                                    modalTitle="modals.user.actions.update.personnel"
                                    :modalTitleOptions="['name'=>$u->localized_name]"
                                    :modalContent="['name' => 'default.user-modal', 'parameters' => [
                                    'id' => $u->id,
                                    'serviceId'=>$serviceId,
                                    'establishmentId'=>$establishmentId
                                    ]
                                    ]"
                                />

                                @canany(['super-admin-access','admin-access','establishment-admin-access'])
                                    <livewire:default.open-modal-button
                                        wire:key="occ-{{ $u->id }}"
                                        classes="rounded"
                                        content="<i class='fa-solid fa-briefcase'></i>"
                                        :toolTipMessage="__('toolTips.user.manage.occupations')"
                                        modalTitle="modals.user.actions.manage.occupations"
                                        :modalTitleOptions="['name'=>$u->localized_name]"
                                        :modalContent="['name' => 'default.admin.occupations-modal', 'parameters' => ['user' => $u]]"
                                    />
                                    <livewire:default.open-modal-button
                                        wire:key="bank-{{ $u->id }}"
                                        classes="rounded"
                                        content="<i class='fa-solid fa-credit-card'></i>"
                                        :toolTipMessage="__('toolTips.user.manage.banking_information')"
                                        modalTitle="modals.user.actions.manage.banking_information"
                                        :modalTitleOptions="['name'=>$u->localized_name]"
                                        :modalContent="['name' => 'default.admin.banking-information-modal', 'parameters' => ['bankable' => $u, 'bankableType' => 'user']]"
                                    />
                                @endcanany

                                @canany(['super-admin-access','admin-access'])
                                    <livewire:default.open-modal-button
                                        wire:key="roles-{{ $u->id }}"
                                        classes="rounded"
                                        content="<i class='fa-solid fa-link'></i>"
                                        :toolTipMessage="__('toolTips.user.manage.roles')"
                                        modalTitle="modals.user.actions.manage.roles"
                                        :modalTitleOptions="['name'=>$u->localized_name]"
                                        :modalContent="['name' => 'default.super-admin.roles-modal', 'parameters' => ['id' => $u->id]]"
                                    />
                                @endcanany
                            </td>
                            <td>{{ $u->employee_number }}</td>
                            <td>{{ $u->name_fr }}</td>
                            <td>{{ $u->name_ar }}</td>
                            <td>{{ $u->email }}</td>
                            <td>{{ $u->social_number }}</td>

                            @isset($establishmentId)
                                <td>{{ $u->establishment_name }}</td>
                            @endisset

                            @isset($serviceId)
                                <td>{{ $u->service_name }}</td>
                            @endisset

                            <td>{{ $u->created_at->format('Y-m-d') }}</td>
                            <td>{{ $u->phone }}</td>
                            <td>{{ $u->card_number }}</td>
                            <td>{{ $u->birth_date }}</td>
                            <td>{{ $u->birth_place_fr }}</td>
                            <td>{{ $u->birth_place_ar }}</td>
                            <td>{{ $u->birth_place_en }}</td>


                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $this->users->links('components.default.pagination') }}
    @else
        <div class="table__footer">
            <h2>{{ $usersTableEmptyMsg }}</h2>
        </div>
    @endif
</div>
