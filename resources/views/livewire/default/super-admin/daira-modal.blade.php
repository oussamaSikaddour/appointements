<div class="modal__body">
    <div class="form__container">
        <form class="form" wire:submit="handleSubmit">

            <div class="row center">
                <x-default.form.input model="{{$form}}.designation_fr" :label="__('forms.daira.designation_fr')" type="text" html_id="MW-bfr" />
                <x-default.form.input model="{{$form}}.designation_ar" :label="__('forms.daira.designation_ar')" type="text" html_id="MW-bAr" />
                <x-default.form.input model="{{$form}}.designation_en" :label="__('forms.daira.designation_en')" type="text" html_id="MW-bEN" />
            </div>
            <div class="row center">
                <x-default.form.input model="{{$form}}.code" :label="__('forms.daira.code')" type="text" html_id="MW-ac" />
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
