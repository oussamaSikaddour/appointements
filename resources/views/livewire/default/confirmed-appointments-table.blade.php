<div class="table__container"
     x-on:update-confirmed-appointments-table.window="$wire.$refresh()">

    {{-- Header --}}
    <div class="table__header">
        <h3>@lang('tables.confirmed_appointments.info')</h3>
        <div class="table__actions">

            {{-- Excel Export --}}
            <div wire:loading wire:target="generateAppointmentsExcel">
                <x-default.loading />
            </div>

            @can('appointments-location-admin-access')
            <button class="button button--primary rounded hasTooltip"
                    wire:click="generateAppointmentsExcel">
                <span id="TT-download-app" class="toolTip"
                      role="tooltip"
                      aria-label="{{ __('toolTips.appointment.excel.download') }}">
                    @lang("toolTips.appointment.excel.download")
                </span>
                <i class="fa-solid fa-file-export"></i>
            </button>
           @endcan
            {{-- Filters Toggle --}}
            <button class="button rounded table__filters__btn hasTooltip" id="filter">
                <span id="TT-filter"
                      class="toolTip"
                      role="tooltip"
                      aria-label="@lang('toolTips.common.filters')"
                      aria-haspopup="true"
                      aria-expanded="false"
                      aria-controls="tableFilters">
                    @lang("toolTips.common.filters")
                </span>
                <i class="fa-solid fa-filter"></i>
            </button>

        </div>
    </div>

    {{-- Filters --}}
    <div class="table__filters" wire:ignore.self>
        @canany(["appointments-location-admin-access",'doctor-access'])


        <x-default.form.input
            model="patient"
            :label="__('tables.confirmed_appointments.patient')"
            type="text"
            html_id="TApp-patient"
            role="filter" />

        <x-default.form.input
            model="patientCode"
            :label="__('tables.confirmed_appointments.patient_code')"
            type="text"
            html_id="TApp-patient-code"
            role="filter" />
        @endcanany
        <x-default.form.selector
            htmlId="TApp-year"
            model="year"
            :label="__('tables.confirmed_appointments.year')"
            :data="$yearsOptions"
            type="filter" />

        <x-default.form.selector
            htmlId="TApp-month"
            model="month"
            :label="__('tables.confirmed_appointments.month')"
            :data="$monthsOptions"
            type="filter" />

        <x-default.form.selector
            htmlId="TApp-specialty"
            model="specialtyId"
            :label="__('tables.confirmed_appointments.specialty')"
            :data="$specialtiesOptions"
            type="filter" />
@cannot('doctor-access')
        <x-default.form.selector
            htmlId="TApp-doctor"
            model="doctorId"
            :label="__('tables.confirmed_appointments.doctor')"
            :data="$doctorsOptions"
            type="filter" />
@endcannot
@cannot('appointments-location-admin-access')
        <x-default.form.selector
            htmlId="TApp-daira"
            model="dairaId"
            :label="__('tables.confirmed_appointments.daira')"
            :data="$dairatesOptions"
            type="filter" />

        <x-default.form.selector
            htmlId="TApp-location"
            model="appointmentsLocationId"
            :label="__('tables.confirmed_appointments.location')"
            :data="$appointmentsLocationsOptions"
            type="filter" />
 @endcannot
        <x-default.form.selector
            htmlId="TApp-scheduleDay"
            model="scheduleDayDate"
            :label="__('tables.confirmed_appointments.schedule_day')"
            :data="$scheduleDaysOptions"
            type="filter" />

        {{-- Reset --}}
        <button class="button button--primary rounded table__filters__btn--reset hasTooltip"
                wire:click="resetFilters">
            <span id="trashToolTip" class="toolTip"
                  role="tooltip"
                  aria-label="@lang('toolTips.common.resetFilters')">
                @lang("toolTips.common.resetFilters")
            </span>
            <i class="fa-solid fa-arrows-rotate"></i>
        </button>
    </div>

    {{-- Table --}}
    @if(isset($this->confirmedAppointments) && count($this->confirmedAppointments))
        <div class="table__body">
            <table>
                <thead>
                    <tr>
                       <th scope="column"><div>@lang('tables.common.actions')</div></th>
                        @canany(['doctor-access','appointments-location-admin-access'])



                        <x-default.table.sortable-th
                            model="queue_number"
                            :label="__('tables.confirmed_appointments.queue_number')"
                            :$sortDirection
                            :$sortBy />

                        <x-default.table.sortable-th
                            model="patient_code"
                            :label="__('tables.confirmed_appointments.patient_code')"
                            :$sortDirection
                            :$sortBy />

                        <x-default.table.sortable-th
                            model="patient_name"
                            :label="__('tables.confirmed_appointments.patient')"
                            :$sortDirection
                            :$sortBy />
                        <x-default.table.sortable-th
                            model="patient_birth_date"
                            :label="__('tables.confirmed_appointments.patient_birth_date')"
                            :$sortDirection
                            :$sortBy />
                        <x-default.table.sortable-th
                            model="patient_tel"
                            :label="__('tables.confirmed_appointments.patient_tel')"
                            :$sortDirection
                            :$sortBy />
                        @endcanany
                                   <x-default.table.sortable-th
                            model="doctor_name"
                            :label="__('tables.confirmed_appointments.doctor')"
                            :$sortDirection
                            :$sortBy />
                            <x-default.table.sortable-th
                               model="specialty"
                              :label="__('tables.confirmed_appointments.specialty')"
                                :$sortDirection
                               :$sortBy />
                           <x-default.table.sortable-th
                            model="day_at"
                            :label="__('tables.confirmed_appointments.date')"
                            :$sortDirection
                            :$sortBy />
                          <x-default.table.sortable-th
                            model="appointments_location"
                            :label="__('tables.confirmed_appointments.location')"
                            :$sortDirection
                            :$sortBy />
                           <x-default.table.sortable-th
                            model="type"
                            :label="__('tables.confirmed_appointments.type')"
                            :$sortDirection
                            :$sortBy />

                            <th>@lang('tables.confirmed_appointments.referral_letter')</th>





                    </tr>
                </thead>

                <tbody>
                    @foreach ($this->confirmedAppointments as $appointment)
                        <tr wire:key="appointment-{{ $appointment->id }}">
                            <td>
                                {{-- Cancel --}}
                                @if (!$isForDoctor)

                                <x-default.action-btn
                                    :tooltip="__('toolTips.appointment.cancel')"
                                    icon="ban"
                                    function="openAppointmentCancellingDialog"
                                    :parameters="[$appointment]" />

                                @endif
                                {{-- PDF --}}
                                <x-default.action-btn
                                    :tooltip="__('toolTips.appointment.get_confirmation')"
                                    icon="pdf"
                                    function="generateAppointmentConfirmationPdf"
                                    :parameters="[$appointment]" />

                                {{-- Map --}}
                                <x-default.action-btn
                                    :tooltip="__('toolTips.appointment.location_map')"
                                    icon="map"
                                    function="openGoogleMap"
                                    :parameters="[$appointment->latitude, $appointment->longitude]" />
                            </td>
                              @canany(['doctor-access','appointments-location-admin-access'])
                            <td>{{ $appointment->queue_number }}</td>
                            <td>{{ $appointment->patient_code }}</td>
                            <td>{{ $appointment->patient_name }}</td>
                            <td>{{ $appointment->patient_birth_date }}</td>
                            <td>{{ $appointment->patient_tel }}</td>
                            @endcanany
                            <td>{{ $appointment->doctor_name }}</td>
                            <td>{{ $appointment->specialty }}</td>
                            <td>{{$appointment->day_at }}</td>
                            <td>{{ $appointment->appointments_location }}</td>
                            <td>{{ $appointmentTypes[$appointment->type]}}</td>
                            <td>
                                  @if($appointment->referral_letter )
                               <livewire:default.open-modal-button
                                    wire:key="appointment-RL-{{ $appointment->id }}"
                                    classes="rounded"
                                    content="<i class='fa-solid fa-envelope'></i>"
                                    :toolTipMessage="__('toolTips.appointment.referral_letter')"
                                    modalTitle="modals.appointment.referral_letter"
                                    type="for_image"
                                    :modalContent="
                                     $appointment->referral_letter
                                    "/>
                                    @endif
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


    @else
        <div class="table__footer">
            <h2>@lang('tables.confirmed_appointments.not_found')</h2>
        </div>
    @endif
</div>

@script
<script>
    Livewire.on('open-google-map', url => {
        window.open(url, '_blank');
    });
</script>
@endscript
