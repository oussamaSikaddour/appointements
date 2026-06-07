<div class="modal__body">
    <div class="form__container">
        <form class="form" wire:submit="handleSubmit">

            <div class="row center">
                <x-default.form.input model="{{$form}}.designation_fr" :label="__('forms.field.designation_fr')" type="text" html_id="MF-bfr" />
                <x-default.form.input model="{{$form}}.designation_ar" :label="__('forms.field.designation_ar')" type="text" html_id="MF-bAr" />
                <x-default.form.input model="{{$form}}.designation_en" :label="__('forms.field.designation_en')" type="text" html_id="MF-bEN" />
            </div>
            <div class="row center">
                <x-default.form.input model="{{$form}}.acronym" :label="__('forms.field.acronym')" type="text" html_id="MF-ac" />
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
