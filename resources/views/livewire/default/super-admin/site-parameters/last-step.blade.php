
<form class="form form-sp-l" wire:submit.prevent="handleSubmit"  >

    <div class="column center">

        <div class="radio__group">
        <div class="choices">

        <x-default.form.radio-button
         model="form.maintenance"
         value="1"
        :label="__('forms.site_parameters.steps.last.enable')"
         htmlId="m-m-rb-y"/>
        <x-default.form.radio-button
         model="form.maintenance"
         value="0"
       :label="__('forms.site_parameters.steps.last.disable')"
         htmlId="m-m-rb-n"/>
        </div>
        @error("form.maintenance")
        <div class="input__error">
            {{ $message }}
        </div>
        @enderror

        </div>
    </div>
    @if ($generalSettings?->maintenance)
    <div class="row">
         <div wire:loading wire:target="downloadDatabase" >
          <x-default.loading/>
        </div>


        <button class="button "
        wire:click.prevent="downloadDatabase"
        wire:loading.attr="disabled">
        @lang("forms.site_parameters.actions.download_db")</button>

    </div>
    @endif
    <div class="form__actions">
        <div wire:loading wire:target="handleSubmit">
            <x-default.loading />
        </div>

        <button type="submit" class="button button--primary">@lang("forms.common.actions.submit")</button>
    </div>
</form>


@script

<script>


const siteStates = document.querySelector(".radio__group > .choices");
const siteStatesLabels= siteStates.querySelectorAll("label")
const siteStatesInputs= siteStates.querySelectorAll("input[type='radio']")

siteStatesLabels.forEach((label, index) => {
label.addEventListener('keydown', (e) => {
  if (e.key === ' ') {
    const RadioButtonCheckedEvent = new CustomEvent('radio-button-checked-event' ,{
               detail: {
                  radioButton:siteStatesInputs[index]
                      }
                    });
    document.dispatchEvent(RadioButtonCheckedEvent);
    @this.set("form.maintenance", siteStatesInputs[index].value);
  }
})
});

</script>


@endscript
