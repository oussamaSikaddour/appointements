<div class="modal__body">
    <!-- Form Section -->
    <form class="table__form">
        <!-- Form Inputs Container -->
        <div class="table__form__inputs__container">
            <div class="table__form__inputs">
                <x-default.form.input model="{{$form}}.designation_fr" :label="__('forms.field_grade.designation_fr')" type="text" html_id="MFG-bfr" />
                <x-default.form.input model="{{$form}}.designation_ar" :label="__('forms.field_grade.designation_ar')" type="text" html_id="MFG-bAr" />
                <x-default.form.input model="{{$form}}.designation_en" :label="__('forms.field_grade.designation_en')" type="text" html_id="MFG-bEN" />
                <x-default.form.input model="{{$form}}.acronym" :label="__('forms.field_grade.acronym')" type="text" html_id="MFG-ac" />
            </div>
        </div>

        <!-- Form Buttons Container -->
        <div class="table__form__buttons__container">


            <!-- Form Buttons -->
            <div class="table__form__buttons">
                <!-- Submit Button -->
                <button type="submit" class="button button--primary rounded hasTooltip" wire:click.prevent="handleSubmit">
                    @if($form === "addForm")
                        <span id="submitBntField_grade" class="toolTip" role="tooltip" aria-label="@lang('toolTips.common.add')">
                            @lang("toolTips.common.add")
                        </span>
                        <i class="fa-solid fa-plus"></i>
                    @else
                        <span id="submitBntField_grade" class="toolTip" role="tooltip" aria-label="@lang('toolTips.common.update')">
                            @lang("toolTips.common.update")
                        </span>
                        <i class="fa-solid fa-pen-nib"></i>
                    @endif
                </button>
                <!-- Reset Button -->
                <button wire:click.prevent="resetForm" class="button rounded hasTooltip">
                    <span id="restOccuptionForm" class="toolTip" role="tooltip" aria-label="@lang('toolTips.common.reset')">
                        @lang("toolTips.common.resetForm")
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
<div class="table__container" x-on:update-field-grades-table.window="$wire.$refresh()">
    <div class="table__header">
        <h3>@lang('tables.field_grades.info',["acronym"=>"$fieldAcronym"])</h3>
        <div class="table__actions">


            <div wire:loading wire:target="excelFile">
                <x-default.loading />
            </div>

            <x-default.form.upload-input-with-tooltip
              :tooltip="__('toolTips.field_grade.manage.upload')"
               icon="upload"
               model="excelFile"
               types="excel"
                wire:loading.attr="disabled"
                />



                <button class="button  rounded hasTooltip" wire:click="generateEmptyFieldGradesExcel()">
                    <span id="TT-ued" class="toolTip" role="tooltip" aria-label="{{ __('toolTips.field_grade.excel.empty') }}">
                        @lang("toolTips.field_grade.excel.empty")
                    </span>
                  <i class="fa-solid fa-file-export"></i>
                </button>
                <button class="button button--primary rounded hasTooltip" wire:click="generateFieldGradesExcel()">
                    <span id="TT-ued" class="toolTip" role="tooltip" aria-label="{{ __('toolTips.field_grade.excel.donwload') }}">
                        @lang("toolTips.field_grade.excel.download")
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

  <div class="table__filters" wire:ignore>
        <x-default.form.input
            model="designation"
            :label="__('tables.fields.designation')"
            type="text"
            html_id="FGtDesignation"
            role="filter"
        />
        <x-default.form.input
            model="acronym"
            :label="__('tables.fields.acronym')"
            type="text"
            html_id="FGTAcronym"
            role="filter"
        />


        <button class="button button--primary rounded table__filters__btn--reset hasToolTip" wire:click="resetFilters">
            <span id="trashToolTip3" class="toolTip" role="tooltip" aria-label="reset Filters">
                @lang("toolTips.common.resetFilters")
            </span>
            <i class="fa-solid fa-arrows-rotate"></i>
        </button>
    </div>

    @if (isset($this->fieldGrades) && $this->fieldGrades->isNotEmpty())
        <div class="table__body">
            <table>
                <thead>
                    <tr>
                           <th></th>
                        <x-default.table.sortable-th wire:key="FTG-Th-1" model="acronym" :label="__('tables.field_grades.acronym')" :$sortDirection :$sortBy />
                        <x-default.table.sortable-th wire:key="FTG-Th-2" model="designation_fr" :label="__('tables.field_grades.designation_fr')" :$sortDirection :$sortBy    />
                        <x-default.table.sortable-th wire:key="FTG-Th-3" model="designation_en" :label="__('tables.field_grades.designation_en')" :$sortDirection :$sortBy    />
                        <x-default.table.sortable-th wire:key="FTG-Th-4" model="designation_ar" :label="__('tables.field_grades.designation_ar')" :$sortDirection :$sortBy    />
                        <x-default.table.sortable-th wire:key="FTG-Th-4" model="created_at" :label="__('tables.field_grades.registration_date')" :$sortDirection :$sortBy />


                        <th scope="column"><div>@lang('tables.common.actions')</div></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($this->fieldGrades as $fieldG)
                        <tr wire:key="{{ $fieldG->id }}" scope="row">

                            <td>
                                    <x-default.form.radio-button
                                        model="selectedChoice"
                                        htmlId="{{ 'fgM-id'.$fieldG->id }}"
                                        value="{{ $fieldG->id }}"
                                        type="forTable"
                                        wire:key="{{ 'fgM-key-'.$fieldG->id }}"
                                    />
                            </td>
                            <td>{{ $fieldG->acronym}}</td>
                          <td>{{ $fieldG->designation_fr }}</td>
                          <td>{{ $fieldG->designation_en }}</td>
                          <td>{{ $fieldG->designation_ar}}</td>

                            <td>{{ $fieldG->created_at->format('Y-m-d') }}</td>
                            <td>
                                <x-default.action-btn :tooltip="__('toolTips.field.delete')" icon="trash" function="openDeleteDialog" :parameters="[$fieldG]" />

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{ $this->fieldGrades->links('components.default.pagination') }}
    @else
        <div class="table__footer">
             <h2>
             @lang('tables.field_grades.not_found')
               </h2>
        </div>
    @endif
</div>

</div>
