<div class="table__container"
     x-on:update-medical-files-table.window="$wire.$refresh()">
    <div class="table__header">
        <h3>@lang('tables.medical_files.info')</h3>
        <div class="table__actions">
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
            :label="__('tables.medical_files.name')"
            type="text"
            html_id="TsSName"
            role="filter"
        />
        <x-default.form.input
            model="code"
            :label="__('tables.medical_files.code')"
            type="text"
            html_id="TSCode"
            role="filter"
        />
        <x-default.form.selector
            htmlId="TsTEb"
            model="gender"
            :label="__('tables.medical_files.gender')"
            :data="$genderOptions"
            type="filter"
        />
        <x-default.form.selector
            htmlId="TsTEb"
            model="year"
            :label="__('tables.medical_files.year')"
            :data="$yearsOptions"
            type="filter"
        />

        <button class="button button--primary rounded table__filters__btn--reset hasTooltip" wire:click="resetFilters">
            <span id="trashToolTip3" class="toolTip" role="tooltip" aria-label="reset Filters">
                @lang("toolTips.common.resetFilters")
            </span>
            <i class="fa-solid fa-arrows-rotate"></i>
        </button>
    </div>

    @if(isset($this->medicalFiles) && count($this->medicalFiles))
        <div class="table__body">
            <table>
                <thead>
                    <tr>
                         <th scope="column"><div>@lang('tables.common.actions')</div></th>
                        <x-default.table.sortable-th wire:key="medical-file-th-5" model="code" :label="__('tables.medical_files.code')" :$sortDirection :$sortBy />
                        <x-default.table.sortable-th wire:key="medical-file-th-9" model="insurance_number" :label="__('tables.medical_files.insurance_number')" :$sortDirection :$sortBy />
                        <x-default.table.sortable-th wire:key="medical-file-th-1" model="last_name_fr" :label="__('tables.medical_files.last_name_fr')" :$sortDirection :$sortBy />
                        <x-default.table.sortable-th wire:key="medical-file-th-2" model="last_name_ar" :label="__('tables.medical_files.last_name_ar')" :$sortDirection :$sortBy />
                        <x-default.table.sortable-th wire:key="medical-file-th-3" model="first_name_fr" :label="__('tables.medical_files.first_name_ar')" :$sortDirection :$sortBy />
                        <x-default.table.sortable-th wire:key="medical-file-th-4" model="first_name_ar" :label="__('tables.medical_files.first_name_fr')" :$sortDirection :$sortBy />
                        <x-default.table.sortable-th wire:key="medical-file-th-6" model="gender" :label="__('tables.medical_files.gender')" :$sortDirection :$sortBy />
                        <x-default.table.sortable-th wire:key="medical-file-th-6" model="birth_date" :label="__('tables.medical_files.birth_date')" :$sortDirection :$sortBy />
                        <x-default.table.sortable-th wire:key="medical-file-th-8" model="tel" :label="__('tables.medical_files.tel')" :$sortDirection :$sortBy />
                        <x-default.table.sortable-th wire:key="medical-file-th-7" model="created_at" :label="__('tables.medical_files.created_at')" :$sortDirection :$sortBy />

                    </tr>
                </thead>
                <tbody>
                    @foreach ($this->medical_files as $medicalFile)
                    @php
                       $name = $locale === 'ar'
                         ? "{$medicalFile->last_name_ar} {$medicalFile->first_name_ar}"
                       : "{$medicalFile->last_name_fr} {$medicalFile->first_name_fr}";
                    @endphp
                        <tr wire:key="{{ $medicalFile->id }}-gt">
                            <td>
                                @if (!$isForDoctor)


                                <x-default.action-btn
                                    :tooltip="__('toolTips.medical_file.delete')"
                                    icon="trash"
                                    function="openDeleteDialog"
                                    :parameters="[$medicalFile]"
                                />
                                <livewire:default.open-modal-button
                                    wire:key="medicalFile-m-{{ $medicalFile->id }}"
                                    classes="rounded"
                                    content="<i class='fa-solid fa-pen-to-square'></i>"
                                    :toolTipMessage="__('toolTips.medical_file.update')"
                                    modalTitle="modals.medical_file.actions.update"
                                    :modalTitleOptions="['code' => $medicalFile->code]"
                                    :modalContent="[
                                        'name' => 'default.user.medical-file-modal',
                                        'parameters' => [
                                                     'medicalFileId' => $medicalFile->id,
                                                     ]
                                    ]"
                                />
                                <x-default.table.link
                                    :toolTipMessage="__('toolTips.medical_file.manage.view')"
                                    route="medical_file_route"
                                    :parameters='[
                                    "id" => $medicalFile->id,
                                     "code" => $medicalFile->code ,
                                     "name"=>$name]'
                                    icon="view" />
                                @else
                                       <livewire:default.open-modal-button
                                    wire:key="doctor-App-m-{{ $medicalFile->id }}"
                                    classes="rounded"
                                    content="<i class='fa-solid fa-stethoscope'></i>"
                                    :toolTipMessage="__('toolTips.appointment.simple')"
                                    modalTitle="modals.appointment.actions.add.simple"
                                    :modalTitleOptions="['code' => $medicalFile->code]"
                                    :modalContent="[
                                        'name' => 'default.appointment-modal',
                                        'parameters' => [
                                                     'patientId' => $medicalFile->id,
                                                     ]
                                    ]"
                                />
                                <x-default.table.link
                                    :toolTipMessage="__('toolTips.medical_file.manage.visits')"
                                    route="patient_visits_route"
                                    :parameters='[
                                    "id" => $medicalFile->id,
                                     "code" => $medicalFile->code ,
                                     "name"=>$name]'
                                    icon="patient-visit" />

                                 @endif

                            </td>
                            <td scope="row">{{ $medicalFile->code }}</td>
                            <td>{{ $medicalFile->insurance_number }}</td>
                            <td>{{ $medicalFile->last_name_fr }}</td>
                            <td>{{ $medicalFile->last_name_ar }}</td>
                            <td>{{ $medicalFile->first_name_fr }}</td>
                            <td>{{ $medicalFile->first_name_ar }}</td>
                            <td>{{$genderOptions[$medicalFile->gender] }}</td>
                            <td>{{$medicalFile->birth_date}}</td>
                            <td>{{ $medicalFile->tel }}</td>
                            <td>{{ $medicalFile->created_at->format('Y-m-d') }}</td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="table__footer">
            <h2>@lang('tables.medical_files.not_found')</h2>
        </div>
    @endif
</div>
