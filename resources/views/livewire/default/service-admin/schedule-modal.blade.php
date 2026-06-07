<div class="modal__body">
    <div class="form__container">
        <form class="form" wire:submit="handleSubmit">

            <div class="row center">
                <x-default.form.input
                model="{{$form}}.name_fr"
                :label="__('forms.schedule.name_fr')"
                 type="text"
                  html_id="MSchedule-nfr"


                  />
                <x-default.form.input
                model="{{$form}}.name_en"
                :label="__('forms.schedule.name_en')"
                 type="text"
                  html_id="MSchedule-nEn" />
                <x-default.form.input
                model="{{$form}}.name_ar"
                :label="__('forms.schedule.name_ar')"
                 type="text"
                  html_id="MSchedule-nAr" />

            </div>
            <div class="row center">
           <x-default.form.selector
                        htmlId="MSchedule-y"
                        model="{{$form}}.year"
                       :label="__('forms.schedule.year')"
                        :data="$yearsOptions"
                        :showError="true"/>
           <x-default.form.selector
                        htmlId="MSchedule-M"
                        model="{{$form}}.month"
                       :label="__('forms.schedule.month')"
                        :data="$monthsOptions"
                        :showError="true"/>

            </div>
            <div class="column">
            <x-default.form.textarea
                    model="{{$form}}.description_fr"
                  :label="__('forms.schedule.description_fr')"
                  html_id="MSchedule-DesFr"/>
            <x-default.form.textarea
                    model="{{$form}}.description_en"
                  :label="__('forms.schedule.description_en')"
                  html_id="MSchedule-DesEn"/>
            <x-default.form.textarea
                    model="{{$form}}.description_ar"
                  :label="__('forms.schedule.description_ar')"
                  html_id="MSchedule-DesAr"/>
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
