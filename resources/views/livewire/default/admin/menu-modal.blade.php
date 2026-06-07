<div class="modal__body">
    <div class="form__container">
        <form class="form" wire:submit="handleSubmit">

            <div class="row center">
                <x-default.form.input
                model="{{$form}}.title_fr"
                :label="__('forms.menu.title_fr')"
                 type="text"
                  html_id="MT-tFr" />
                <x-default.form.input
                model="{{$form}}.title_ar"
                :label="__('forms.menu.title_ar')"
                 type="text"
                  html_id="MT-tAr" />
                <x-default.form.input
                model="{{$form}}.title_en"
                :label="__('forms.menu.title_en')"
                 type="text"
                  html_id="MT-tEn" />


            </div>
            <div class="row center">
           <x-default.form.selector
                        htmlId="Mtt-ps"
                        model="{{$form}}.type"
                       :label="__('forms.menu.type')"
                        :data="$menuTypesOptions"
                        :showError="true"/>


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
