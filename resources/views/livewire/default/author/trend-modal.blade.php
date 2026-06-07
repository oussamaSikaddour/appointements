<div class="modal__body">
<div class="form__container">
    <form class="form" wire:submit="handleSubmit">

        <div class="row center">
            <x-default.form.input model="{{$form}}.title_fr" :label="__('forms.trend.title_fr')" type="text" html_id="mTrend-aFr" />
            <x-default.form.input model="{{$form}}.title_ar" :label="__('forms.trend.title_ar')" type="text" html_id="mTrend-aFr" />
            <x-default.form.input model="{{$form}}.title_en" :label="__('forms.trend.title_en')" type="text" html_id="mTrend-aEn" />
        </div>

        <div class="column">

        <p>@lang('forms.trend.content_fr') :</p>
        <livewire:default.tiny-mce-text-area
        htmlId="MTrendCttfr"
        contentUpdatedEvent="set-content-fr"
        wire:key="MaContentFr"
        :content="$contentFr"
        />
        <p>@lang('forms.trend.content_ar') :</p>
        <livewire:default.tiny-mce-text-area
        htmlId="MTrendCttAr"
        contentUpdatedEvent="set-content-ar"
        wire:key="MaContentAr"
        :content="$contentAr"
        />
        <p>@lang('forms.trend.content_en') :</p>
        <livewire:default.tiny-mce-text-area
        htmlId="MTrendCttEn"
        contentUpdatedEvent="set-content-en"
        wire:key="MaContentEn"
        :content="$contentEn"
        />
        </div>

       <div class="row center">
            <x-default.form.input model="{{$form}}.start_at" :label="__('forms.trend.start_at')" type="date" html_id="mTrend-SAt" />
            <x-default.form.input model="{{$form}}.end_at" :label="__('forms.trend.end_at')" type="date" html_id="mTrend-EAt" />
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
