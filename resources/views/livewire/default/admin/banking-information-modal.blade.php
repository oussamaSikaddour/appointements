<div class="modal__body">
    <!-- Form Section -->
    <form class="table__form">
        <!-- Form Inputs Container -->
        <div class="table__form__inputs__container">
            <div class="table__form__inputs">
                <x-default.form.input
                    model="{{ $form }}.agency_fr"
                    :label="__('forms.banking_information.agency_fr')"
                    type="text"
                    html_id="BIM-agency-fr"
                />
                <x-default.form.input
                    model="{{ $form }}.agency_ar"
                    :label="__('forms.banking_information.agency_ar')"
                    type="text"
                    html_id="BIM-agency-ar"
                />
                <x-default.form.input
                    model="{{ $form }}.agency_en"
                    :label="__('forms.banking_information.agency_en')"
                    type="text"
                    html_id="BIM-agency-en"
                />
                <x-default.form.input
                    model="{{ $form }}.agency_code"
                    :label="__('forms.banking_information.agency_code')"
                    type="text"
                    html_id="BIM-agency-code"
                />
                <x-default.form.input
                    model="{{ $form }}.account_number"
                    :label="__('forms.banking_information.account_number')"
                    type="text"
                    html_id="BIM-account-number"
                />
                <x-default.form.selector
                    htmlId="BIM-bank-id"
                    model="{{ $form }}.bank_id"
                    :label="__('forms.banking_information.bank_id')"
                    :data="$banksOptions"
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
                    @if($form === "addForm")
                        <span id="submitBtnBanking_information" class="toolTip" role="tooltip" aria-label="@lang('toolTips.common.add')">
                            @lang('toolTips.common.add')
                        </span>
                        <i class="fa-solid fa-plus"></i>
                    @else
                        <span id="submitBtnBanking_information" class="toolTip" role="tooltip" aria-label="@lang('toolTips.common.update')">
                            @lang('toolTips.common.update')
                        </span>
                        <i class="fa-solid fa-pen-nib"></i>
                    @endif
                </button>

                <!-- Reset Button -->
                <button wire:click.prevent="resetForm" class="button rounded hasTooltip">
                    <span id="resetBankingInformationForm" class="toolTip" role="tooltip" aria-label="@lang('toolTips.common.reset')">
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
    <div class="table__container" x-on:update-banking-information-table.window="$wire.$refresh()">
        <div class="table__header">
            <h3>@lang('tables.banking_information.info_custom', ['name' => $bankableName])</h3>
        </div>

        @if(isset($this->bankingInformations) && $this->bankingInformations->isNotEmpty())
            <div class="table__body">
                <table>
                    <thead>
                        <tr>
                            <th></th>
                            <th scope="column">
                                <div>@lang('tables.common.actions')</div>
                            </th>
                            <x-default.table.sortable-th wire:key="UBKI-TH-1" model="bank_acronym" :label="__('tables.banking_information.bank_acronym')" :$sortDirection :$sortBy />
                            <x-default.table.sortable-th wire:key="UBKI-TH-2" model="agency" :label="__('tables.banking_information.agency')" :$sortDirection :$sortBy />
                            <x-default.table.sortable-th wire:key="UBKI-TH-3" model="agency_code" :label="__('tables.banking_information.agency_code')" :$sortDirection :$sortBy />
                            <x-default.table.sortable-th wire:key="UBKI-TH-4" model="account_number" :label="__('tables.banking_information.account_number')" :$sortDirection :$sortBy />
                            <x-default.table.sortable-th wire:key="UBKI-TH-6" model="is_active" :label="__('tables.banking_information.is_active')" :$sortDirection :$sortBy />
                            <x-default.table.sortable-th wire:key="UBKI-TH-7" model="created_at" :label="__('tables.banking_information.created_at')" :$sortDirection :$sortBy />
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($this->bankingInformations as $bi)
                            <tr wire:key="{{ 'bkm-' . $bi->id }}" scope="row">
                                <!-- Radio Button -->
                                <td>
                                    <x-default.form.radio-button
                                        model="selectedChoice"
                                        htmlId="{{ 'bkm-id' . $bi->id }}"
                                        value="{{ $bi->id }}"
                                        type="forTable"
                                        wire:key="{{ 'bkm-key-' . $bi->id }}"
                                    />
                                </td>
                                <!-- Actions -->
                                <td>
                                    <x-default.action-btn
                                        :tooltip="__('toolTips.banking_information.delete')"
                                        icon="trash"
                                        function="openDeleteBankingInformationDialog"
                                        :parameters="[$bi]"
                                    />
                                </td>
                                <!-- Details -->
                                <td>{{ $bi->bank_acronym }}</td>
                                <td>{{ $bi->agency }}</td>
                                <td>{{ $bi->agency_code }}</td>
                                <td>{{ $bi->account_number }}</td>
                                <!-- Active Status -->
                                <td>
                                    <x-default.form.radio-button
                                        model="activeBankingInformationId"
                                        htmlId="{{ 'bnkI-id' . $bi->id }}"
                                        value="{{ $bi->id }}"
                                        type="forTable"
                                        wire:key="{{ 'bnkI-key-' . $bi->id }}"
                                    />
                                </td>
                                <!-- Created At -->
                                <td>{{ $bi->created_at->format('Y-m-d') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="table__footer">
                <h2>@lang('tables.banking_information.not_found')</h2>
            </div>
        @endif
    </div>
</div>
