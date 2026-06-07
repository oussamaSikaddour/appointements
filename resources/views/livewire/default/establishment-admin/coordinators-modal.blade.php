<div class="modal__body">
    <!-- Form Section -->
    <form class="table__form">
        <!-- Form Inputs Container -->
        <div class="table__form__inputs__container">
            <div class="table__form__inputs">
                <x-default.form.selector
                    htmlId="coord-mf-id"
                    model="manageForm.user_id"
                    :label="__('forms.coordinator.user_id')"
                    :data="$personalOptions"
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
    <div class="table__container" x-on:update-coordinators-table.window="$wire.$refresh()">
        @if(isset($this->coordinators) && $this->coordinators->isNotEmpty())
            <div class="table__body">
                <table>
                    <thead>
                        <tr>
                            <th scope="column">
                                <div>@lang('tables.common.actions')</div>
                            </th>
                            <x-default.table.sortable-th
                            wire:key="coord-TH-1"
                             model="employee_number"
                             :label="__('tables.coordinators.employee_number')"
                             :$sortDirection
                             :$sortBy />
                            <x-default.table.sortable-th
                            wire:key="coord-TH-2"
                            model="name"
                            :label="__('tables.coordinators.name')"
                            appLocal="true"
                            :$sortDirection
                            :$sortBy />
                            <x-default.table.sortable-th
                            wire:key="coord-TH-3"
                             model="email"
                             :label="__('tables.coordinators.email')"
                              :$sortDirection
                              :$sortBy />
                            <x-default.table.sortable-th
                            wire:key="coord-TH-5"
                             model="phone"
                             :label="__('tables.coordinators.phone')"
                              :$sortDirection
                              :$sortBy />
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($this->coordinators as $coord)
                            <tr wire:key="coord-{{ $coord->id }}">
                                <td>
                                    <x-default.action-btn :tooltip="__('toolTips.coordinator.ban')" icon="ban" function="openManageCoordDialog" :parameters="[$coord]" />
                                </td>
                                <td>{{ $coord->employee_number }}</td>
                                <td>{{ $coord->name }}</td>
                                <td>{{ $coord->email }}</td>
                                <td>{{ $coord->phone }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
