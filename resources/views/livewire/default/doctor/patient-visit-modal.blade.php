<div class="modal__body">
<div class="form__container">
    <form class="form" wire:submit="handleSubmit">

        <div class="column">
        <p>@lang('forms.patient_visit.report_fr') :</p>
        <livewire:default.tiny-mce-text-area
        htmlId="MAreportfr"
        contentUpdatedEvent="set-report-fr"
        wire:key="MaFReportFr"
        :content="$reportFr"
        />
        <p>@lang('forms.patient_visit.report_ar') :</p>
        <livewire:default.tiny-mce-text-area
        htmlId="MAReportAr"
        contentUpdatedEvent="set-report-ar"
        wire:key="MaReportAr"
        :content="$reportAr"
        />
        <p>@lang('forms.patient_visit.report_en') :</p>
        <livewire:default.tiny-mce-text-area
        htmlId="MAreportEn"
        contentUpdatedEvent="set-report-en"
        wire:key="MaReportEn"
        :content="$reportEn"
        />
        </div>

        <div class="form__actions">
            <div wire:loading wire:target="handleSubmit">
                <x-default.loading />
            </div>
            <button type="submit" class="button button--primary">@lang('forms.common.actions.submit')</button>
        </div>
    </form>
</div>
</div>
