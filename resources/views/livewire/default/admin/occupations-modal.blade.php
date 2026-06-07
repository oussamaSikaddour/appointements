<div class="modal__body">
    <!-- Form Section -->
    <form class="table__form">
        <!-- Form Inputs Container -->
        <div class="table__form__inputs__container">
            <div class="table__form__inputs">
                <x-default.form.selector
                    htmlId="OM-FO"
                    model="{{ $form }}.field_id"
                    :label="__('forms.occupation.field_id')"
                    :data="$fieldsOptions"
                    :showError="true"
                    type="filter"
                />
                <x-default.form.selector
                    htmlId="OM-FGO"
                    model="{{ $form }}.field_grade_id"
                    :label="__('forms.occupation.field_grade_id')"
                    :data="$fieldGradesOptions"
                    :showError="true"
                    type="filter"
                />
                <x-default.form.input
                    model="{{ $form }}.experience"
                    :label="__('forms.occupation.experience')"
                    type="number"
                    html_id="OM-EXP"
                />
                <x-default.form.selector
                    htmlId="OM-FSO"
                    model="{{ $form }}.field_specialty_id"
                    :label="__('forms.occupation.field_specialty_id')"
                    :data="$fieldSpecialtiesOptions"
                    :showError="true"
                    type="filter"
                />
                <x-default.form.textarea
                    model="{{ $form }}.description_fr"
                    :label="__('forms.occupation.description_fr')"
                    html_id="OM-DFR"
                />
                <x-default.form.textarea
                    model="{{ $form }}.description_ar"
                    :label="__('forms.occupation.description_ar')"
                    html_id="OM-DAR"
                />
                <x-default.form.textarea
                    model="{{ $form }}.description_en"
                    :label="__('forms.occupation.description_en')"
                    html_id="OM-DEN"
                />
            </div>
        </div>

        <!-- Form Buttons Container -->
        <div class="table__form__buttons__container">
            <div class="table__form__buttons">
                <!-- Submit Button -->
                <button type="submit" class="button button--primary rounded hasTooltip" wire:click.prevent="handleSubmit">
                    @if($form === "addForm")
                        <span id="submitBtnOccupation" class="toolTip" role="tooltip" aria-label="@lang('toolTips.common.add')">
                            @lang('toolTips.common.add')
                        </span>
                        <i class="fa-solid fa-plus"></i>
                    @else
                        <span id="submitBtnOccupation" class="toolTip" role="tooltip" aria-label="@lang('toolTips.common.update')">
                            @lang('toolTips.common.update')
                        </span>
                        <i class="fa-solid fa-pen-nib"></i>
                    @endif
                </button>
                <!-- Reset Button -->
                <button wire:click.prevent="resetForm" class="button rounded hasTooltip">
                    <span id="resetOccupationForm" class="toolTip" role="tooltip" aria-label="@lang('toolTips.common.reset')">
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
    <div class="table__container" x-on:update-occupations-table.window="$wire.$refresh()">
        <div class="table__header">
            <h3>@lang('tables.occupations.info_custom', ['name' => $employeeName])</h3>
        </div>

        @if(isset($this->occupations) && $this->occupations->isNotEmpty())
            <div class="table__body">
                <table>
                    <thead>
                        <tr>
                            <th></th>
                            <th scope="column">
                                <div>@lang('tables.common.actions')</div>
                            </th>
                            <x-default.table.sortable-th wire:key="UO-TH-3" model="field" :label="__('tables.occupations.field')" :$sortDirection :$sortBy />
                            <x-default.table.sortable-th wire:key="UO-TH-4" model="specialty" :label="__('tables.occupations.specialty')" :$sortDirection :$sortBy />
                            <x-default.table.sortable-th wire:key="UO-TH-5" model="grade" :label="__('tables.occupations.grade')" :$sortDirection :$sortBy />
                            <x-default.table.sortable-th wire:key="UO-TH-2" model="experience" :label="__('tables.occupations.experience')" :$sortDirection :$sortBy />
                            <x-default.table.sortable-th wire:key="UO-TH-6" model="is_active" :label="__('tables.occupations.is_active')" :$sortDirection :$sortBy />
                            <x-default.table.sortable-th wire:key="UO-TH-7" model="created_at" :label="__('tables.occupations.created_at')" :$sortDirection :$sortBy />

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($this->occupations as $o)
                            <tr wire:key="{{ $o->id }}" scope="row">
                                <td>
                                    <x-default.action-btn
                                        :tooltip="__('toolTips.occupation.delete')"
                                        icon="trash"
                                        function="openDeleteOccupationDialog"
                                        :parameters="[$o]"
                                    />
                                </td>
                                <td>
                                    <x-default.form.radio-button
                                        model="selectedChoice"
                                        htmlId="oc-id{{ $o->id }}"
                                        value="{{ $o->id }}"
                                        type="forTable"
                                        wire:key="oc-key{{ $o->id }}"
                                    />
                                </td>
                                <td>{{ $o->field }}</td>
                                <td>{{ $o->specialty }}</td>
                                <td>{{ $o->fieldGrade }}</td>
                                <td>{{ $o->experience }}</td>
                                <td>
                                    <x-default.form.radio-button
                                        model="activeOccupationId"
                                        htmlId="aoc-id{{ $o->id }}"
                                        value="{{ $o->id }}"
                                        type="forTable"
                                        wire:key="aoc-key{{ $o->id }}"
                                    />
                                </td>
                                <td>{{ $o->created_at->format('Y-m-d') }}</td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="table__footer">
                <h2>@lang('tables.occupations.not_found')</h2>
            </div>
        @endif
    </div>
</div>
