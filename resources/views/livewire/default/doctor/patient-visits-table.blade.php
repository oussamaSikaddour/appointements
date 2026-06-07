<div class="table__container"
     x-on:update-patient-visits-table.window="$wire.$refresh()">

    {{-- Header --}}
    <div class="table__header">
        <h3>@lang('tables.patient_visits.info')</h3>
        <div class="table__actions">

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
        <x-default.form.input
            model="patient"
            :label="__('tables.patient_visits.patient')"
            type="text"
            html_id="PV-patient"
            role="filter" />

        <x-default.form.input
            model="patientCode"
            :label="__('tables.patient_visits.patient_code')"
            type="text"
            html_id="PV-patient-code"
            role="filter" />

        <x-default.form.selector
            htmlId="PV-doctor"
            model="doctorId"
            :label="__('tables.patient_visits.doctor')"
            :data="$doctorsOptions"
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
    @if(isset($this->visits) && $this->visits->count())
        <div class="table__body">
            <table>
                <thead>
                    <tr>
                        <th scope="column">
                            <div>@lang('tables.common.actions')</div>
                        </th>

                        <x-default.table.sortable-th
                            model="patient_code"
                            :label="__('tables.patient_visits.patient_code')"
                            :$sortDirection
                            :$sortBy />

                        <x-default.table.sortable-th
                            model="patient_name"
                            :label="__('tables.patient_visits.patient')"
                            :$sortDirection
                            :$sortBy />

                        <x-default.table.sortable-th
                            model="doctor_name"
                            :label="__('tables.patient_visits.doctor')"
                            :$sortDirection
                            :$sortBy />

                        {{-- 🕒 Created At column --}}
                        <x-default.table.sortable-th
                            model="created_at"
                            :label="__('tables.patient_visits.created_at')"
                            :$sortDirection
                            :$sortBy />
                    </tr>
                </thead>

                <tbody>
                    @foreach ($this->visits as $visit)
                        <tr wire:key="visit-{{ $visit->id }}">
                            <td class="flex gap-2">
                                <x-default.action-btn
                                    :tooltip="__('toolTips.patient_visit.delete')"
                                    icon="trash"
                                    function="openDeleteDialog"
                                    :parameters="[$visit]" />

                                <livewire:default.open-modal-button
                                    wire:key="visit-modal-{{ $visit->id }}"
                                    classes="rounded"
                                    content="<i class='fa-solid fa-pen-to-square'></i>"
                                    :toolTipMessage="__('toolTips.patient_visit.update')"
                                    modalTitle="modals.patient_visit.actions.update"
                                    :modalTitleOptions="[
                                    'code'=>$visit->patient_code
                                    ]"
                                    :modalContent="[
                                        'name' => 'default.doctor.patient-visit-modal',
                                        'parameters' => [
                                        'visitId' => $visit->id
                                        ],
                                    ]"
                                    :containsTinyMce="true"
                                />
                                    <livewire:default.open-modal-button
                                         wire:key="Pv-FM-{{ $visit->id }}"
                                         classes="rounded"
                                         content="<i class='fa-solid fa-file-pdf'></i>"
                                         :toolTipMessage="__('toolTips.patient_visit.manage.files')"
                                          modalTitle="modals.patient_visit.actions.manage.files"
                                         :modalTitleOptions="['name' => $visit->patient_name]"
                                         :modalContent="[
                                                'name' => 'default.files-modal',
                                               'parameters' => [
                                                     'fileableId' => $visit->id,
                                                 'fileableType' => 'App\Models\Visit',
                                                            ],
                                                          ]"
                                             />
                                       <livewire:default.open-modal-button
                                        wire:key="Pv-IM-{{ $visit->id }}"
                                        classes="rounded"
                                        content="<i class='fa-solid fa-images'></i>"
                                        :toolTipMessage="__('toolTips.patient_visit.manage.images')"
                                        modalTitle="modals.patient_visit.actions.manage.images"
                                        :modalTitleOptions="['name'=>$visit->patient_name]"
                                        :modalContent="[
                                        'name' => 'default.images-modal',
                                        'parameters' => [
                                                         'imageableId' => $visit->id,
                                                         'imageableType' => 'App\Models\Visit',
                                                         ]
                                                         ]"
                                    />


                            </td>

                            <td>{{ $visit->patient_code }}</td>
                            <td>{{ $visit->patient_name }}</td>
                            <td>{{ $visit->doctor_name }}</td>
                            <td>{{$visit->created_at->format('Y-m-d') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="table__footer">
            <h2>@lang('tables.patient_visits.not_found')</h2>
        </div>
    @endif
</div>


