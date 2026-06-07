
<div class="modal__body">
<div class="form__container">
    <form class="form" wire:submit="handleSubmit">

            <div class="row center">
                    <x-default.form.input
                       model="{{$form}}.name"
                      :label="__('forms.slider.name')"
                      type="text"
                      html_id="MSlideN"
                      />
                    <x-default.form.selector
                        htmlId="MSliderT"
                        model="{{$form}}.sliderable_type"
                       :label="__('forms.slider.sliderable_type')"
                        :data="$sliderableTypesOptions"
                        :showError="true"
                        type="filter"
                        />
                    <x-default.form.selector
                        htmlId="MSlideId"
                        model="{{$form}}.sliderable_id"
                       :label="__('forms.slider.sliderable_id')"
                        :data="$sliderableIdsOptions"
                        :showError="true"
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
