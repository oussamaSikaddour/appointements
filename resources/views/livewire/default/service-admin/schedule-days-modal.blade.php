<div class="modal__body">
    <!-- Form Section -->
    <form class="table__form">
        <!-- Form Inputs Container -->
        <div class="table__form__inputs__container">
            <div class="table__form__inputs">
              <x-default.form.input
                    model="{{ $form }}.day_at"
                    :label="__('forms.schedule_day.day_at')"
                    type="date"
                    html_id="SdM-DayAt"
                    :min="$minDate"
                />

                <x-default.form.selector
                    htmlId="SdM-doctor"
                    model="{{ $form }}.doctor_id"
                    :label="__('forms.schedule_day.doctor_id')"
                    :data="$doctorsOptions"
                    :showError="true"
                />
                <x-default.form.input
                    model="{{ $form }}.available_number"
                    :label="__('forms.schedule_day.available_number')"
                    type="number"
                    html_id="SdM-PN"
                    min="1"
                    max="50"
                />
                <x-default.form.selector
                    htmlId="SdM-ALocation"
                    model="{{ $form }}.appointments_location_id"
                    :label="__('forms.schedule_day.appointments_location_id')"
                    :data="$appointmentsLocationsOptions"
                    :showError="true"
                />
            </div>
        </div>

        <!-- Form Buttons Container -->
        <div class="table__form__buttons__container">
            <div class="table__form__buttons">
                <!-- Submit Button -->
                <button type="submit" class="button button--primary rounded hasTooltip" wire:click.prevent="handleSubmit">
                    @if($form === "addForm")
                        <span id="submitBtnscheduleDay" class="toolTip" role="tooltip" aria-label="@lang('toolTips.common.add')">
                            @lang('toolTips.common.add')
                        </span>
                        <i class="fa-solid fa-plus"></i>
                    @else
                        <span id="submitBtnscheduleDay" class="toolTip" role="tooltip" aria-label="@lang('toolTips.common.update')">
                            @lang('toolTips.common.update')
                        </span>
                        <i class="fa-solid fa-pen-nib"></i>
                    @endif
                </button>
                <!-- Reset Button -->
                <button wire:click.prevent="resetForm" class="button rounded hasTooltip">
                    <span id="resetscheduleDayForm" class="toolTip" role="tooltip" aria-label="@lang('toolTips.common.reset')">
                        @lang('toolTips.common.resetForm')
                    </span>
                    <i class="fa-solid fa-arrows-rotate"></i>
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
    <div class="table__container" x-on:update-scheduleDays-table.window="$wire.$refresh()">
        <div class="table__header">
            <h3>@lang('tables.schedule_days.info', ['name' => $scheduleName])</h3>
        </div>

        @if(isset($this->scheduleDays) && $this->scheduleDays->isNotEmpty())
            <div class="table__body">
                <table>
                    <thead>
                        <tr>

                           @if($scheduleState =="not_published")
                            <th></th>
                            <th scope="column">
                                <div>@lang('tables.common.actions')</div>
                            </th>
                           @endif
                            <x-default.table.sortable-th
                            wire:key="sch-d-Th-1"
                            model="day_at"
                            :label="__('tables.schedule_days.day_at')"
                            :$sortDirection
                            :$sortBy

                            />
                            <x-default.table.sortable-th
                            wire:key="sch-d-Th-2"
                            model="doctor"
                            :label="__('tables.schedule_days.doctor')"
                            :$sortDirection
                            :$sortBy
                            />
                            <x-default.table.sortable-th
                            wire:key="sch-d-Th-3"
                            model="available_number"
                            :label="__('tables.schedule_days.available_number')"
                            :$sortDirection
                            :$sortBy />
                            <x-default.table.sortable-th
                            wire:key="sch-d-Th-4"
                            model="confirmed_number"
                            :label="__('tables.schedule_days.confirmed_number')"
                            :$sortDirection
                            :$sortBy />
                            <x-default.table.sortable-th
                            wire:key="sch-d-Th-5"
                            model="appointment_location"
                            :label="__('tables.schedule_days.appointment_location')"
                             :$sortDirection
                             :$sortBy />

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($this->scheduleDays as $sd)

                            <tr wire:key="{{ $sd->id }}" scope="row">
                                   @if($scheduleState =="not_published")

                                <td>

                                    <x-default.action-btn
                                        :tooltip="__('toolTips.schedule_day.delete')"
                                        icon="trash"
                                        function="openDeleteScheduleDayDialog"
                                        :parameters="[$sd]"
                                    />

                                </td>
                                <td>

                                    <x-default.form.radio-button
                                        model="selectedChoice"
                                        htmlId="sd-id{{ $sd->id }}"
                                        value="{{ $sd->id }}"
                                        type="forTable"
                                        wire:key="sd-key{{ $sd->id }}"
                                    />

                                </td>
                                @endIf
                                <td>{{ $sd->day_at->format('Y-m-d'); }}</td>
                                <td>{{ $sd->doctor }}</td>
                                <td>{{ $sd->available_number }}</td>
                                <td>{{ $sd->confirmed_number }}</td>
                                <td>{{ $sd->appointment_location }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="table__footer">
                <h2>@lang('tables.schedule_days.not_found')</h2>
            </div>
        @endif
    </div>
</div>
