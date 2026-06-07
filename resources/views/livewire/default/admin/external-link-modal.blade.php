<div class="modal__body">
    <div class="form__container">
        <form class="form" wire:submit="handleSubmit">

            <div class="row center">
                <x-default.form.input
                model="{{$form}}.name_fr"
                :label="__('forms.menu.name_fr')"
                 type="text"
                  html_id="ELM-NaFr" />
                <x-default.form.input
                model="{{$form}}.name_ar"
                :label="__('forms.menu.name_ar')"
                 type="text"
                  html_id="ELM-NaAr" />
                <x-default.form.input
                model="{{$form}}.name_en"
                :label="__('forms.menu.name_en')"
                 type="text"
                  html_id="ELM-NaEn" />
            </div>
            <div class="row center">
                <x-default.form.input
                model="{{$form}}.url"
                :label="__('forms.menu.url')"
                 type="text"
                  html_id="ELM-Url" />
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
