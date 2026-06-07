<div class="modal__body">
    <div class="form__container">
        <form class="form" wire:submit="handleSubmit">

            <div class="row center">
                <x-default.form.input model="{{$form}}.designation_fr" :label="__('forms.bank.designation_fr')" type="text" html_id="MB-bfr" />
                <x-default.form.input model="{{$form}}.designation_ar" :label="__('forms.bank.designation_ar')" type="text" html_id="MB-bAr" />
                <x-default.form.input model="{{$form}}.designation_en" :label="__('forms.bank.designation_en')" type="text" html_id="MB-bEN" />
            </div>
            <div class="row center">
                <x-default.form.input model="{{$form}}.acronym" :label="__('forms.bank.acronym')" type="text" html_id="MB-ac" />
                <x-default.form.input model="{{$form}}.code" :label="__('forms.bank.code')" type="code" html_id="MB-code" />
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
