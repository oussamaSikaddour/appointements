


<div class="modal__body">
    <!-- Form Section -->
    <form class="table__form">
        <!-- Form Inputs Container -->
        <div class="table__form__inputs__container">
            <div class="table__form__inputs">
                <x-default.form.selector
                    htmlId="AppointM-SP"
                    model="specialtyId"
                    :label="__('forms.appointment.specialty_id')"
                    :data="$specialtiesOptions"
                    :showError="true"
                    type="filter"
                />
                <x-default.form.selector
                    htmlId="AppointM-doc"
                    model="addForm.doctor_id"
                    :label="__('forms.appointment.doctor_id')"
                    :data="$doctorsOptions"
                    :showError="true"
                    type="filter"
                />
                <x-default.form.selector
                    htmlId="AppointM-D"
                    model="dairaId"
                    :label="__('forms.appointment.daira_id')"
                    :data="$dairatesOptions"
                    :showError="true"
                    type="filter"
                />

                <x-default.form.selector
                    htmlId="AppointM-APLS"
                    model="addForm.appointments_location_id"
                    :label="__('forms.appointment.appointments_location_id')"
                    :data="$appointmentsLocationsOptions"
                    :showError="true"
                    type="filter"
                />

        @if (!$isAFollowUp)


        <div class="column center"

        x-data="{ uploading: false, progress: 0 }"
        x-on:livewire-upload-start="uploading = true"
        x-on:livewire-upload-finish="uploading = false"
        x-on:livewire-upload-cancel="uploading = false"
        x-on:livewire-upload-error="uploading = false"
        x-on:livewire-upload-progress="progress = $event.detail.progress"
        >

        <x-default.form.upload-input model="addForm.referral_letter"
        :label="__('forms.appointment.referral_letter')"    types="img" />

            <div x-show="uploading">
              <progress max="100" x-bind:value="progress"></progress>

          </div>

            </div>
        @if ($temporaryImageUrl !=="")
            <div class="imgs__container">
                <div class="imgs">
                        <img class="img" src="{{ $temporaryImageUrl }}" alt="{{__('forms.appointment.referral_letter')}}" />
                </div>
            </div>
        @endif
        @endif


            </div>
        </div>


    </form>

    <!-- Table Section -->
    <div class="table__container" x-on:update-available-appointments-table.window="$wire.$refresh()">
        <div class="table__header">
            @if ($this->schedulesDays()?->isEmpty())
               <h3>@lang('tables.available_appointments.not_found')</h3>
            @else
            <h3>@lang('tables.available_appointments.info.initials')</h3>
            @endif

        </div>

  @if($this->schedulesDays() && $this->schedulesDays()->isNotEmpty())
            <div class="table__body">
                <table>
                    <thead>
                        <tr>
                            <th scope="column">
                                <div>@lang('tables.common.actions')</div>
                            </th>
                            <x-default.table.sortable-th wire:key="Appoin-Th-1" model="day_at" :label="__('tables.available_appointments.date_at')" :$sortDirection :$sortBy />
                            <x-default.table.sortable-th wire:key="Appoin-Th-2" model="doctor" :label="__('tables.available_appointments.doctor')" :$sortDirection :$sortBy />
                            <x-default.table.sortable-th wire:key="Appoin-Th-4" model="daira" :label="__('tables.available_appointments.daira')" :$sortDirection :$sortBy />
                            <x-default.table.sortable-th wire:key="Appoin-Th-3" model="appointments_location" :label="__('tables.available_appointments.appointments_location')" :$sortDirection :$sortBy />
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($this->schedulesDays() as $sd)
                            <tr wire:key="scheduleDay-{{ $sd->id }}" scope="row">
                                <td>
                                    <x-default.action-btn
                                        :tooltip="__('toolTips.appointment.confirm')"
                                        icon="confirm"
                                        function="openConfirmAppointmentDialog"
                                        :parameters="[$sd]"
                                    />
                                </td>

                                <td>{{ $sd->day_at->format('Y-m-d') }}</td>
                                <td>{{ $sd->doctor }}</td>
                                <td>{{ $dairatesOptions[$sd->daira] }}</td>
                                <td>{{ $sd->appointments_location }}</td>


                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        @endif
    </div>
</div>
