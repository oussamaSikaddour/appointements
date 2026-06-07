<div class="modal__body">
    <!-- Form Section -->
    <form class="table__form">
        <!-- Form Inputs Container -->
        <div class="table__form__inputs__container">
            <div class="table__form__inputs">
                <x-default.form.selector
                    htmlId="ALAdmins-mf-id"
                    model="manageForm.user_id"
                    :label="__('forms.appointments-location-admin.user_id')"
                    :data="$personalOptions"
                    :showError="true"
                />
            </div>
            <div class="table__form__inputs">
                <x-default.form.selector
                    htmlId="ALAdmins-mf-Eid"
                    model="manageForm.appointments_location_id"
                    :label="__('forms.appointments-location-admin.appointments_location_id')"
                    :data="$appointmentsLocationsOptions"
                    :showError="true"
                />
            </div>
        </div>

        <!-- Form Buttons Container -->
        <div class="table__form__buttons__container">
            <div class="table__form__buttons">
                <!-- Submit Button -->
                <button type="submit"
                        class="button button--primary rounded hasTooltip"
                        wire:click.prevent="handleSubmit">
                    <span id="submitBtnBanking_information" class="toolTip" role="tooltip" aria-label="@lang('toolTips.common.add')">
                        @lang('toolTips.common.add')
                    </span>
                    <i class="fa-solid fa-check"></i>
                </button>


            </div>

            <div class="table__form__buttons__loading">
                <div wire:loading wire:target="handleSubmit">
                    <x-default.loading />
                </div>
            </div>
        </div>
    </form>

    <!-- Table Section -->
    <div class="table__container" x-on:update-appointments-location-admins-table.window="$wire.$refresh()">
        @if(isset($this->appointmentsLocationAdmins) && $this->appointmentsLocationAdmins->isNotEmpty())
            <div class="table__body">
                <table>
                    <thead>
                        <tr>
                            <th scope="column">
                                <div>@lang('tables.common.actions')</div>
                            </th>
                            <x-default.table.sortable-th
                            wire:key="ALAdmin-TH-1"
                             model="employee_number"
                             :label="__('tables.appointments_location_admins.employee_number')"
                             :$sortDirection
                             :$sortBy />
                            <x-default.table.sortable-th
                            wire:key="ALAdmin-TH-2"
                            model="name"
                            :label="__('tables.appointments_location_admins.name')"
                            appLocal="true"
                            :$sortDirection
                            :$sortBy />
                            <x-default.table.sortable-th
                            wire:key="ALAdmin-TH-3"
                             model="email"
                             :label="__('tables.appointments_location_admins.email')"
                              :$sortDirection
                              :$sortBy />
                            <x-default.table.sortable-th
                            wire:key="ALAdmin-TH-5"
                             model="phone"
                             :label="__('tables.appointments_location_admins.phone')"
                              :$sortDirection
                              :$sortBy />
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($this->appointmentsLocationAdmins as $ALAdmin)
                            <tr wire:key="ALAdmin-{{ $ALAdmin->id }}">
                                <td>
                                    <x-default.action-btn :tooltip="__('toolTips.appointments-location-admin.ban')" icon="ban" function="openManageAppointmentsLocationAdminDialog" :parameters="[$ALAdmin]" />
                                </td>
                                <td>{{ $ALAdmin->employee_number }}</td>
                                <td>{{ $ALAdmin->name }}</td>
                                <td>{{ $ALAdmin->email }}</td>
                                <td>{{ $ALAdmin->phone }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
