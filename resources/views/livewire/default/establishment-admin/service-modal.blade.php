<div class="modal__body">
    <div class="form__container">
        <form class="form" wire:submit="handleSubmit">

            <div class="row center">
                <x-default.form.input
                model="{{$form}}.name"
                :label="__('forms.service.name_fr')"
                 type="text"
                  html_id="MSer-nfr"
                  />
                <x-default.form.input
                model="{{$form}}.name_en"
                :label="__('forms.service.name_en')"
                 type="text"
                  html_id="MSer-nEn" />
                <x-default.form.input
                model="{{$form}}.name_ar"
                :label="__('forms.service.name_ar')"
                 type="text"
                  html_id="MSer-nAr" />

            </div>
            <div class="row center">
           <x-default.form.selector
                        htmlId="MSer-st"
                        model="{{$form}}.type"
                       :label="__('forms.service.type')"
                        :data="$serviceTypesOptions"
                        :showError="true"/>
           <x-default.form.selector
                        htmlId="MSer-Sep"
                        model="{{$form}}.specialty_id"
                       :label="__('forms.service.specialty')"
                        :data="$serviceSpecialtiesOptions"
                        :showError="true"/>
            </div>
            <div class="row center">
           <x-default.form.selector
                        htmlId="MSer-ui"
                        model="{{$form}}.head_of_service_id"
                       :label="__('forms.service.head_of_service_id')"
                        :data="$headOfServiceOptions"
                        :showError="true"/>
            </div>
                 <div class="row center">
                <x-default.form.input
                    model="{{$form}}.tel"
                    :label="__('forms.service.tel')"
                    type="text"
                    html_id="MService-Ph"
                />
                <x-default.form.input
                    model="{{$form}}.fax"
                    :label="__('forms.service.fax')"
                    type="text"
                    html_id="MEService-fax"

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
